<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;

class ContactController extends Controller {
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionSubscribe()
	{
		$data = Yii::$app->request->post();
		$model = new ContactForm();
		$res = [];
		if($model->sendSubscribeEmail(Yii::$app->params['adminEmail'], $data['email'])){
			$res['error'] = 'false';
		} else {
			$res['error'] = 'true';
		}
		echo json_encode($res);
	}
    
}
