<?php
use yii\widgets\ListView;
use yii\helpers\Url;
$this->title = "8thwonderpromos Cart";
?>
<section class="banner-area top-breadcrumbs">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>Cart</h1>
            </div>
            <div class="col-second">
                <p>Items In Cart</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="/">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="cart-title">
        <div class="row">
            <div class="col-md-6">
                <h6 class="ml-15">Product</h6>
            </div>
            <div class="col-md-2">
                <h6>Price</h6>
            </div>
            <div class="col-md-2">
                <h6>Quantity</h6>
            </div>
            <div class="col-md-2">
                <h6>Total</h6>
            </div>
        </div>
    </div>
    <?php if($cart == NULL): ?>
    <div class="cart-single-item">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                Your Cart Is Empty!
            </div>
        </div>
    </div>
    <?php else: ?>
        <?php if(isset($cart['shop'])): ?>
            <?php foreach($cart['shop'] as $info):
                $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
            ?>
            <div class="cart-single-item" id="<?php echo $info->slug; ?>">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="product-item d-flex align-items-center">
                            <img src="<?php echo $img; ?>" class="img-fluid" alt="" width="150" height="100">
                            <h6><?php echo $info->name; ?></h6>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="price">$<?php echo $info->unit_price; ?></div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="quantity-container d-flex align-items-center mt-15">
                            <input type="text" class="quantity-amount" data-type="shop" data-product="<?php echo $info->slug; ?>" value="<?php echo $info->quantity; ?>">
                            <div class="arrow-btn d-inline-flex flex-column">
                                <button class="increase arrow" type="button" title="Increase Quantity">
                                    <span class="lnr lnr-chevron-up"></span>
                                </button>
                                <button class="decrease arrow" type="button" title="Decrease Quantity">
                                    <span class="lnr lnr-chevron-down"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="total">$<?php echo $info->quantity * $info->unit_price; ?></div>
                        <div class="cross removeFromCart" data-slug="<?php echo $info->slug; ?>">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if(isset($cart['drop'])): ?>
            <?php foreach($cart['drop'] as $info):
                $img = $info->thumbnail;
            ?>
            <div class="cart-single-item" id="<?php echo $info->slug; ?>">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="product-item d-flex align-items-center">
                            <img src="<?php echo $img; ?>" class="img-fluid" alt="" width="150" height="100">
                            <h6><?php echo $info->title; ?></h6>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="price">$<?php echo $info->price; ?></div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="quantity-container d-flex align-items-center mt-15">
                            <select class="quantity-amount" style="display: none;" data-type="drop" data-product="<?php echo $info->slug; ?>" disabled>
                                <?php for($i =0; $i < 11; $i++){ ?>
                                    <option value="<?= $i; ?>" <?php if($i == $info->quantity){ echo 'selected'; } ?>><?= $i; ?></option>
                                <?php } ?>
                            </select>
                            <textarea class="form-control desc"><?php echo $info->desc; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="total">$<?php echo $info->quantity * $info->price; ?></div>
                        <div class="cross removeFromCart" data-slug="<?php echo $info->slug; ?>">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <div class="subtotal-area d-flex align-items-center justify-content-end">
        <div class="row">
            <div class="col-lg-4">&nbsp;</div>
            <div class="col-lg-4">&nbsp;</div>
            <div class="col-lg-4">
                <div class="title text-uppercase pull-left">Total</div>
                <div class="subtotal pull-right">$<?php echo $total; ?></div>        
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="title text-uppercase"><?php echo $offer; ?>% Discount Because You have <?php echo $subscription; ?> Subscription.</div>
            </div>
            <div class="col-lg-4">
                <div class="title text-uppercase pull-left">Discount</div>
                <div class="subtotal pull-right"><?php echo $offer; ?>%</div>        
            </div>
        </div>
        <div class="row subtotal-price">
            <div class="col-lg-4">&nbsp;</div>
            <div class="col-lg-4">&nbsp;</div>
            <div class="col-lg-4">
                <div class="title text-uppercase pull-left">Subtotal</div>
                <div class="subtotal pull-right">$<?php echo $totalWithOffer; ?></div>        
            </div>
        </div>
    </div>
    <div class="cupon-area d-flex align-items-center justify-content-between flex-wrap">
        <a href="javascript:void(0);" class="view-btn color-2 update-cart"><span>Update Cart</span></a>
        <div class="cuppon-wrap d-flex align-items-center flex-wrap">
            <!--<div class="cupon-code">
                <input type="text">
                <button class="view-btn color-2"><span>Apply</span></button>
            </div>-->
            <a href="<?php echo Url::toRoute('/cart/checkout'); ?>" class="view-btn color-2"><span>Checkout</span></a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php
$this->registerJs("
        $(document).ready(function(){
            $('.removeFromCart').on('click', function(){
                var product = $(this).attr('data-slug');
                $.ajax({
                    url: base_url + 'cart/remove',
                    method: 'POST',
                    data: {'product': product, 'type': 'drop'},
                    success: function (data) {
                        data = $.parseJSON(data);
                        if(data.quantity == 0){
                            location.reload();
                        }
                    }
                });
            });
            $('.update-cart').on('click', function(e){
                e.preventDefault();
                var products = [];
                $('.quantity-amount').each(function(){
                    var a = {};
                    var product = $(this).data('product');
                    var quantity = $(this).val();
                    var type = $(this).data('type');
                    var desc = '';
                    if(type == 'drop'){
                        desc = $(this).next('textarea').val();
                        console.log(desc);
                    }
                    if(quantity == 0){
                        $('#'+product).remove();
                    }
                    a['product'] = product;
                    a['quantity'] = quantity;
                    a['type'] = type;
                    a['desc'] = desc;
                    products.push(a);
                });
                $.ajax({
                    url: base_url + 'cart/updatecart',
                    method: 'POST',
                    data: {'products': products},
                    success: function (data) {
                        console.log(data);
                        // data = JSON.parse(data);
                    }
                });
            });
        });
    ");
?>