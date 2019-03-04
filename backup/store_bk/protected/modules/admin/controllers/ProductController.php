<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	protected function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
	        return false;
	    }
		if(isFrontUserLoggedIn()){
			return true;
		} else {
			$this->redirect(CController::createUrl("/admin/login"));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$gallery=new ProductGallery('search');
		$gallery->unsetAttributes();  // clear any default values
		
		$related=new RelatedProducts('search');
		$related->unsetAttributes();  // clear any default values
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'gallery'=>$gallery,
			'related'=>$related
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Product;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			//pre($_POST['Product'], true);
			$model->attributes=$_POST['Product'];
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->deleted = 1;
		$model->save();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array("manage"));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function gridImage($data){
		$html = '<image src="'.base_url().'/images/products/'.$data->image.'" height="100" width="100">';
		return $html;
	}
	
	public function gridImageType($data){
		if($data->image_type == 'm'){
			return "Main Image";	
		} else if ($data->image_type == 't') {
			return "Thumbnail";	
		} else if ($data->image_type == 'g') {
			return "Gallery Image";	
		}
	}
	
	public function gridRelated($data){
		return Product::model()->findByPk($data->related)->name;
	}
	
	public function gridCategory($data){
		return Category::model()->findByPk($data->category)->name;
	}
}
