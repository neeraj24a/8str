<?php
/* @var $this QnaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Qnas',
);

$this->menu=array(
	array('label'=>'Create Qna', 'url'=>array('create')),
	array('label'=>'Manage Qna', 'url'=>array('admin')),
);
?>

<h1>Qnas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
