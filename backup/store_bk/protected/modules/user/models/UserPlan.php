<?php

/**
 * This is the model class for table "user_plan".
 *
 * The followings are the available columns in table 'user_plan':
 * @property string $id
 * @property string $user_id
 * @property string $plan_id
 * @property string $plan_start_date
 * @property string $plan_end_date
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class UserPlan extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_plan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id, plan_id, plan_start_date, plan_end_date, created_by, modified_by, date_entered, date_modified', 'required'),
			array('status, deleted', 'numerical', 'integerOnly'=>true),
			array('id, user_id, plan_id, created_by, modified_by', 'length', 'max'=>36),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, plan_id, plan_start_date, plan_end_date, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'plan_id' => 'Plan',
			'plan_start_date' => 'Plan Start Date',
			'plan_end_date' => 'Plan End Date',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('plan_id',$this->plan_id,true);
		$criteria->compare('plan_start_date',$this->plan_start_date,true);
		$criteria->compare('plan_end_date',$this->plan_end_date,true);
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
	 * @return UserPlan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getUserActivePlan($user_id)
        {
           
           $user_plan =  UserPlan::model()->find(array("condition"=>"user_id = '$user_id' AND status = 1 AND deleted = 0 "));
           return $user_plan;
        }        
        
        
}
