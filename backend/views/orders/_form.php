<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card products-form">
    <div class="card-header card-header-rose card-header-icon">
        <div class="card-text">
            <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php $c_list = ArrayHelper::map(backend\models\Users::findAll(['status' => 1,'type' => 'general']), 'id', 'username'); ?>
                        <?= $form->field($model, 'customer')->dropDownList($c_list,['prompt' => 'Select','class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'order_number')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'order_amount')->textInput(['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php $list = [ 'cod' => 'Cod', 'netbanking' => 'Netbanking', 'cc' => 'Cc', 'dc' => 'Dc', 'paypal' => 'Paypal']; ?>
                        <?= $form->field($model, 'payment_method')->dropDownList($list,['prompt' => 'Select','class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'transaction_id')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php $s_list = [ 'success' => 'Success', 'review' => 'Review', 'pending' => 'Pending', 'failed' => 'Failed']; ?>
                        <?= $form->field($model, 'payment_status')->dropDownList($s_list,['prompt' => 'Select','class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'order_date')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'shipping_date')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 m-t-20">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['/orders'], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
