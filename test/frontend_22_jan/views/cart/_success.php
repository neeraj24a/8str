<div class="container">
    <p class="text-center">New order has been received.</p>
    <div class="row mt-50">
        <div class="col-md-4">
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
                </tbody></table>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        </div>
    </div>
</div>
<div class="container">
    <div class="billing-form">
        <div class="row">
            <div class="col-12">
                <div class="order-wrapper mt-50">
                    <h3 class="billing-title mb-10">Your Order</h3>
                    <div class="order-list">
                        <div class="list-row d-flex justify-content-between">
                            <div>Product</div>
                            <div>Total</div>
                        </div>
                        <?php foreach($detail as $info): ?>
                        <div class="list-row d-flex justify-content-between">
                            <div><?php echo backend\models\Products::findOne($info->product)->name; ?></div>
                            <div>x <?php echo $info->quantity; ?></div>
                            <div>$<?php echo $info->quantity * $info->purchased_price; ?></div>
                        </div>
                        <?php endforeach; ?>
                        <div class="list-row border-bottom-0 d-flex justify-content-between">
                            <h6>Total</h6>
                            <div class="total">$<?php echo $order->order_amount; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>