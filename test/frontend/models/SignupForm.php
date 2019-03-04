<?php
namespace frontend\models;

use yii\base\Model;
use frontend\models\Users;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'frontend\models\Users', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email','first_name','last_name'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'frontend\models\Users', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['first_name', 'required'],
            ['last_name', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Users();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->type = 'general';
        $user->status = 1;
        $user->setPassword($this->password);
        $user->generateAuthKey();
//        if($user->validate()){
//            $user->save();
//        } else {
//            pre($user->getErrors(),true);
//        }
        return $user->save() ? $user : null;
    }
}
