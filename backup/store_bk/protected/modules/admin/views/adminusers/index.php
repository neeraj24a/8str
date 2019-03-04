<?php
/* @var $this AdminusersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Adminusers',
);

$this->menu=array(
	array('label'=>'Create Adminusers', 'url'=>array('create')),
	array('label'=>'Manage Adminusers', 'url'=>array('admin')),
);
?>

<h1>Adminusers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
