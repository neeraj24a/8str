<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, target-densityDpi=device-dpi, user-scalable=0" />
        <?= Html::csrfMetaTags() ?>
        <link rel="SHORTCUT ICON" href="<?php echo base_url(); ?>/images/logo.png">
        <meta name="title" content="MP3 download. Record pool. MP4 download Video Record pool. | 8thwonderpromos">
		<meta name="keywords" content="mp3 download, mp3, mp4 download, mp4, record pool, remix, club hits, dj, vdj, electronic music">
		<meta name="description" content="MP3 download Mp4 download subscription platform. Record pool for djs.Record pool for video djs. The best club hits and remixes validated for us.">
        <meta charset="UTF-8">
		<meta name="theme-color" content="#333333" />
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#333333">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#333333">
        <title><?= Html::encode($this->title) ?></title>
        <meta property="og:site_name" content="8thwonderpromos">
        <meta property="og:url" content="index.html">
        <meta property="og:title" content="8thwonderpromos">
        <meta property="og:type" content="website">
        <meta property="og:description" content="8thwonderpromos">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="MP3 download. Record pool. MP4 download Video Record pool. | 8thwonderpromos">
        <meta name="twitter:description" content="MP3 download Mp4 download subscription platform. Record pool for djs.Record pool for video djs. The best club hits and remixes validated for us.">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link href="static/css/lity.min.css" rel="stylesheet" />
		<link href="static/css/jplayer.css" rel="stylesheet" />
		<link href="static/css/reset.css" rel="stylesheet" />
		<link href="static/css/main.css" rel="stylesheet" />
		<link href="static/css/fonts.css" rel="stylesheet" />
		<link href="static/css/aos.css" rel="stylesheet" />
		<link rel="stylesheet" href="static/jscript/lib/slick/slick.css">
		<link rel="stylesheet" href="static/jscript/lib/slick/slick-theme.css">
		<link href="static/css/responsive.css" rel="stylesheet" />
		<!--[if IE]><script src="static/jscript/html5.js"></script><![endif]-->
		<!--<script src="static/jscript/jquery.min.js"></script>-->
		<script>
            var base_url = "<?php echo Url::toRoute('/'); ?>";
        </script>
    </head>
	<body>
		<?php $this->beginBody() ?>
		<div class="e-home-banner ui-full">
			<header>
				<div class="header-in">
					<div class="e-logo">
						<a href="<?php echo Url::toRoute('/'); ?>">
							<img src="static/images/logo.png" width="83" height="88" alt="8thwonder">
						</a>
					</div>
					<?php if(Yii::$app->user->isGuest): ?>
						<a href="https://www.8thwonderpromos.com/amember/signup" class="e-signup">Sign Up</a>
					<?php else: ?>
						<a href="<?php echo Url::toRoute('/logout'); ?>" class="e-signup">Logout</a>
					<?php endif; ?>
					<ul class="nav">
						<li><a class="active" href="<?php echo Url::toRoute('/'); ?>">Home</a></li>
						<li><a href="https://pool.8thwonderpromos.com">Pool</a></li>
						<li><a href="https://www.8thwonderpromos.com/shop">Shop</a></li>
						<?php if(Yii::$app->user->isGuest): ?>
						<li><a href="<?php echo Url::toRoute('/login'); ?>">Login</a></li>
						<li class="mobileView">
							<a href="https://www.8thwonderpromos.com/amember/signup" class="e-mob-signup">Sign Up</a>
						</li>
						<?php else: ?>
						<li class="mobileView">
							<a href="<?php echo Url::toRoute('/logout'); ?>" class="e-mob-signup">Logout</a>
						</li>
						<?php endif; ?>
					</ul>
					<!-- Close button -->
					<button class="h-nav__close-btn" id="close-nav" type="button">
						<i class="fas fa-times" style="font-size: 48px;"></i>
					</button>
					<!-- Hamburger button -->
					<button class="h-hamburger" id="open-nav" type="button" aria-label="Open navigation">
						<i class="fas fa-bars" style="font-size: 48px;"></i>
					</button>
				</div>	
			<!--/HEADER --></header>    
			
			<div class="e-home-content">
				<h1 data-aos="fade-up" data-aos-delay="200" data-aos-once="true">High Quality Audio &amp; Video</h1>
				<span data-aos="fade-up" data-aos-delay="350" data-aos-once="true">Your a DJ? looking for a place to get all your visual and audio content? 8th Wonder is the right place for you with an easy to use website. </span>
				<div class="btnOuter" data-aos="fade-up" data-aos-delay="450" data-aos-once="true">
					<a href="https://www.8thwonderpromos.com/amember/signup" data-text="Join now for free" class="sim-button button3 btn">Join now for free</a>
				</div>	
			   
			<!--/e-home-content --></div>
		<!-- /e-home-banner -->
		</div>
		<div class="e-join-wonder ui-full e-pdngTop158">
			<h2 data-aos="fade-up" data-aos-once="true">Why Join 8<sup>th</sup>wonder</h2>
			<i data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="wave"><img src="static/images/wave-b.png" width="98" height="14" alt="wave"></i>
			
			<section class="ui-inner">
				<div class="e-join-box" data-aos="fade-up" data-aos-delay="300" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-1.png" width="58" height="56" alt="1"></figure>
					<h3>All The Newest Tracks First </h3>
				</div>
				<div class="e-join-box" data-aos="fade-up" data-aos-delay="350" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-2.png" width="58" height="56" alt="2"></figure>
					<h3>Classics Avialble in Audio &amp; Video</h3>
				</div>
				<div class="e-join-box" data-aos="fade-up" data-aos-delay="400" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-3.png" width="58" height="56" alt="3"></figure>
					<h3>Upload over 200 Tracks a Week </h3>
				</div>
				<div class="e-join-box"  data-aos="fade-up" data-aos-delay="450" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-4.png" width="58" height="56" alt="4"></figure>
					<h3>All Versions Available  </h3>
				</div>
				<div class="e-join-box"  data-aos="fade-up" data-aos-delay="500" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-5.png" width="58" height="56" alt="5"></figure>
					<h3>The most Video Edits in the World  </h3>
				</div>
				<div class="e-join-box" data-aos="fade-up" data-aos-delay="550" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-6.png" width="58" height="56" alt="6"></figure>
					<h3>Easy Desktop Downloader  </h3>
				</div>
				<div class="e-join-box" data-aos="fade-up" data-aos-delay="600" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-7.png" width="58" height="56" alt="7"></figure>
					<h3>Unlimited Downloads </h3>
				</div>
				<div class="e-join-box" data-aos="fade-up" data-aos-delay="650" data-aos-once="true">
					<figure><img src="static/images/join-wonder-icon-8.png" width="58" height="56" alt="8"></figure>
					<h3>Affordable Membership Pricing </h3>
				</div>
			</section>
			<div class="e-more-videos ui-full">
				<a href="https://www.8thwonderpromos.com/amember/signup" data-text="join now" class="sim-button button3 btn">Join Now</a>
			</div>
		<!-- /e-join-wonder -->
		</div>
		<?php echo $content; ?>
		<footer class="ui-full e-pdngTop112 center">
				<section class="ui-inner">
					<figure data-aos="fade-up" data-aos-once="true">
						<img src="static/images/mailIcn.png" width="89" height="88" alt="Mail">
					</figure>
					<span data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
						stay in touch
					</span>
					<p data-aos="fade-up" data-aos-delay="250" data-aos-once="true">
						Subscribe to 8thwonderpromos e-newsletter and get exclusive updates, offers, and more!
					</p>
					<section data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="e-subscribe">
						<form method="post" action="#" id="contact_form" accept-charset="UTF-8" class="contact-form">
							<div>
								<input type="email" id="Email" placeholder="Email address">
								<div id="email-error" style="position: absolute; color: red;margin: 70px 0 0 35px;"></div>
								<div id="email-success" style="position: absolute; color: green;margin: 70px 0 0 35px;"></div>
							</div>
							<button type="submit" name="commit" id="Subscribe">subscribe</button>
						</form>
					</section>
					<ul data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
					<li><a href="https://www.facebook.com/8thwonderrecordpool/"><img src="static/images/facebook.png" width="39" height="39" alt="facebook"></a></li>
					<li><a href="https://twitter.com/8thwonderpromos"><img src="static/images/twitter.png" width="39" height="39" alt="Twitter"></a></li>
					<li><a href="https://www.instagram.com/8thwonderrecordpool/"><img src="static/images/instagram.png" width="39" height="39" alt="instagram"></a></li>
					<li><a href="https://www.youtube.com/channel/UCfODYpiz94l_OU-l6G7y5Pg"><img src="static/images/youtube.png" width="39" height="39" alt="youtube"></a></li>
					</ul>
				<small data-aos="fade-up" data-aos-delay="200" data-aos-once="true">©copy 2019 8thwonderpromos.com | All Rights Reserved</small>
		</footer>
		<div id="inline" style="overflow:auto;background:#FDFDF6;padding:20px;width:600px;max-width:100%;border-radius:6px" class="lity-hide">
			<div id="video-player" class="jPlayer jp-video-270p"></div>
		</div>
		<?php $this->endBody() ?>
		<script src="static/jscript/lib/slick/slick.js"></script>
		<script src="static/jscript/aos.min.js"></script>
		<script src="static/jscript/lity.min.js"></script>
		<script src="static/jscript/jquery.jplayer.min.js"></script>
		<script src="static/jscript/player.js"></script>
		<script src="static/jscript/aos.min.js"></script>
		<script>
			if (window.hasOwnProperty('AOS')) {
			  AOS.init({
				offset: 0,
				easing: 'ease',
				duration: 1000
			  });
			}
			
			$(document).ready(function() {
				$(this).bind("contextmenu", function(e) {
					e.preventDefault();
				});
				var vfile = "";
				var afile = "";
				$('.video-play').click(function(){
					vfile = $(this).data('file');
				});
				$('.audio-play').click(function(){
					afile = $(this).data('file');
					$("#audio-player").plyr("destroy");
					$("#audio-player").html("");
					$("#audio-player").plyr({
						media: {
							mp3: afile
						},
						swfPath: "static/jscript/jquery.jplayer.swf"
					});
					setTimeout(function(){ $(".play").click(); }, 200);
				});
				$(document).on('click', '[data-lightbox]', lity);
				$(document).on('lity:open', function(event, instance) {
					console.log(instance.element());
					console.log('Lightbox opened');
					$("#video-player").plyr({
						media: {
							title: "",
							mp4: vfile,
							m4v: vfile,
							poster: "static/images/poster.png"
						},
						swfPath: "static/jscript/jquery.jplayer.swf"
					});
					setTimeout(function(){ $(".play").click(); }, 200);
				});
				$(document).on('lity:close', function(event, instance) {
					console.log('Lightbox closed');
					$("#video-player").plyr("destroy");
					$("#video-player").html("");
					vfile = "";
				});
				$('.h-hamburger').click(function(){
					$('.e-home-banner').toggleClass('mobileNav');
				});
				$('.h-nav__close-btn').click(function(){
					$('.e-home-banner').removeClass('mobileNav');
				});
				 
			});
			
			$(window).scroll(function(){
				if ($(window).scrollTop() >= 1107) {
					$('header div.e-logo a img').attr('src', 'static/images/logo-black.png');
					$('header').addClass('fixed-header');
					$('header .header-in').addClass('visible-title');
				}
				else {
					$('header div.e-logo a img').attr('src', 'static/images/logo.png');
					$('header').removeClass('fixed-header');
					$('header .header-in').removeClass('visible-title');
				}
			});			
		</script>   
	</body>
</html>
<?php $this->endPage() ?>