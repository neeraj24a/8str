<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $sku
 * @property string $name
 * @property string $category
 * @property string $slug
 * @property integer $quantity
 * @property string $short_desc
 * @property string $description
 * @property integer $in_stock
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class Product extends AdminBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, sku, name, category, description, created_by, modified_by, date_entered, date_modified', 'required'),
			array('quantity, in_stock, status, deleted', 'numerical', 'integerOnly'=>true),
			array('id, category, created_by, modified_by', 'length', 'max'=>36),
			array('sku', 'length', 'max'=>64),
			array('price, offer_price', 'length', 'max'=>16),
			array('name', 'length', 'max'=>256),
			array('slug, short_desc', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sku, name, category, slug, quantity, price, offer_price, short_desc, description, in_stock, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on'=>'search'),
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
                    'product_main_image' => array(self::HAS_MANY,'ProductGallery','product','condition' =>'product_main_image.image_type = "m"'),
                    'product_gallery_image' => array(self::HAS_MANY,'ProductGallery','product','condition' =>'product_gallery_image.image_type = "g"'),
		);
	}
	
	/**
         * Behaviors for this model
        */
        public function behaviors() {
            return array(
                'slug' => array(
                    'class' => 'ext.behaviors.SluggableBehavior.SluggableBehavior',
                    'columns' => array('name'),
                    'unique' => true,
                    'update' => true,
                ),
            );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sku' => 'Sku',
			'name' => 'Name',
			'category' => 'Category',
			'slug' => 'Slug',
			'quantity' => 'Quantity',
			'price' => 'Price (MRP)',
			'offer_price' => 'Discounted Price',
			'short_desc' => 'Short Desc',
			'description' => 'Description',
			'in_stock' => 'In Stock',
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
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('short_desc',$this->short_desc,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('in_stock',$this->in_stock);
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
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
