<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Products;
use yii\data\ActiveDataProvider;

class ShopController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionDetail($product) {
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

}
