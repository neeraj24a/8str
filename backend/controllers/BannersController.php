<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use backend\models\Banners;
use backend\models\BannerSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannersController extends Controller
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
        if ( Yii::$app->user->isGuest )
            return Yii::$app->getResponse()->redirect(Url::to(['/login'],302));
        else if(Yii::$app->user->identity->type != 'admin')
            throw new BadRequestHttpException('Insufficient privileges to access this area.');
        
        return parent::beforeAction($action);
    }

    /**
     * Lists all Banners models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banners model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banners();

        $this->handleBannerSave($model);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Banners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->handleBannerSave($model);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Banners model.
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
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function handleBannerSave(Banners $model) {
        $prev_img = $model->image;
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->validate()) {
                if ($model->image) {
                    $filePath = '../assets/uploads/banners/' . create_guid() . '.' . $model->image->extension;
                    if ($model->image->saveAs($filePath)) {
                        $model->image = $filePath;
                    }
                } else {
                    $model->image = $prev_img;
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
