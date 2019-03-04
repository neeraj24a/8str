<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Banners;
use frontend\models\SubscribeForm;

class HomeController extends Controller {
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $banners = Banners::find()->all();
        $model = new SubscribeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for subscribing with us.');
            } else {
                Yii::$app->session->setFlash('error', 'Please Try Again!');
            }
            return $this->refresh();
        } else {
            return $this->render('index',['banners' => $banners,'model' => $model]);
        }
    }
    
    public function actionDetail($product)
    {
        $info = \backend\models\Products::findOne(['slug' => $product]);
        $info->main_image = str_replace('../', Yii::$app->homeUrl, $info->main_image);
        $arr = [];
        $arr['slug'] = $info->slug;
        $arr['name'] = $info->name;
        $arr['unit_price'] = $info->unit_price;
        $arr['main_image'] = $info->main_image;
        $arr['description'] = $info->description;
        $arr['sku'] = $info->sku;
        $arr['offer_price'] = $info->offer_price;
        $arr['variation'] = $info->variation;
        $arr['size'] = $info->size;
        $arr['colors'] = $info->colors;
        $arr['available'] = $info->available;
        $arr['category'] = \backend\models\Category::findOne($info->category)->category;
        
        echo json_encode($arr);
    }

    public function actionSubscribe()
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
    
}
