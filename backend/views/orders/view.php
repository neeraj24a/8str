<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = 'Order Detail';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
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
                        <a href="<?php echo Url::toRoute(["/orders/update", "id" => $model->id]); ?>" class="mb-sm btn btn-warning">Update</a>
						<?php if($model->printful_synced == 0): ?>
						<a href="<?php echo Url::toRoute(["/orders/sync", "id" => $model->id]); ?>" class="mb-sm btn btn-info">Sync Order</a>
						<?php endif; ?>
                        <a href="<?php echo Url::toRoute(["/orders"]); ?>" class="mb-sm btn btn-success">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'customer',
                                    'value' => function($model) {
                                        return \backend\models\Users::findOne($model->customer)->username;
                                    }
                                ],
                                'order_number',
                                [
                                    'attribute' => 'order_amount',
                                    'value' => function($model) {
                                        return "$".$model->order_amount;
                                    }
                                ],
                                'payment_method',
                                'transaction_id',
                                'payment_status',
                                'order_date',
                                'shipping_date',
                                [
                                    'attribute' => 'is_paid',
                                    'value' => function($model) {
                                        if($model->is_paid == 0){
                                            return 'No';
                                        } else {
                                            return 'Yes';
                                        }
                                    }
                                ],
                                'freight',
                                'note',
                                'shipping_method',
                                [
                                    'attribute' => 'is_shipped',
                                    'value' => function($model) {
                                        if($model->is_shipped == 0){
                                            return 'No';
                                        } else {
                                            return 'Yes';
                                        }
                                    }
                                ],
                                'shipping_tracking',
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
                    <h4 class="card-title">Order Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Purchased Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($details as $detail): ?>
                                <tr>
                                    <?php $product = backend\models\Products::findOne($detail->product); ?>
                                    <?php if($product === null): ?>
                                        <?php $drop = backend\models\Drops::findOne($detail->product); ?>
                                        <td><?php echo $drop->title; ?></td>
                                        <td>
                                            <?php if($drop->type == 'audio'): ?>
                                                Audio Drop
                                            <?php else: ?>
                                                Video Drop
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $detail->quantity; ?></td>
                                        <td><?php echo $detail->description; ?></td>
                                        <td>$<?php echo $detail->product_price; ?></td>
                                        <td>$<?php echo $detail->purchased_price; ?></td>
                                        <td>$<?php echo $detail->purchased_price * $detail->quantity; ?></td>
                                    <?php else: ?>
                                        <td><?php echo $product->name; ?></td>
                                        <td>Shop</td>
                                        <td><?php echo $detail->quantity; ?></td>
                                        <td><?php echo $detail->description; ?></td>
                                        <td>$<?php echo $detail->product_price; ?></td>
                                        <td>$<?php echo $detail->purchased_price; ?></td>
                                        <td>$<?php echo $detail->purchased_price * $detail->quantity; ?></td>
                                    <?php endif; ?>
                                    
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
                    <h4 class="card-title">Billing Address</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Address Line 1</th>
                                    <th>Address Line 2</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $billing->address_line_1; ?></td>
                                    <td><?php echo $billing->address_line_2; ?></td>
                                    <td><?php echo $billing->city; ?></td>
                                    <td><?php echo $billing->state; ?></td>
                                    <td><?php echo $billing->zip; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($shipping !== null): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">Shipping Address</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Address Line 1</th>
                                    <th>Address Line 2</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $shipping->address_line_1; ?></td>
                                    <td><?php echo $shipping->address_line_2; ?></td>
                                    <td><?php echo $shipping->city; ?></td>
                                    <td><?php echo $shipping->state; ?></td>
                                    <td><?php echo $shipping->zip; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
