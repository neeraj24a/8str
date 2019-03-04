<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions'=>array('class' => 'search-form')
)); ?>
<div class="box-body">
	<div class="form-group">
		<div class="col-xs-12">
			<?php echo $form->labelEx($model,'question'); ?>
			<?php 
				$all_q = Qna::model()->findAll(); 
				$questions = CHtml::listData($all_q, 'question', 'question');
			?>
			<?php echo $form->dropDownList($model,'question',$questions,array('empty'=>'Select Question','class' => 'form-control')); ?>
		</div>
	</div>
</div>
<div class="box-footer">
	<?php echo CHtml::submitButton('Search',array("class" => 'btn btn-info search-button')); ?>
	<a href="<?php echo base_url().'/admin/qna/manage' ?>" class="btn btn-warning">Clear</a>
</div>
<?php $this->endWidget(); ?>