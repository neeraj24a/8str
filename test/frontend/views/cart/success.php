<?php 

use yii\helpers\Url;

$this->title = "Order Confirmation";

?>
<div id="shopify-section-cart-template" class="shopify-section">
	<header class="collection-header">
		<div class="page-width">
			<div class="section-header text-center">
				<h1>Payment Success</h1>
			</div>
		</div>
	</header>
    <div class="page-width">
        <div class="section-header text-center">
            <h1>Order Details</h1>
        </div>
		<div class="row mt-50">
			<div class="col-md-4 pmt-order">
				<h3 class="billing-title mt-20 pl-15">Order Info</h3>
				<table class="order-rable">
					<tbody><tr>
							<td>Order number</td>
							<td><?php echo $order->order_number; ?></td>
						</tr>
						<tr>
							<td>Date</td>
							<?php
								$dt = new DateTime($order->order_date);

								$date = $dt->format('M d, Y');
							?>
							<td><?php echo $date; ?></td>
						</tr>
						<tr>
							<td>Total</td>
							<td>USD <?php echo $order->order_amount; ?></td>
						</tr>
						<tr>
							<td>Payment Method</td>
							<td><?php echo $order->payment_method; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-4 pmt-address">
				<h3 class="billing-title mt-20 pl-15">Billing Address</h3>
				<table class="order-rable">
					<tbody>
						<tr>
							<td>Name</td>
							<td><?php echo $billing->first_name.' '.$billing->last_name; ?></td>
						</tr>
						<tr>
							<td>Street</td>
							<td><?php echo $billing->address_line_1; ?> <?php echo $billing->address_line_2; ?></td>
						</tr>
						<tr>
							<td>City</td>
							<td><?php echo $billing->city; ?></td>
						</tr>
						<tr>
							<td>State</td>
							<td><?php echo $billing->state; ?></td>
						</tr>
						<tr>
							<td>Country</td>
							<td><?php echo $billing->country; ?></td>
						</tr>
						<tr>
							<td>Postcode</td>
							<td><?php echo $billing->zip; ?></td>
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
							<td><?php echo $shipping->first_name.' '.$shipping->last_name; ?></td>
						</tr>
						<tr>
							<td>Street</td>
							<td><?php echo $shipping->address_line_1; ?> <?php echo $shipping->address_line_2; ?></td>
						</tr>
						<tr>
							<td>City</td>
							<td><?php echo $shipping->city; ?></td>
						</tr>
						<tr>
							<td>State</td>
							<td><?php echo $shipping->state; ?></td>
						</tr>
						<tr>
							<td>Country</td>
							<td><?php echo $shipping->country; ?></td>
						</tr>
						<tr>
							<td>Postcode</td>
							<td><?php echo $shipping->zip; ?></td>
						</tr>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="order-wrapper">
                    <h3 class="billing-title mb-10">Your Order</h3>
                    <div class="order-list">
						<table class="order-rable">
							<thead>
								<tr>
									<th>Product</th>
									<th>Quantity</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($detail as $info): ?>
								<?php $product = backend\models\Products::findOne($info->product); ?>
								<tr>
								<?php if($product === null): ?>
									<td><?php echo backend\models\Drops::findOne($info->product)->title; ?></td>
									<td>x <?php echo $info->quantity; ?></td>
									<td>$<?php echo $info->quantity * $info->purchased_price; ?></td>
								<?php else: ?>
									<td><?php echo $product->name; ?></td>
									<td>x <?php echo $info->quantity; ?></td>
									<td>$<?php echo $info->quantity * $info->purchased_price; ?></td>
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
</div>