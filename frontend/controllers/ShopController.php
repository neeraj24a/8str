<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Products;
use backend\models\ProductGallery;
use backend\models\Category;
use backend\models\Drops;
use frontend\models\AddToCartForm;
use yii\data\ActiveDataProvider;

class ShopController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $categories = Category::find()->all();
        $products = [];
        foreach($categories as $cat){
            $products[$cat->slug] = Products::find()->where('category = :category',[':category' => $cat->id])->orderby(['date_entered' => 'DESC'])->limit(5)->all();
        }
        $products['audio-drops'] = Drops::find()->where('type = :type',[':type' => 'audio'])->orderBy(['date_entered' => 'DESC'])->limit(5)->all();
        $products['video-drops'] = Drops::find()->where('type = :type',[':type' => 'video'])->orderBy(['date_entered' => 'DESC'])->limit(5)->all();
        /*$dataProvider = new ActiveDataProvider([
            'query' => Products::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);*/
        return $this->render('index', ['products' => $products, 'categories' => $categories]);
    }

    public function actionDetail($product) {
        $info = \backend\models\Products::findOne(['slug' => $product]);
        $gallery = ProductGallery::find(['product' => $info->id])->all();
        $info->gallery = [];
        if($gallery !== null){
            foreach($gallery as $g){
                $g->image = str_replace('../', Yii::$app->homeUrl, $g->image);
                array_push($info->gallery, $g->image);
            }
        }
        $info->main_image = str_replace('../', Yii::$app->homeUrl, $info->main_image);
        $info->category = \backend\models\Category::findOne($info->category)->category;
        $addToCart = new AddToCartForm();
        return $this->render('detail',['model' => $info, 'addToCart' => $addToCart]);
    }

    public function actionCategory($name) {
        if($name == 'all'){
            return $this->redirect(['/shop']);
        } else if($name == 'audio-drops') {
            $drops = Drops::find()->where('type = :type',[':type' => 'audio'])->orderBy(['date_entered' => 'DESC'])->all();
            $title = 'Audio Drops';
            $products = [];
            $total = sizeof($drops);
        } else if($name == 'video-drops') {
            $drops = Drops::find()->where('type = :type',[':type' => 'video'])->orderBy(['date_entered' => 'DESC'])->all();
            $title = 'Video Drops';
            $products = [];
            $total = sizeof($drops);
        } else {
            $category = Category::findOne(['slug' => $name]);
            $title = $category->category;
            $products = Products::find()->where('category = :category',[':category' => $category->id])->orderby(['date_entered' => 'DESC'])->all();
            $drops = [];
            $total = sizeof($products);
        }
        $categories = Category::find()->all();
        return $this->render('category', ['products' => $products, 'drops' => $drops, 'title' => $title, 'categories' => $categories, 'total' => $total]);
    }

}
