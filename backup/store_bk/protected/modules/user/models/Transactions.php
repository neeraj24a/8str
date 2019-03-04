<?php

/**
 * This is the model class for table "transactions".
 *
 * The followings are the available columns in table 'transactions':
 * @property string $id
 * @property string $invoice
 * @property string $user_id
 * @property string $plan_id
 * @property string $transaction_id
 * @property string $payment_method
 * @property string $payment_status
 * @property string $amount
 * @property string $details
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Transactions extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, invoice, user_id, plan_id, transaction_id, payment_method, amount, details, created_by, modified_by, date_entered, date_modified', 'required'),
			array('status, deleted', 'numerical', 'integerOnly'=>true),
			array('id, user_id, plan_id, created_by, modified_by', 'length', 'max'=>36),
			array('invoice', 'length', 'max'=>64),
			array('transaction_id', 'length', 'max'=>128),
			array('payment_method', 'length', 'max'=>6),
			array('payment_status', 'length', 'max'=>9),
			array('amount', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice, user_id, plan_id, transaction_id, payment_method, payment_status, amount, details, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on'=>'search'),
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
			'invoice' => 'Invoice',
			'user_id' => 'User',
			'plan_id' => 'Plan',
			'transaction_id' => 'Transaction',
			'payment_method' => 'Payment Method',
			'payment_status' => 'Payment Status',
			'amount' => 'Amount',
			'details' => 'Details',
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
		$criteria->compare('invoice',$this->invoice,true);
		$criteria->compare('user_id',Yii::app()->user->id,true);
		$criteria->compare('plan_id',$this->plan_id,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('payment_status',$this->payment_status,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('details',$this->details,true);
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
	 * @return Transactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
