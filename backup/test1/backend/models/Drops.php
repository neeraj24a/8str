<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "drops".
 *
 * @property string $id
 * @property string $title
 * @property string $type
 * @property string $thumbnail
 * @property string $file
 * @property string $description
 * @property string $youtube
 * @property string $soundcloud
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Drops extends \yii\db\ActiveRecord
{
    public $quantity;
    public $desc;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drops';
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
                'attribute' => 'title',
                'ensureUnique'=>true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'description', 'price'], 'required'],
            [['type', 'description'], 'string'],
            [['date_entered', 'date_modified'], 'safe'],
            [['id', 'created_by', 'modified_by'], 'string', 'max' => 36],
            [['slug', 'title', 'thumbnail', 'file'], 'string', 'max' => 255],
            [['youtube', 'soundcloud'], 'string', 'max' => 512],
            [['youtube', 'soundcloud'],'url'],
            [['status', 'deleted'], 'string', 'max' => 1],
            [['price'], 'string', 'max' => 11],
            [['id'], 'unique'],
            [['thumbnail'], 'file', 'extensions' => 'png, jpg', 'allowEmpty' => true],
            [['file'], 'file', 'extensions' => 'mp4, mp3', 'allowEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type',
            'slug' => 'Slug',
            'price' => 'Price',
            'thumbnail' => 'Thumbnail',
            'file' => 'File',
            'description' => 'Description',
            'youtube' => 'Youtube',
            'soundcloud' => 'Soundcloud',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }
}
