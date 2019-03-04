<?php

namespace backend\controllers;

use Yii;
use backend\models\Products;
use yii\web\UploadedFile;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
