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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'desc' => 'Add Description',
        ];
    }
}
