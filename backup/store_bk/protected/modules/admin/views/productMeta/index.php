<?php
/* @var $this ProductMetaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Metas',
);

$this->menu=array(
	array('label'=>'Create ProductMeta', 'url'=>array('create')),
	array('label'=>'Manage ProductMeta', 'url'=>array('admin')),
);
?>

<h1>Product Metas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
