<?php

require_once "checkout-com.php";

class Am_paysystem_CheckoutComGooglePay extends Am_Paysystem_CheckoutCom
{
    protected $defaultTitle = "Google Pay";
    protected $defaultDescription  = "";

    protected function _initSetupForm(Am_Form_Setup $form)
    {
	$form->addText('google_merchant_id')->setLabel(___('Google Pay Merchant ID'));
    }

    function getConfig($key=null, $default=null)
    {
        return parent::getConfig($key, $this->getDi()->plugins_payment->loadGet('checkout-com')->getConfig($key, $default));
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

        $public_key = $this->getConfig('public_key');
        $amount = $invoice->first_total * 100;
        $currency = $invoice->currency;
        $email = $invoice->getEmail();
        $title = $this->getDi()->config->get('site_title');
        $subtitle = $invoice->getLineDescription();

        $form->addHidden('id')->setValue($controller->getRequest()->get('id'));
        $url = $this->getCheckoutJs();

        $mode = (float)$invoice->second_total > 0 ? 'card' : 'mixed'; //local payments do not support recurring
        $jsEndpoint = $this->getApiEndpoint().'/tokens';
        $controller->view->headScript()->appendFile('https://pay.google.com/gp/p/js/pay.js');
        $cancelUrl = $this->getCancelUrl();
        $env = $this->getConfig('testing') ? 'TEST' : 'PRODUCTION';
	$merchant_id = $this->getConfig("google_merchant_id");
        $errMsg = ___('Error processing payment');
        $form->addRaw()->setContent(<<<CUT
   <style>
    .gpay-button{display:block!important;border-radius: 25px; margin:auto;}
   </style>
   <div id='google-pay-container'></div>
CUT
        );

            $form->addScript()->setScript(<<<CUT
   jQuery(document).ready(function(){
   var baseRequest = {
      apiVersion: 2,
      apiVersionMinor: 0
    };

    var tokenizationSpecification = {
      type: 'PAYMENT_GATEWAY',
      parameters: {
        'gateway': 'checkoutltd',
        'gatewayMerchantId': '{$public_key}'
      }
    };
    var  allowedCardNetworks = ["AMEX", "DISCOVER", "JCB", "MASTERCARD", "VISA"];

    var  allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

    var  baseCardPaymentMethod = {
      type: 'CARD',
      parameters: {
        allowedAuthMethods: allowedCardAuthMethods,
        allowedCardNetworks: allowedCardNetworks
      }
    };

    var  cardPaymentMethod = Object.assign(
      {tokenizationSpecification: tokenizationSpecification},
      baseCardPaymentMethod
    );

    var  paymentsClient =
        new google.payments.api.PaymentsClient({environment: '{$env}'});

    var  isReadyToPayRequest = Object.assign({}, baseRequest);

    isReadyToPayRequest.allowedPaymentMethods = [baseCardPaymentMethod];

    paymentsClient.isReadyToPay(isReadyToPayRequest)
        .then(function(response) {
          if (response.result) {
            var button =
                paymentsClient.createButton({onClick: function(e){
                    e.preventDefault();
                    var paymentDataRequest = Object.assign({}, baseRequest);
                    paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
                      paymentDataRequest.transactionInfo = {
                        totalPriceStatus: 'FINAL',
                        totalPrice: '{$amount}',
                        currencyCode: '{$currency}'
                        };
                        paymentDataRequest.merchantInfo = {
                            merchantName: '{$title}',
			    merchantId: '{$merchant_id}'
                        };
                        paymentsClient.loadPaymentData(paymentDataRequest).then(function(paymentData){
                        $.ajax({
                            url: '{$jsEndpoint}',
                            type: 'post',
                            data: JSON.stringify({
                                type: 'googlepay',
                                token_data: JSON.parse(paymentData.paymentMethodData.tokenizationData.token)
                            }),
                            dataType: 'json',
                            headers: {
                                'Authorization': '{$public_key}',
                                "Content-Type": 'application/json'
                            },
                            success: function (data) {
                                jQuery("#cc-checkout-com").append(jQuery("<input type='hidden' name='cko-card-token'>").val(data.token));
                                jQuery("#cc-checkout-com").submit();
                            },
                            error: function(){
                                amFlashError('{$errMsg}');
                                document.location.href='{$cancelUrl}';
                            }
                        });
                        }).catch(function(err){
                            // show error in developer console for debugging
                            amFlashError(err.statusCode);
                            document.location.href='{$cancelUrl}';
                        });
                    }, 'buttonColor' : 'black', buttonType:'long'});
            jQuery('#google-pay-container').append(jQuery(button));

          }
        })
        .catch(function(err) {
          // show error in developer console for debugging
        console.log(err);
        amFlashError(err.statusMessage);
        document.location.href='{$cancelUrl}';
        });
});
CUT
        );

        return $form;

    }


}
