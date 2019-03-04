<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
	if($model->type == 'audio')
		$this->title = "8thwonderpromos Audio Drops: ".$model->title;
	else
		$this->title = "8thwonderpromos Video Drops: ".$model->title;

	if($model->youtube != '' && $model->type == 'video'){
      $video_id = getUtubeId($model->youtube);
    }
    if($model->type == 'video'){
      $img = 'https://img.youtube.com/vi/'.$video_id.'/hqdefault.jpg';
    } else{
      $img = Url::toRoute('/images/audio-drop.png');
    }
?>
<div class="shopify-section">
	<div class="product-template__container page-width">
  		<meta itemprop="name" content="<?php echo $model->title; ?>">
  		<meta itemprop="url" content="https://www.8thwonderpromos.com/djdrops/details?drops=<?php echo $model->slug; ?>">
  		<meta itemprop="image" content="<?php echo $img; ?>">
  		<div class="grid product-single">
    		<div class="grid__item product-single__photos medium-up--one-half">
		        <div class="product-image-wrapper product-single__photo-wrapper">
		          	<?php if($model->type == 'video' && $model->youtube != ''): ?>
						<div class="video-container">
							<iframe width="853" height="480" src="https://www.youtube.com/embed/<?php echo getUtubeId($model->youtube); ?>" frameborder="0" allowfullscreen></iframe>
						</div>
					<?php else: ?>
						<div class="col-lg-2">&nbsp;</div>
						<div class="col-lg-8">
							<img class="img-responsive" src="<?php echo Url::toRoute('/images/audio-drop.png'); ?>">
							<?php 
								$src = str_replace('../', Yii::$app->homeUrl, $model->file);  
							?>
							<div class="audio-player">
								<audio preload="auto" controls>
									<source src="<?php echo $src; ?>">
								</audio>
							</div>	
						</div>
						<div class="col-lg-2">&nbsp;</div>
					<?php endif; ?>
		        </div>
      		</div>
    		<div class="grid__item medium-up--one-half">
      			<div class="product-single__meta">
        			<h1 itemprop="name" class="product-single__title"><?php echo $model->title; ?></h1>
    				<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
      					<meta itemprop="priceCurrency" content="USD">
      					<link itemprop="availability" href="http://schema.org/InStock">
      					<p class="product-single__price product-single__price-product-template">
          					<span class="visually-hidden">Regular price</span>
      						<s id="ComparePrice-product-template" class="hide"></s>
          					<span class="product-price__price product-price__price-product-template">
            					<span id="ProductPrice-product-template" itemprop="price" content="<?php echo $model->price; ?>">
              						$<?php echo $model->price; ?>
            					</span>
            					<span class="product-price__sale-label product-price__sale-label-product-template hide">Sale</span>
          					</span>
      					</p>
      					<?php if($inCart): ?>
							<?php $form = ActiveForm::begin(['action' => ['cart/remove'],'options' => ['method' => 'post','id' => 'drop-remove-cart', 'class' => 'product-form product-form-product-template']]) ?>
								<?= $form->field($cartForm, 'type')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => 'drop', 'name' => 'type'])->label(false); ?>
			                    <?= $form->field($cartForm, 'product')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => $model->slug, 'name' => 'product'])->label(false); ?>
				            
				            	<div class="product-form__item product-form__item--submit">
          							<?= Html::submitButton('<span id="AddToCartText-product-template">Remove From Cart</span>', ['class' => 'btn product-form__cart-submit']) ?>
          						</div>
          						<div id="notification" class="product-form__item product-form__item--notification">
									<?php if(isset($_GET['cart'])): ?>
										<?php if($_GET['cart']  == 'added'): ?>
										Added To Cart Successfully!
										<?php elseif($_GET['cart'] == 'present'): ?>
										Already Added To Cart!
										<?php endif; ?>
									<?php endif; ?>
          						</div>
							<?php ActiveForm::end(); ?>
						<?php else: ?>
							<?php $form = ActiveForm::begin(['action' => ['cart/droptocart'],'options' => ['enctype' => 'multipart/form-data', 'method' => 'post','id' => 'add-to-cart', 'class' => 'product-form product-form-product-template']]) ?>
								<div class="selector-wrapper product-form__item">
	              					<?= $form->field($cartForm, 'desc')->textarea(['maxlength' => true,'class' => 'form-control', 'name' => 'description', 'id' => 'desc']); ?>
									<?= $form->field($cartForm, 'logo')->fileInput(['maxlength' => true,'class' => 'form-control', 'name' => 'logo', 'id' => 'logo']); ?>
	            				</div>
								<?= $form->field($cartForm, 'type')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => 'drop', 'name' => 'type', 'id' => 'type'])->label(false); ?>
			                    <?= $form->field($cartForm, 'quantity')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => '1', 'name' => 'quantity', 'id' => 'quantity'])->label(false); ?>
			                    <?= $form->field($cartForm, 'product')->hiddenInput(['maxlength' => true,'class' => 'form-control','value' => $model->slug, 'name' => 'product', 'id' => 'product'])->label(false); ?>
			                    <div class="product-form__item product-form__item--submit">
          							<?= Html::submitButton('<span id="AddToCartText-product-template">Add To Cart</span>', ['class' => 'btn product-form__cart-submit']) ?>
          						</div>
          						<div id="notification" class="product-form__item product-form__item--notification">
									<?php if(isset($_GET['cart'])): ?>
										<?php if($_GET['cart']  == 'added'): ?>
										Added To Cart Successfully!
										<?php elseif($_GET['cart'] == 'present'): ?>
										Already Added To Cart!
										<?php endif; ?>
									<?php endif; ?>
          						</div>
				            <?php ActiveForm::end(); ?>
						<?php endif; ?>
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
    function reloadPage(){
		var hrf = window.location.href;
		if(hrf.search('&cart') !== -1){
			var arr = hrf.split('&cart');
			window.open(arr[0],'_self');
		} else {
			window.location.reload();
		}
	}
	$(document).ready(function(){
    	$( 'audio' ).audioPlayer();
		$('#drop-remove-cart').on('beforeSubmit', function(e){
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
	               		$('#notification').html('Added To Cart Successfully!');
	               		$('#CartCount').html(res.quantity);
	               	} else if(res.msg == 'Already Added') {
	               		$('#notification').html('Already Added To Cart!');
               		} else if(res.msg == 'Removed') {
               			$('#CartCount').html(res.quantity);
               			$('#notification').html('Removed From Cart Successfully!');
               		}
					setTimeout(reloadPage, 3000);
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
        $('#drop-to-cart').on('beforeSubmit', function(e){
        	e.preventDefault();
			var form = $(this);
			var data = new FormData(form);
			/*data.append('logo', $('#logo')[0].files[0]);
			data.append('desc', $('#desc').val());
			data.append('type', $('#type').val());
			data.append('quantity', $('#quantity').val());
			data.append('product', $('#product').val());*/
			console.log(data);
    		// var form = $(this);
			$.ajax({
	            url    : form.attr('action'),
	            type   : 'POST',
	            data   : data,
				contentType: false,
				cache: false,
				processData:false,
	            success: function (response) 
	            {                  
	               	var res = $.parseJSON(response);
	               	if(res.msg == 'Added'){
	               		$('#notification').html('Added To Cart Successfully!');
	               		$('#CartCount').html(res.quantity);
	               	} else if(res.msg == 'Already Added') {
	               		$('#notification').html('Already Added To Cart!');
               		} else if(res.msg == 'Removed') {
               			$('#CartCount').html(res.quantity);
               			$('#notification').html('Removed From Cart Successfully!');
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