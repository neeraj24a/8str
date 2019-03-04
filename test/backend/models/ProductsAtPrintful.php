<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products_at_printful".
 *
 * @property string $id
 * @property string $store_product
 * @property string $color
 * @property string $size
 * @property string $printful_id
 * @property string $external_id
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class ProductsAtPrintful extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_at_printful';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'store_product', 'color', 'size', 'printful_id', 'external_id', 'created_by', 'modified_by', 'date_entered', 'date_modified'], 'required'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id', 'store_product', 'color', 'size', 'printful_id', 'external_id', 'created_by', 'modified_by'], 'string', 'max' => 36],
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
            'store_product' => 'Store Product',
            'color' => 'Color',
            'size' => 'Size',
            'printful_id' => 'Printful ID',
            'external_id' => 'External ID',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }
}
