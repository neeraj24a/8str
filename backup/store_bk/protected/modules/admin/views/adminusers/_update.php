<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'genres-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<div class="box-body">
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'first_name'); ?>
            <?php echo $form->textField($model, 'first_name', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'first_name'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'last_name'); ?>
            <?php echo $form->textField($model, 'last_name', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'last_name'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'role_id'); ?>
            <?php echo $form->dropDownList($model, 'role_id', $roles, array('empty' => 'Select Role', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'role_id'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'state_id'); ?>
            <?php echo $form->dropDownList($model, 'state_id', $states, array('empty' => 'Select State', 'class' => 'form-control')); ?>
            <p>Note: Select Country First</p>
            <?php echo $form->error($model, 'state_id'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'country_id'); ?>
            <?php
            echo $form->dropDownList($model, 'country_id', $countries, array(
                'empty' => 'Select Country',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('states'),
                    'update' => '#Adminusers_state_id',
                    'data' => array('country' => 'js:this.value'),
            )));
            ?>
            <?php echo $form->error($model, 'country_id'); ?>
        </div>
    </div>
</div>
<div class="box-footer">
    <?php echo CHtml::link('Back', array('/admin/adminusers'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>
<?php $this->endWidget(); ?>