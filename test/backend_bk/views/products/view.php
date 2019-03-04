<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
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
                        <a href="<?php echo Url::toRoute(["/products/update", "id" => $model->id]); ?>" class="mb-sm btn btn-warning">Update</a>
                        <?php if($model->is_synced == 0): ?>
                            <a href="<?php echo Url::toRoute(["/products/sync", "id" => $model->id]); ?>" class="mb-sm btn btn-success">Sync</a>
                        <?php endif; ?>
                        <a href="<?php echo Url::toRoute(["/products"]); ?>" class="mb-sm btn btn-success">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php $model->category = Category::findOne($model->category)->category; ?>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'sku',
                                'slug',
                                'name',
                                'description:ntext',
                                'category',
                                'units_in_stock',
                                'unit_price',
                                'offer_price',
                                'variation:ntext',
                                'size:ntext',
                                'colors:ntext',
                                'weight_type',
                                'weight',
                                'available',
                                'discount',
                                'main_image',
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>