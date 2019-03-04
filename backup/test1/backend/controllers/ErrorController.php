<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Description of ErrorController
 *
 * @author neeraj
 */
class ErrorController extends Controller {

    public function beforeAction($action) {
        $this->layout = 'error_main';
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            $statusCode = $exception->statusCode;
            $name = $exception->getName();
            $message = $exception->getMessage();

            return $this->render('index', [
                        'exception' => $exception,
                        'statusCode' => $statusCode,
                        'name' => $name,
                        'message' => $message
            ]);
        }
    }

}
