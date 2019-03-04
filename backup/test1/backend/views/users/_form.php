<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card">
    <div class="card-header card-header-rose card-header-icon">
        <div class="card-text">
            <h4 class="card-title">Users Form</h4>
        </div>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'type')->dropDownList(['admin' => 'Admin'],
                                ['prompt' => 'Select Type','class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 m-t-20">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['/users'], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>