<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property string $id
 * @property string $email
 * @property int $status
 * @property int $deleted
 * @property string $date_entered
 * @property string $date_modified
 */
class Guests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guests';
    }

    public function beforeSave($insert) {
        //pre($model, true);
        if ($this->isNewRecord) {
            $this->id = create_guid();
            $this->deleted = 0;
            $this->status = 1;
            $this->date_entered = date("Y-m-d H:i:s");
            $this->date_modified = date("Y-m-d H:i:s");
        } else {
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
            [['email'], 'required'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id'], 'string', 'max' => 36],
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
            'email' => 'Guest Email',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }
}
