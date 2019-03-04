<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Banners */

$this->title = 'Banner Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid banners-view">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title"><?= Html::encode($this->title) ?></h4>

                    <div class="col-lg-6 pull-right">
                        <a href="<?php echo Url::toRoute(["/banners/update", "id" => $model->id]); ?>" class="mb-sm btn btn-warning">Update</a>
                        <a href="<?php echo Url::toRoute(["/banners"]); ?>" class="mb-sm btn btn-success">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'image',
                                'url:url'
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
