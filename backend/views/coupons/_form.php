<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card coupons-form">
    <div class="card-header card-header-rose card-header-icon">
        <div class="card-text">
            <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'coupon')->textInput(['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model,'valid_till')->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => '', 'dateFormat' => 'yy-mm-dd']]) ?>
                    </div>
                </div>
            </div>
			<div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'discount_type')->dropDownList(['flat' => 'Flat','percent' => 'Percent'],['prompt' => 'Select Discount Type','class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'discount')->textInput(['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
			<div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= $form->field($model, 'coupon_count')->textInput(['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 m-t-20">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['/coupons'], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerJs(
    "$(document).ready(function(){
		$('#coupons-valid_till').addClass('form-control');
    });"
);
?>
