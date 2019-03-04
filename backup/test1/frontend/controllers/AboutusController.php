<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class AboutusController extends Controller {
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
}
