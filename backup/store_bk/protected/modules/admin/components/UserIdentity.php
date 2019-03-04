<?php

ob_start();

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    public $role;

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
       
        $user = Users::model()->find(array('condition' => "username = '$this->username' AND is_admin = 1"));
        if ($user === null)
            if (strpos($this->username, "@")) {
                $this->errorCode = self::ERROR_EMAIL_INVALID;
            } else {
                $this->errorCode = self::ERROR_EMAIL_INVALID;
            } else if (md5($this->password) !== $user->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else if ($user->status == 0 && Yii::app()->getModule('admin')->loginNotActiv == false)
            $this->errorCode = self::ERROR_STATUS_NOTACTIV;
        else {
            Yii::app()->session['user_id'] = $user->id;
            Yii::app()->session['user_name'] = $user->username;
            Yii::app()->session['first_name'] = $user->first_name;
            Yii::app()->session['last_name'] = $user->last_name;
            Yii::app()->session['role'] = Roles::model()->findByPk($user->role_id)->role_name;
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}
