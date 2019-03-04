<?php $baseUrl = Yii::app()->theme->baseUrl; ?>
<!-- start section -->
<section class="section light-backgorund">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <div class="navbar-vertical">
                    <ul class="nav nav-stacked">
                        <li class="header">
                            <h6 class="text-uppercase">Categories <i class="fa fa-navicon pull-right"></i></h6>
                        </li>
                        <?php foreach($categories as $c): ?>
                        <li><a href="<?php echo base_url().'/product-category?name='.$c->slug; ?>"><?php echo $c->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- end navbar-vertical -->
            </div><!-- end col -->
            <div class="col-sm-8 col-md-9">
                <div class="owl-carousel slider owl-theme">
                    <div class="item">
                        <figure>
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/slider/slider_10.jpg" alt=""/>
                            </a>
                        </figure>
                    </div><!-- end item -->
                    <div class="item">
                        <figure>
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/slider/slider_09.jpg" alt=""/>
                            </a>
                        </figure>
                    </div><!-- end item -->
                    <div class="item">
                        <figure>
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/slider/slider_08.jpg" alt=""/>
                            </a>
                        </figure>
                    </div><!-- end item -->
                </div><!-- end owl carousel -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- end section -->


<!-- start section -->
<section class="section white-background">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="title-wrap">
                    <h2 class="title"><span class="text-primary">Newest</span> Products</h2>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row column-4">
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <div class="badges">
                            <span class="product-badge top left primary-background text-white semi-circle">Sale</span>
                            <span class="product-badge top right text-warning">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </span>
                        </div>
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img class="front" src="<?php echo $baseUrl; ?>/img/products/men_01.jpg" alt="">
                                <img class="back" src="<?php echo $baseUrl; ?>/img/products/men_02.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <div class="badges">
                            <span class="product-badge top right danger-background text-white semi-circle">-20%</span>
                        </div>
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/women_01.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <div class="badges">
                            <span class="product-badge bottom left warning-background text-white semi-circle">Out of Stock</span>
                        </div>
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/bags_01.jpg" alt="">
                            </a>
                        </figure>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <div class="badges">
                            <span class="product-badge bottom right info-background text-white semi-circle">New</span>
                        </div>
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/fashion_01.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/hoseholds_05.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                        <ul class="countdown-product">
                            <li>
                                <span class="days">00</span>
                                <p>Days</p>
                            </li>
                            <li>
                                <span class="hours">00</span>
                                <p>Hours</p>
                            </li>
                            <li>
                                <span class="minutes">00</span>
                                <p>Mins</p>
                            </li>
                            <li>
                                <span class="seconds">00</span>
                                <p>Secs</p>
                            </li>
                        </ul><!-- end countdown -->
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/kids_01.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/shoes_01.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->

            <div class="col-sm-6 col-md-3">
                <div class="thumbnail store style1">
                    <div class="header">
                        <figure class="layer">
                            <a href="javascript:void(0);">
                                <img src="<?php echo $baseUrl; ?>/img/products/technology_02.jpg" alt="">
                            </a>
                        </figure>
                        <div class="icons">
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                            <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                        <div class="price">
                            <small class="amount off">$68.99</small>
                            <span class="amount text-primary">$59.99</span>
                        </div>
                        <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->
        </div><!-- end row -->

        <hr class="spacer-30 no-border"/>

        <div class="row">
            <div class="col-sm-6">
                <div class="box-banner-img">
                    <figure>
                        <a href="javascript:void(0);">
                            <img src="<?php echo $baseUrl; ?>/img/banners/banner_04.jpg" alt=""/>
                        </a>
                    </figure>
                </div><!-- end box-banner-img -->
            </div><!-- end col -->
            <div class="col-sm-6">
                <div class="box-banner-img">
                    <figure>
                        <a href="javascript:void(0);">
                            <img src="<?php echo $baseUrl; ?>/img/banners/banner_05.jpg" alt=""/>
                        </a>
                    </figure>
                </div><!-- end box-banner-img -->
            </div><!-- end col -->
        </div><!-- end row -->

        <hr class="spacer-30 no-border"/>

        <div class="row">
            <div class="col-sm-12">
                <div class="title-wrap">
                    <h2 class="title"><span class="text-primary">Popular</span> Products</h2>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row">
            <div class="col-sm-12">
                <div class="owl-carousel column-4 owl-theme">
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/men_01.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/technology_02.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <div class="badges">
                                    <span class="product-badge top left primary-background text-white semi-circle">Sale</span>
                                    <span class="product-badge top right text-warning">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                    </span>
                                </div>
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img class="front" src="<?php echo $baseUrl; ?>/img/products/men_03.jpg" alt="">
                                        <img class="back" src="<?php echo $baseUrl; ?>/img/products/men_04.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/shoes_01.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <div class="badges">
                                    <span class="product-badge top right danger-background text-white semi-circle">-20%</span>
                                </div>
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/women_03.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                </div><!-- end owl carousel -->
            </div><!-- end col -->
        </div><!-- end row -->
        <?php 
            foreach($categories as $c):
                if (!empty($c->product_list)):
        ?>
        <hr class="spacer-30 no-border"/>
        <div class="row">
            <div class="col-sm-12">
                <div class="title-wrap">
                    <h2 class="title"><span class="text-primary"><?php echo $c->name; ?></span> Products</h2>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row">
            <div class="col-sm-12">
                <div class="owl-carousel column-4 owl-theme">
                    <?php
                        foreach ($c->product_list as $product) {
                            ?>   
                            <div class="item">
                                <div class="thumbnail store style1">
                                    <div class="header">
                                        <figure class="layer">
                                            <a href="<?php echo  base_url().'/product?name='.$product->slug  ?>">
                                                <img src="<?php echo $baseUrl; ?>/img/products/men_01.jpg" alt="">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="caption">
                                        <h6 class="regular"><a href="<?php echo  base_url().'/product?name='.$product->slug  ?>"><?php echo $product->name; ?></a></h6>
                                        <div class="price">
                                            <!--<small class="amount off">$68.99</small>-->
                                            <span class="amount text-primary">$<?php echo $product->price; ?></span>
                                        </div>
                                        <a href="javascript:void(0);" class="add-to-cart" data-product="<?php echo $product->slug; ?>"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                                    </div><!-- end caption -->
                                </div><!-- end thumbnail -->
                            </div><!-- end item -->
                            <?php
                        }
                    ?>
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/technology_02.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <div class="badges">
                                    <span class="product-badge top left primary-background text-white semi-circle">Sale</span>
                                    <span class="product-badge top right text-warning">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                    </span>
                                </div>
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img class="front" src="<?php echo $baseUrl; ?>/img/products/men_03.jpg" alt="">
                                        <img class="back" src="<?php echo $baseUrl; ?>/img/products/men_04.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/shoes_01.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <div class="badges">
                                    <span class="product-badge top right danger-background text-white semi-circle">-20%</span>
                                </div>
                                <figure class="layer">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $baseUrl; ?>/img/products/women_03.jpg" alt="">
                                    </a>
                                </figure>
                                <div class="icons">
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);"><i class="fa fa-gift"></i></a>
                                    <a class="icon semi-circle" href="javascript:void(0);" data-toggle="modal" data-target=".productQuickView"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="shop-single-product-v1.html">Lorem Ipsum dolor sit</a></h6>
                                <div class="price">
                                    <small class="amount off">$68.99</small>
                                    <span class="amount text-primary">$59.99</span>
                                </div>
                                <a href="javascript:void(0);"><i class="fa fa-cart-plus mr-5"></i>Add to cart</a>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                </div><!-- end owl carousel -->
            </div><!-- end col -->
        </div><!-- end row -->
        <?php
                endif;
            endforeach; 
        ?>
    </div><!-- end container -->
</section>
<!-- end section -->