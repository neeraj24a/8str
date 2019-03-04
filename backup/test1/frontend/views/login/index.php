<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Login";
?>
<section class="banner-area top-breadcrumbs">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>Login</h1>
            </div>
            <div class="col-second">
                <p>Login For Store & DJ Drops</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="/">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Login</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<section id="forget-block">
    <div class="container">
        <div class="login-form">
            <h4>Enter Login Credentials Below</h4>
            <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['class' => 'form', 'autocomplete' => 'off'],
                ]);
            ?>
            <div class="col-md-12">
                <?php echo $form->field($model, 'username')->textInput(['class' => 'frgt-pass', 'placeholder' => 'Username','autocomplete' => 'off']); ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->field($model, 'password')->passwordInput(['class' => 'frgt-pass', 'placeholder' => 'Password','autocomplete' => 'off']); ?>
            </div>
            <p class="remeber-head">
                <input type="checkbox">
                Remember me 
                <a href="https://www.8thwonderpromos.com/amember/login">Forget Password</a>
            </p>
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'submit-link', 'name' => 'login-button']) ?> | 
                    <a href="<?php echo yii\helpers\Url::toRoute('/signup'); ?>" class="green-txt">Sign Up</a>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <h6>Don’t have an account? <a href="https://www.8thwonderpromos.com/amember/signup">Join now</a></h6>
            <h5>By clicking your agree to <a href="https://pool.8thwonderpromos.com/terms">terms &amp; conditions.</a></h5>
        </div>
    </div>
</section>