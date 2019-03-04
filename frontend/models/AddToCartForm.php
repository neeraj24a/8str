<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddToCartForm extends Model
{
    public $size;
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
            [['size','type', 'quantity', 'product'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'size' => 'Size',
        ];
    }
}
