<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Drops;
use backend\models\Banners;
use backend\models\Trending;
use frontend\models\SubscribeForm;
use frontend\models\AddToCartForm;

class HomeController extends Controller {
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
	$this->layout = 'homepage';
	$trending = [];
	$t = Trending::find()->all();
	if($t !== null){
		$resp = json_decode($t[0]->data);
	}
	
	$trending['audio'] = $resp->data->audio;
	$trending['video'] = $resp->data->video;
	$banners = Banners::find()->all();
        $products = Products::find()->where('is_featured = :featured',[':featured' => 1])->orderBy(['date_entered' => 'DESC'])->limit(5)->all();
        $drops = Drops::find()->orderBy(['date_entered' => 'DESC'])->limit(5)->all();
        $model = new SubscribeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for subscribing with us.');
            } else {
                Yii::$app->session->setFlash('error', 'Please Try Again!');
            }
            return $this->refresh();
        } else {
            return $this->render('index',['banners' => $banners, 'drops' => $drops, 'model' => $model, 'products' => $products, 'trending' => $trending]);
        }
    }
    
    public function actionDetail($product)
    {
        $info = \backend\models\Products::findOne(['slug' => $product]);
        $info->main_image = str_replace('../', Yii::$app->homeUrl, $info->main_image);
        $info->category = \backend\models\Category::findOne($info->category)->category;
        $addToCart = new AddToCartForm();
        return $this->render('/shop/detail',['model' => $info, 'addToCart' => $addToCart]);
        // echo json_encode($arr);
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
	
	public function actionTrend()
	{
		$tUrl = 'https://pool.8thwonderpromos.com/top-trending';
		$context = stream_context_create(array('https' => array('header'=>'Connection: close\r\n')));
		$resp = file_get_contents($tUrl,false,$context);
		$t = Trending::find()->all();
		if($t !== null){
			$t[0]->data = $resp;
			$t[0]->save();
		}
	}
    
}
