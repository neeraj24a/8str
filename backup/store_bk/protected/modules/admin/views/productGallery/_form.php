<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-gallery-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<div class="box-body" id="container">
	<div class="row form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'product'); ?>
			<?php 
				$attrs = array('empty'=>'Select Product','class' => 'form-control');
				if($product !== null){
					$model->product = $product;
					$attrs = array('empty'=>'Select Product',"disabled" => "disabled",'class' => 'form-control');
				}
				$products = CHtml::listData(Product::model()->findAll(), 'id', 'name');
			?>
			<?php echo $form->dropDownList($model,'product',$products,$attrs); ?>
			<?php echo $form->error($model,'product'); ?>
		</div>
	</div>
	<div class="row form-group" id="row">
		<div class="col-xs-5">
			<?php echo $form->labelEx($model,'image_type'); ?>
			<?php echo CHtml::dropDownList('ProductGallery[image_type][]',0,array('m' => 'Main Image','g' => 'Gallery Image','t' => 'Thumbnail'),array('empty'=>'Select Image Type','class' => 'form-control')); ?>
			<?php echo $form->error($model,'image_type'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'image'); ?>
			<?php echo CHtml::fileField('ProductGallery[image][]', 0,array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
		<div class="col-xs-1">
			<a href="javascript:void(0);" class="add-row">
				<i class="fa fa-plus"></i>
			</a>
		</div>
	</div>
</div>
<div class="box-footer">
	<?php echo CHtml::link('Back', array('/admin/productGallery'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
	$(document).ready(function(){
		var row = $("#row");
		$(document).on("click",".add-row",function(){
			//var r = row.find("a.add-row").text("Delete").addClass("removeRow").removeClass("add-row");
			$("#row").clone().appendTo("#container").find("a.add-row").html('<i class="fa fa-minus"></i>').addClass("removeRow").removeClass("add-row");
		});
		$(document).on("click",".removeRow",function(){
			$(this).parent().parent().remove();
		});
	});
</script>
