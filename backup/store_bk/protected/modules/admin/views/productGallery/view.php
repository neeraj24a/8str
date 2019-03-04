<?php
/* @var $this ProductGalleryController */
/* @var $model ProductGallery */

$this->breadcrumbs=array(
	'Product Galleries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductGallery', 'url'=>array('index')),
	array('label'=>'Create ProductGallery', 'url'=>array('create')),
	array('label'=>'Update ProductGallery', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductGallery', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductGallery', 'url'=>array('admin')),
);
?>

<h1>View ProductGallery #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product',
		'image_type',
		'image',
		'status',
		'deleted',
		'created_by',
		'modified_by',
		'date_entered',
		'date_modified',
	),
)); ?>
