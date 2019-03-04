<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $category
 * @property string $slug
 * @property string $description
 * @property string $picture
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Category extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'category';
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

    public function behaviors() {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'category',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category'], 'required'],
            [['description'], 'string'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id', 'created_by', 'modified_by'], 'string', 'max' => 36],
            [['category', 'slug'], 'string', 'max' => 128],
//            [['picture'], 'string', 'max' => 255],
            [['status', 'deleted'], 'integer', 'max' => 1],
            [['picture'], 'file', 'extensions' => 'png, jpg', 'skipOnEmpty' => true],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'slug' => 'Slug',
            'description' => 'Description',
            'picture' => 'Picture',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }

}
