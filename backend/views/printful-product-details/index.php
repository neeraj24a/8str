<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Printful Products';
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
                        <?= Html::a('Add Printful Product Details', ['create'], ['class' => 'mb-sm btn btn-success ml-10 pull-right']) ?>
                        <?= Html::a('Reset', ['/printful-product-details'], ['class' => 'mb-sm btn btn-warning ml-10 pull-right']) ?>
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
                                [
                                    'attribute' => 'printful_product',
                                    'filter' => ArrayHelper::map(backend\models\PrintfulProducts::findAll(['status' => 1]), 'id', 'printful_product_name'),
                                    'value' => function($model) {
                                        return \backend\models\PrintfulProducts::findOne($model->printful_product)->printful_product_name;
                                    }
                                ],
                                'color',
                                'size',
                                'printful_product_id',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{v} {u} {d}',
                                    'buttons' => [
                                        'v' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-search"></i>', $url, [
                                                        'title' => Yii::t('app', 'View Printful Product'),
                                                        'class' => 'btn btn-info'
                                            ]);
                                        },
                                        'u' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-edit"></i>', $url, [
                                                        'title' => Yii::t('app', 'Update Printful Product'),
                                                        'class' => 'btn btn-success'
                                            ]);
                                        },
                                        'd' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                                        'title' => Yii::t('app', 'Delete Printful Product'),
                                                        'data-method' => 'post',
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        }
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'v') {
                                            $url = Url::to(['/printful-product-details/view', 'id' => $model->id]);
                                            return $url;
                                        }

                                        if ($action === 'u') {
                                            $url = Url::to(['/printful-product-details/update', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'd') {
                                            $url = Url::to(['/printful-product-details/delete', 'id' => $model->id]);
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