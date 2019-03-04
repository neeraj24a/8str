<script src="<?php echo base_url().'/themes/admin/dist/js/bootstrap-multiselect.js'; ?>"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'related-products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php //pre($model->getErrors());  ?>
<div class="box-body">
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'product'); ?>
			<?php 
				$attrs = array('empty'=>'Select Product','class' => 'form-control');
				if($product !== null){
					$model->product = $product;
					$attrs = array('empty'=>'Select Product',"disabled" => "disabled",'class' => 'form-control');
				}
				$attrs['ajax'] = array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('relatedProducts/populateRelated'), //url to call.
						'update'=>'#related_product_list', //selector to update
						'data' => array('parent', 'js:this.value'),
					);
				$products = CHtml::listData(Product::model()->findAll(), 'id', 'name');
			?>
			<?php echo $form->dropDownList($model,'product',$products,$attrs); ?>
			<?php echo $form->hiddenField($model,'product',array("value"=>"$product")); ?>
			<?php echo $form->error($model,'product'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'related'); ?>
			<?php echo CHtml::dropDownList('RelatedProducts[related][]',[], [],array('empty'=>'Select Related Product','id' => 'related_product_list','class' => 'form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->error($model,'related'); ?>
		</div>
	</div>
</div>
<div class="box-footer">
    <?php echo CHtml::link('Back', array('/admin/product'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>
<?php $this->endWidget(); ?>
<script>
	$(document).ready(function(){
		//$('#related_product_list').multiselect();
	});
</script>
<?php if($product !== null): ?>
<script>
	$(document).ready(function(){
		var product = "<?php echo $product; ?>";
		$.ajax({
			'type':'POST', //request type
			'url': "<?php echo CController::createUrl('relatedProducts/populateRelated'); ?>",
			'update':'#related_product_list', //selector to update
			'data' : { parent: product },
			'success' : function(data){
				$('#related_product_list').html(data);
			}
		});
	});
</script>
<?php endif; ?>
