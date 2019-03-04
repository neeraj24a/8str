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
<section id="download-now-sec">
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
</section>
<section id="home_banner">
    <div class="home_bnnr_content">
        <div class="container">
            <div class="bnnr_content">
                <h1>JOIN THE NUMBER #1 DJ POOL</h1>
                <div class="left">
                    <h5>
                        High Quality Audio &amp; Video
                        Classics Avialble in Audio &amp; Video
                        All Versions Available
                        Easy Desktop Downloader
                        Fast Downloads
                        Affordable Membership Pricing
                    </h5>
                </div>
                <div class="right">
                    <h5>
                        All The Newest Tracks First
                        Upload over 200 Tracks a Week
                        The most Video Edits in the World
                        Unlimited Downloads
                        Dropbox Feature
                        Ueser Freindly
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="membership-options">
    <div class="container">
        <h2>MEMBERSHIP OPTIONS</h2>
        <h5>Pick which option works best for you</h5>
        <div class="row">
            <div class="col-sm-4">
                <div class="options-box">
                    <h3>Monthly Plan (Bronze)</h3>
                    <h5>
                        Unlimited Downloads Audio &amp; Video
                        All content id3 Tagged
                        Serato Ready Cue Points
                        Fast Downloads
                        Trending Charts
                        Desktop Application
                        High Quality 320kbps Files
                        Exclusive Remix Video Edits
                        Multiple Versions Available
                    </h5>
                    <h4>$9.99</h4>
                    <span class="small">
                        First Month Then $19.99 After
                    </span>
                </div>
                <a class="option-signup" title="Sign Up" href="https://www.8thwonderpromos.com/amember/signup/monthly">Sign Up</a>
            </div>
            <div class="col-sm-4">
                <div class="options-box">
                    <h3>Annualy Plan (Plantinum)</h3>
                    <h5>
                        Unlimited Downloads Audio &amp; Video
                        All content id3 Tagged
                        Serato Ready Cue Points
                        Fast Downloads
                        Trending Charts
                        Desktop Application
                        High Quality 320kbps Files
                        Exclusive Remix Video Edits
                        Multiple Versions Available
                        25% Off Membership
                        20% Off Our Store
                        Free 8th T-Shirt
                    </h5>
                    <h4>$174.99</h4>
                    <span class="small">
                        First Year Then 174.99 After
                    </span>
                </div>
                <a class="option-signup" title="Sign Up" href="https://www.8thwonderpromos.com/amember/signup">Sign Up</a>
            </div>
            <div class="col-sm-4">
                <div class="options-box">
                    <h3>Quaterly Plan (Gold)</h3>
                    <h5>
                        Unlimited Downloads Audio &amp; Video
                        All content id3 Tagged
                        Serato Ready Cue Points
                        Fast Downloads
                        Trending Charts
                        Desktop Application
                        High Quality 320kbps Files
                        Exclusive Remix Video Edits
                        Multiple Versions Available
                        10% Off Membership
                        10% Off Our Store
                    </h5>
                    <h4>$54.99</h4>
                    <span class="small">
                        First Quater Then 54.99 After
                    </span>
                </div>
                <a class="option-signup" title="Sign Up" href="https://www.8thwonderpromos.com/amember/signup">Sign Up</a>
            </div>
        </div>
        <h4 class="need-help">Need Help Call:1833 DJ Promo</h4>
        <h3 class="newslttr-head">Subcribe To Our Newsletter To Recieve Exclusive Content &amp; Updates</h3>
        <?php
            $form = ActiveForm::begin([
                        'options' => ['class' => 'subscribe-field', 'autocomplete' => 'off'],
            ]);
        ?>
            <?= $form->field($model, 'email')->textInput(['class' => 'input-field'])->label(false); ?>
            <input type="button" value="Subscribe" class="sub-btn">
            <?= Alert::widget() ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
<!-- End Product Carousel Area -->
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