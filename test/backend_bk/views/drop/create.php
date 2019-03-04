<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Drops */

$this->title = 'Add Drops';
$this->params['breadcrumbs'][] = ['label' => 'Drops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 drops-create">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>

