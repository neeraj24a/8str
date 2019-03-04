<?php
/* @var $this FrontusersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Frontusers',
);

$this->menu=array(
	array('label'=>'Create Frontusers', 'url'=>array('create')),
	array('label'=>'Manage Frontusers', 'url'=>array('admin')),
);
?>

<h1>Frontusers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
