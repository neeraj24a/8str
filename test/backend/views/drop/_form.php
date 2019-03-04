<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Drops */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card drops-form">
    <div class="card-header card-header-rose card-header-icon">
        <div class="card-text">
            <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="card-body">
        <p class="btn-warning bold">Note: Enter youtube link for video drop & file for audio drop</p>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'type')->dropDownList([ 'audio' => 'Audio Drops', 'video' => 'Video Drops'], ['prompt' => 'Select','class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'thumbnail')->fileInput(['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'file')->fileInput(['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'youtube')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'soundcloud')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6 form-group">
                    <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                </div>
                <div class="col-lg-6 form-group">
                    <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class' => 'form-control']) ?>
                </div>
            </div>
            <div class="col-lg-12 m-t-20">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['/drop'], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
