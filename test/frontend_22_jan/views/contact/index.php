<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\widgets\Alert;
$this->title = "Contact Us";
?>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>Contact Us</h1>
            </div>
            <div class="col-second">
                <p>We always like to hear you.</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="<?php echo Url::toRoute('/'); ?>">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Contact Us</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container m-b-100">
    <?php $form = ActiveForm::begin(['id' => 'form-contact', 'options' => ['class' => 'contact-form', 'autocomplete' => 'off']]); ?>

    <div class="row">
        <div class="col-lg-12">
            <h3 class="billing-title mt-20 mb-10">Contact Us</h3>
            <?= Alert::widget() ?>
            <div class="row">
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'name')->textInput(['class' => 'common-input', 'placeholder' => 'Name*', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'email')->textInput(['class' => 'common-input', 'placeholder' => 'Email*', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-lg-12">
                    <?php echo $form->field($model, 'subject')->textInput(['class' => 'common-input', 'placeholder' => 'Subject*', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-lg-12">
                    <?php echo $form->field($model, 'body')->textarea(['class' => 'common-input', 'placeholder' => 'Message*', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-lg-12">
                    <?php
                    echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">    
                <div class="col-lg-12">
                    <?= Html::submitButton('Submit', ['class' => 'btn green', 'name' => 'contact-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>