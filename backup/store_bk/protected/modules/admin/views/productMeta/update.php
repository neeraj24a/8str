<?php
/* @var $this ProductMetaController */
/* @var $model ProductMeta */

$this->breadcrumbs=array(
	'Product Metas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductMeta', 'url'=>array('index')),
	array('label'=>'Create ProductMeta', 'url'=>array('create')),
	array('label'=>'View ProductMeta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductMeta', 'url'=>array('admin')),
);
?>

<h1>Update ProductMeta <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>