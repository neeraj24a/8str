<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Cart";
?>
<?php $active = Yii::$app->controller->id; ?>
<div id="shopify-section-header" class="shopify-section">
    <div data-section-id="header" data-section-type="header-section">
       <nav class="mobile-nav-wrapper medium-up--hide" role="navigation">
          <ul id="MobileNav" class="mobile-nav">
             <li class="mobile-nav__item border-bottom">
                <a href="<?php echo Url::toRoute('/'); ?>" class="mobile-nav__link">
                HOME
                </a>
             </li>
             <li class="mobile-nav__item border-bottom">
                <a href="https://pool.8thwonderpromos.com" class="mobile-nav__link">
                POOL
                </a>
             </li>
             <li class="mobile-nav__item border-bottom">
                <a href="<?php echo Url::toRoute('/shop'); ?>" class="mobile-nav__link">
                SHOP
                </a>
             </li>
             <li class="mobile-nav__item border-bottom">
                <a href="https://pool.8thwonderpromos.com/contact" class="mobile-nav__link">
                CONTACT US
                </a>
             </li>
             <?php if(Yii::$app->user->isGuest): ?>
			 <li class="mobile-nav__item border-bottom">
                <a href="https://www.8thwonderpromos.com/amember/signup" class="mobile-nav__link">
                SIGN UP
                </a>
             </li>
			 <?php else: ?>
			 <li class="mobile-nav__item border-bottom">
                <a href="<?php echo Url::toRoute('/orders'); ?>" class="mobile-nav__link">
                MY ORDERS
                </a>
             </li>
             <?php endif; ?>
          </ul>
       </nav>
       <header class="site-header logo--center border-bottom" role="banner">
          <div class="grid grid--no-gutters grid--table">
             <div class="grid__item small--one-half medium-up--one-quarter logo-align--center">
                <h1 class="h2 site-header__logo" itemscope itemtype="http://schema.org/Organization">
                   <a href="<?php echo Url::toRoute('/'); ?>" itemprop="url" class="site-header__logo-image site-header__logo-image--centered">
                      <img class=""
                         src="<?php echo Url::toRoute('/images/logo.png'); ?>"
                         data-src="<?php echo Url::toRoute('/images/logo.png'); ?>"
                         data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                         data-aspectratio="6.435185185185185"
                         data-sizes="auto"
                         alt="8thwonderpromos"
                         style="max-width: 100px">
                      <noscript>
                         <img src="<?php echo Url::toRoute('/images/logo.png'); ?>"
                            srcset="<?php echo Url::toRoute('/images/logo.png'); ?> 1x, <?php echo Url::toRoute('/images/logo.png'); ?> 2x"
                            alt="8thwonderpromos"
                            itemprop="logo"
                            style="max-width: 400px;">
                      </noscript>
                   </a>
                </h1>
             </div>
             <div class="grid__item small--one-half medium-up--two-quarter text-right site-header__icons site-header__icons--plus">
                <nav class="small--hide" id="AccessibleNav" role="navigation">
                      <ul class="site-nav list--inline site-nav--centered" id="SiteNav">
                         <li class="site-nav--active">
                            <a href="<?php echo Url::toRoute('/'); ?>" class="site-nav__link site-nav__link--main">
                                HOME
                            </a>
                         </li>
                         <li>
                            <a href="https://pool.8thwonderpromos.com" class="site-nav__link site-nav__link--main">
                                POOL
                            </a>
                         </li>
                         <li >
                            <a href="<?php echo Url::toRoute('/shop'); ?>" class="site-nav__link site-nav__link--main">SHOP</a>
                         </li>
                         <li >
                            <a href="https://pool.8thwonderpromos.com/contact" class="site-nav__link site-nav__link--main">CONTACT US</a>
                         </li>
						 <?php if(Yii::$app->user->isGuest): ?>
						 <li>
							 <a href="https://www.8thwonderpromos.com/amember/signup" class="site-nav__link site-nav__link--main">SIGN UP</a>
						 </li>
						 <?php endif; ?>
                      </ul>
                </nav>
            </div>
             <div class="grid__item small--one-half medium-up--one-quarter text-right site-header__icons site-header__icons--plus">
                <div class="site-header__icons-wrapper">
                    <?php if(Yii::$app->user->isGuest): ?>
                    <a href="<?php echo Url::toRoute('/login'); ?>" class="site-header__account">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-login" viewBox="0 0 28.33 37.68">
                            <path d="M14.17 14.9a7.45 7.45 0 1 0-7.5-7.45 7.46 7.46 0 0 0 7.5 7.45zm0-10.91a3.45 3.45 0 1 1-3.5 3.46A3.46 3.46 0 0 1 14.17 4zM14.17 16.47A14.18 14.18 0 0 0 0 30.68c0 1.41.66 4 5.11 5.66a27.17 27.17 0 0 0 9.06 1.34c6.54 0 14.17-1.84 14.17-7a14.18 14.18 0 0 0-14.17-14.21zm0 17.21c-6.3 0-10.17-1.77-10.17-3a10.17 10.17 0 1 1 20.33 0c.01 1.23-3.86 3-10.16 3z"/>
                        </svg>
                        <span class="icon__fallback-text">Log in</span>
                    </a>
                    <?php else: ?>
					<ul class="nav navbar-nav">
						<li class="dropdown">
						  <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?= \Yii::$app->user->identity->username ?> <span class="glyphicon glyphicon-user pull-right"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="<?php echo Url::toRoute('/orders'); ?>">My Orders <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
							<li class="divider"></li>
							<li><a href="/amember/member">Go To Profile <span class="glyphicon glyphicon-stats pull-right"></span></a></li>
							<li class="divider"></li>
							<li><a href="<?php echo Url::toRoute('/logout'); ?>">Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
						  </ul>
						</li>
					</ul>
                    <!--<a href="<?php echo Url::toRoute('/logout'); ?>" class="site-header__account">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-logout" viewBox="0 0 28.33 37.68">
                            <path d="M14.17 14.9a7.45 7.45 0 1 0-7.5-7.45 7.46 7.46 0 0 0 7.5 7.45zm0-10.91a3.45 3.45 0 1 1-3.5 3.46A3.46 3.46 0 0 1 14.17 4zM14.17 16.47A14.18 14.18 0 0 0 0 30.68c0 1.41.66 4 5.11 5.66a27.17 27.17 0 0 0 9.06 1.34c6.54 0 14.17-1.84 14.17-7a14.18 14.18 0 0 0-14.17-14.21zm0 17.21c-6.3 0-10.17-1.77-10.17-3a10.17 10.17 0 1 1 20.33 0c.01 1.23-3.86 3-10.16 3z"/>
                        </svg>
                        <span class="icon__fallback-text">Log out</span>
                    </a>-->
                    <?php endif; ?>
                   <a href="<?php echo Url::toRoute('/cart'); ?>" class="site-header__cart">
                      <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-cart" viewBox="0 0 37 40">
                         <path d="M36.5 34.8L33.3 8h-5.9C26.7 3.9 23 .8 18.5.8S10.3 3.9 9.6 8H3.7L.5 34.8c-.2 1.5.4 2.4.9 3 .5.5 1.4 1.2 3.1 1.2h28c1.3 0 2.4-.4 3.1-1.3.7-.7 1-1.8.9-2.9zm-18-30c2.2 0 4.1 1.4 4.7 3.2h-9.5c.7-1.9 2.6-3.2 4.8-3.2zM4.5 35l2.8-23h2.2v3c0 1.1.9 2 2 2s2-.9 2-2v-3h10v3c0 1.1.9 2 2 2s2-.9 2-2v-3h2.2l2.8 23h-28z"/>
                      </svg>
                      <span class="visually-hidden">Cart</span>
                      <span class="icon__fallback-text">Cart</span>
                      <div id="" class="site-header__cart-count">
                        <span id="CartCount">0</span>
                        <span class="icon__fallback-text medium-up--hide">items</span>
                      </div>
                   </a>
                   <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                      <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-hamburger" viewBox="0 0 37 40">
                         <path d="M33.5 25h-30c-1.1 0-2-.9-2-2s.9-2 2-2h30c1.1 0 2 .9 2 2s-.9 2-2 2zm0-11.5h-30c-1.1 0-2-.9-2-2s.9-2 2-2h30c1.1 0 2 .9 2 2s-.9 2-2 2zm0 23h-30c-1.1 0-2-.9-2-2s.9-2 2-2h30c1.1 0 2 .9 2 2s-.9 2-2 2z"/>
                      </svg>
                      <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 37 40">
                         <path d="M21.3 23l11-11c.8-.8.8-2 0-2.8-.8-.8-2-.8-2.8 0l-11 11-11-11c-.8-.8-2-.8-2.8 0-.8.8-.8 2 0 2.8l11 11-11 11c-.8.8-.8 2 0 2.8.4.4.9.6 1.4.6s1-.2 1.4-.6l11-11 11 11c.4.4.9.6 1.4.6s1-.2 1.4-.6c.8-.8.8-2 0-2.8l-11-11z"/>
                      </svg>
                      <span class="icon__fallback-text">expand/collapse</span>
                   </button>
                </div>
             </div>
          </div>
       </header>
    </div>
</div>
