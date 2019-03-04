<?php

/**
 * This is the model class for table "temp_media".
 *
 * The followings are the available columns in table 'temp_media':
 * @property string $id
 * @property string $s3_bucket
 * @property string $file_name
 * @property string $s3_url
 * @property string $user_id
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Temp extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temp_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, s3_bucket, acl, type, file_name, s3_url, user_id, created_by, modified_by, date_entered, date_modified', 'required'),
			array('acl, type, status, deleted', 'numerical', 'integerOnly'=>true),
			array('id, user_id, created_by, modified_by', 'length', 'max'=>36),
			array('s3_bucket', 'length', 'max'=>128),
			array('file_name', 'length', 'max'=>256),
			array('s3_url', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, s3_bucket, acl, type, file_name, s3_url, user_id, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			's3_bucket' => 'S3 Bucket',
			'file_name' => 'File Name',
			's3_url' => 'S3 Url',
			'user_id' => 'User',
			'status' => 'Status',
			'deleted' => 'Deleted',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
			'date_entered' => 'Date Entered',
			'date_modified' => 'Date Modified',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('s3_bucket',$this->s3_bucket,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('s3_url',$this->s3_url,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('date_entered',$this->date_entered,true);
		$criteria->compare('date_modified',$this->date_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Temp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
