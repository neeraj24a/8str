<?php

/**
 * ChangePassword class.
 * ChangePassword is the data structure for keeping
 * username of a particular user.
 */
class ForgotPassword extends CFormModel {

    public $username;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username', 'required'),
            array('username', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => "Uername or Email",
        );
    }

    public function authenticate($attribute, $params) {
        $username = $this->username;
        $user = Users::model()->find(array("condition" => " username = '$username' OR email = '$username' "));
        if(empty($user))
        {
            $this->addError($attribute, "Sorry! we do not have any matching record .");
        }    
    }

}
