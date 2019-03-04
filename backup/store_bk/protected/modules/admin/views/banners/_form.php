<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'banners-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<div class="box-body" id="container">
	<div class="row form-group" id="row">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'image_type'); ?>
			<?php echo $form->textField($model,'link',array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'image_type'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'image'); ?>
			<?php echo $form->fileField($model,'banner', array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
	</div>
</div>
<div class="box-footer">
	<?php echo CHtml::link('Back', array('/admin/banners'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>

<?php $this->endWidget(); ?>