<section class="content-header">
  <h1>
    Update
    <small>Product Images</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo base_url() . '/admin/productGallery'; ?>"><i class="fa fa-dashboard"></i> Product Gallery</a></li>
    <li class="active">Update</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<?php $p = Product::model()->findByPk($product); ?>
					<h3 class="box-title"><?php echo $p->name; ?></h3>
				</div>
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
					<div class="form-group pull-left" style="width:100%;">
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
					<?php 
						$i = 0;
						foreach($gallery as $g): 
						$sel = [];
						$sel[$g->image_type] = array('selected' => true);
						//pre($sel);
					?>
					<div class="form-group pull-left" style="width:100%;" id="row">
						<div class="col-xs-5">
							<?php echo $form->labelEx($model,'image_type'); ?>
							<?php echo CHtml::dropDownList('ProductGallery[image_type][]',0,array('m' => 'Main Image','g' => 'Gallery Image','t' => 'Thumbnail'),array('empty'=>'Select Image Type','class' => 'form-control','options' => $sel)); ?>
							<?php echo $form->error($model,'image_type'); ?>
						</div>
						<div class="col-xs-6">
							<?php echo $form->labelEx($model,'image'); ?>
							<?php echo CHtml::fileField('ProductGallery[image][]', 0,array('class' => 'form-control')); ?>
							<?php echo $form->error($model,'image'); ?>
						</div>
						<div class="col-xs-1">
							<?php if($i == 0): ?>
								<a href="javascript:void(0);" class="add-row"><i class="fa fa-plus"></i></a>
							<?php else: ?>
								<a href="javascript:void(0);" class="removeRow"><i class="fa fa-minus"></i></a>
							<?php endif; ?>
						</div>
					</div>
					<?php $i++; endforeach; ?>
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
							$("#row").clone().appendTo("#container").find("a.add-row").html('<i class="fa fa-minus"></i>').addClass("removeRow").removeClass("add-row");
						});
						$(document).on("click",".removeRow",function(){
							$(this).parent().parent().remove();
						});
					});
				</script>
				
			</div>
		</div>
	</div>
</section>
