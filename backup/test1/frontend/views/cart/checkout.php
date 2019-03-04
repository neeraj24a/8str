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
                <h1>Checkout</h1>
            </div>
            <div class="col-second">
                <p>Cart Checkout</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="/">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="<?php echo Url::toRoute('/cart'); ?>">Cart<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container m-b-100">
    <?php if (Yii::$app->user->isGuest): ?>
    <?php 
        $session = Yii::$app->getSession();
        $cart = $session->get('cart');
    ?>
    <div class="checkput-login">
        <div class="top-title">
            <p>Login To Proceed? <a data-toggle="collapse" href="#checkout-login" aria-expanded="false" aria-controls="checkout-login">Click here to login</a></p>
        </div>
        <div class="collapse" id="checkout-login">
            <div class="checkout-login-collapse d-flex flex-column">
                <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'action' => Yii::$app->homeUrl.'login',
                            'options' => ['class' => 'd-block', 'autocomplete' => 'off'],
                ]);
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <?php echo $form->field($model, 'username')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Username', 'autocomplete' => 'off']); ?>

                    </div>
                    <div class="col-lg-4">
                        <?php echo $form->field($model, 'password')->passwordInput(['class' => 'form-control mt-10', 'placeholder' => 'Password', 'autocomplete' => 'off']); ?>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <?= Html::submitButton('Login', ['class' => 'view-btn color-2 mt-20 mr-20', 'name' => 'login-button']) ?>
                    <div class="mt-20"><input type="checkbox" class="pixel-checkbox" id="login-1"><label for="login-1">Remember me</label></div>
                </div>
                <?php ActiveForm::end(); ?>
                <a href="#" class="mt-10">Lost your password?</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php if (Yii::$app->user->id): ?>
<div class="container m-b-100">
    <?php if(sizeof($addresses) > 0): ?>
    <div class="row mb-20">
        <div class="col-lg-8 col-md-6">
            <div class="mt-20 pull-left w-100">
                <label for="saved_billing" class="bld">Saved Billing Address</label>
                <select class="form-control" id="saved_billing">
                    <option value="">Select Your Previous Billing Address</option>
                    <?php
                        $selected = '';
                        foreach($addresses as $address): ?>
                        <?php if($address->address_type == 'billing'): ?>
                            <?php if($address->is_default){$selected = 'selected';} ?>
                            <option <?php echo $selected; ?> value="<?php echo $address->id; ?>"><?php echo $address->first_name.','.$address->last_name.','.$address->address_line_1.','.$address->address_line_2.','.$address->city.','.$address->state.','.$address->zip.','.$address->contact; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
        $form = ActiveForm::begin([
            'id' => 'address-form',
            'action' => Yii::$app->homeUrl.'cart/process',
            'options' => ['class' => 'billing-form', 'autocomplete' => 'off', 'id' => 'checkout-form'],
        ]);
    ?>
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <h3 class="billing-title mt-20 mb-10">Billing Details</h3>
                <div class="mt-20 pull-left w-100">
                    <label for="login-6">Default Billing Address?</label>
                    <?php echo $form->field($add_model, 'is_default')->dropDownList(['0' => 'No', 'Yes'],['class' => 'form-control', 'autocomplete' => 'off'])->label(false); ?>
                </div>
                <div class="row pull-left" id="billing">
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'first_name')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'First Name*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'First Name*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'last_name')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Last Name*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Last Name*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'contact')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Contact*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Contact*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'address_line_1')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Address Line 1*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Address Line 1*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'address_line_2')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Address Line 2', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Address Line 2'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'city')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'City*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'City*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'state')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'State*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'State*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'country')->textInput(['class' => 'form-control mt-10', 'value' => 'USA', 'autocomplete' => 'off', 'disabled' => 'disabled'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'zip')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Zip*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Zip*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                </div>
                <?php 
                    if(isset($cart['shop'])):
                ?>
                <h3 class="billing-title mt-20 mb-10">Shipping Details</h3>
                <div class="mt-20 pull-left w-100 mb-20">
                    <label for="saved_shipping" class="bld">Saved Shipping Address</label>
                    <select class="form-control" id="saved_shipping">
                        <?php
                            $selected = '';
                            foreach($addresses as $address): ?>
                            <?php if($address->address_type == 'shipping'): ?>
                                <?php if($address->is_default){$selected = 'selected';} ?>
                                <option <?php echo $selected; ?> value="<?php echo $address->id; ?>"><?php echo $address->first_name.','.$address->last_name.','.$address->address_line_1.','.$address->address_line_2.','.$address->city.','.$address->state.','.$address->zip.','.$address->contact; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mt-20">
                    <input type="checkbox" class="pixel-checkbox" id="ship-bill">
                    <label for="login-6">Shipping same as billing address?</label>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'ship_first_name')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'First Name*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'First Name*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'ship_last_name')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Last Name*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Last Name*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'ship_contact')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Contact*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Contact*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'ship_address_line_1')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Address Line 1*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Address Line 1*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'ship_address_line_2')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Address Line 2', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Address Line 2'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'ship_city')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'City*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'City*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->field($add_model, 'ship_state')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'State*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'State*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'ship_country')->textInput(['class' => 'form-control mt-10', 'value' => 'USA', 'autocomplete' => 'off', 'disabled' => 'disabled'])->label(false); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $form->field($add_model, 'ship_zip')->textInput(['class' => 'form-control mt-10', 'placeholder' => 'Zip*', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = 'Zip*'", 'autocomplete' => 'off'])->label(false); ?>
                    </div>
                </div>
                <?php endif; ?>
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
                        <button type="submit" class="view-btn color-2 w-100 mt-20"><span>Proceed to Checkout</span></button>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php endif; ?>
<?php $this->registerJs(<<< EOT_JS
$(document).ready(function(){
    $('#ship-bill').click(function () {
        if ($(this).is(':checked')) {
            $('#billing :input').each(function () {
                var inpt = $(this);
                if (inpt.attr('aria-required') == 'true' && inpt.val().length == 0) {
                    alert('Fill Shipping Info First');
                    $('html, body').animate({
                        scrollTop: $('#address-form').offset().top
                    }, 2000);
                    $('#ship-bill').prop('checked', false);
                    return false;
                } else {
                    $('#addressform-ship_first_name').val($('#addressform-first_name').val());
                    $('#addressform-ship_last_name').val($('#addressform-last_name').val());
                    $('#addressform-ship_contact').val($('#addressform-contact').val());
                    $('#addressform-ship_address_line_1').val($('#addressform-address_line_1').val());
                    $('#addressform-ship_address_line_2').val($('#addressform-address_line_2').val());
                    $('#addressform-ship_city').val($('#addressform-city').val());
                    $('#addressform-ship_state').val($('#addressform-state').val());
                    $('#addressform-ship_zip').val($('#addressform-zip').val());
                }
            });
        }
    });
    $('#saved_billing').change(function(){
        var opt = $(this).find("option:selected").text();
        if(opt.length != 0){
            var option = opt.split(",");
            $("#addressform-first_name").val(option[0]);
            $("#addressform-last_name").val(option[1]);
            $("#addressform-address_line_1").val(option[2]);
            $("#addressform-address_line_2").val(option[3]);
            $("#addressform-city").val(option[4]);
            $("#addressform-state").val(option[5]);
            $("#addressform-zip").val(option[6]);
            $("#addressform-contact").val(option[7]);
        }
    });
    $('#saved_shipping').change(function(){
        var opt = $(this).find("option:selected").text();
        if(opt.length != 0){
            var option = opt.split(",");
            $("#addressform-ship_first_name").val(option[0]);
            $("#addressform-ship_last_name").val(option[1]);
            $("#addressform-ship_address_line_1").val(option[2]);
            $("#addressform-ship_address_line_2").val(option[3]);
            $("#addressform-ship_city").val(option[4]);
            $("#addressform-ship_state").val(option[5]);
            $("#addressform-ship_zip").val(option[6]);
            $("#addressform-ship_contact").val(option[7]);
        }
    });
}); 
EOT_JS
);
?>