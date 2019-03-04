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
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'sku')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php $list = ArrayHelper::map(backend\models\Category::findAll(['status' => 1]), 'id', 'category'); ?>
                        <?= $form->field($model, 'category')->dropDownList($list,['prompt' => 'Select Category','class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'main_image')->fileInput(['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'units_in_stock')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'variation')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'size')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'colors')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'weight_type')->dropDownList([ 'pound' => 'Pound', 'gram' => 'Gram', 'kg' => 'Kg', 'ounce' => 'Ounce', ], ['prompt' => 'Select','class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'weight')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'available')->dropDownList(getParam('boolean'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'discount')->dropDownList(getParam('boolean'),['prompt' => 'Select','class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-12 form-group">
                    <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class' => 'form-control']) ?>
                </div>
            </div>
            <div class="col-lg-12 m-t-20">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['/products'], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>