<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property string $id
 * @property string $image
 * @property string $url
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
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
            [['image'], 'required'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id', 'created_by', 'modified_by'], 'string', 'max' => 36],
            [['url'], 'string', 'max' => 512],
            [['status', 'deleted'], 'string', 'max' => 1],
            [['id'], 'unique'],
            [['image'], 'file', 'extensions' => 'png, jpg', 'skipOnEmpty' => !$this->isNewRecord],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'url' => 'Url',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }
}
