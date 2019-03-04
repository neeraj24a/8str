<?php
/* @var $this ProductGalleryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Galleries',
);

$this->menu=array(
	array('label'=>'Create ProductGallery', 'url'=>array('create')),
	array('label'=>'Manage ProductGallery', 'url'=>array('admin')),
);
?>

<h1>Product Galleries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
