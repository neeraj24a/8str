<?php
/* @var $this RelatedProductsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Related Products',
);

$this->menu=array(
	array('label'=>'Create RelatedProducts', 'url'=>array('create')),
	array('label'=>'Manage RelatedProducts', 'url'=>array('admin')),
);
?>

<h1>Related Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
