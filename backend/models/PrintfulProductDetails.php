<?php

namespace backend\models; 

use Yii; 

/** 
 * This is the model class for table "printful_products". 
 * 
 * @property string $id
 * @property string $printful_product
 * @property string $color
 * @property string $size
 * @property int $printful_product_id
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */ 
class PrintfulProductDetails extends \yii\db\ActiveRecord
{ 
    /** 
     * @inheritdoc 
     */ 
    public static function tableName() 
    { 
        return 'printful_product_details'; 
    }

    public function beforeSave($insert) {
        //pre($model, true);
        if ($this->isNewRecord) {
            $this->id = create_guid();
            $this->created_by = Yii::$app->user->id;
            $this->modified_by = Yii::$app->user->id;
            $this->deleted = 0;
            $this->status = 1;
            $this->date_entered = date("Y-m-d H:i:s");
            $this->date_modified = date("Y-m-d H:i:s");
        } else {
            $this->modified_by = Yii::$app->user->id;
            $this->date_modified = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
    }

    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return [
            [['printful_product', 'color', 'size', 'printful_product_id'], 'required'],
            [['printful_product_id'], 'integer'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id','printful_product', 'color', 'size', 'created_by', 'modified_by'], 'string', 'max' => 36],
            [['status', 'deleted'], 'string', 'max' => 1],
            [['id'], 'unique'],
        ]; 
    } 

    /** 
     * @inheritdoc 
     */ 
    public function attributeLabels() 
    { 
        return [ 
            'id' => 'ID',
            'printful_product' => 'Printful Product',
            'color' => 'Color',
            'size' => 'Size',
            'printful_product_id' => 'Printful Product ID',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ]; 
    } 
} 