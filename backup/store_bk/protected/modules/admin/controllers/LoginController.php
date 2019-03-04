<?php

class LoginController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/login_main';

    public function actionIndex() {

        if (!isFrontUserLoggedIn()) {
            $model = new LoginForm;
            $mail_sent_message = '';
            // collect user input data
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $user_id = $_SESSION['user_id'];
                    $this->redirect(CController::createUrl("/admin/dashboard"));
                }
            }
            // display the login form
            $this->render('index', array('model' => $model));
        } else {
            $user_id = Yii::app()->session['user_id'];
            if ($user_id != NULL) {
                $this->redirect(CController::createUrl("/admin/dashboard"));
            } else
                $this->redirect(Yii::app()->controller->module->returnUrl);
        }
    }
}
