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
    public $password;
    public $rememberMe = true;
    public $session;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = Users::find()->where(['username' => $this->username, 'type' => 'general'])->one();
            $user->last_visit = date("Y-m-d H:i:s");
            if($user->update(false) !== false){
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                throw new \yii\web\NotFoundHttpException("Something Went wrong Try Again.");
            }
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Users::findByUsername($this->username);
            if($this->_user === null) {
                $session = Yii::$app->getSession();
                $session['offer'] = '';
                $url = 'https://www.8thwonderpromos.com/amember/api/check-access/by-login-pass?_key=5XAcMA4i3crPhaoUkQMD&login='.$this->username.'&pass='.$this->password;
                $response = file_get_contents($url);
                $response = json_decode($response);
		if($response->ok == 1){
                    $subscriptions = (array) $response->subscriptions;
                    $c_sub = '';
                    $product = '';
		    if(sizeof($subscriptions) > 0){
                        foreach($subscriptions as $k => $s){
                            if($c_sub == ''){
                                $c_sub = $s;
                                $product = $k;
                            } else if(strtotime($s) > strtotime($c_sub)){
                                $c_sub = $s;
                                $product = $k;
                            }
                        }
                        $pUrl = 'https://www.8thwonderpromos.com/amember/api/products/'.$product.'/?_key=5XAcMA4i3crPhaoUkQMD';
                        $res = file_get_contents($pUrl);
                        $res = json_decode($res);
                        $nested = (array)$res[0]->nested;
                        if($nested['billing-plans'][0]->second_period == '30d'){
                            $session['offer'] = 'monthly';
                        } else if($nested['billing-plans'][0]->second_period == '1m'){
                            $session['offer'] = 'monthly';
                        } else if($nested['billing-plans'][0]->second_period == '90d'){
                            $session['offer'] = 'quaterly';
                        } else if($nested['billing-plans'][0]->second_period == '3m'){
                            $session['offer'] = 'quaterly';
                        } else if($nested['billing-plans'][0]->second_period == '180d'){
                            $session['offer'] = 'halfyearly';
                        } else if($nested['billing-plans'][0]->second_period == '6m'){
                            $session['offer'] = 'halfyearly';
                        } else if($nested['billing-plans'][0]->second_period == '365d'){
                            $session['offer'] = 'yearly';
                        } else if($nested['billing-plans'][0]->second_period == '1y'){
                            $session['offer'] = 'yearly';
                        } else {
			    $session['offer'] = 'monthly';
			}
		    } else {
                        $session['offer'] = 'no subscription';
                    }
                    
                    $user = Users::findOne(['username' => $this->username, 'type' => 'general']);
                    if($user === null){
                        $userModel = new Users();
                        $userModel->amember = $response->user_id;
                        $userModel->first_name = $response->name_f;
                        $userModel->last_name = $response->name_l;
                        $userModel->email = $response->email;
                        $userModel->type = 'general';
                        $userModel->username = $this->username;
                        $userModel->auth_key = Yii::$app->security->generateRandomString();
                        $userModel->status = 1;
                        $userModel->password = Yii::$app->security->generatePasswordHash($this->password);    
                        $userModel->save();
                    }
                    $this->_user = Users::find()->where(['username' => $this->username, 'type' => 'general'])->one();
                }
            } else {
                $session = Yii::$app->getSession();
                $session['offer'] = '';
                $url = 'https://www.8thwonderpromos.com/amember/api/check-access/by-login-pass?_key=5XAcMA4i3crPhaoUkQMD&login='.$this->username.'&pass='.$this->password;
                $response = file_get_contents($url);
                $response = json_decode($response);
		if($response->ok == 1){
		    $user = Users::findOne(['username' => $this->username, 'type' => 'general']);
		    $pass = Yii::$app->security->generatePasswordHash($this->password);
		    $user->password = $pass;
		    $user->save(false);
                    $subscriptions = (array) $response->subscriptions;
                    $c_sub = '';
                    $product = '';
		    if(sizeof($subscriptions) > 0){
                        foreach($subscriptions as $k => $s){
                            if($c_sub == ''){
                                $c_sub = $s;
                                $product = $k;
                            } else if(strtotime($s) > strtotime($c_sub)){
                                $c_sub = $s;
                                $product = $k;
                            }
                        }
                        $pUrl = 'https://www.8thwonderpromos.com/amember/api/products/'.$product.'/?_key=5XAcMA4i3crPhaoUkQMD';
                        $res = file_get_contents($pUrl);
                        $res = json_decode($res);
			$nested = (array)$res[0]->nested;
			if($nested['billing-plans'][0]->second_period == '30d'){
                            $session['offer'] = 'monthly';
                        } else if($nested['billing-plans'][0]->second_period == '1m'){
                            $session['offer'] = 'monthly';
                        } else if($nested['billing-plans'][0]->second_period == '90d'){
                            $session['offer'] = 'quaterly';
                        } else if($nested['billing-plans'][0]->second_period == '3m'){
                            $session['offer'] = 'quaterly';
                        } else if($nested['billing-plans'][0]->second_period == '180d'){
                            $session['offer'] = 'halfyearly';
                        } else if($nested['billing-plans'][0]->second_period == '6m'){
                            $session['offer'] = 'halfyearly';
                        } else if($nested['billing-plans'][0]->second_period == '365d'){
                            $session['offer'] = 'yearly';
                        } else if($nested['billing-plans'][0]->second_period == '1y'){
                            $session['offer'] = 'yearly';
                        } else {
			    $session['offer'] = 'monthly';
			}
		    } else {
                        $session['offer'] = 'no subscription';
                    }
                } else {
                    $this->_user = null;
                }
            }
        }
        return $this->_user;
    }
}

