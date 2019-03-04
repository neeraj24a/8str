<?php 

use yii\helpers\Url;

$this->title = "Order Confirmation";

?>
<section class="banner-area top-breadcrumbs">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>Payment</h1>
            </div>
            <div class="col-second">
                <p>Payment Processing</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="/">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="<?php echo Url::toRoute('/cart'); ?>">Cart<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Checkout<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Success</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <h2 class="text-center">Thank you. Your order has been received.</h2>
    <div class="row mt-50">
        <div class="col-md-4 pmt-order">
            <h3 class="billing-title mt-20 pl-15">Order Info</h3>
            <table class="order-rable">
                <tbody><tr>
                        <td>Order number</td>
                        <td>: <?php echo $order->order_number; ?></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <?php
                            $dt = new DateTime($order->order_date);

                            $date = $dt->format('M d, Y');
                        ?>
                        <td>: <?php echo $date; ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>: USD <?php echo $order->order_amount; ?></td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td>: <?php echo $order->payment_method; ?></td>
                    </tr>
                </tbody></table>
        </div>
        <div class="col-md-4 pmt-address">
            <h3 class="billing-title mt-20 pl-15">Billing Address</h3>
            <table class="order-rable">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>: <?php echo $billing->first_name.' '.$billing->last_name; ?></td>
                    </tr>
                    <tr>
                        <td>Street</td>
                        <td>: <?php echo $billing->address_line_1; ?> <?php echo $billing->address_line_2; ?></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>: <?php echo $billing->city; ?></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>: <?php echo $billing->state; ?></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>: <?php echo $billing->country; ?></td>
                    </tr>
                    <tr>
                        <td>Postcode</td>
                        <td>: <?php echo $billing->zip; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 pmt-address">
            <?php if($shipping !== null): ?>
            <h3 class="billing-title mt-20 pl-15">Shipping Address</h3>
            <table class="order-rable">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>: <?php echo $shipping->first_name.' '.$shipping->last_name; ?></td>
                    </tr>
                    <tr>
                        <td>Street</td>
                        <td>: <?php echo $shipping->address_line_1; ?> <?php echo $shipping->address_line_2; ?></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>: <?php echo $shipping->city; ?></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>: <?php echo $shipping->state; ?></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>: <?php echo $shipping->country; ?></td>
                    </tr>
                    <tr>
                        <td>Postcode</td>
                        <td>: <?php echo $shipping->zip; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="billing-form">
        <div class="row">
            <div class="col-12">
                <div class="order-wrapper">
                    <h3 class="billing-title mb-10">Your Order</h3>
                    <div class="order-list">
                        <div class="list-row title b-b d-flex justify-content-between">
                            <div class="product">Product</div>
                            <div class="qty">Quantity</div>
                            <div class="item-total">Total</div>
                        </div>
                        <?php foreach($detail as $info): ?>
                        <div class="list-row d-flex justify-content-between">
                            <?php $product = backend\models\Products::findOne($info->product); ?>
                            <?php if($product === null): ?>
                                <div class="product"><?php echo backend\models\Drops::findOne($info->product)->title; ?></div>
                                <div class="qty">x <?php echo $info->quantity; ?></div>
                                <div class="item-total">$<?php echo $info->quantity * $info->purchased_price; ?></div>
                            <?php else: ?>
                                <div class="product"><?php echo $products->name; ?></div>
                                <div class="qty">x <?php echo $info->quantity; ?></div>
                                <div class="item-total">$<?php echo $info->quantity * $info->purchased_price; ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>