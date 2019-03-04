<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = 'Add Product Images';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card products-form">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-text">
						<h4 class="card-title"><?= Html::encode($this->title) ?></h4>
					</div>
				</div>
				<div class="card-body">
					<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-6">
								<div class="form-group">
									<?= $form->field($model, 'product')->hiddenInput(['value' => $product]) ?>
									<?php echo $productName; ?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<?= $form->field($model, 'imageFiles[]')->fileInput(['maxlength' => true,'class' => 'form-control']) ?>
								</div>
							</div>
						</div>
						<div class="col-lg-12 m-t-20">
							<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
							<?= Html::a('Back', ['/products/view?id='.$product], ['class' => 'mb-sm btn btn-warning pull-right']) ?>
						</div>
					</div>
					<?php ActiveForm::end() ?>
				</div>
			</div>
        </div>
    </div>
</div>
