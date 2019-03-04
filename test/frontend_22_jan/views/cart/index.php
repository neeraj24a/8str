<?php
use yii\widgets\ListView;
use yii\helpers\Url;
$this->title = "8thwonderpromos Cart";
?>
<div id="shopify-section-cart-template" class="shopify-section">
    <div class="page-width">
        <?php if($cart == NULL): ?>
        <div class="empty-page-content text-center">
            <h1>Your cart</h1>
            <p class="cart--empty-message">Your cart is currently empty.</p>
            <div class="cookie-message">
                <p>Enable cookies to use the shopping cart</p>
            </div>
            <a href="<?php echo Url::toRoute('/shop'); ?>" class="btn btn--has-icon-after cart__continue-btn">
                Continue shopping
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-arrow-right" viewBox="0 0 20 8">
                    <path d="M15.186.445c.865.944 1.614 1.662 2.246 2.154.631.491 1.227.857 1.787 1.098v.44a9.933 9.933 0 0 0-1.875 1.196c-.606.485-1.328 1.196-2.168 2.134h-.752c.612-1.309 1.253-2.315 1.924-3.018H.77v-.986h15.577c-.495-.632-.84-1.1-1.035-1.406-.196-.306-.486-.843-.87-1.612h.743z" fill="#000" fill-rule="evenodd"></path>
                </svg>
            </a>
        </div>
        <?php else: ?>
        <div class="section-header text-center">
            <h1>Your cart</h1>
        </div>
            <table>
                <thead class="cart__row cart__header">
                    <tr>
                        <th colspan="2">Product</th>
                        <th>Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($cart['shop'])): ?>
                    <?php foreach($cart['shop'] as $info):
                        $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
					?>
						<?php foreach($info->var_qnty as $key => $val): ?>
							<?php foreach($val as $k => $v): ?>
								<tr class="cart__row border-bottom line1 cart-flex border-top" id="<?php echo $info->slug; ?>">
									<td class="cart__image-wrapper cart-flex-item">
										<a href="<?php echo Url::toRoute('/shop/detail?product='.$info->slug); ?>">
											<img class="cart__image" src="<?php echo $img; ?>" alt="<?php echo $info->name; ?>">
										</a>
									</td>
									<td class="cart__meta small--text-left cart-flex-item">
										<div class="list-view-item__title">
											<a href="<?php echo Url::toRoute('/shop/detail?product='.$info->slug); ?>">
												<?php echo $info->name; ?>
												<span class="medium-up--hide">
													<span class="visually-hidden">Quantity</span>
													(x<?php echo $info->quantity; ?>)
												</span>
											</a>
										</div>
										<div class="cart__meta-text">
											Size: <?php echo $k; ?> Color: <?php echo $key; ?><br>
										</div>
										<p class="small--hide">
											<a href="javascript:void(0);" class="btn btn--small btn--secondary cart__remove removeFromCart" data-slug="<?php echo $info->slug; ?>" data-type="shop" data-size="<?php echo $k; ?>" data-color="<?php echo $key; ?>">Remove</a>
										</p>
									</td>
									<td class="cart__price-wrapper cart-flex-item">
										$<?php echo $info->unit_price; ?>
										<div class="cart__edit medium-up--hide">
											<button type="button" class="btn btn--secondary btn--small js-edit-toggle cart__edit--active" data-target="line1">
												<span class="cart__edit-text--edit">Edit</span>
												<span class="cart__edit-text--cancel">Cancel</span>
											</button>
										</div>
									</td>
									<td class="cart__update-wrapper cart-flex-item text-right">
										<a href="javascript:void(0);" class="btn btn--small btn--secondary cart__remove medium-up--hide removeFromCart" data-slug="<?php echo $info->slug; ?>" data-type="shop" data-size="<?php echo $k; ?>" data-color="<?php echo $key; ?>">Remove</a>
										<div class="cart__qty">
											<label class="cart__qty-label">Quantity</label>
											<input class="cart__qty-input quantity-amount" type="number" data-type="shop" data-product="<?php echo $info->slug; ?>" data-size="<?php echo $k; ?>" data-color="<?php echo $key; ?>" value="<?php echo $v; ?>" min="0" pattern="[0-9]*">
										</div>
										<input type="submit" name="update" class="btn btn--small cart__update medium-up--hide" value="Update">
									</td>
									<td class="text-right small--hide">
										<div>
											$<?php echo $v * $info->unit_price; ?>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(isset($cart['drop'])): ?>
                    <?php foreach($cart['drop'] as $info):
                        $img = $info->thumbnail;
                    ?>
                    <tr class="cart__row border-bottom line1 cart-flex border-top" id="<?php echo $info->slug; ?>">
                        <td class="cart__image-wrapper cart-flex-item">
                            <a href="<?php echo Url::toRoute('/shop/detail?product='.$info->slug); ?>">
                                <img class="cart__image" src="<?php echo $img; ?>" alt="<?php echo $info->title; ?>">
                            </a>
                        </td>
                        <td class="cart__meta small--text-left cart-flex-item">
                            <div class="list-view-item__title">
                                <a href="<?php echo Url::toRoute('/djfrops/detail?product='.$info->slug); ?>">
                                    <?php echo $info->title; ?>
                                    <span class="medium-up--hide">
                                        <span class="visually-hidden">Quantity</span>
                                        (x<?php echo $info->quantity; ?>)
                                    </span>
                                </a>
                            </div>
                            <div class="cart__meta-text">
                                <textarea class="form-control desc"><?php echo $info->desc; ?></textarea>
                            </div>
                            <p class="small--hide">
                                <a href="javascript:void(0);" class="btn btn--small btn--secondary cart__remove removeFromCart" data-type="drop" data-slug="<?php echo $info->slug; ?>">Remove</a>
                            </p>
                        </td>
                        <td class="cart__price-wrapper cart-flex-item">
                            $$<?php echo $info->price; ?>
                            <div class="cart__edit medium-up--hide">
                                <button type="button" class="btn btn--secondary btn--small js-edit-toggle cart__edit--active" data-target="line1">
                                    <span class="cart__edit-text--edit">Edit</span>
                                    <span class="cart__edit-text--cancel">Cancel</span>
                                </button>
                            </div>
                        </td>
                        <td class="cart__update-wrapper cart-flex-item text-right">
                            <a href="javascript:void(0);" class="btn btn--small btn--secondary cart__remove medium-up--hide removeFromCart" data-slug="<?php echo $info->slug; ?>">Remove</a>
                            <div class="cart__qty">
                                <label class="cart__qty-label">Quantity</label>
                                <input class="cart__qty-input quantity-amount" type="number" data-type="drop" data-product="<?php echo $info->slug; ?>" value="<?php echo $info->quantity; ?>" min="0" pattern="[0-9]*">
                            </div>
                            <input type="submit" name="update" class="btn btn--small cart__update medium-up--hide" value="Update">
                        </td>
                        <td class="text-right small--hide">
                            <div>
                                $<?php echo $info->quantity * $info->price; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>    
            <footer class="cart__footer">
                <div class="grid">
                    <div class="grid__item text-right small--text-center">
                        <div>
                            <span class="cart__subtotal-title">Total</span>
                            <span class="cart__subtotal">$<?php echo $total; ?></span>
                        </div>
                        <div>
                            <span class="cart__subtotal-title">Discount</span>
                            <span class="cart__subtotal"><?php echo $offer; ?>%</span>
                        </div>
                        <div class="cart__shipping">
                            <?php echo $offer; ?>% Discount Because You have <?php echo $subscription; ?> Subscription. 
                            <?php if (Yii::$app->user->isGuest): ?>
                            If not logged in, log in for discount.
                            <?php endif; ?>
                        </div>
                        <div>
                            <span class="cart__subtotal-title">Subtotal</span>
                            <span class="cart__subtotal">$<?php echo $totalWithOffer; ?></span>
                        </div>
                        <div class="cart__shipping">Shipping &amp; taxes calculated at checkout</div>
                        <a href="<?php echo Url::toRoute('shop'); ?>" class="btn btn--secondary cart__update cart__continue--large small--hide">Continue shopping</a>
                        <input type="button" name="update" class="btn btn--secondary cart__update cart__update--large small--hide update-cart" value="Update">
                        <a href="<?php echo Url::toRoute('/cart/checkout'); ?>" class="btn btn--small-wide">Check out</a>
                    </div>
                </div>
            </footer>
            <?php endif; ?>
    </div>
</div>

<?php
$this->registerJs("
        $(document).ready(function(){
            $('.removeFromCart').on('click', function(){
				var el = $(this);
                var product = el.attr('data-slug');
				var type = el.attr('data-type');
				var reqObj = {};
				reqObj.product = product;
				reqObj.type = type;
				if(type == 'shop'){
					var color = el.attr('data-color');
					var size = el.attr('data-size');
					reqObj.color = color;
					reqObj.size = size;
				}
				$.ajax({
                    url: base_url + 'cart/remove',
                    method: 'POST',
                    data: reqObj,
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
					var el = $(this);
                    var product = el.data('product');
                    var quantity = el.val();
                    var type = el.data('type');
                    if(type == 'drop'){
                        a['desc'] = $('.cart__meta-text textarea').val();
                    } else {
						a['color'] = el.data('color');
						a['size'] = el.data('size');
					}
                    if(quantity == 0){
                        $('#'+product).remove();
                    }
                    a['product'] = product;
                    a['quantity'] = quantity;
                    a['type'] = type;
                    products.push(a);
                });
                $.ajax({
                    url: base_url + 'cart/updatecart',
                    method: 'POST',
                    data: {'products': products},
                    success: function (data) {
                        location.reload();
                    }
                });
            });
        });
    ");
?>