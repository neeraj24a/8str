<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

use Yii;


/**
 * Description of BaseModel
 *
 * @author neeraj
 */
class BaseModel extends \yii\db\ActiveRecord {

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            if (isset($this->password)) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
                $this->verifyPassword = $this->password;
            }
            $this->id = create_guid();
            $this->created_by = Yii::$app->user->id;
            $this->modified_by = Yii::$app->user->id;
            $this->deleted = 0;
            $this->status = 1;
            $this->date_entered = date("Y-m-d H:i:s");
            $this->date_modified = date("Y-m-d H:i:s");
        } else {
            $this->date_modified = date("Y-m-d H:i:s");
            if (Yii::$app->user->identity)
                $this->modified_by = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

    public static function getAll($model_name, $params = array()) {
        $default_condition = array("status" => 1, "deleted" => 0);

//        $obj_model = new $model_name;
        if (count($params)) {
            if (!empty($params["condition"])) {
                $params["condition"] = $params["condition"] . " AND " . $default_condition["condition"];
            } else {
                $params = array_merge($params, $default_condition);
            }
            return $model_name::findAll($params);
        } else {
            return $model_name::findAll($default_condition);
        }
    }

}
