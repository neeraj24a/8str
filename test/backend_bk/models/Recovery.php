<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Users;


/**
 * Recovery is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Recovery extends Model {
    public $password;
    public $verifyPassword;
    
    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['password', 'verifyPassword'], 'required'],
            // rememberMe must be a boolean value
            ['verifyPassword', 'compare','compareAttribute' => 'password', 'message' => 'Verify Password should match password.'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'password' => 'Password',
            'verifyPassword' => 'Verify Password',
        ];
    }
}