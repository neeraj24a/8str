<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminBaseModel extends CActiveRecord {

    /**
     * Prepares id, status, date_entered, created_by, date_modified and 
     * modified_user_id,deleted attributes before performing validation.
     */
    protected function beforeValidate() {
        if ($this->isNewRecord) {
// set the create date, last updated date and the user doing the creating
            if (create_guid()) {
                $this->id = create_guid();
                $this->date_entered = date("Y-m-d H:i:s");
                $this->created_by = Yii::app()->session['user_id'];
                $this->modified_by = Yii::app()->session['user_id'];
                $this->deleted = 0;
                $this->status = 1;
                $this->date_modified = date("Y-m-d H:i:s");
            }
        } else {
//not a new record, so just set the last updated time and last updated user id
            $this->date_modified = date("Y-m-d H:i:s");
            $this->modified_by = Yii::app()->session['user_id'];
        }
        return parent::beforeValidate();
    }

//    protected function afterValidate() {
//        parent::afterValidate();
//        if (isset($this->password))
//            $this->password = $this->encrypt($this->password);
//    }
//
//    public function encrypt($value) {
//        return md5($value);
//    }

    public static function executeQuery($sql) {
        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND status=1 AND deleted=0";
        } else {
            $sql .= " WHERE status=1 AND deleted=0";
        }

        $command = Yii::app()->db->createCommand($sql);
        $results = $command->queryAll();
        return $results;
    }

    public static function executeSimpleQuery($sql) {
        $command = Yii::app()->db->createCommand($sql);
        $results = $command->queryAll();
        return $results;
    }
    

    public static function deleteQuery($sql) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();

        return true;
    }

    /**
     * This is a function which uses Yii findAll function 
     * with condition status = 1 and deleted = 0
     * 
     */
    public static function getAll($model_name, $params = array()) {
        $default_condition = array("condition" => "status =  1 AND deleted = 0");
        
        $obj_model = new $model_name;
        if(count($params)){
            if(!empty($params["condition"])){
                $params["condition"] = $params["condition"] . " AND " . $default_condition["condition"];
            }
            else{
                $params = array_merge($params, $default_condition);
            }
            return $obj_model->findAll($params);
        } else {
            return $obj_model->findAll($default_condition);
        }

    }
    /**
     * This is a function which uses Yii findAll function 
     * with condition status = 1 and deleted = 0
     * 
     */
    public static function get($model_name, $params = array()) {
        $default_condition = array("condition" => "status =  1 AND deleted = 0");
        
        $obj_model = new $model_name;
        if(count($params)){
            if(!empty($params["condition"])){
                $params["condition"] = $params["condition"] . " AND " . $default_condition["condition"];
            }
            else{
                $params = array_merge($params, $default_condition);
            }
            return $obj_model->find($params);
        } else {
            return $obj_model->find($default_condition);
        }

        
    }
   
    public static function getAllWithCondition($group = '', $order = '', $condition = '', $model_name) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "status =  1 AND deleted = 0";
        if ($condition != '')
            $Criteria->condition = $condition;
        if ($group != '')
            $Criteria->group = $group;
        if ($order != '')
            $Criteria->order = $order;
        $obj_model = new $model_name;
        $model = $obj_model->findByPk($id, $Criteria);

        return $model;
    }

    /**
     * storeModelByAttributesName($model,$val)
     * This is a function which store model values as per model attributes name.
     */
    public static function storeModelByAttributesName($model, $data) {
        $attributes = $model->attributeNames();
        $attribute_array = Array();
        foreach ($attributes as $attribute) {
            if (isset($data[$attribute])) {

                $attribute_array[$attribute] = $data[$attribute];
            }
        }
        $model->attributes = $attribute_array;
//        pre($model->attributes,true);
        return $model;
    }

    public static function saveModel($model, $attributes, $validate = false) {

        $obj_model = new $model;
        $obj_model->attributes = $attributes;
        $obj_model->save($validate);
        return $obj_model->id;
    }

    public static function updateModelByPk($model, $attributes, $pk) {

        $obj_model = new $model;
        $obj_model->updateByPk($pk, $attributes);
        return $obj_model->id;
    }

    public static function setCommonFields() {
        $id = create_guid();
        $status = 1;
        $deleted = 0;
        $date_modified = date("Y-m-d H:i:s");
        $date_entered = date("Y-m-d H:i:s");
        $created_by = Yii::app()->user->id;
        $modified_by = Yii::app()->user->id;
        return array('id' => $id, 'status' => $status, 'deleted' => $deleted,
            'date_modified' => $date_modified, 'date_entered' => $date_entered,
            'created_by' => $created_by, 'modified_user_id' => $modified_by);
    }

    public static function getValueByAttributeName($model, $id, $attribute_name) {

        $obj = new $model;
        $attributes = $obj->findByPk($id);
        return $attributes->$attribute_name;
    }
    
    //this function will return only the first row of the result
    
     public static function executeSimpleQueryFirstRow($sql) {
        $command = Yii::app()->db->createCommand($sql);
        $results = $command->queryRow();
        return $results;
    }

}

?>
