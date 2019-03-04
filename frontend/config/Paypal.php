<?php
namespace frontend\config;
use Yii;
use yii\helpers\Url;
class Paypal {  

    public $url;
    public $env;
    public $clientId;
    public $clientSecret;
    public $access_token;
    public $paymentID;
    public $payerID;
    public $premiumService;

    public function __construct($params=0) {
        $this->access_token = '';
        $cancel_url = Url::toRoute('/cart/cancel');
        $return_url = Url::toRoute('/cart/complete');
        /* for sandbox url is https://api.sandbox.paypal.com */
        $this->url = getParam('paypal_url');
        $this->clientId = getParam('paypal_clientId');
        $this->clientSecret = getParam('paypal_clientSecret');

        if(isset($params['paymentID'])) {
            $this->paymentID = $params['paymentID'];
        }

        if(isset($params['payerID'])) {
            $this->payerID = $params['payerID'];
        }

        if(isset($params['access_token'])) {
            $this->access_token = $params['access_token'];
        }

        /* This is where you describe the product you are selling */    
        $this->premiumService = '{
            "intent":"sale",
            "redirect_urls":{
                 "cancel_url": "'.$cancel_url.'",
                 "return_url": "'.$return_url.'"
            },
            "payer":{
                "payment_method":"paypal"
            },
            "transactions":[
            {
                "amount":{
                "currency":"USD",
                "total":"39.00"
                },
                "item_list":{
                    "items": [
                    {
                        "quantity": "1",
                        "name": "Premium Service",
                        "price": "39.00",
                        "currency": "USD",
                        "description": "Purchase allows one time use of this premium service"
                    }]
                },
                "description":"Premium Service"

            }]
        }';
    }

    public function getToken() {
        $curlUrl = $this->url."/v1/oauth2/token";
        $curlHeader = array(
            "Content-type" => "application/json",
            "Authorization: Basic ". base64_encode( $this->clientId .":". $this->clientSecret),
        );
        $postData = array(
            "grant_type" => "client_credentials"
        );

        $curlPostData = http_build_query($postData);
        $curlResponse = $this->curlCall($curlUrl, $curlHeader, $curlPostData);
        if($curlResponse['http_code'] == 200) {
            $this->access_token = $curlResponse['json']['access_token'];
        }
    }


    public function createPayment() {
        $curlUrl = $this->url."/v1/payments/payment";
        $curlHeader = array(
            "Content-Type:application/json",
            "Authorization:Bearer  ". $this->access_token,
        );
        $curlResponse = $this->curlCall($curlUrl, $curlHeader, $this->premiumService);
        $id = null;
        $approval_url = null;
        if($curlResponse['http_code'] == 201) {
            $id = $curlResponse['json']['id'];
            foreach ($curlResponse['json']['links'] as $link) {
                if($link['rel'] == 'approval_url'){
                    $approval_url = $link['href'];
                }
            }
        }

        $res = ['paymentID' =>$id,'approval_url'=>$approval_url];
        return $res;
    }

    public function executePayment() {
        $curlUrl = $this->url."/v1/payments/payment/".$this->paymentID."/execute";

        $curlHeader = array(
            "Content-Type:application/json",
            "Authorization:Bearer ".$this->access_token,
        );
        $postData = array(
            "payer_id" => $this->payerID
        );

        $curlPostData = json_encode($postData);
        $curlResponse = $this->curlCall($curlUrl, $curlHeader, $curlPostData);

        return $curlResponse;
    }

    function curlCall($curlServiceUrl, $curlHeader, $curlPostData) {
        // response container
        $resp = array(
            "http_code" => 0,
            "json"     => ""
        );

        //set the cURL parameters
        $ch = curl_init($curlServiceUrl);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_SSLVERSION , 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        //curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeader);

        if(!is_null($curlPostData)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPostData);
        }
        //getting response from server
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch); // close cURL handler
        // pre($resp);
        // some kind of an error happened
        if (empty($response)) {
            return $resp;
        }

        $resp["http_code"] = $http_code;
        $resp["json"] = json_decode($response, true);
        // pre($resp, true);
        return $resp;

    }
}
?>
