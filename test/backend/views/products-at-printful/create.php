<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductsAtPrintful */

$this->title = Yii::t('app', 'Create Products At Printful');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products At Printfuls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-at-printful-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
