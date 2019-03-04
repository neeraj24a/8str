<?php

class LogoutController extends Controller {

	public $defaultAction = 'logout';

	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->baseUrl.'/admin/login');
	}

}

?>