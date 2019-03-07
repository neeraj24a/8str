<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

use backend\models\Orders;
use backend\models\OrderSearch;
use backend\models\OrderDetails;
use backend\models\Address;
use backend\models\Products;
use backend\models\PrintfulProductDetails;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;
/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
        if (Yii::$app->user->isGuest)
            return Yii::$app->getResponse()->redirect(Url::to(['/login'], 302));
        else if (Yii::$app->user->identity->type != 'admin')
            throw new BadRequestHttpException('Insufficient privileges to access this area.');

        return parent::beforeAction($action);
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $order = $this->findModel($id);
        $detail = OrderDetails::findAll(['order' => $id]);
        $shipping_address = Address::findOne(['address_type' => 'shipping','id' => $order->shipping_address]);
        $billing_address = Address::findOne(['address_type' => 'billing','id' => $order->billing_address]);
        return $this->render('view', [
            'model' => $order,
            'details' => $detail,
            'shipping' => $shipping_address,
            'billing' => $billing_address
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionSync($id)
	{
		$order = $this->findModel($id);
        $detail = OrderDetails::findAll(['order' => $id]);
		$ship_add = Address::findOne(['address_type' => 'shipping','id' => $order->shipping_address]);
        
		$pf = new PrintfulApiClient('ciac7wnf-7cvl-wa20:io6q-8d0qfxlnvf42');
		$request = [];
		$request['recipient']  = ['address1' => $ship_add->address_line_1 .' '. $ship_add->address_line_2,'city' => $ship_add->city,'country_code' => 'US', 'state_code' => $ship_add->state, 'zip' => $ship_add->zip];
		$items = [];
		foreach($detail as $d){
			if($d->quantity_details != NULL){
				$d->quantity_details = unserialize($d->quantity_details);
				foreach($d->quantity_details as $key => $val){
					$color = $key;
					foreach($val as $k => $v){
						$prod = Products::findOne($d->product);
						$p = PrintfulProductDetails::find()->where(['and', "printful_product = '".$prod->printful_product."'","color = '".$color."'", "size = '".$k."'"])->one();
						$url = 'https://www.8thwonderpromos.com';
						$img = str_replace('../assets', $url.'/assets', $prod->main_image);
						$item['quantity'] = $v;
						$item['variant_id'] = $p->printful_product_id;
						$item['files'] = [
							[
								'url' => $img
							]
						];
						array_push($items, $item);
					}
				}
			}
		}
		
		$request['items'] = $items;
		pre($request, true);
		// $request = json_encode($request);
		try {
			// Calculate shipping rates for an order
			$response = $pf->post('orders', $request);
			$odr = Orders::findOne($id);
			$odr->printful_synced = 1;
			$odr->printful_order = $response['id'];
			$odr->save(false);
			return $this->redirect(['view', 'id' => $id]);
		} catch (PrintfulApiException $e) { //API response status code was not successful
			echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
		} catch (PrintfulException $e) { //API call failed
			echo 'Printful Exception: ' . $e->getMessage();
			var_export($pf->getLastResponseRaw());
		}
	}
}
