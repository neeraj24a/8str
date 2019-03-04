<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;
use Yii;
/**
 * Description of LogoutController
 *
 * @author neeraj
 */
class LogoutController extends \yii\web\Controller {
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionIndex()
    {
        Yii::$app->user->logout();
        $_SESSION = [];
        return $this->redirect(['/login']);
    }
    
}
