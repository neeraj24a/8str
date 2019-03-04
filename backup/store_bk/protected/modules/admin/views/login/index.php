<div class="login-box">
    <div class="login-logo">
        <b>Admin</b>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array(
                'autcomplete' => "off"
            ),
        ));
        ?>
        <div class="form-group has-feedback">
            <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Username')); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
            <?php echo $form->error($model, 'password'); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
        <?php $this->endWidget(); ?>
        <a href="#">I forgot my password</a><br>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->


