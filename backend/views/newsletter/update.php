<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Newsletter */

$this->title = 'Update Email';
$this->params['breadcrumbs'][] = ['label' => 'Newsletter', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
