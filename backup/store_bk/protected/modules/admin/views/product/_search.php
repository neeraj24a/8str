<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions'=>array('class' => 'search-form')
)); ?>
<div class="box-body">
	<div class="form-group">
		<div class="col-xs-4">
			<?php echo $form->label($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class' => 'form-control')); ?>
		</div>
		<div class="col-xs-4">
			<?php echo $form->label($model,'sku'); ?>
			<?php echo $form->textField($model,'sku',array('size'=>60,'maxlength'=>255,'class' => 'form-control')); ?>
		</div>
		<div class="col-xs-4">
			<?php echo $form->label($model,'category'); ?>
			<?php 
				$all_cat = Category::model()->findAll(); 
				$list = CHtml::listData($all_cat, 'id', 'name');  
			?>
			<?php echo $form->dropDownList($model,'category',$list, array('empty'=>'Select Category','class' => 'form-control')); ?>
		</div>
	</div>
</div>
<div class="box-footer">
	<?php echo CHtml::submitButton('Search',array("class" => 'btn btn-info search-button')); ?>
	<a href="<?php echo base_url().'/admin/product/manage' ?>" class="btn btn-warning">Clear</a>
</div>
<?php $this->endWidget(); ?>
