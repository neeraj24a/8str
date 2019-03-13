<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use frontend\models\LoginForm;
use frontend\models\Users;
use frontend\config\Cart;

class LoginController extends \yii\web\Controller {
    
//    public $layout = '@app/views/layouts/login_main';
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            $info = new Cart();
            $cart = $info->getCart();
	    if(isset($_POST['LoginForm'])){
		    $username = $_POST['LoginForm']['username'];
		    $password = $_POST['LoginForm']['password'];
		    $url = 'https://www.8thwonderpromos.com/amember/api/check-access/by-login-pass?_key=5XAcMA4i3crPhaoUkQMD&login='.$username.'&pass='.$password;
		    $response = file_get_contents($url);
		    $response = json_decode($response);
		    if($response->ok == 1){
			    $user = Users::findOne(['username' => $username, 'type' => 'general']);
			    $pass = Yii::$app->security->generatePasswordHash($password);
			    $user->password = $pass;
			    $user->save(false);
			    if ($model->load(Yii::$app->request->post()) && $model->login()) {
				$session = Yii::$app->getSession();
						$session->set('cart', $cart);
				$return_url = Yii::$app->request->referrer;
				if($return_url != NULL) {
				    return $this->redirect($return_url);
				} else {
				    return $this->goBack();
				}
			    }
		    }
	    }
            $model->password = '';
            return $this->render('index', [
                        'model' => $model,
            ]);
        } else {
            return $this->redirect(['/home']);
        }
    }

}
