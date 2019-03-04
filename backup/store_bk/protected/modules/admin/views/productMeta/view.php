<?php
/* @var $this ProductMetaController */
/* @var $model ProductMeta */

$this->breadcrumbs=array(
	'Product Metas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductMeta', 'url'=>array('index')),
	array('label'=>'Create ProductMeta', 'url'=>array('create')),
	array('label'=>'Update ProductMeta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductMeta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductMeta', 'url'=>array('admin')),
);
?>

<h1>View ProductMeta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product',
		'meta_title',
		'meta_keywords',
		'meta_desc',
		'status',
		'deleted',
		'created_by',
		'modified_by',
		'date_entered',
		'date_modified',
	),
)); ?>
