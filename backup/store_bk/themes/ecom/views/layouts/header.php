<!-- start topBar -->
<?php $categories = Category::model()->findAll(array("condition" => "status ='1' AND deleted='0'")); ?>
<div class="topBar">
    <div class="container">
        <ul class="list-inline pull-left hidden-sm hidden-xs">
            <li><span class="text-primary">Have a question?</span> Call +123 4567 8910</li>
        </ul>

        <ul class="topBarNav pull-right">
            <li class="linkdown">
                <a href="javascript:void(0);">
                    <i class="fa fa-user mr-5"></i>
                    <span class="hidden-xs">
                        My Account 
                        <i class="fa fa-angle-down ml-5"></i>
                    </span>
                </a>
                <ul class="w-150">
                    <?php if(!Yii::app()->user->id): ?>
                    <li><a href="<?php echo base_url(); ?>/login">Login</a></li>
                    <li><a href="http://localhost/amember/signup">Create Account</a></li>
                    <?php else : ?>
                    <li><a href="<?php echo base_url(); ?>/orders">Your Orders</a></li>
                    <li><a href="http://localhost/amember/member" target="_blank">Profile</a></li>
                    <li class="divider"></li>
                    <?php endif; ?>
                    <li><a href="<?php echo base_url(); ?>/cart">My Cart</a></li>
                    <li><a href="<?php echo base_url(); ?>/checkout">Checkout</a></li>
                </ul>
            </li>
            <li class="linkdown">
                <a href="javascript:void(0);">
                    <i class="fa fa-shopping-basket mr-5"></i>
                    <span class="hidden-xs">
                        <?php 
                            $cart_size = 0;
                            if(isset(Yii::app()->session['cart'])){
                                $cart_size = sizeof(Yii::app()->session['cart']);
                            } 
                        ?>
                        
                        
                        Cart<sup class="text-primary" id="cart_count">(<?php echo $cart_size; ?>)</sup>
                        <i class="fa fa-angle-down ml-5"></i>
                    </span>    
                </a>
                <ul class="cart w-250">
                    <li>
                        <div class="cart-items">
                            <ol class="items" id="cart-items">
                                <?php 
                                    if(isset(Yii::app()->session['cart']) && sizeof(Yii::app()->session['cart']) > 0): ?>
                                    <?php foreach(Yii::app()->session['cart'] as $item): ?>
                                        <li id="<?php echo $item['product']->slug; ?>"> 
                                            <a href="<?php echo  base_url().'/product?name='.$item['product']->slug  ?>" class="product-image">
                                                <img src="<?php echo base_url(); ?>/images/products/<?php echo (!empty($item['product']->product_main_image[0]->image)) ? $item['product']->product_main_image[0]->image : ''; ?>" alt="<?php echo $item['product']->name; ?>">
                                            </a>
                                            <div class="product-details">
                                                <div class="close-icon"> 
                                                    <a href="javascript:void(0);" class="remove-from-cart" data-cart="false" data-product="<?php echo $item['product']->slug; ?>"><i class="fa fa-close"></i></a>
                                                </div>
                                                <p class="product-name"> 
                                                    <a href="shop-single-product-v1.html"><?php echo $item['product']->name; ?></a> 
                                                </p>
                                                <strong><?php echo $item['quantity']; ?></strong> x <span class="price text-primary">$<?php echo $item['product']->price; ?></span>
                                            </div><!-- end product-details -->
                                        </li><!-- end item -->
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="cart-empty">Your Cart Is Empty!</li>
                                <?php endif; ?>
                            </ol>
                        </div>
                    </li>
                    <li id="cart-option" <?php if($cart_size == 0){ echo 'style="display:none;"'; }?>>
                        <div class="cart-footer">
                            <a href="cart.html" class="pull-left"><i class="fa fa-cart-plus mr-5"></i>View Cart</a>
                            <a href="checkout.html" class="pull-right"><i class="fa fa-shopping-basket mr-5"></i>Checkout</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div><!-- end container -->
</div>
<!-- end topBar -->
<div class="middleBar">
    <div class="container">
        <div class="row display-table">
            <div class="col-sm-3 vertical-align text-left hidden-xs">
                <a href="javascript:void(0);">
                    <img width="160" src="<?php echo $baseUrl; ?>/img/logo-big.png" alt="" />
                </a>
            </div><!-- end col -->
            <div class="col-sm-9 vertical-align text-center">
                <form>
                    <div class="row grid-space-1">
                        <div class="col-sm-6">
                            <input type="text" name="keyword" class="form-control input-lg" placeholder="Search">
                        </div><!-- end col -->
                        <div class="col-sm-3">
                            <select class="form-control input-lg" name="category">
                                <option value="all">All Categories</option>
                                <?php foreach($categories as $c): ?>
                                <option value="kids"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div><!-- end col -->
                        <div class="col-sm-3">
                            <input type="submit"  class="btn btn-default btn-block btn-lg" value="Search">
                        </div><!-- end col -->
                    </div><!-- end row -->
                </form>
            </div><!-- end col -->
        </div><!-- end  row -->
    </div><!-- end container -->
</div><!-- end middleBar -->

<!-- start navbar -->
<div class="navbar yamm navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar-collapse-3" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="javascript:void(0);" class="navbar-brand visible-xs">
                <img src="<?php echo $baseUrl; ?>/img/logo.png" alt="logo">
            </a>
        </div>
        <div id="navbar-collapse-3" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- Home -->
                <li class="dropdown active"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Home<i class="fa fa-angle-down ml-5"></i></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="home-v1.html">Home - Version 1</a></li>
                        <li><a href="home-v2.html">Home - Version 2</a></li>
                        <li><a href="home-v3.html">Home - Version 3</a></li>
                        <li><a href="home-v4.html">Home - Version 4 <span class="label primary-background">1.1</span></a></li>
                        <li class="active"><a href="home-v5.html">Home - Version 5 <span class="label primary-background">1.1</span></a></li>
                        <li><a href="home-v6.html">Home - Version 6 <span class="label primary-background">1.2</span></a></li>
                        <li><a href="home-v7.html">Home - Version 7 <span class="label primary-background">1.3</span></a></li>
                    </ul><!-- end ul dropdown-menu -->
                </li><!-- end li dropdown -->    
                <!-- Features -->
                <li class="dropdown left"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Features<i class="fa fa-angle-down ml-5"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="headers.html">Headers</a></li>
                        <li><a href="footers.html">Footers</a></li>
                        <li><a href="sliders.html">Sliders</a></li>
                        <li><a href="typography.html">Typography</a></li>
                        <li><a href="grid.html">Grid</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Dropdown Level 1</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Dropdown Level</a></li>
                                <li class="dropdown-submenu"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Dropdown Level 2</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);">Dropdown Level</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- end ul dropdown-menu -->
                </li><!-- end li dropdown -->
                <!-- Pages -->
                <li class="dropdown yamm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Pages<i class="fa fa-angle-down ml-5"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- Content container to add padding -->
                            <div class="yamm-content">
                                <div class="row">
                                    <ul class="col-sm-3">
                                        <li class="title">
                                            <h6>Shop Pages</h6>
                                        </li>
                                        <li><a href="shop-sidebar-left.html">Sidebar Left</a></li>
                                        <li><a href="shop-sidebar-right.html">Sidebar Right</a></li>
                                        <li><a href="shop-filter-top.html">Filters Top</a></li>
                                        <li><a href="shop-full-width-sidebar-left.html">Full Width Sidebar Left</a></li>
                                        <li><a href="shop-full-width-sidebar-right.html">Full Width Sidebar Right</a></li>
                                        <li><a href="shop-full-width-filter-top.html">Full Width Filters Top</a></li>
                                        <li><a href="category.html">Category <span class="label primary-background">1.1</span></a></li>
                                        <li><a href="shop-single-product-v1.html">Single product</a></li>
                                        <li><a href="shop-single-product-v2.html">Single product v2 <span class="label primary-background">1.3</span></a></li>
                                        <li class="title">
                                            <h6>Contact Pages</h6>
                                        </li>
                                        <li><a href="contact-v1.html">Contact Us Version 1</a></li>
                                        <li><a href="contact-v2.html">Contact Us Version 2</a></li>
                                    </ul><!-- end ul col -->
                                    <ul class="col-sm-3">
                                        <li class="title">
                                            <h6>About us Pages</h6>
                                        </li>
                                        <li><a href="about-us-v1.html">About Us Version 1</a></li>
                                        <li><a href="about-us-v2.html">About Us Version 2</a></li>
                                        <li><a href="about-us-v3.html">About Us Version 3</a></li>
                                        <li class="title">
                                            <h6>Blog Pages</h6>
                                        </li>
                                        <li><a href="blog-v1.html">Blog Version 1</a></li>
                                        <li><a href="blog-v2.html">Blog Version 2</a></li>
                                        <li><a href="blog-v3.html">Blog Version 3</a></li>
                                        <li><a href="blog-article-v1.html">Blog article</a></li>
                                    </ul><!-- end ul col -->
                                    <ul class="col-sm-3">
                                        <li class="title">
                                            <h6>User account</h6>
                                        </li>
                                        <li><a href="login.html">Login</a></li>
                                        <li><a href="register.html">Register</a></li>
                                        <li><a href="login-register.html">Login or Register</a></li>
                                        <li><a href="my-account.html">My Account</a></li>
                                        <li><a href="cart.html">Cart</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="user-information.html">User Information</a></li>
                                        <li><a href="order-list.html">Order List</a></li>
                                        <li><a href="order-confirmation.html">Order Confirmation <span class="label primary-background">1.1</span></a></li>
                                        <li><a href="forgot-password.html">Forgot Password</a></li>
                                    </ul><!-- end ul col -->
                                    <ul class="col-sm-3">
                                        <li class="title">
                                            <h6>Other Pages</h6>
                                        </li>
                                        <li><a href="help.html">Help</a></li>
                                        <li><a href="faq.html">Faq</a></li>
                                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                        <li><a href="blank-page.html">Blank Page <span class="label primary-background">1.1</span></a></li>
                                        <li><a href="404-error.html">404 Error</a></li>
                                        <li><a href="500-error.html">500 Error</a></li>
                                        <li><a href="coming-soon.html">Coming soon</a></li>
                                        <li><a href="subscribe.html">Subscribe</a></li>
                                    </ul><!-- end ul col -->
                                </div><!-- end row -->
                            </div><!-- end yamn-content -->
                        </li><!-- end li -->
                   </ul><!-- end ul dropdown-menu -->
                </li><!-- end li dropdown -->
                <!-- elements -->
                <li><a href="elements.html">Elements</a></li>
                <!-- Collections -->
                <li class="dropdown yamm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Collections<i class="fa fa-angle-down ml-5"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <a href="javascript:void(0);">
                                            <figure class="zoom-out">
                                                <img alt="" src="<?php echo $baseUrl; ?>/img/banners/collection_01.jpg">
                                            </figure>
                                        </a>
                                    </div><!-- end col -->
                                    <div class="col-xs-12 col-sm-3">
                                        <a href="javascript:void(0);">
                                            <figure class="zoom-in">
                                                <img alt="" src="<?php echo $baseUrl; ?>/img/banners/collection_02.jpg">
                                            </figure>
                                        </a>
                                    </div><!-- end col -->
                                    <div class="col-xs-12 col-sm-3">
                                        <a href="javascript:void(0);">
                                            <figure class="zoom-out">
                                                <img alt="" src="<?php echo $baseUrl; ?>/img/banners/collection_03.jpg">
                                            </figure>
                                        </a>
                                    </div><!-- end col -->
                                    <div class="col-xs-12 col-sm-3">
                                        <a href="javascript:void(0);">
                                            <figure class="zoom-in">
                                                <img alt="" src="<?php echo $baseUrl; ?>/img/banners/collection_04.jpg">
                                            </figure>
                                        </a>
                                    </div><!-- end col -->
                                </div><!-- end row -->

                                <hr class="spacer-20 no-border">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <h6>Pellentes que nec diam lectus</h6>
                                        <p>Proin pulvinar libero quis auctor pharet ra. Aenean fermentum met us orci, sedf eugiat augue pulvina r vitae. Nulla dolor nisl, molestie nec aliquam vitae, gravida sodals dolor...</p>
                                        <button type="button" class="btn btn-default round btn-md">Read more</button>
                                    </div><!-- end col -->
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="thumbnail store style1">
                                            <div class="header">
                                                <div class="badges">
                                                    <span class="product-badge top left white-backgorund text-primary semi-circle">Sale</span>
                                                    <span class="product-badge top right text-primary">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    </span>
                                                </div>
                                                <figure class="layer">
                                                    <img src="<?php echo $baseUrl; ?>/img/products/men_01.jpg" alt="">
                                                </figure>
                                                <div class="icons">
                                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <h6 class="thin"><a href="javascript:void(0);">Lorem Ipsum dolor sit</a></h6>
                                                <div class="price">
                                                    <small class="amount off">$68.99</small>
                                                    <span class="amount text-primary">$59.99</span>
                                                </div>
                                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                                            </div><!-- end caption -->
                                        </div><!-- end thumbnail -->
                                    </div><!-- end col -->
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="thumbnail store style1">
                                            <div class="header">
                                                <div class="badges">
                                                    <span class="product-badge top left white-backgorund text-primary semi-circle">Sale</span>
                                                    <span class="product-badge top right text-primary">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    </span>
                                                </div>
                                                <figure class="layer">
                                                    <img src="<?php echo $baseUrl; ?>/img/products/women_01.jpg" alt="">
                                                </figure>
                                                <div class="icons">
                                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <h6 class="thin"><a href="javascript:void(0);">Lorem Ipsum dolor sit</a></h6>
                                                <div class="price">
                                                    <small class="amount off">$68.99</small>
                                                    <span class="amount text-primary">$59.99</span>
                                                </div>
                                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                                            </div><!-- end caption -->
                                        </div><!-- end thumbnail -->
                                    </div><!-- end col -->
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="thumbnail store style1">
                                            <div class="header">
                                                <div class="badges">
                                                    <span class="product-badge top left white-backgorund text-primary semi-circle">Sale</span>
                                                    <span class="product-badge top right text-primary">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    </span>
                                                </div>
                                                <figure class="layer">
                                                    <img src="<?php echo $baseUrl; ?>/img/products/kids_01.jpg" alt="">
                                                </figure>
                                                <div class="icons">
                                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <h6 class="thin"><a href="javascript:void(0);">Lorem Ipsum dolor sit</a></h6>
                                                <div class="price">
                                                    <small class="amount off">$68.99</small>
                                                    <span class="amount text-primary">$59.99</span>
                                                </div>
                                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                                            </div><!-- end caption -->
                                        </div><!-- end thumbnail -->
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div><!-- end yamm-content -->
                        </li><!-- end li -->
                    </ul><!-- end dropdown-menu -->
                </li><!-- end dropdown -->
            </ul><!-- end navbar-nav -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown right">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <span class="hidden-sm">Categories</span><i class="fa fa-bars ml-5"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach($categories as $c): ?>
                            <li><a href="<?php echo base_url().'/product-category?name='.$c->slug; ?>"><?php echo $c->name;?></a></li>
                        <?php endforeach; ?>
                    </ul><!-- end ul dropdown-menu -->
                </li><!-- end dropdown -->
            </ul><!-- end navbar-right -->
        </div><!-- end navbar collapse -->
    </div><!-- end container -->
</div><!-- end navbar -->
