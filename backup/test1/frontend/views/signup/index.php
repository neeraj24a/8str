<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = "Sign Up";
?>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>Sign Up</h1>
            </div>
            <div class="col-second">
                <p>Signup for an account with us.</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center justify-content-end">
                    <a href="<?php echo Url::toRoute('/'); ?>">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Sign Up</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container m-b-100">
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'billing-form', 'autocomplete' => 'off']]); ?>

    <div class="row">
        <div class="col-lg-12">
            <h3 class="billing-title mt-20 mb-10">Sign Up</h3>
            <div class="row">
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'first_name')->textInput(['class' => 'common-input mt-10', 'placeholder' => 'First Name*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'First Name*'", 'autocomplete' => 'off'])->label(false); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'last_name')->textInput(['class' => 'common-input mt-10', 'placeholder' => 'Last Name*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Last Name*'", 'autocomplete' => 'off'])->label(false); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'username')->textInput(['class' => 'common-input mt-10', 'placeholder' => 'Username*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Username*'", 'autocomplete' => 'off'])->label(false); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'password')->passwordInput(['class' => 'common-input mt-10', 'placeholder' => 'Password*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Password*'", 'autocomplete' => 'off'])->label(false); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'email')->textInput(['class' => 'common-input mt-10', 'placeholder' => 'Email*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Email*'", 'autocomplete' => 'off'])->label(false); ?>
                </div>
            </div>
            <div class="row">    
                <div class="col-lg-12">
                    <?= Html::submitButton('Signup', ['class' => 'btn green', 'name' => 'signup-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>