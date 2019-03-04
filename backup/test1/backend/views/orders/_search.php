<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer') ?>

    <?= $form->field($model, 'order_number') ?>

    <?= $form->field($model, 'order_amount') ?>

    <?= $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'transaction_id') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'order_date') ?>

    <?php // echo $form->field($model, 'shipping_date') ?>

    <?php // echo $form->field($model, 'is_paid') ?>

    <?php // echo $form->field($model, 'freight') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'shipping_method') ?>

    <?php // echo $form->field($model, 'is_shipped') ?>

    <?php // echo $form->field($model, 'shipping_tracking') ?>

    <?php // echo $form->field($model, 'shipping_address') ?>

    <?php // echo $form->field($model, 'billing_address') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'modified_by') ?>

    <?php // echo $form->field($model, 'date_entered') ?>

    <?php // echo $form->field($model, 'date_modified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
