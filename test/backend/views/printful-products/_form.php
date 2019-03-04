<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card products-form">
    <div class="card-header card-header-rose card-header-icon">
        <div class="card-text">
            <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="form-group">
                        <?= $form->field($model, 'printful_product_name')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
             </div>
            <div class="col-lg-12 m-t-20">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['/printful-products'], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
