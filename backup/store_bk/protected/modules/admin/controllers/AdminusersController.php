<?php

class AdminusersController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    protected function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (isFrontUserLoggedIn()) {
            return true;
        } else {
            $this->redirect(CController::createUrl("/admin/login"));
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Adminusers;
        $countries = Countries::model()->findAll(array('order' => 'name ASC'));
        $countries = CHtml::listData($countries, 'id', 'name');
        $roles = getParam('admin_roles');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Adminusers'])) {
            $model->attributes = $_POST['Adminusers'];
            $model->is_admin = 1;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
            'countries' => $countries,
            'roles' => $roles
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $countries = Countries::model()->findAll(array('order' => 'name ASC'));
        $countries = CHtml::listData($countries, 'id', 'name');
        $roles = getParam('admin_roles');
        $states = States::model()->findAll(array('condition' => "country_id = '$model->country_id'", 'order' => 'name ASC'));
        $states = CHtml::listData($states, 'id', 'name');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Adminusers'])) {
            $model->attributes = $_POST['Adminusers'];
            $model->verifyPassword = $model->password;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'countries' => $countries,
            'states' => $states,
            'roles' => $roles
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->redirect(array('manage'));
    }

    /**
     * Manages all models.
     */
    public function actionManage() {
        $model = new Adminusers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Adminusers']))
            $model->attributes = $_GET['Adminusers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionStates() {
        $country = $_POST['country'];
        $states = States::model()->findAll(array('condition' => "country_id = '$country'", 'order' => 'name ASC'));
        echo "<option value=''>Select State</option>";
        foreach ($states as $state) {
            echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Adminusers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Adminusers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Adminusers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'adminusers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
