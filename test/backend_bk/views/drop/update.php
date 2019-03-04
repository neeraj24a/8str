<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Drops */

$this->title = 'Update Drop: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Drops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-fluid drops-update">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>