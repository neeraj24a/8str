<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'Update Category: '.$model->category;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
