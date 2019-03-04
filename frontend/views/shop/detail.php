<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "8thwonderpromos Shop: ".$model->name;
?>
<div id="shopify-section-product-template" class="shopify-section">
	<div class="product-template__container page-width">
  		<meta itemprop="name" content="<?php echo $model->name; ?>">
  		<meta itemprop="url" content="https://www.8thwonderpromos.com/detail?product=<?php echo $model->slug; ?>">
  		<meta itemprop="image" content="<?php echo $model->main_image; ?>">
  		<div class="grid product-single">
    		<div class="grid__item product-single__photos medium-up--one-half">
				<div class="xzoom-container product-image-wrapper">
					<div class="product-single__photo-wrapper">
						<img class="xzoom4" id="xzoom-fancy" src="<?php echo $model->main_image; ?>" xoriginal="<?php echo $model->main_image; ?>" />
					</div>
					<noscript>
						<img src="<?php echo $model->main_image; ?>" alt="<?php echo $model->name; ?>" id="FeaturedImage-product-template" class="product-featured-img" style="max-width: 530px;">
					</noscript>
					<div class="xzoom-thumbs thumbnails-wrapper">
						<a href="<?php echo $model->main_image; ?>">
							<img class="xzoom-gallery4" width="80" src="<?php echo $model->main_image; ?>" xpreview="<?php echo $model->main_image; ?>" title="The description goes here">
						</a>
						<?php if(sizeof($gallery) > 0): ?>
							<?php foreach($gallery as $g): ?>
								<a href="<?php echo $g; ?>">
									<img class="xzoom-gallery4" width="80" src="<?php echo $g; ?>" xpreview="<?php echo $g; ?>" title="The description goes here">
								</a>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
		        <!--<div class="product-image-wrapper product-single__photo-wrapper">
		          	<div style="padding-top: 100%; position: relative; overflow: hidden;" class="product-single__photo js-zoom-enabled product-single__photo--has-thumbnails" data-image-id="3919315632151" data-zoom="">
		            <img class="product-image feature-row__image product-featured-img" src="<?php echo $model->main_image; ?>" data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]" data-aspectratio="1.0" data-sizes="auto" alt="<?php echo $model->name; ?>" data-srcset="" class="zoomImg" style="position: absolute; border: none; max-width: none; max-height: none;">
		        	</div>
		        </div>
      			<noscript>
        			<img src="<?php echo $model->main_image; ?>" alt="<?php echo $model->name; ?>" id="FeaturedImage-product-template" class="product-featured-img" style="max-width: 530px;">
      			</noscript>
        		<div class="thumbnails-wrapper">
          			<ul class="grid grid--uniform product-single__thumbnails product-single__thumbnails-product-template">
              			<li class="grid__item medium-up--one-quarter product-single__thumbnails-item">
                			<a href="" class="text-link product-single__thumbnail product-single__thumbnail--product-template active-thumb" data-thumbnail-id="3919315632151" data-zoom="">
                     			<img class="product-single__thumbnail-image" src="<?php echo $model->main_image; ?>" alt="<?php echo $model->name; ?>">
                			</a>
              			</li>
              		</ul>
        		</div>-->
    		</div>
    		<div class="grid__item medium-up--one-half">
      			<div class="product-single__meta">
        			<h1 itemprop="name" class="product-single__title"><?php echo $model->name; ?></h1>
    				<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
      					<meta itemprop="priceCurrency" content="USD">
      					<link itemprop="availability" href="http://schema.org/InStock">
      					<p class="product-single__price product-single__price-product-template">
          					<span class="visually-hidden">Regular price</span>
      						<s id="ComparePrice-product-template" class="hide"></s>
          					<span class="product-price__price product-price__price-product-template">
            					<span id="ProductPrice-product-template" itemprop="price" content="<?php echo $model->unit_price; ?>">
              						$<?php echo $model->unit_price; ?>
            					</span>
            					<span class="product-price__sale-label product-price__sale-label-product-template hide">Sale</span>
          					</span>
      					</p>
      					<?php $form = ActiveForm::begin(['action' => ['cart/add'],'options' => ['method' => 'post','id' => 'product-to-cart', 'class' => 'product-form product-form-product-template']]) ?>
                    <div class="selector-wrapper product-form__item">
              					<label for="SingleOptionSelector-0">
                					Size
              					</label>
              					<select class="single-option-selector single-option-selector-product-template product-form__input" name="size">
                  					<?php $sizes = backend\models\PrintfulProductDetails::find()->where(['printful_product' => $model->printful_product])->groupBy([
                                            'size'])->orderBy(['date_entered' => 'SORT_ASC'])->all(); 
										foreach($sizes as $size):
									?>
									<option value="<?php echo $size->size; ?>"><?php echo $size->size; ?></option>
									<?php endforeach; ?>
								</select>
            				</div>
                    <div class="selector-wrapper product-form__item">
                        <label for="SingleOptionSelector-0">
                          Color
                        </label>
                        <select class="single-option-selector single-option-selector-product-template product-form__input" name="color">
                          <?php
                            $variants = backend\models\PrintfulProductDetails::find()->where(['printful_product' => $model->printful_product])->groupBy([
                                            'color'])->all();
                            foreach($variants as $variant):
                          ?>
                            <option value="<?php echo $variant->color; ?>"><?php echo $variant->color; ?></option>
                          <?php endforeach; ?>
                        </select>
                    </div>
            				<div class="product-form__item product-form__item--quantity">
            					<?= $form->field($addToCart, 'quantity')->textInput(['maxlength' => true,'class' => 'form-control','value' => '1', 'name' => 'quantity', "min" => "1", "class" => "product-form__input", "pattern" => "[0-9]*"])->label(false); ?>
          					</div>
          					<?= $form->field($addToCart, 'type')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => 'shop', 'name' => 'type'])->label(false); ?>
		                    <?= $form->field($addToCart, 'product')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => $model->slug, 'name' => 'product'])->label(false); ?>
		                    <div class="product-form__item product-form__item--submit">
          						<?= Html::submitButton('<span id="AddToCartText-product-template">Add To Cart</span>', ['class' => 'btn product-form__cart-submit']) ?>
          					</div>
          					<div id="notification" class="product-form__item product-form__item--notification">
          						
          					</div>
						<?php ActiveForm::end(); ?>
      				</div>
	        		<div class="product-single__description rte" itemprop="description">
      					<p><?php echo $model->description; ?></p>
					</div>
					<div class="social-sharing"></div>
		      	</div>
			</div>
		</div>
	</div>
	<div class="text-center return-link-wrapper">
		<a href="/shop" class="btn btn--secondary btn--has-icon-before return-link">
	  		<svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-arrow-left" viewBox="0 0 20 8"><path d="M4.814 7.555C3.95 6.61 3.2 5.893 2.568 5.4 1.937 4.91 1.341 4.544.781 4.303v-.44a9.933 9.933 0 0 0 1.875-1.196c.606-.485 1.328-1.196 2.168-2.134h.752c-.612 1.309-1.253 2.315-1.924 3.018H19.23v.986H3.652c.495.632.84 1.1 1.036 1.406.195.306.485.843.869 1.612h-.743z" fill="#000" fill-rule="evenodd"></path></svg>
	  		Back to SHOP
		</a>
	</div>
</div>
<?php
$this->registerJs(
    "(function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
    $(document).ready(function(){
		$('.xzoom4, .xzoom-gallery4').xzoom({tint: '#006699', Xoffset: 15});
    	var isTouchSupported = 'ontouchstart' in window;
		if (isTouchSupported) {
			var xzoom = $('.xzoom').data('xzoom');
                xzoom.eventunbind();
			$(this).hammer().on('tap', function(event) {
                event.pageX = event.gesture.center.pageX;
                event.pageY = event.gesture.center.pageY;
                var s = 1, ls;

                xzoom.eventmove = function(element) {
                    element.hammer().on('drag', function(event) {
                        event.pageX = event.gesture.center.pageX;
                        event.pageY = event.gesture.center.pageY;
                        xzoom.movezoom(event);
                        event.gesture.preventDefault();
                    });
                }

                var counter = 0;
                xzoom.eventclick = function(element) {
                    element.hammer().on('tap', function() {
                        counter++;
                        if (counter == 1) setTimeout(openfancy,300);
                        event.gesture.preventDefault();
                    });
                }

                function openfancy() {
                    if (counter == 2) {
                        xzoom.closezoom();
                        $.fancybox.open(xzoom.gallery().cgallery);
                    } else {
                        xzoom.closezoom();
                    }
                    counter = 0;
                }
				xzoom.openzoom(event);
            });
		} else {
			$('#xzoom-fancy').bind('click', function(event) {
                var xzoom = $(this).data('xzoom');
                xzoom.closezoom();
                $.fancybox.open(xzoom.gallery().cgallery, {padding: 0, helpers: {overlay: {locked: false}}});
                event.preventDefault();
            });
		}
        $('#product-to-cart').on('beforeSubmit', function(e){
        	e.preventDefault();
    		var form = $(this);
	      	$.ajax({
	            url    : form.attr('action'),
	            type   : 'POST',
	            data   : form.serialize(),
	            success: function (response) 
	            {                  
	               	var res = $.parseJSON(response);
	               	if(res.msg == 'Added'){
                    $('#CartCount').html(res.quantity);
	               		$('#notification').html('Added To Cart Successfully!');
	               	} else if(res.msg == 'Removed') {
                    $('#CartCount').html(res.quantity);
               			$('#notification').html('Remove From Cart Successfully!');
               		}
	            },
	            error  : function (e) 
	            {
	                console.log(e);
	            }
	        });
		    return false;
        }).on('submit', function(e){
		    e.preventDefault();
		});
    });"
);
?>
