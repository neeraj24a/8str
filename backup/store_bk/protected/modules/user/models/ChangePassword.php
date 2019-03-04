<?php


/**
 * ChangePassword class.
 * ChangePassword is the data structure for keeping
 * username of a particular user.
 */
class ChangePassword extends CFormModel {

    public $password;
    public $confirm_password;
    public $current_password;
    

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('current_password,password,confirm_password', 'required'),
            array('confirm_password', 'compare', 'compareAttribute'=>'password'),
            array('password', 'length', 'max' => 128, 'min' => 6, 'message' => "Incorrect password (minimal length 6 symbols)."),
            array('current_password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'current_password' => "Current Password",
            'password' => "New Password",
            'confirm_password' => "Confirm Password",
        );
    }
    
    
    public function authenticate($attribute, $params) {
        $id = Yii::app()->user->id;
        if (Users::model()->findByPk($id)->password != md5($this->current_password)) {
            $this->addError($attribute, "Current Password is incorrect.");
        }
    }

   

}
