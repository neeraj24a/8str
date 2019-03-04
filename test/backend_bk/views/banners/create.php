<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Banners */

$this->title = Yii::t('app', 'Add Banners');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 banners-create">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
