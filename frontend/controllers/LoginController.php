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
            pre($_POST, true);
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $session = Yii::$app->getSession();
				$session->set('cart', $cart);
                $return_url = Yii::$app->request->referrer;
//                pre($return_url, true);
                if($return_url != NULL) {
                    return $this->redirect($return_url);
                } else {
                    return $this->goBack();
                }
//                return $this->redirect(['/home']);
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
