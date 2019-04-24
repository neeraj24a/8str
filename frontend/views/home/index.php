<?php
$this->title = "Welcome to 8thwonderpromos DJ Pool";

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\Banners */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="e-top-video-download ui-full e-pdngTop158">
	<h2 data-aos="fade-up" data-aos-once="true">Top Video downloads</h2>
	<i data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="wave"><img src="static/images/wave-b.png" width="98" height="14" alt="wave"></i>
	
	<section class="ui-inner">
		<?php
		$j = 1;
		foreach($trending['video'] as $v): 
			if($j == 11){
				break;
			}
		?>
		<div class="e-video-box" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
			<div class="videoPlay-box ui-full postionR">
				<figure><img src="static/images/thumb.jpg" width="223" height="156" alt="video"></figure> 
				<a href="#inline" data-lity class="video-play" data-file="<?php echo $v->url; ?>"><img src="static/images/play.png" width="39" height="38" alt="play"></a>
			</div>
			<h3 title="<?php echo $v->title; ?>"><?php echo excerpt($v->title, 40); ?></h3>
			<p title="<?php echo $v->artist; ?>"><?php echo excerpt($v->artist, 25); ?></p>
		</div>
		<?php
		$j++;
		endforeach; ?>
	</section>    
	<div class="e-more-videos ui-full">
		<a href="https://pool.8thwonderpromos.com" data-text="more videos" class="sim-button button3 btn">more videos</a>
	</div>
<!--/e-top-video-download -->
</div>
<div class="ui-full e-audio-download e-pdngTop158">
	<h2 data-aos="fade-up" data-aos-once="true">Top Audio downloads
	<i data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="wave"><img src="static/images/wave.png" width="98" height="14" alt="wave"></i>
	</h2>
	
	<section class="e-audio-listen">
		<div class="e-audio-listen-border" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
			<div class="e-audio-listen-inner">
				<ul>
					<?php
					$k = 1;
					foreach($trending['audio'] as $a): 
						if($k == 11){
							break;
						}
					?>
						<li>
							<div class="e-audio-left">
								<i class="icon-play-1 audio-play" data-file="<?php echo $a->url; ?>"><img src="static/images/audio-play.png" width="10" height="13" alt="play"></i>
								<h4><?php echo $a->title; ?></h4>
							  <span><?php echo $a->artist; ?></span>
							</div>
							<div class="e-audio-right">
								<a href="javascript:void(0);"><?php echo $a->genre; ?></a>
								<a href="javascript:void(0);"><?php echo $a->subgenre; ?></a>
								<small><?php echo $a->bpm; ?></small>
								<small><?php echo $a->key; ?></small>
							</div>
						</li>
					<?php
					$k++;
					endforeach; ?>
					<li>
						<div id="audio-player" class="jPlayer audioPlayer"></div>
					</li>
				</ul>
			</div>
		</div>
	</section>
	
<!--/e-audio-download -->
</div>
<div class="e-pool-plans ui-full e-pdngTop158">
	<h2 data-aos="fade-up" data-aos-once="true">pool membership plans</h2>
	<i data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="wave"><img src="static/images/wave-b.png" width="98" height="14" alt="wave"></i>
	
	<section class="ui-inner">
		<div class="e-membership-plan" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
			<section>
			<h6>monthly bronze</h6>
			<img src="static/images/plan-sep.jpg" width="37" height="3" alt="sep">
			<label><sup>$</sup>9.99<sup>*</sup></label>
			<small class="desc">For 1st month then $19.99/Mo.</small>
			</section>
			<ul>
			<li>No Discount On Membership</li>
			<li>10% Off On Store</li>
			<li>No Free 8th T-Shirt</li>
			<li>Unlimited Downloads Audio &amp; Video</li>
			<li>All content id3 Tagged</li>
			<li>Serato Ready Cue Points</li>
			<li>Fast Downloads</li>
			<li>Trending Charts</li>
			<li>Desktop Application</li>
			<li>High Quality 320kbps Files</li>
			<li>Exclusive Remix Video Edits</li>
			<li>Multiple Versions Available</li>
			</ul>
			<div class="center"><a href="https://www.8thwonderpromos.com/amember/signup" data-text="subscribe" class="sim-button button3">subscribe</a></div>
		</div>
		<div class="e-membership-plan" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
			<div class="active-plan"></div>
			<section>
			<h6>ANNUAL PLATINUM</h6>
			<img src="static/images/plan-sep.jpg" width="37" height="3" alt="sep">
			<label><sup>$</sup>174.99</label>
			<small class="desc">per year</small>
			</section>
			<ul>
			<li>25% Off On Membership</li>
			<li>30% Off On Store</li>
			<li>No Free 8th T-Shirt</li>
			<li>Unlimited Downloads Audio &amp; Video</li>
			<li>All content id3 Tagged</li>
			<li>Serato Ready Cue Points</li>
			<li>Fast Downloads</li>
			<li>Trending Charts</li>
			<li>Desktop Application</li>
			<li>High Quality 320kbps Files</li>
			<li>Exclusive Remix Video Edits</li>
			<li>Multiple Versions Available</li>
			</ul>
			<div class="center"><a href="https://www.8thwonderpromos.com/amember/signup" data-text="subscribe" class="sim-button button3">subscribe</a></div>
		</div>
		<div class="e-membership-plan" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
			<section>
			<h6>monthly bronze</h6>
			<img src="static/images/plan-sep.jpg" width="37" height="3" alt="sep">
			<label><sup>$</sup>9.99<sup>*</sup></label>
			<small class="desc">For 1st month then $19.99/Mo.</small>
			</section>
			<ul>
			<li>10% Off On Membership</li>
			<li>20% Off On Store</li>
			<li>No Free 8th T-Shirt</li>
			<li>Unlimited Downloads Audio &amp; Video</li>
			<li>All content id3 Tagged</li>
			<li>Serato Ready Cue Points</li>
			<li>Fast Downloads</li>
			<li>Trending Charts</li>
			<li>Desktop Application</li>
			<li>High Quality 320kbps Files</li>
			<li>Exclusive Remix Video Edits</li>
			<li>Multiple Versions Available</li>
			</ul>
			<div class="center"><a href="https://www.8thwonderpromos.com/amember/signup" data-text="subscribe" class="sim-button button3">subscribe</a></div>
		</div>
	</section>
	
<!--/e-pool-plans -->
</div>
<div class="e-featured-shop ui-full e-pdngTop158">
	<section class="ui-inner">
	<h2 data-aos="fade-up" data-aos-once="true">featured shop collection</h2>
	<i data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="wave"><img src="static/images/wave-b.png" width="98" height="14" alt="wave"></i>
	<div class="e-collection-slider" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
		<ul class="banner-carousel">
			<?php foreach($products as $product): ?>
                <?php
                    $arr = explode("../", $product->main_image);
                    $img = \yii\helpers\Url::toRoute($arr[1]);
                ?>
			<li>
				<a href="<?php echo Url::toRoute('/shop/detail?product='.$product->slug); ?>">
					<div class="e-shop-box">
						<figure><img src="<?php echo $img; ?>" width="156" height="158" alt="shop"></figure>
						<h3><?php echo $product->name; ?></h3>
						<span>$<?php echo $product->unit_price; ?></span>
					</div>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<hr>
	<a href="<?php echo Url::toRoute('/shop'); ?>" data-text="visit shop" class="e-visit-shop sim-button button3 btn">visit shop</a>
	</section>
<!-- /e-featured-shop -->
</div>
<!--<div class="e-top-dj ui-full e-pdngTop158">
	<h2 data-aos="fade-up" data-aos-once="true">Trusted by top DJ</h2>
	<i data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="wave"><img src="static/images/wave-b.png" width="98" height="14" alt="wave"></i>
	
	<section class="ui-inner">
		<ul class="trusted-dj" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
			<li><img src="static/images/trusted01.jpg" alt="1"></li>
		</ul>
	</section>
</div>-->
<?php
$this->registerJs(
    "$(window).on('load',function(){
        $('#notificationModal').modal({show: true,backdrop: false});
    });"
);
?>
