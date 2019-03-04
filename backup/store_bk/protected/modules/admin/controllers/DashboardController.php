<?php

class DashboardController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function actionError() {
        $this->layout = '//layouts/login_main';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionIndex() {
        if (isFrontUserLoggedIn()) {
          
            $active_users = Users::model()->findAll(array("condition"=>"status = 1 AND is_admin = 0 "));
            $inactive_users = Users::model()->findAll(array("condition"=>"status = 0 AND is_admin = 0"));
            $paid_users = Users::model()->findAll(array("condition"=>"is_paid = 1 AND is_admin = 0"));
            $non_paid_users = Users::model()->findAll(array("condition"=>"is_paid = 0 AND is_admin = 0"));
            $data_arr = array();
            $data_arr['user_data'] = array();
            $data_arr['last_five_customer'] = array();
            $count_active_users =   count($active_users);
            array_push($data_arr['user_data'],$count_active_users);
            $count_inactive_users = count($inactive_users);
            array_push($data_arr['user_data'],$count_inactive_users);
            $count_paid_users =     count($paid_users);
            array_push($data_arr['user_data'],$count_paid_users);
            $count_non_paid_users = count($non_paid_users);
            array_push($data_arr['user_data'],$count_non_paid_users);
             
            // getting the last 5 customers
            
            $last_five_customers = Users::model()->findAll(array("condition"=>"is_admin = 0 ","limit"=>5,"order"=> "date_entered DESC"));
            $data_arr['last_five_customer'] = $last_five_customers;
            
            $this->render('index',array('data_arr'=>$data_arr));
        } else {
            $this->redirect(CController::createUrl("/admin/login"));
        }
    }

}
