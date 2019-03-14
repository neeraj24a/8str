<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\DetailView;

use backend\models\Category;
use backend\models\Products;

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
						<a href="<?php echo Url::toRoute(["/products/addimages", "id" => $model->id]); ?>" class="mb-sm btn btn-warning">Add Images</a>
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
                                [
									'attribute' => 'main_image',
									'format' => 'html',    
									'value' => function ($data) {
										return Html::img('../'.$data->main_image,
											['width' => '70px']);
									},
								],
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">Product Images</h4>

                    <div class="col-lg-6 pull-right">
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => ['class' => 'table'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'product',
                                    'value' => function($data) {
                                        return Products::findOne($data->product)->name;
                                    }
                                ],
                                [
									'attribute' => 'image',
									'format' => 'html',    
									'value' => function ($data) {
										return Html::img('../'.$data->image,
											['width' => '70px']);
									},
								],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{d}',
                                    'buttons' => [
                                        'd' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                                        'title' => Yii::t('app', 'Delete Product'),
                                                        'data-method' => 'post',
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        }
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'd') {
                                            $url = Url::to(['/products/deleteImage', 'id' => $model->id]);
                                            return $url;
                                        }
                                    }
                                ],
                            ],
                        ]);
                    ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>