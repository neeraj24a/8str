<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = "Checkout";

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
                    <a href="<?php echo Url::toRoute('/cart/checkout'); ?>">Checkout<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Payment</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php if (Yii::$app->user->id): ?>
<div class="container m-b-100">
    <?php
        $form = ActiveForm::begin([
            'id' => 'address-form',
            'action' => Yii::$app->homeUrl.'cart/process',
            'options' => ['class' => 'billing-form', 'autocomplete' => 'off', 'id' => 'checkout-form'],
        ]);
    ?>
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="col-lg-6 address-holder">
                    <h3>Billing Address</h3>
                    <div class="name"><?php echo $billing['first_name'].' '.$billing['last_name']; ?></div>
                    <div class="address"><?php echo $billing['address_line_1'].' '.$billing['address_line_2']; ?></div>
                    <div class="city"><?php echo $billing['city']; ?></div>
                    <div class="state-country"><?php echo $billing['state']; ?>, <?php echo $billing['country']; ?></div>
                    <div class="zip"><?php echo $billing['zip']; ?></div>
                    <div class="contact"><?php echo $billing['contact']; ?></div>
                </div>
                <div class="col-lg-6 address-holder">
                    <h3>Shipping Address</h3>
                    <div class="name"><?php echo $shipping['first_name'].' '.$shipping['last_name']; ?></div>
                    <div class="address"><?php echo $shipping['address_line_1'].' '.$shipping['address_line_2']; ?></div>
                    <div class="city"><?php echo $shipping['city']; ?></div>
                    <div class="state-country"><?php echo $shipping['state']; ?>, <?php echo $shipping['country']; ?></div>
                    <div class="zip"><?php echo $shipping['zip']; ?></div>
                    <div class="contact"><?php echo $shipping['contact']; ?></div>
                </div>   
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="order-wrapper">
                    <h3 class="billing-title mb-10">Your Order</h3>
                    <div class="order-list">
                        <div class="list-row title b-b d-flex justify-content-between">
                            <div class="product">Product</div>
                            <div class="qty">Quantity</div>
                            <div class="item-total">Total</div>
                        </div>
                        <?php if(isset($cart['shop'])): ?>
                            <?php foreach($cart['shop'] as $info):
                                $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                            ?>
                            <div class="list-row d-flex justify-content-between">
                                <div class="product"><?php echo $info->name; ?></div>
                                <div class="qty">x <?php echo $info->quantity; ?></div>
                                <div class="item-total">$<?php echo $info->quantity * $info->unit_price; ?></div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($cart['drop'] as $info):
                                $img = $info->thumbnail;
                            ?>
                            <div class="list-row d-flex justify-content-between">
                                <div class="product"><?php echo $info->title; ?></div>
                                <div class="qty">x <?php echo $info->quantity; ?></div>
                                <div class="item-total">$<?php echo $info->quantity * $info->price; ?></div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="list-row sub-total-block b-t d-flex justify-content-between">
                            <div class="sub-total-title">
                                <h6>Total</h6>    
                            </div>
                            <div class="sub-total">
                                $<?php echo $total; ?>
                            </div>
                        </div>
                        <div class="list-row sub-total-block  b-t-b d-flex justify-content-between">
                            <div class="sub-total-title">
                                <h6>Subscription Discount</h6>    
                            </div>
                            <div class="sub-total">
                                (-)<?php echo $offer; ?>%
                            </div>
                        </div>
                        <div class="list-row sub-total-block b-b d-flex justify-content-between">
                            <div class="sub-total-title">
                                <h6>Sub Total</h6>    
                            </div>
                            <div class="sub-total">
                                $<?php echo $totalWithOffer; ?>
                            </div>
                        </div>
                        <div id="paypal-button"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php endif; ?>
<script>
    var transactionDetails = <?php echo $transaction; ?>
</script>
<?php $this->registerJs(<<< EOT_JS
$(document).ready(function(){
    paypal.Button.render({
        // Configure environment
        env: 'production',
        client: {
            // sandbox: 'Aa59mhDWax3KqdDOmPtnUZ5avPCB8O4PVx6kU-oLkObjnUh9Jx_qySICwdnC',
            production: 'ARoVjwXgdOJ2FfrZKykYoQaK8KD7uAQprWYeVCg9Zx3KxR22JF2e_c6_ZyVgZMkEG2nlSNvpt41AwRYr'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },
        // Set up a payment
        payment: function(data, actions) {
          return actions.payment.create({
            transactions: transactionDetails,
            note_to_payer: 'Contact us for any questions on your order.'
          });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return $.ajax({
                        url: base_url+'cart/transact/',
                        method: 'POST',
                        data: data,
                        success: function(res){
                            res = $.parseJSON(res);
                            console.log(res);
                            $('#paypal-button').html('Payment Successful');
                            setTimeout(function(){
                                console.log(res);
                                console.log(res.order);
                                window.location.href = base_url+'cart/success?order='+res.order;    
                            }, 2000)
                        }
                    });
            /*return actions.request.post(base_url+'cart/transact/', data).then(function(res) {
                $('#paypal-button').html('Payment Successful');
                setTimeout(function(){
                    console.log(res);
                    console.log(res.order);
                    window.location.href = base_url+'cart/success?order='+res.order;    
                }, 2000)
            });*/
        }
    }, '#paypal-button');
}); 
EOT_JS
);
?>