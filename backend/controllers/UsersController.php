<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use backend\models\Users;
use backend\models\UsersSearch;
use backend\models\Recovery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller {

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
        if ( Yii::$app->user->isGuest )
            return Yii::$app->getResponse()->redirect(Url::to(['/login'],302));
        else if(Yii::$app->user->identity->type != 'admin')
            throw new BadRequestHttpException('Insufficient privileges to access this area.');
        
        return parent::beforeAction($action);
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsersSearch();
        $searchModel->type = 'admin';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Users();
        if ($model->load(Yii::$app->request->post())) {
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->status = 1;
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                pre($model->getErrors(), true);
            }
        } 

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $prev_pass = $model->password;
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->password))
                $model->password = $prev_pass;
            else
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $model->password = '';
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionResetpassword($id){
        
        $model = new Recovery;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Users::findOne(['id' => $id]);
            $user->password = Yii::$app->security->generatePasswordHash($model->password);
            $user->update(false);
            return $this->redirect(['/users']);
        }
        return $this->render('reset', ['model' => $model]);
    }
    
    public function actionChangestatus($id){
        $model = $this->findModel($id);
        
        if($model->status == 1)
            $model->status = 0;
        else
            $model->status = 1;
        
        $model->update();
        return $this->redirect(['/users']);
        
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
