<section class="content-header">
  <h1>
    Update
    <small>Related Product</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo base_url() . '/admin/relatedProducts'; ?>"><i class="fa fa-dashboard"></i> Related Products</a></li>
    <li class="active">Update</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $product->name; ?></h3>
				</div>
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'related-products-form',
					// Please note: When you enable ajax validation, make sure the corresponding
					// controller action is handling ajax validation correctly.
					// There is a call to performAjaxValidation() commented in generated controller code.
					// See class documentation of CActiveForm for details on this.
					'enableAjaxValidation'=>false,
				)); ?>
				<div class="box-body">
					<div class="col-xs-6">
						<div class="form-group">
							<?php echo $form->labelEx($model,'product'); ?>
							<?php 
								$attrs = array('empty'=>'Select Product','class' => 'form-control');
								if($product !== null){
									$model->product = $product;
									$attrs = array('empty'=>'Select Product',"disabled" => "disabled",'class' => 'form-control');
								}
								$products = CHtml::listData(Product::model()->findAll(), 'id', 'name');
							?>
							<?php echo $form->dropDownList($model,'product',$products,
									$attrs,
									array(
										'ajax' => array(
										'type'=>'POST', //request type
										'url'=>CController::createUrl('relatedProducts/populateRelated'), //url to call.
										'update'=>'#related_product_list', //selector to update
										'data' => array('parent', 'js:this.value'),
									))
									); ?>
							<?php echo $form->error($model,'product'); ?>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<?php echo $form->labelEx($model,'related'); ?>
							<?php echo CHtml::dropDownList('RelatedProducts[related][]', [],[],array('empty'=>'Select Related Product','id' => 'related_product_list','class' => 'form-control','multiple' => 'multiple')); ?>
							<?php echo $form->error($model,'related'); ?>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<?php echo CHtml::link('Back', array('/admin/relatedProducts'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
				</div>
				<?php $this->endWidget(); ?>
				<?php if($product !== null): ?>
				<script>
					$(document).ready(function(){
						var product = "<?php echo $product->id; ?>";
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
			</div>
		</div>
	</div>
</section>
