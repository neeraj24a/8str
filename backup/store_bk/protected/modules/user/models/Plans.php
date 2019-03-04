<?php

/**
 * This is the model class for table "plans".
 *
 * The followings are the available columns in table 'plans':
 * @property string $id
 * @property string $plan_name
 * @property string $plan_desc
 * @property string $plan_price
 * @property string $plan_duration
 * @property string $free_duration
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Plans extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, plan_name, plan_price, plan_duration,plan_duration_type, created_by, modified_by, date_entered, date_modified', 'required'),
			array('status, deleted', 'numerical', 'integerOnly'=>true),
			array('id, created_by, modified_by', 'length', 'max'=>36),
			array('plan_duration,free_duration', 'length', 'max'=>3),
			array('plan_duration,free_duration', 'numerical', 'integerOnly'=>true),
			array('plan_name', 'length', 'max'=>255),
			array('plan_desc', 'length', 'max'=>512),
			array('plan_price', 'length', 'max'=>16),
			array('plan_duration_type, free_duration_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plan_name, plan_desc, plan_price, plan_duration,plan_duration_type, free_duration,free_duration_type, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on'=>'search'),
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
			'plan_name' => 'Plan Name',
			'plan_desc' => 'Plan Desc',
			'plan_price' => 'Plan Price',
			'plan_duration' => 'Plan Duration',
			'plan_duration_type' => 'Plan Duration Type',
			'free_duration' => 'Free Duration',
			'free_duration_type' => 'Free Duration Type',
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
		$criteria->compare('plan_name',$this->plan_name,true);
		$criteria->compare('plan_desc',$this->plan_desc,true);
		$criteria->compare('plan_price',$this->plan_price,true);
		$criteria->compare('plan_duration',$this->plan_duration,true);
		$criteria->compare('free_duration',$this->free_duration,true);
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
	 * @return Plans the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
