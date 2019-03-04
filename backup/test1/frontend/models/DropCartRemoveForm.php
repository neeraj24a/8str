<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class DropCartRemoveForm extends Model
{
    public $type;
    public $product;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // desc is required
            [['type', 'product'], 'required'],
        ];
    }
}
