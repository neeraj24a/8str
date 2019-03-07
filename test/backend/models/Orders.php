<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $id
 * @property string $is_guest
 * @property string $customer
 * @property string $order_number
 * @property string $order_amount
 * @property string $payment_method
 * @property string $transaction_id
 * @property string $payment_status
 * @property string $order_date
 * @property string $shipping_date
 * @property int $is_paid
 * @property string $freight
 * @property string $note
 * @property string $shipping_method
 * @property int $is_shipped
 * @property string $shipping_tracking
 * @property string $shipping_address
 * @property string $billing_address
 * @property string $payment_details
 * @property int $status
 * @property int $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Orders extends \yii\db\ActiveRecord {

    public function beforeSave($insert) {
        //pre($model, true);
        if ($this->isNewRecord) {
            $this->id = create_guid();
            if(empty($this->created_by)){
				$this->created_by = Yii::$app->user->id;
			}
			if(empty($this->modified_by)){
				$this->modified_by = Yii::$app->user->id;
			}
            $this->deleted = 0;
            $this->status = 1;
            $this->date_entered = date("Y-m-d H:i:s");
            $this->date_modified = date("Y-m-d H:i:s");
        } else {
            if(empty($this->modified_by)){
				$this->modified_by = Yii::$app->user->id;
			}
            $this->date_modified = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'is_guest', 'customer', 'order_number', 'order_amount', 'payment_method', 'transaction_id', 'payment_status', 'order_date', 'freight', 'shipping_address', 'billing_address', 'date_entered', 'date_modified'], 'required'],
            [['payment_method', 'payment_status', 'payment_details'], 'string'],
            [['order_date', 'shipping_date', 'date_entered', 'date_modified'], 'safe'],
            [['id', 'customer', 'shipping_address', 'billing_address', 'created_by', 'modified_by'], 'string', 'max' => 36],
            [['order_number', 'paypal_order_id'], 'string', 'max' => 32],
            [['order_amount', 'freight'], 'string', 'max' => 16],
            [['transaction_id'], 'string', 'max' => 64],
			[['printful_order'], 'integer', 'max' => 11],
            [['is_guest', 'is_paid', 'is_shipped', 'printful_synced', 'status', 'deleted'], 'string', 'max' => 1],
            [['note', 'shipping_tracking'], 'string', 'max' => 512],
            [['shipping_method'], 'string', 'max' => 256],
            [['id','order_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'is_guest' => 'Guest',
            'customer' => 'Customer',
            'order_number' => 'Order Number',
            'order_amount' => 'Order Amount',
            'payment_method' => 'Payment Method',
            'transaction_id' => 'Transaction ID',
            'payment_status' => 'Payment Status',
            'payment_details' => 'Payment Details',
            'order_date' => 'Order Date',
            'shipping_date' => 'Shipping Date',
            'is_paid' => 'Is Paid',
			'printful_order' => 'Printful Order',
			'printful_synced' => 'Synced To Printful',
			'paypal_order_id' => 'Paypal Order',
            'freight' => 'Freight',
            'note' => 'Note',
            'shipping_method' => 'Shipping Method',
            'is_shipped' => 'Is Shipped',
            'shipping_tracking' => 'Shipping Tracking',
            'shipping_address' => 'Shipping Address',
            'billing_address' => 'Billing Address',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }

}
