<?php
/* @var $this CareersController */
/* @var $model Careers */

$this->breadcrumbs=array(
	'Careers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Careers', 'url'=>array('index')),
	array('label'=>'Manage Careers', 'url'=>array('admin')),
);
?>

<h1>Create Careers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>