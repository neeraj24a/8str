<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Drops;
use backend\models\DropSearch;
use yii\data\ActiveDataProvider;
use frontend\models\DropCartForm;
use frontend\models\DropCartRemoveForm;
use frontend\config\Cart;

class DjdropsController extends Controller {
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DropSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	/*$dataProvider = new ActiveDataProvider([
            'query' => Drops::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);*/
        return $this->render('index', ['dataProvider' => $dataProvider,'searchModel' => $searchModel]);
    }

    public function actionDetails($drop)
    {
        $model = Drops::findOne(['slug' => $drop]);
    	$cartForm = new DropCartForm();
    	$removeForm = new DropCartRemoveForm();
    	$cart = new Cart();
    	$inCart = $cart->getItemInCart($model->slug, 'drop');

    	return $this->render('detail',['model' => $model, 'cartForm' => $cartForm, 'removeForm' => $removeForm, 'inCart' => $inCart]);
    }
    
}
