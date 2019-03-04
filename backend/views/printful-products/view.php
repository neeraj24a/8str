<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = $model->printful_product_name;
$this->params['breadcrumbs'][] = ['label' => 'Printful Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid products-view">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title"><?= Html::encode($this->title) ?></h4>

                    <div class="col-lg-6 pull-right">
                        <a href="<?php echo Url::toRoute(["/printful-products/update", "id" => $model->id]); ?>" class="mb-sm btn btn-warning">Update</a>
                        <a href="<?php echo Url::toRoute(["/printful-products"]); ?>" class="mb-sm btn btn-success">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'printful_product_name'
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
