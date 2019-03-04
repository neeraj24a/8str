<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid banners-index">
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
                        <?= Html::a('Add Banner', ['create'], ['class' => 'mb-sm btn btn-success ml-10 pull-right']) ?>
                        <?= Html::a('Reset', ['/banners'], ['class' => 'mb-sm btn btn-warning ml-10 pull-right']) ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => ['class' => 'table'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'image',
                                    'format' => 'html',    
                                    'value' => function ($data) {
                                        return Html::img($data['image'],
                                            ['width' => '350']);
                                    },
                                ],
                                'url',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{v} {u} {d}',
                                    'buttons' => [
                                        'v' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-search"></i>', $url, [
                                                        'title' => Yii::t('app', 'View Banner'),
                                                        'class' => 'btn btn-info'
                                            ]);
                                        },
                                        'u' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-edit"></i>', $url, [
                                                        'title' => Yii::t('app', 'Update Banner'),
                                                        'class' => 'btn btn-success'
                                            ]);
                                        },
                                        'd' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                                        'title' => Yii::t('app', 'Delete Banner'),
                                                        'data-method'=>'post',
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        }
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'v') {
                                            $url = Url::to(['/banners/view', 'id' => $model->id]);
                                            return $url;
                                        }

                                        if ($action === 'u') {
                                            $url = Url::to(['/banners/update', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'd') {
                                            $url = Url::to(['/banners/delete', 'id' => $model->id]);
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
