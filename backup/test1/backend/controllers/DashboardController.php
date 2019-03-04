<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;
use Yii;
use yii\helpers\Url;
use backend\models\Track;
/**
 * Description of LogoutController
 *
 * @author neeraj
 */
class DashboardController extends \yii\web\Controller {
    public $layout = '@app/views/layouts/main';
    /**
     * Logout action.
     *
     * @return Response
     */
    public function beforeAction($action) {
        if ( Yii::$app->user->isGuest )
            return Yii::$app->getResponse()->redirect(Url::to(['/login'],302));
        
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
//        $audios = Track::findAll(['type' => 'audio']);
//        $videos = Track::findAll(['type' => 'video']);
        return $this->render('index',['audio' => '1','video' => '1']);
    }
    
}
