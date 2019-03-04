<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid products-index">
    <div class="row">
        <div class="col-lg-12">
<?php Pjax::begin(); ?>
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title"><?= Html::encode($this->title) ?></h4>

                    <div class="col-lg-6 pull-right">
                        <?= Html::a('Add Product', ['create'], ['class' => 'mb-sm btn btn-success ml-10 pull-right']) ?>
<?= Html::a('Reset', ['/products'], ['class' => 'mb-sm btn btn-warning ml-10 pull-right']) ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => ['class' => 'table'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'sku',
                                'name',
                                [
                                    'attribute' => 'category',
                                    'filter' => ArrayHelper::map(backend\models\Category::findAll(['status' => 1]), 'id', 'category'),
                                    'value' => function($model) {
                                return \backend\models\Category::findOne($model->category)->category;
                            }
                                ],
                                'units_in_stock',
                                'unit_price',
                                [
                                    'attribute' => 'is_featured',
                                    'filter' => getParam('is_active'),
                                    'value' => function($model) {
                                        return getParam('is_active')[$model->is_featured];
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{f} {v} {u} {d}',
                                    'buttons' => [
                                        'f' => function ($url, $model) {
                                            if ($model->is_featured == 1) {
                                                $title = "Make Featured";
                                                $class = "fa fa-check-circle";
                                            } else {
                                                $title = "Remove Featured";
                                                $class = "fa fa-times-circle";
                                            }
                                            return Html::a('<i class="' . $class . '"></i>', $url, [
                                                        'title' => Yii::t('app', $title),
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        },
                                                'v' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-search"></i>', $url, [
                                                        'title' => Yii::t('app', 'View Product'),
                                                        'class' => 'btn btn-info'
                                            ]);
                                        },
                                                'u' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-edit"></i>', $url, [
                                                        'title' => Yii::t('app', 'Update Product'),
                                                        'class' => 'btn btn-success'
                                            ]);
                                        },
                                                'd' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                                        'title' => Yii::t('app', 'Delete Product'),
                                                        'data-method' => 'post',
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        }
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'f') {
                                            $url = Url::to(['/products/featuring', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'v') {
                                            $url = Url::to(['/products/view', 'id' => $model->id]);
                                            return $url;
                                        }

                                        if ($action === 'u') {
                                            $url = Url::to(['/products/update', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'd') {
                                            $url = Url::to(['/products/delete', 'id' => $model->id]);
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
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>