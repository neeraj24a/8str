<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use backend\models\Orders;
use backend\models\Users;
use backend\models\Products;
use backend\models\Drops;
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
        else if(Yii::$app->user->identity->type != 'admin')
            throw new BadRequestHttpException('Insufficient privileges to access this area.');
        
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        $orders = Orders::find()->all();
        $total = 0;
        foreach($orders as $order){
            $total = $total + $order->order_amount;
        }
        $products = Products::find()->count();
        $drops = Drops::find()->count();
        $products = $products + $drops;
        $users = Users::find()->count();
        return $this->render('index',['orders' => sizeof($orders),'users' => $users, 'products' => $products, 'total' => $total]);
    }
    
}
