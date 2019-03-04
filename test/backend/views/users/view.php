<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <h3>User Details</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">User: <?php echo $model->username; ?></h4>
                    
                    <div class="col-lg-6 pull-right">
                        <a href="<?php echo Url::toRoute(["/users/update", "id" => $model->id]); ?>" class="mb-sm btn btn-warning">Update</a>
                        <a href="<?php echo Url::toRoute(["/users"]); ?>" class="mb-sm btn btn-success">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'username',
                                'type',
                                'email',
                                'last_visit',
                                'status',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>