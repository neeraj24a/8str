<?php

namespace backend\controllers;


use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

use Yii;
use backend\models\Products;
use backend\models\PrintfulProducts;
use backend\models\PrintfulProductDetails;
use yii\web\UploadedFile;
use backend\models\ProductSearch;
use backend\models\ProductSyncData;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Products();
		$this->handleProductSave($model);

        return $this->render('create', [
                    'model' => $model,
        ]);
    }
	
	public function actionGetproducts($product) {
		$type = strtoupper($product);
		$pf = new PrintfulApiClient('a77vf4jb-a1cw-pwk3:rna8-hab76vppqhbz');
		$response = $pf->get('products');
		$products = [];
        foreach($response as $product){
			if($product['type'] == $type){
				$arr = [];
				$arr['id'] = $product['id'];
				$arr['model'] = $product['model'];
				$arr['image'] = $product['image'];
				array_push($products, $arr);
			}
		}
		pre($products);
	}

    public function actionPrintfulInfo($product){
        if(!empty($product)){
            $products = PrintfulProductDetails::find()->where(['printful_product' => $product])
                        ->groupBy(['color','size'])
                        ->orderBy([
                            'color' => SORT_ASC,
							'size' => SORT_ASC,
                        ])->all();
			$html = $this->renderPartial('_printful-products', ['products' => $products]);
            echo $html;
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->handleProductSave($model);

        return $this->render('update', [
                    'model' => $model,
        ]);
    }
    
    public function actionFeaturing($id) {
        $model = $this->findModel($id);
        if($model->is_featured == 0){
            $model->is_featured = 1;
        } else {
            $model->is_featured = 0;
        }
        $model->update();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionSync($id) {
        $model = $this->findModel($id);
        $link = Url::base(true);
        $url = str_replace("admin", "", $link);
		$thumb = str_replace('../', $url, $model->main_image);
        $img = str_replace('../', $url, $model->printful_mock_up);
		$files = [];
		$default = ['url' => $img];
		array_push($files, $default);
		if(!empty($model->printful_back_mock)){
			$bk_img = str_replace('../', $url, $model->printful_back_mock);
			$back = ['type' => 'label_outside', 'url' => $bk_img];
			array_push($files, $back);
		}
		
        $pf = new PrintfulApiClient('a77vf4jb-a1cw-pwk3:rna8-hab76vppqhbz');
        $request = [];
        $request['sync_product']  = ['name' => $model->name,'thumbnail' => $thumb];
        $variants = [];
        // $sizes = explode(',', $model->size);
        $vv = PrintfulProductDetails::find()->where(['printful_product' => $model->printful_product])
                        ->orderBy([
                            'color' => SORT_ASC,
                            'size' => SORT_ASC,
                        ])->all();
        foreach($vv as $v){
            $variant = [
                'retail_price' => $model->unit_price,
                'variant_id' => $v->printful_product_id,
                'size' => $v->size,
                'files' => $files
            ];
            array_push($variants, $variant);
        }
		
        $request['sync_variants'] = $variants;
        
        try {
            $response = $pf->post('store/products', $request);
			$printful_id = $response['id'];
            $external_id = $response['external_id'];
			try{
				$resp = $pf->get('store/products/'.$printful_id);
				$model->printful_id = $printful_id;
				$model->external_id = $external_id;
				$model->is_synced = 1;
				$model->save(false);
				foreach($resp['sync_variants'] as $var){
					foreach($vv as $v){
						if($v->printful_product_id == $var['variant_id']){
							$mod = new ProductSyncData();
							$mod->product = $model->id;
							$mod->variant = $v->id;
							$mod->printful_id = $var['id'];
							$mod->external_id = $var['external_id'];
							$mod->sync_product_id = $var['sync_product_id'];
							$mod->save(false);
						}
					}
				}
				return $this->redirect(Yii::$app->request->referrer);
            } catch (PrintfulApiException $e) { //API response status code was not successful
				echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
			} catch (PrintfulException $e) { //API call failed
				echo 'Printful Exception: ' . $e->getMessage();
				var_export($pf->getLastResponseRaw());
			} 
        } catch (PrintfulApiException $e) { //API response status code was not successful
            echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
        } catch (PrintfulException $e) { //API call failed
            echo 'Printful Exception: ' . $e->getMessage();
            var_export($pf->getLastResponseRaw());
        }
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function handleProductSave(Products $model) {
        $prev_img = $model->main_image;
		$prev_printful_mock_up = $model->printful_mock_up;
		$prev_printful_back_mock = $model->printful_back_mock;
        if ($model->load(Yii::$app->request->post())) {
            $model->main_image = UploadedFile::getInstance($model, 'main_image');
			$model->printful_mock_up = UploadedFile::getInstance($model, 'printful_mock_up');
			$model->printful_back_mock = UploadedFile::getInstance($model, 'printful_back_mock');
            if ($model->validate()) {
                if ($model->main_image) {
                    $filePath = '../assets/uploads/products/' . create_guid() . '.' . $model->main_image->extension;
                    if ($model->main_image->saveAs($filePath)) {
                        $model->main_image = $filePath;
                    }
                } else {
                    $model->main_image = $prev_img;
                }
				if ($model->printful_mock_up) {
                    $filePath = '../assets/uploads/products/' . create_guid() . '.' . $model->printful_mock_up->extension;
                    if ($model->printful_mock_up->saveAs($filePath)) {
                        $model->printful_mock_up = $filePath;
                    }
                } else {
                    $model->printful_mock_up = $prev_printful_mock_up;
                }
				if ($model->printful_back_mock) {
                    $filePath = '../assets/uploads/products/' . create_guid() . '.' . $model->printful_back_mock->extension;
                    if ($model->printful_back_mock->saveAs($filePath)) {
                        $model->printful_back_mock = $filePath;
                    }
                } else {
                    $model->printful_back_mock = $prev_printful_back_mock;
                }

                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                pre($model->getErrors(), true);
            }
        }
    }

}
