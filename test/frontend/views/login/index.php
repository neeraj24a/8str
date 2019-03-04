<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Login";
?>
<div class="page-width">
    <div class="grid">
        <div class="grid__item medium-up--one-half medium-up--push-one-quarter">
            <div class="note form-success hide" id="ResetSuccess">
                We've sent you an email with a link to update your password.
            </div>
            <div id="CustomerLoginForm" class="form-vertical">
                <?php
                    $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'options' => ['class' => 'form-vertical', 'autocomplete' => 'off'],
                    ]);
                ?>
                    <h1 class="text-center">Login For Store & DJ Drops</h1>
                    <?php echo $form->field($model, 'username')->textInput(['class' => 'frgt-pass', 'placeholder' => 'Username','autocomplete' => 'off']); ?>
                    <?php echo $form->field($model, 'password')->passwordInput(['class' => 'frgt-pass', 'placeholder' => 'Password','autocomplete' => 'off']); ?>
                    <div class="text-center">
                        <p><a href="https://www.8thwonderpromos.com/amember/login" id="RecoverPassword">Forgot your password?</a></p>
                        <?= Html::submitButton('Login', ['class' => 'btn', 'name' => 'login-button']) ?>
                        <p>
                            <a href="https://www.8thwonderpromos.com/amember/signup" id="customer_register_link">Create account</a>
                        </p>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>