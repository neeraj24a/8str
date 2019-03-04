<?php
$baseUrl = Yii::app()->theme->baseUrl;
?> 
<div class="clearfix"></div>
<!-- // BANNER AREA START // -->
<div class="aboutus_area" style="background: none;">
    <div class="container">
        <div class="row">
            <div class="about_inner">
                <div class="col-md-12">
                    <h1 style="background:none;"><?php echo $product->name; ?></h1>
                    <?php
                    //pre($product->product_gallery_image,true);
                    ?>
                    <div class="bread_cum"> <a href="<?php echo base_url(); ?>/products">Products</a> > <a href="<?php echo base_url().'/product-category?name='.$category->slug; ?>"><?php echo $category->name; ?></a> > <a href="javascript:void(0);" class="active"><?php echo $product->name; ?></a> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // BANNER AREA END // -->
<div class="clearfix"></div>
<!-- // PRODUCTS CONT AREA START // -->
<div class="product_area <?php echo $category->slug; ?>">
    <div class="container bg">
        <div class="row">
            <div class="col-md-12">
                <div class="product_inner">          
                    <div class="row">
                        <div class="col-md-3">
							<div class="list-group categories">
								<span href="#" class="list-group-item active">
									Browse by Category
								</span>
								<a href="<?php echo base_url(); ?>/products" class="list-group-item">
									<i class="fa fa-folder"></i> All
								</a>
								<?php foreach($categories as $cat): ?>
								<a href="<?php echo base_url().'/product-category?name='.$cat->slug; ?>" class="list-group-item">
									<i class="fa fa-folder"></i> <?php echo $cat->name; ?>
								</a>
								<?php endforeach; ?>
							</div>	
                        </div>
                        <div class="col-md-9">
                            <!--<h1><?php echo $product->name; ?></h1>-->
                            <div class="product_details">
                                <div class="product_detailsL">
                                    <div class="product_detailsIN zoomin frame">
                                        <div><img src="<?php echo base_url(); ?>/images/products/<?php echo (!empty($product->product_main_image[0]->image)) ? $product->product_main_image[0]->image : ''; ?>" alt="" title=""></div>
                                    </div> 
                                    <?php
                                    if (!empty($product->product_gallery_image)) {
                                        ?>

                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                            <!-- Indicators -->
                                            <!-- Wrapper for slides -->
                                            <div class="carousel-inner">
                                                <div class="item active">
                                                    <?php  
                                                    foreach($product->product_gallery_image as $gallery_image)
                                                    {    
                                                    ?>
                                                    <div class="box_pro2">
                                                        <a href="#"><img src="<?php echo base_url().'/images/products/'.$gallery_image->image;  ?>" alt=""> </a> 
                                                    </div>
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <!-- Left and right controls -->
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <div class="product_detailsR">
                                    <h3>Item#:  <?php echo $product->sku; ?></h3>
                                    <p>Name - <?php echo $product->name; ?></p>
                                    <p>Category - <?php echo $category->name; ?></p>
                                    <!--<p><img src="<?php echo $baseUrl; ?>/img/share.png" alt=""></p>
                                    <span> <strong>Plant Size:</strong> 1-4 INCH POT </span>
                                    <p><strong>Quantity:</strong>
                                        <input name="" type="text">
                                        <span class="text">(Minimum: 1)</span></p>
                                    <p><strong>Shipping:</strong> <span>Lorem Ipsum is simply dummy text</span></p>-->
                                    <p class="total">TOTAL: &#8377;<?php echo $product->price; ?></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="des_container">
                            		
										<div id="product-info">	
											<ul  class="nav nav-pills">
												<li class="active">
        											<a  href="#desc" data-toggle="tab">Description</a>
												</li>
												<li>
													<a href="#add" data-toggle="tab">Additional Info</a>
												</li>
												<!--<li>
													<a href="#rev" data-toggle="tab">Review</a>
												</li>-->
  											</ul>

											<div class="tab-content clearfix">
			  									<div class="tab-pane active" id="desc">
          										<?php echo $product->description; ?>
												</div>
												<div class="tab-pane" id="add">
          										<h3>Comming Soon....!</h3>
												</div>
        										<div class="tab-pane" id="rev">
          										<div class="row">
                                        <div class="col-md-12">
                                            <div class="contact_field">
                                                <label class="col-md-3">Your Name: *</label>
                                                <input name="" type="text" placeholder="">
                                            </div>
                                            <div class="contact_field">
                                                <label class="col-md-3">Your Name: *</label>
                                                <input name="" type="text" placeholder="" class="contact_bg"></div>
                                            <div class="contact_field">
                                                <label class="col-md-3">Your Review *</label>
                                                <textarea name="" cols="" rows=""></textarea>
                                            </div>
                                            <div class="contact_field">
                                                <label class="col-md-3">Your Rating:</label>
                                                <a href="#"><img src="img/Star.png" alt=""></a>  <a href="#"><img src="img/Star.png" alt=""></a>  <a href="#"><img src="img/Star.png" alt=""></a>  <a href="#"><img src="img/Star.png" alt=""></a>  <a href="#"><img src="img/Star.png" alt=""></a>
                                            </div>
                                            <div class="contact_field">
                                                <label class="col-md-3"></label>
                                                <input name="" type="submit" value="SUBMIT">
                                                <input name="" type="button" value="RESET" class="btnbg">
                                            </div>

                                        </div>
                                    	</div>
												</div>
          									
											</div>
  										</div>                            		
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // PRODUCTS AREA END // -->
<div class="clearfix"></div>