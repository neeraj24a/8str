<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
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
                        <?= Html::a('Reset', ['/orders'], ['class' => 'mb-sm btn btn-warning ml-10 pull-right']) ?>
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
                                    'attribute' => 'customer',
                                    'filter' => ArrayHelper::map(backend\models\Users::findAll(['status' => 1,'type' => 'general']), 'id', 'username'),
                                    'value' => function($model) {
                                        return \backend\models\Users::findOne($model->customer)->username;
                                    }
                                ],
                                'order_number',
                                'order_amount',
                                'order_date',
								[
									'attribute' => 'printful_synced',
									'format' => 'raw',
									'filter' => ['0' => 'No', '1' => 'Yes'],
									'value' => function($model) {
										$url = Url::to(['/orders/sync', 'id' => $model->id]);
										if($model->printful_synced){
											return 'Yes';
										} else {
											return Html::a('No', $url, [
                                                        'title' => Yii::t('app', 'No'),
                                                        'class' => 'btn btn-warning'
                                            ]);
										}
									}
								],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{v} {u} {d}',
                                    'buttons' => [
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
                                        if ($action === 'v') {
                                            $url = Url::to(['/orders/view', 'id' => $model->id]);
                                            return $url;
                                        }

                                        if ($action === 'u') {
                                            $url = Url::to(['/orders/update', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'd') {
                                            $url = Url::to(['/orders/delete', 'id' => $model->id]);
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
        