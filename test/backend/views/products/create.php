<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = 'Add Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
