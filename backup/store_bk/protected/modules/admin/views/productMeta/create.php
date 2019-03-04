<?php
/* @var $this ProductMetaController */
/* @var $model ProductMeta */

$this->breadcrumbs=array(
	'Product Metas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductMeta', 'url'=>array('index')),
	array('label'=>'Manage ProductMeta', 'url'=>array('admin')),
);
?>

<h1>Create ProductMeta</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>