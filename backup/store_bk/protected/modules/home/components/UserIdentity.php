<?php
ob_start();
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    
    const ERROR_EMAIL_INVALID = 3;
    const ERROR_STATUS_NOTACTIV = 4;
    const ERROR_STATUS_BAN = 5;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        //http://example.com/amember/api/check-access/by-login-pass?_key=APIKEY&login=john&pass=1234
        
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://localhost/amember/api/check-access/by-login-pass?_key='.getParam('amember_api').'&login='.$this->username.'&pass='.$this->password,
            CURLOPT_USERAGENT => 'Amember Login Curl'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $res = json_decode($resp);
        //pre($res);
        if($res->ok){
            $this->_id = $res->user_id;
            Yii::app()->user->id = $res->user_id;
            $this->username = $this->username;
            $this->errorCode = self::ERROR_NONE;
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        // Close request to clear up some resources
        curl_close($curl);
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}