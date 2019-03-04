<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer_address".
 *
 * @property string $id
 * @property string $to_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $landmark
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip
 * @property int $is_default
 * @property string $address_type
 * @property string $user
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Address extends \yii\db\ActiveRecord {

    public function beforeSave($insert) {
        //pre($model, true);
        if ($this->isNewRecord) {
            $this->id = create_guid();
            $this->user = Yii::$app->user->id;
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
    public static function tableName() {
        return 'customer_address';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'first_name', 'last_name', 'address_line_1', 'city', 'state', 'country', 'zip', 'address_type', 'user', 'created_by', 'modified_by', 'date_entered', 'date_modified'], 'required'],
            [['address_type'], 'string'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id', 'user', 'created_by', 'modified_by'], 'string', 'max' => 36],
            [['first_name', 'last_name'], 'string', 'max' => 256],
            [['address_line_1', 'address_line_2', 'landmark'], 'string', 'max' => 128],
            [['city', 'state', 'country'], 'string', 'max' => 64],
            [['zip'], 'string', 'max' => 16],
            [['is_default', 'status', 'deleted'], 'string', 'max' => 1],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'landmark' => 'Landmark',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zip' => 'Zip',
            'is_default' => 'Is Default',
            'address_type' => 'Address Type',
            'user' => 'User',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }

}
