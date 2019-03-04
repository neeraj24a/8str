<?php

class DefaultController extends Controller {

    public function actionIndex() {
        if (!isFrontUserLoggedIn()) {
           $this->redirect(CController::createUrl("/admin/login"));
        } else {
          $this->redirect(CController::createUrl("/admin/dashboard"));
        }
    }

}
