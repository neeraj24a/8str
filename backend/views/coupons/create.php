<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */
$this->title = Yii::t('app', 'Add Coupon');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 coupons-create">
            <?php echo $this->render('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
