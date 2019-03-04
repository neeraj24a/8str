<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Users;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required'],
            // username is validated by validatePassword()
            ['username', 'validateUser'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => 'Username Or Email',
        ];
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUser($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Please enter registered email or username with us.');
            } else {
                
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Users::findByUsernameOrEmail($this->username);
        }

        return $this->_user;
    }
}

