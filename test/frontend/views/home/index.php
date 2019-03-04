<?php
$this->title = "Homepage";

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\Banners */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="shopify-section index-section index-section--flush">
    <div data-section-id="slideshow" data-section-type="slideshow-section">
        <div class="slideshow-wrapper">
            <div class="flexslider">
                <ul class="slides">
                    <?php foreach($banners as $b): ?>
                        <li>
                            <?php if($b->url != '' || $b->url != null): ?>
                            <a href="<?php echo $b->url; ?>">
                                <img src="<?php echo str_replace('../assets', 'assets', $b->image); ?>" />
                            </a>
                            <?php else: ?>
                                <img src="<?php echo str_replace('../assets', 'assets', $b->image); ?>" />
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="shopify-section">
	<div class="page-width">
		<div class="grid--uniform grid--view-items">
			<div class="home_bnnr_content">
				<div class="container">
					<div class="bnnr_content">
						<h1>JOIN THE NUMBER #1 DJ POOL</h1>
						<div class="left">
							<h5>
								High Quality Audio &amp; Video <br>
								Classics Avialble in Audio &amp; Video <br>
								All Versions Available <br>
								Easy Desktop Downloader <br>
								Fast Downloads <br>
								Affordable Membership Pricing
							</h5>
							<p></p>
						</div>
						<div class="right">
							<h5>
								All The Newest Tracks First <br>
								Upload over 200 Tracks a Week <br>
								The most Video Edits in the World <br>
								Unlimited Downloads <br>
								Dropbox Feature <br>
								User Freindly
							</h5>
							<p></p>
						</div>
						<p></p>
					</div>
					<p></p>
				</div>
				<p></p>
			</div>
		</div>
	</div>
</div>
<div class="shopify-section index-section">
    <div class="page-width">
        <div class="section-header text-center">
            <h2>POOL MEMBERSHIP PLANS</h2>
        </div>
        <div class="grid--uniform grid--view-items">
			<section id="pricing-table">
				<div class="container">
					<div class="row">
						<div class="pricing">
							<div class="pull-left one-third small--one-whole pad-2p">
								<div class="type">
									<p>Monthly Bronze</p>
								</div>
								<div class="plan">
									<div class="header">
										<span>$</span>9<sup>.99*</sup>
										<p class="month">For 1st month then $19.99/Mo. </p>
									</div>
									<div class="content">
										<ul>
											<li>No Discount On Membership</li>
											<li>10% Off On Store</li>
											<li>No Free 8th T-Shirt</li>
											<li>Unlimited Downloads Audio & Video</li>
											<li>All content id3 Tagged</li>
											<li>Serato Ready Cue Points</li>
											<li>Fast Downloads</li>
											<li>Trending Charts</li>
											<li>Desktop Application</li>
											<li>High Quality 320kbps Files</li>
											<li>Exclusive Remix Video Edits</li>
											<li>Multiple Versions Available</li>
										</ul>
									</div>		
									<div class="price">
										<a href="https://www.8thwonderpromos.com/amember/signup/monthly" target="_blank" class="bottom">
											<p class="cart">Subscribe</p>
										</a>
									</div>
								</div>
							</div>
							<div class="pull-left one-third small--one-whole pad-2p">
								<div class="type standard">
									<p>Annual Platinum</p>
								</div>
								<div class="plan">
									<div class="header">
										<span>$</span>174<sup>.99</sup>
										<p class="month">per year</p>
									</div>
									<div class="content">
										<ul>
											<li>25% Off On Membership</li>
											<li>30% Off On Store</li>
											<li>No Free 8th T-Shirt</li>
											<li>Unlimited Downloads Audio & Video</li>
											<li>All content id3 Tagged</li>
											<li>Serato Ready Cue Points</li>
											<li>Fast Downloads</li>
											<li>Trending Charts</li>
											<li>Desktop Application</li>
											<li>High Quality 320kbps Files</li>
											<li>Exclusive Remix Video Edits</li>
											<li>Multiple Versions Available</li>
										</ul>
									</div>
									<div class="price">
										<a href="https://www.8thwonderpromos.com/amember/signup/yearly" target="_blank" class="bottom">
											<p class="cart">Subscribe</p>
										</a>
									</div>
								</div>
							</div>

							<div class="pull-left one-third small--one-whole pad-2p">
								<div class="type ultimate">
									<p>Quarterly Gold</p>
								</div>
								<div class="plan">
									<div class="header">
										<span>$</span>54<sup>.99</sup>
										<p class="month">per 3 months</p>
									</div>
									<div class="content">
										<ul>
											<li>10% Off On Membership</li>
											<li>20% Off On Store</li>
											<li>No Free 8th T-Shirt</li>
											<li>Unlimited Downloads Audio & Video</li>
											<li>All content id3 Tagged</li>
											<li>Serato Ready Cue Points</li>
											<li>Fast Downloads</li>
											<li>Trending Charts</li>
											<li>Desktop Application</li>
											<li>High Quality 320kbps Files</li>
											<li>Exclusive Remix Video Edits</li>
											<li>Multiple Versions Available</li>
										</ul>
									</div>
									<div class="price">
										<a href="https://www.8thwonderpromos.com/amember/signup/quaterly" target="_blank" class="bottom">
											<p class="cart">Subscribe</p>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<div class="shopify-section index-section">
    <div class="page-width">
        <div class="section-header text-center">
            <h2>FEATURED SHOP COLLECTION</h2>
        </div>
        <div class="grid grid--uniform grid--view-items">
            <?php foreach($products as $product): ?>
                <?php
                    $arr = explode("../", $product->main_image);
                    $img = \yii\helpers\Url::toRoute($arr[1]);
                ?>
            <div class="grid__item grid__item--featured-collections small--one-half medium-up--one-fifth">
               <div class="grid-view-item">
                  <a class="grid-view-item__link grid-view-item__image-container" href="<?php echo Url::toRoute('/shop/detail?product='.$product->slug); ?>">
                     <div class="featured-collections grid-view-item__image-wrapper">
                        <div style="padding-top:100.0%;">
                           <img
                              class="featured-collections-img grid-view-item__image"
                              src="<?php echo $img; ?>"
                              data-src="<?php echo $img; ?>"
                              data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                              data-aspectratio="1.0"
                              data-sizes="auto"
                              alt="<?php echo $product->name; ?>">
                        </div>
                     </div>
                     <noscript>
                        <img class="grid-view-item__image" src="<?php echo $img; ?>" alt="<?php echo $product->name; ?>" style="max-width: 195.0px;">
                     </noscript>
                     <div class="h4 grid-view-item__title"><?php echo $product->name; ?></div>
                     <div class="grid-view-item__meta">
                        <!-- snippet/product-price.liquid -->
                        <span class="visually-hidden">Regular price</span>
                        <span class="product-price__price">$<?php echo $product->unit_price; ?></span>
                     </div>
                  </a>
               </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center goto-link-wrapper">
          <a href="/shop" class="btn btn--secondary btn--has-icon-before return-link">
              Visit Shop
          </a>
        </div>
  </div> 
</div>
<div id="shopify-section-featured-collections" class="shopify-section index-section">
    <div class="page-width">
        <div class="section-header text-center">
            <h2>FEATURED DROPS COLLECTION</h2>
        </div>
        <div class="grid grid--uniform grid--view-items">
            <?php foreach($drops as $drop): ?>
                <?php
                    if($drop->youtube != '' && $drop->type == 'video'){
                      $video_id = getUtubeId($drop->youtube);
                    }
                    if($drop->type == 'video'){
                      $img = 'https://img.youtube.com/vi/'.$video_id.'/hqdefault.jpg';
                    } else{
                      $img = Url::toRoute('/images/audio-drop.png');
                    }
                ?>
            <div class="grid__item grid__item--featured-collections small--one-half medium-up--one-fifth">
               <div class="grid-view-item">
                  <a class="grid-view-item__link grid-view-item__image-container" href="<?php echo Url::toRoute('/djdrops/details?drop='.$drop->slug); ?>">
                     <div class="featured-collections grid-view-item__image-wrapper">
                        <div style="padding-top:100.0%;">
                           <img
                              class="featured-collections-img grid-view-item__image"
                              src="<?php echo $img; ?>"
                              data-src="<?php echo $img; ?>"
                              data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                              data-aspectratio="1.0"
                              data-sizes="auto"
                              alt="<?php echo $drop->title; ?>">
                        </div>
                     </div>
                     <noscript>
                        <img class="grid-view-item__image" src="<?php echo $img; ?>" alt="<?php echo $drop->title; ?>" style="max-width: 195.0px;">
                     </noscript>
                     <div class="h4 grid-view-item__title"><?php echo $drop->title; ?></div>
                     <div class="grid-view-item__meta">
                        <!-- snippet/product-price.liquid -->
                        <span class="visually-hidden">Regular price</span>
                        <span class="product-price__price">$<?php echo $drop->price; ?></span>
                     </div>
                  </a>
               </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center goto-link-wrapper">
          <a href="/shop" class="btn btn--secondary btn--has-icon-before return-link">
              View All Drops
          </a>
        </div>
  </div>
</div>
<?php
$this->registerJs(
    "$(window).on('load', function(){
        $('.flexslider').flexslider({
            animation: 'slide',
            slideshow: true,
            start: function(slider){
                $('body').removeClass('loading');
            }
        });
    });
    $(window).on('load',function(){
        $('#notificationModal').modal({show: true,backdrop: false});
    });"
);
?>
