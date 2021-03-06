<?php

namespace backend\controllers;


use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

use Yii;
use backend\models\Products;
use yii\web\UploadedFile;
use backend\models\ProductSearch;
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
        $img = str_replace('../', $url, $model->main_image);
        $pf = new PrintfulApiClient('ciac7wnf-7cvl-wa20:io6q-8d0qfxlnvf42');
        $request = [];
        $request['sync_product']  = ['name' => $model->name,'thumbnail' => $img];
        $variants = [];
        $sizes = explode(',', $model->size);
        $i = 1;
        foreach($sizes as $size){
            $variant = [
                'retail_price' => $model->unit_price,
                'variant_id' => $i,
                'size' => trim($size),
                'files' => [
                    ['url' => $img]
                ]
            ];
            array_push($variants, $variant);
            $i++;
        }
        $request['sync_variants'] = $variants;
        try {
            // Calculate shipping rates for an order
            $response = $pf->post('store/products', $request);
            $printful_id = $response['id'];
            $external_id = $response['external_id'];
            $model->is_synced = 1;
            $model->printful_id = $printful_id;
            $model->external_id = $external_id;
            $model->save(false);
            return $this->redirect(Yii::$app->request->referrer);
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
        if ($model->load(Yii::$app->request->post())) {
            $model->main_image = UploadedFile::getInstance($model, 'main_image');

            if ($model->validate()) {
                if ($model->main_image) {
                    $filePath = '../assets/uploads/products/' . create_guid() . '.' . $model->main_image->extension;
                    if ($model->main_image->saveAs($filePath)) {
                        $model->main_image = $filePath;
                    }
                } else {
                    $model->main_image = $prev_img;
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
