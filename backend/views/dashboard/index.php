<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Users */

$this->title = 'Dashboard';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <p class="card-category">Users</p>
                    <h3 class="card-title"><?php echo number_format($users); ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="#"><i class="material-icons">update</i> Just Updated Get Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-th"></i>
                    </div>
                    <p class="card-category">Products</p>
                    <h3 class="card-title"><?php echo number_format($products); ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="#"><i class="material-icons">update</i> Just Updated Get Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                    <p class="card-category">Total Sell</p>
                    <h3 class="card-title">$<?php echo number_format($total); ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="#"><i class="material-icons">update</i> Just Updated Get Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-bar-chart"></i>
                    </div>
                    <p class="card-category">Orders</p>
                    <h3 class="card-title"><?php echo number_format($orders); ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="#"><i class="material-icons">update</i> Just Updated Get Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
