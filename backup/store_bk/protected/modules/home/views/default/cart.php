<?php $baseUrl = Yii::app()->theme->baseUrl; ?>
<!-- breadcrumb start -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li class="active">Cart</li>
                </ul><!-- end breadcrumb -->
            </div><!-- end col -->    
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- breadcrumb end -->
<!-- section start -->
<section class="section white-backgorund">
    <div class="container">
        <div class="row">
            <!-- start sidebar -->
            <div class="col-sm-3">
                <div class="widget">
                    <h6 class="subtitle">Account Navigation</h6>

                    <ul class="list list-unstyled">
                        <li>
                            <a href="my-account.html">My Account</a>
                        </li>
                        <li class="active">
                            <a href="cart.html">My Cart <span class="text-primary">(3)</span></a>
                        </li>
                        <li>
                            <a href="order-list.html">My Order</a>
                        </li>
                        <li>
                            <a href="wishlist.html">Wishlist <span class="text-primary">(5)</span></a>
                        </li>
                        <li>
                            <a href="user-information.html">Settings</a>
                        </li>
                    </ul>
                </div><!-- end widget -->

                <div class="widget">
                    <h6 class="subtitle">New Collection</h6>
                    <figure>
                        <a href="javascript:void(0);">
                            <img src="<?php echo $baseUrl; ?>/img/products/men_06.jpg" alt="collection">
                        </a>
                    </figure>
                </div><!-- end widget -->

                <div class="widget">
                    <h6 class="subtitle">Featured</h6>

                    <ul class="items">
                        <li> 
                            <a href="shop-single-product-v1.html" class="product-image">
                                <img src="<?php echo $baseUrl; ?>/img/products/men_01.jpg" alt="Sample Product ">
                            </a>
                            <div class="product-details">
                                <p class="product-name"> 
                                    <a href="shop-single-product-v1.html">Product name</a> 
                                </p>
                                <span class="price text-primary">$19.99</span>
                                <div class="rate text-warning">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </li><!-- end item -->
                        <li> 
                            <a href="shop-single-product-v1.html" class="product-image">
                                <img src="<?php echo $baseUrl; ?>/img/products/women_02.jpg" alt="Sample Product ">
                            </a>
                            <div class="product-details">
                                <p class="product-name"> 
                                    <a href="shop-single-product-v1.html">Product name</a> 
                                </p>
                                <span class="price text-primary">$19.99</span>
                                <div class="rate text-warning">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </li><!-- end item -->
                    </ul>

                    <hr class="spacer-10 no-border">
                    <a href="shop-sidebar-left.html" class="btn btn-default btn-block semi-circle btn-md">All Products</a>
                </div><!-- end widget -->
            </div><!-- end col -->
            <!-- end sidebar -->
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <h2 class="title">My Cart</h2>
                    </div><!-- end col -->
                </div><!-- end row -->

                <hr class="spacer-5"><hr class="spacer-20 no-border">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">    
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="2">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th colspan="2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset(Yii::app()->session['cart']) && sizeof(Yii::app()->session['cart']) > 0): ?>
                                        <?php foreach(Yii::app()->session['cart'] as $item): ?>
                                        <tr id="<?php echo $item['product']->slug; ?>">
                                            <td>
                                                <a href="<?php echo  base_url().'/product?name='.$item['product']->slug  ?>">
                                                    <img width="60px" src="<?php echo base_url(); ?>/images/products/<?php echo (!empty($item['product']->product_main_image[0]->image)) ? $item['product']->product_main_image[0]->image : ''; ?>" alt="<?php echo $item['product']->name; ?>">
                                                </a>
                                            </td>
                                            <td>
                                                <h6 class="regular"><a href="shop-single-product-v1.html"><?php echo $item['product']->name; ?></a></h6>
                                                <p></p>
                                            </td>
                                            <td>
                                                <span>$<?php echo $item['product']->price; ?></span>
                                            </td>
                                            <td>
                                                <select class="form-control update-cart" name="select" data-product="<?php echo $item['product']->slug; ?>">
                                                    <?php for($i = 1; $i<11;$i++): ?>
                                                    <option value="<?php echo $i; ?>"
                                                     <?php if($item['quantity'] == $i){echo 'selected="selected"';} ?>
                                                            ><?php echo $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <span class="text-primary">$<?php echo $item['product']->price; ?></span>
                                            </td>
                                            <td>
                                                <button type="button" class="close remove-from-cart" data-cart="true" data-product="<?php echo $item['product']->slug; ?>">×</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>Your Cart Is Empty!</tr>
                                    <?php endif; ?>
                                </tbody>
                            </table><!-- end table -->
                        </div><!-- end table-responsive -->

                        <hr class="spacer-10 no-border">

                        <a href="<?php echo base_url(); ?>/products" class="btn btn-light semi-circle btn-md pull-left">
                            <i class="fa fa-arrow-left mr-5"></i> Continue shopping
                        </a>

                        <a href="<?php echo base_url(); ?>/checkout" class="btn btn-default semi-circle btn-md pull-right">
                            Checkout <i class="fa fa-arrow-right ml-5"></i>
                        </a>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end col -->
        </div><!-- end row -->                
    </div><!-- end container -->
</section>
<!-- section end -->