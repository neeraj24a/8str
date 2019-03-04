<script src="<?php echo base_url().'/themes/admin/dist/js/tinymce/tinymce.min.js'; ?>"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'qna-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); 	
?>
<?php //pre($model->getErrors());  ?>
<div class="box-body">
	<div class="form-group">		
		<div class="col-xs-12">
			<?php echo $form->labelEx($model,'question'); ?>
			<?php echo $form->textArea($model,'question',array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'question'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<?php echo $form->labelEx($model,'answer'); ?>
			<?php echo $form->textArea($model,'answer',array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'answer'); ?>
		</div>
	</div>
</div>
<div class="box-footer">
    <?php echo CHtml::link('Back', array('/admin/qna'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>
<?php $this->endWidget(); ?>
<script>
	tinymce.init({
	  selector: 'textarea',
	  height: 300,
	  theme: 'modern',
	  plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
	  ],
	  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
	  image_advtab: true
	 });
</script>