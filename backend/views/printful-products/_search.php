<?php

use yii\helpers\Html; 
use yii\widgets\ActiveForm; 

/* @var $this yii\web\View */ 
/* @var $model backend\models\PrintfulProductsSearch */ 
/* @var $form yii\widgets\ActiveForm */ 
?> 

<div class="printful-products-search"> 

    <?php $form = ActiveForm::begin([ 
        'action' => ['index'], 
        'method' => 'get', 
        'options' => [ 
            'data-pjax' => 1 
        ], 
    ]); ?> 

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'printful_product_name') ?>

    <?= $form->field($model, 'color') ?>

    <?= $form->field($model, 'size') ?>

    <?= $form->field($model, 'printful_product_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'modified_by') ?>

    <?php // echo $form->field($model, 'date_entered') ?>

    <?php // echo $form->field($model, 'date_modified') ?>

    <div class="form-group"> 
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?> 
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?> 
    </div> 

    <?php ActiveForm::end(); ?> 

</div> 