<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="box-body">
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'sku'); ?>
			<?php echo $form->textField($model,'sku',array('size'=>'60','maxlength'=>'128','class' => 'form-control')); ?>
			<?php echo $form->error($model,'sku'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>'60','maxlength'=>'128','class' => 'form-control')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'category'); ?>
			<?php 
				$all_cat = Category::model()->findAll(); 
				$list = CHtml::listData($all_cat, 'id', 'name');  
			?>
			<?php echo $form->dropDownList($model,'category',$list, array('empty'=>'Select Category','class' => 'form-control')); ?>
			<?php echo $form->error($model,'category'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'quantity'); ?>
			<?php echo $form->textField($model,'quantity',array('size'=>'60','maxlength'=>'11','class' => 'form-control')); ?>
			<?php echo $form->error($model,'quantity'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'price'); ?>
			<?php echo $form->textField($model,'price',  array('size'=>'60','maxlength'=>'16','class' => 'form-control')); ?>
			<?php echo $form->error($model,'price'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'offer_price'); ?>
			<?php echo $form->textField($model,'offer_price',array('size'=>'60','maxlength'=>'16','class' => 'form-control')); ?>
			<?php echo $form->error($model,'offer_price'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'in_stock'); ?>
			<?php echo $form->checkBox($model,'in_stock',  array('checked'=>'checked','class' => 'form-control')); ?>
			<?php echo $form->error($model,'in_stock'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<?php echo $form->labelEx($model,'short_desc'); ?>
			<?php echo $form->textField($model,'short_desc',  array('size'=>'60','maxlength'=>'512','class' => 'form-control')); ?>
			<?php echo $form->error($model,'short_desc'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',  array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	</div>
</div>
<div class="box-footer">
    <?php echo CHtml::link('Back', array('/admin/product'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array("class" => 'btn btn-info pull-right', "id" => "save_to_pg")); ?>
</div>
<?php $this->endWidget(); ?>