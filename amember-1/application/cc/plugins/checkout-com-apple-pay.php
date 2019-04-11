<?php

require_once "checkout-com.php";

class Am_paysystem_CheckoutComApplePay extends Am_Paysystem_CheckoutCom
{
    protected $defaultTitle = "Apple Pay";
    protected $defaultDescription  = "";
    
    protected function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('apple_merchant_id')->setLabel(___('Merchant identifier you created in your apple developer account'));
        $form->addText('apple_cert_path', ['class'=>'am-el-wide'])
            ->setLabel(___('Certificate  .pem file. keep them above/outside your webroot folder'));
        $form->addText('apple_cert_key', ['class'=>'am-el-wide'])
            ->setLabel(___('Key .pem file. keep them above/outside your webroot folder'));
        $form->addSecretText('apple_key_pass')->setLabel(___('Password you used to create key.pem'));
        
    }
    
    function getReadme(){
        return <<<CUT
To create pem files: 
Go here https://developer.apple.com/account/ios/identifier/merchant
click + to create a merchant ID if you haven't already done so. If you have one already, click it, then click "edit"
on the next screen you have 3 things to do.
1 create a Payment Processing Certificate (use your 3rd party payment provider's csr for this)
2 add a Merchant Domain
3 create an Apple Pay Merchant Identity (which is another certificate).
In that third section "Apple Pay Merchant Identity"...

Click "Create Certificate"
Follow the "Create a CSR file. (Optional)" method then hit "Continue"
You'll see at the top of the next page that the act of using KeychainAccess.app to create a CSR, actually creates a private key and certificate (aka public key) pair. These are both kept in keychainaccess.app on your mac. The public key/cert is also saved to disk when you create it, it's this xxx.certSigningRequest file which you'll upload to apple next
Once you upload your public key ( xxx.certSigningrequest file), apple will use it to generate your Apple Pay Merchant Identity (certificate) - a file called merchant_id.cer
download this merchant_id.cer file, and double-click it to insert it into keychain access.app. this should automatically get appended to the existing entry for your Private key in keychain access.app
right-click that certificate (probably named "Merchant ID: merchant...." from within keychain access.app (you may need to expand the private key entry to see the certificate under it) and select "Export 'Merchant ID merchant....' ". This will default to exporting a xxxx.p12 file to your desktop.
it's this xxx.p12 file which you then use openssl in terminal.app on your mac ......

openssl pkcs12 -in ApplePayMerchantIdentity_and_privatekey.p12 -out ApplePay.crt.pem -clcerts -nokeys
openssl pkcs12 -in ApplePayMerchantIdentity_and_privatekey.p12 -out ApplePay.key.pem -nocerts

...to create two .pem files. Remember the password you're asked to create when you extract ApplePay.key.pem above. You'll need to add this to plugin config. These are the two files your webserver will use to authenticate its conversations with Apple, requesting a session etc for each ApplePay transaction your customers make.        
CUT;
    }
    function getConfig($key=null, $default=null)
    {
        return parent::getConfig($key, $this->getDi()->plugins_payment->loadGet('checkout-com')->getConfig($key, $default));
    }
    function directAction($request, $response, $invokeArgs)
    {
        if($request->getActionName() == 'validate'){
            $url = $request->getParam('u');
            if( "https" == parse_url($url, PHP_URL_SCHEME) && substr( parse_url($url, PHP_URL_HOST), -10 )  == ".apple.com" ){
                $ch = curl_init();
                $data = json_encode([
                    'merchantIdentifier' => $this->getConfig('apple_merchant_id'),
                    'initiative'    =>  'web',
                    'initiativeContext' => $_SERVER['HTTP_HOST'],
                    'displayName' => $this->getDi()->config->get('site_title')
                ]);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSLCERT, $this->getConfig('apple_cert_path'));
                curl_setopt($ch, CURLOPT_SSLKEY, $this->getConfig('apple_cert_key'));
                curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $this->getConfig('apple_key_pass'));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
                $res= curl_exec($ch);
                if($res === false)
                {
                    $this->logError('Apple Pay validation error', curl_error($ch));
                }else{
                    print $res;
                }
                curl_close($ch);
            }
        }else{
            parent::directAction($request, $response, $invokeArgs);
        }
    }
    function createFormHosted(Invoice $invoice, $label, Am_Controller_CreditCard_CheckoutCom $controller)
    {
        $token = $invoice->data()->get(self::PAYMENT_TOKEN);
        if (!$token) {
            if (!($token = $this->getPaymentToken($invoice, $error))) {
                throw new Am_Exception_FatalError($error);
            }

            $invoice->data()->set(self::PAYMENT_TOKEN, $token);
            $invoice->save();
        }

        $form = new Am_Form('cc-checkout-com');

        $merchant_id = $this->getConfig('apple_pay_merchant_id');

        $public_key = $this->getConfig('public_key');
        $amount = $invoice->first_total;
        $currency = $invoice->currency;
        $country = $invoice->getCountry();
        $email = $invoice->getEmail();
        $title = $this->getDi()->config->get('site_title');
        $subtitle = $invoice->getLineDescription();

        $form->addHidden('id')->setValue($controller->getRequest()->get('id'));
        $url = $this->getPluginUrl('validate');

        $mode = (float)$invoice->second_total > 0 ? 'card' : 'mixed'; //local payments do not support recurring
        $jsEndpoint = $this->getApiEndpoint().'/tokens';
        
        $cancelUrl = $this->getCancelUrl();
        $errMsg = ___('Error processing payment');
        $form->addRaw()->setContent(<<<CUT
<style>
#applePay {  
	width: 150px;  
	height: 50px;  
	display: none;   
	border-radius: 5px;    
	margin-left: auto;
	margin-right: auto;
	margin-top: 20px;
	background-image: -webkit-named-image(apple-pay-logo-white); 
	background-position: 50% 50%;
	background-color: black;
	background-size: 60%; 
	background-repeat: no-repeat;  
}
</style>
<button type="button" id="applePay"></button>
<p style="display:none" id="got_notactive">ApplePay is possible on this browser, but not currently activated.</p>
<p style="display:none" id="notgot">ApplePay is not available on this browser</p>
CUT
        );
            
            $form->addScript()->setScript(<<<CUT
var debug = false;

if (window.ApplePaySession) {
   var merchantIdentifier = '{$merchant_id}';
   var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
   promise.then(function (canMakePayments) {
	  if (canMakePayments) {
		 document.getElementById("applePay").style.display = "block";
	  } else {   
		 document.getElementById("got_notactive").style.display = "block";
	  }
	}); 
} else {
	document.getElementById("notgot").style.display = "block";
}
   document.getElementById("applePay").style.display = "block";
document.getElementById("applePay").onclick = function(evt) {
	 
	 var paymentRequest = {
	   currencyCode: '{$currency}',
	   countryCode: '{$country}',
	   total: {
          label: '{$title}',
		  amount: '{$amount}'
	   },
	   supportedNetworks: ['amex', 'masterCard', 'visa' ],
	   merchantCapabilities: [ 'supports3DS', 'supportsEMV', 'supportsCredit', 'supportsDebit' ]
	};
	
	var session = new ApplePaySession(3, paymentRequest);
	
	// Merchant Validation
	session.onvalidatemerchant = function (event) {
		logit(event);
		var promise = performValidation(event.validationURL);
		promise.then(function (merchantSession) {
			session.completeMerchantValidation(merchantSession);
		}); 
	}
	
	function performValidation(valURL) {
		return new Promise(function(resolve, reject) {
			var xhr = new XMLHttpRequest();
			xhr.onload = function() {
				var data = JSON.parse(this.responseText);
				logit(data);
				resolve(data);
			};
			xhr.onerror = reject;
			xhr.open('GET', '{$url}?u=' + valURL);
			xhr.send();
		});
	}
	
	
	session.onpaymentauthorized = function (event) {
		var promise = sendPaymentToken(event.payment.token);
		promise.then(function (success) {	
			var status;
			if (success){
				status = ApplePaySession.STATUS_SUCCESS;
				document.getElementById("applePay").style.display = "none";
				document.getElementById("success").style.display = "block";
                session.completePayment(status);
                jQuery("#cc-checkout-com").submit();
			} else {
                status = ApplePaySession.STATUS_FAILURE;
                session.completePayment(status);
                amFlashError('{$errMsg}');
                window.location.href='{$cancelUrl}';
			}
			
            

		});
	}
	function sendPaymentToken(paymentToken) {
		return new Promise(function(resolve, reject) {
                        var reqHeaders = {
                                'Authorization': '{$public_key}', 
                                "Content-Type": 'application/json' 
                            };
                        $.ajax({
                            url: '{$jsEndpoint}',
                            type: 'post',
                            data: JSON.stringify({
                                type: 'applepay', 
                                token_data: paymentToken.paymentData
                            }),
                            dataType: 'json',
                            headers: reqHeaders,
                            success: function (data) {
                                jQuery("#cc-checkout-com").append(jQuery("<input type='hidden' name='cko-card-token'>").val(data.token));
                                resolve(true);
                            },
                            error: function(ret){
                                alert('error '+JSON.stringify(ret));
                                reject;
                            }
                        });                            
		});
	}
	
	session.oncancel = function(event) {
           window.location.href='{$cancelUrl}';
	}
	
	session.begin();
};
document.getElementById("applePay").click();	
function logit( data ){
};                
CUT
        );
            
        return $form;
        
    }
    
    
}
