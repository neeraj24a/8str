<?php

namespace backend\controllers; 

use Yii; 
use backend\models\PrintfulProducts; 
use backend\models\PrintfulProductDetails;
use backend\models\PrintfulProductDetailsSearch; 
use yii\web\Controller; 
use yii\web\NotFoundHttpException; 
use yii\filters\VerbFilter; 

/** 
 * PrintfulProductsController implements the CRUD actions for PrintfulProductDetails model. 
 */ 
class PrintfulProductDetailsController extends Controller
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

    /** 
     * Lists all PrintfulProductDetails models. 
     * @return mixed 
     */ 
    public function actionIndex() 
    { 
        $searchModel = new PrintfulProductDetailsSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 

        return $this->render('index', [ 
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider, 
        ]); 
    } 

    /** 
     * Displays a single PrintfulProductDetails model. 
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
     * Creates a new PrintfulProductDetails model. 
     * If creation is successful, the browser will be redirected to the 'view' page. 
     * @return mixed 
     */ 
    public function actionCreate() 
    { 
        $model = new PrintfulProductDetails(); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            return $this->redirect(['view', 'id' => $model->id]); 
        } 

        return $this->render('create', [ 
            'model' => $model, 
        ]); 
    } 

    /** 
     * Updates an existing PrintfulProducts model. 
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
     * Deletes an existing PrintfulProducts model. 
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
     * Finds the PrintfulProducts model based on its primary key value. 
     * If the model is not found, a 404 HTTP exception will be thrown. 
     * @param string $id
     * @return PrintfulProducts the loaded model 
     * @throws NotFoundHttpException if the model cannot be found 
     */ 
    protected function findModel($id) 
    { 
        if (($model = PrintfulProductDetails::findOne($id)) !== null) { 
            return $model; 
        } 

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.')); 
    } 
} 