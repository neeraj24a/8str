<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */
$prod = backend\models\PrintfulProducts::findOne($model->printful_product);
$this->title = 'Update Printful Product Details: '.$prod->printful_product_name;
$this->params['breadcrumbs'][] = ['label' => 'Printful Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $prod->printful_product_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>

