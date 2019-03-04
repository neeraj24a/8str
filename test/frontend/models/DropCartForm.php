<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class DropCartForm extends Model
{
    public $desc;
	public $logo;
    public $type;
    public $quantity;
    public $product;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // desc is required
            [['desc','type', 'quantity', 'product'], 'required'],
			[['logo'], 'file', 'extensions' => 'png, jpg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'desc' => 'Enter DJ Name',
			'logo' => 'Upload DJ Logo'
        ];
    }
}
