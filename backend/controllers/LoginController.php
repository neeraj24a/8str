<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use backend\models\LoginForm;

class LoginController extends \yii\web\Controller
{
    public $layout = '@app/views/layouts/login_main';
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->redirect(['/dashboard']);
            }

            $model->password = '';
            return $this->render('index', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['/dashboard']);
        }
    }
    
}
