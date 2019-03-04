<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <?php Pjax::begin(); ?>
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">Users List</h4>
                    
                    <div class="col-lg-6 pull-right">
                        <?= Html::a('Add User', ['create'], ['class' => 'mb-sm btn btn-success ml-10 pull-right']) ?>
                        <?= Html::a('Reset', ['/users'], ['class' => 'mb-sm btn btn-warning ml-10 pull-right']) ?>
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
                                'username',
                                'type',
                                'email',
                                'last_visit',
                                [
                                    'attribute' => 'status',
                                    'filter' => getParam('is_active'),
                                    'value' => function($model) {
                                        return getParam('is_active')[$model->status];
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{r} {s} {v} {u} {d}',
                                    'buttons' => [
                                        'r' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-key"></i>', $url, [
                                                        'title' => Yii::t('app', 'Reset Password'),
                                                        'class' => 'btn btn-info'
                                            ]);
                                        },
                                        's' => function ($url, $model) {
                                            if($model->status == 1){
                                                $title = "Block User";
                                                $class = "fa fa-lock";
                                            } else {
                                                $title = "Unblock User";
                                                $class = "fa fa-unlock";
                                            }
                                            return Html::a('<i class="'.$class.'"></i>', $url, [
                                                        'title' => Yii::t('app', $title),
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        },
                                        'v' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-search"></i>', $url, [
                                                        'title' => Yii::t('app', 'View User'),
                                                        'class' => 'btn btn-info'
                                            ]);
                                        },
                                        'u' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-edit"></i>', $url, [
                                                        'title' => Yii::t('app', 'Update User'),
                                                        'class' => 'btn btn-success'
                                            ]);
                                        },
                                        'd' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                                        'title' => Yii::t('app', 'Delete User'),
                                                        'data-method'=>'post',
                                                        'class' => 'btn btn-danger'
                                            ]);
                                        }
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'r') {
                                            $url = Url::to(['/users/resetpassword', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 's') {
                                            $url = Url::to(['/users/changestatus', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'v') {
                                            $url = Url::to(['/users/view', 'id' => $model->id]);
                                            return $url;
                                        }

                                        if ($action === 'u') {
                                            $url = Url::to(['/users/update', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'd') {
                                            $url = Url::to(['/users/delete', 'id' => $model->id]);
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