<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'changepass-form',
    'action' => array('/user/changepassword'),
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnChange' => true,
        'validateOnSubmit' => true,
    )
        ));
?>
<div class="inner_con bg_grey">
    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
    <div class="wraper fc_black">
        <h2 class="fw600 mart15 marb15 titel">Change Password</h2>
        <div class="wraper_sm">
            <div class="marb15">
                <?php echo $form->labelEx($model, 'current_password'); ?>
                <?php echo $form->textField($model, 'current_password', array('placeholder' => 'Enter Current Password', 'class' => 't_box')); ?>
                <?php echo $form->error($model, 'current_password'); ?>
            </div>
            <div class="marb15">
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->textField($model, 'password', array('placeholder' => 'Enter New Password', 'class' => 't_box')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>  
            <div class="marb15">
                <?php echo $form->labelEx($model, 'confirm_password'); ?>
                <?php echo $form->textField($model, 'confirm_password', array('placeholder' => 'Enter Confirm Password', 'class' => 't_box')); ?>
                <?php echo $form->error($model, 'confirm_password'); ?>
            </div>      

            <div class="tar"><input type="submit" value="Submit" class="btn_big bg_red fc_white"></div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
