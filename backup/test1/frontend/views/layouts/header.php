<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Cart";
?>
<?php $active = Yii::$app->controller->id; ?>
<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <a href="<?php echo Url::toRoute('/'); ?>" class="logo" title="8thWonder">
                    <img src="<?php echo Url::toRoute('/images/logo.png'); ?>" alt="">
                </a>
            </div>
            <div class="col-sm-7">
                <div class="top-nav-holder">
                    <div class="navbar navbar-inverse">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="miller-navbar">
                            <ul class="nav navbar-nav">
                                <li class="<?php if ($active == "home") {
                                            echo 'current-menu-item';
                                        } ?>">
                                    <a href="<?php echo Url::toRoute('/'); ?>" title="Home">Home</a>
                                </li>
                                <li><a href="https://pool.8thwonderpromos.com/" title="Pool">Pool</a></li>
                                <li><a href="javascript:void(0);" title="Store">Store</a></li>
                                <li class="<?php if ($active == "djdrops") {
                                            echo 'current-menu-item';
                                        } ?>">
                                    <a href="<?php echo Url::toRoute('/djdrops'); ?>" title="DJ Drops">DJ Drops</a>
                                </li>
                                <li><a href="https://pool.8thwonderpromos.com/contact" title="Contact">Contact</a></li>
                                <?php if(!Yii::$app->user->isGuest): ?>
                                <li class="<?php if ($active == "cart") {
                                            echo 'current-menu-item';
                                        } ?>">
                                    <a href="<?php echo Url::toRoute('/cart'); ?>" title="Cart">Cart</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(Yii::$app->user->isGuest): ?>
            <div class="col-sm-3">
                <a href="https://www.8thwonderpromos.com/amember/signup" title="Join For Free" class="join-fr-free">Join For Free</a>               
                <a href="<?php echo Url::toRoute('/login'); ?>" title="Login" class="home_login">Login</a>
            </div>
            <?php else: ?>
            <div class="col-sm-3">
                <a href="<?php echo Url::toRoute('/logout'); ?>" title="Logout" class="home_login">Logout</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <a class="blk-wht-circle">
        <span class="black-hemi">
            <img src="<?php echo Url::toRoute('/images/black-hemisphere.png'); ?>" alt="">
        </span>
        <span class="white-hemi">
            <img src="<?php echo Url::toRoute('/images/white-hemisphere.png'); ?>" alt="">
        </span>
    </a>
</header>