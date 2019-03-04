<?php
$baseUrl = Yii::app()->theme->baseUrl;
?> 
<div class="clearfix"></div>
<!-- // BANNER AREA START // -->
<div id="jssor_1" style="position: relative; margin: 0 auto; top: 0; left: 0px; width: 960px; height: 300px; overflow: hidden; visibility: hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        <div style="position:absolute;display:block;background: url(<?php echo $baseUrl; ?>/img/loading.gif) no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
    </div>
    <?php
    if (!empty($banner_list)) {
        ?>     
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 960px; height: 300px; overflow: hidden;">
            <!--<?php
            ?>     
            <?php
            foreach ($banner_list as $banner) {
                $link = "#";
                if (!empty($banner->link)) {
                    $link = $banner->link;
                }
                ?>   
                <div> <a  href="<?php echo $link; ?>"><img data-u="image" src="<?php echo base_url(); ?>/images/banners/<?php echo $banner->banner; ?>" /></a> </div>
                <?php
            }
            ?>-->
			<div> 
				<a  href="<?php echo base_url(); ?>">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/banner1.jpg" />
				</a> 
			</div>
			<div> 
				<a  href="<?php echo base_url(); ?>/product?name=asthi-divya-orthopedic-oil">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/asthi-banner.png" width="960" height="300" />
				</a> 
			</div>
			<div> 
				<a  href="<?php echo base_url(); ?>/product?name=nature-balm">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/balm-banner.png" width="960" height="300" />
				</a> 
			</div>
			<div> 
				<a  href="<?php echo base_url(); ?>/product?name=yoyo-condoms">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/condom-banner.png" width="960" height="300" />
				</a> 
			</div>
			<div> 
				<a  href="<?php echo base_url(); ?>/product?name=naturaxion-musli-gold-capsules">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/musli-banner.png" width="960" height="300" />
				</a> 
			</div>
			<div> 
				<a  href="<?php echo base_url(); ?>/product?name=nari-nyari-syrup">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/nari-banner.png" width="960" height="300" />
				</a> 
			</div>
			<div> 
				<a  href="<?php echo base_url(); ?>/product?name=pre-prega">
					<img data-u="image" src="<?php echo base_url(); ?>/images/banners/prega-banner.png" width="960" height="300" />
				</a> 
			</div>
        </div>
        <?php
    }
    ?>
    <div data-u="navigator" class="jssorb13" style="bottom:16px;right:16px;" data-autocenter="1">
        <div data-u="prototype" style="width:21px;height:21px;"></div>
    </div>
</div>
<!-- // BANNER AREA END // -->
<!-- // ABOUTUS CONT AREA START // -->
<div class="aboutus_area">
    <div class="container">
        <div class="row">
            <div class="about_inner animatedParent">        
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="box_left">
                            <h1>ABOUT US</h1>
                            <p class="animated bounceInRight go"><?php echo $about->description; ?></p>
                            <div class="box_right animated bounceInLeft go"><img src="<?php echo $baseUrl; ?>/img/logo.png" alt=""></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box_right2">
                            <h1>OUR VISION</h1>
                            <p class="animated bounceInRight go"><?php echo $vision->description; ?></p>            
                        </div>
                        <div class="box_right3">
                            <h1>OUR MISSION</h1>
                            <p class="animated bounceInRight go"><?php echo $mission->description; ?></p>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // ABOUTUS AREA END // -->
<div class="clearfix"></div>
<!-- // PRODUCTS CONT AREA START // -->
<div class="product_area no-bg">
    <div class="container">
        <div class="row">
            <?php
            foreach ($category_list as $category) {
                if (!empty($category->product_list)) {
                    ?>
                    <div class="product_inner">
                        <h2><?php echo $category->name; ?></h2> 
                        <div class="col-md-12"> 
                            <?php
                            foreach ($category->product_list as $product) {
                                ?>   
                                <div class="col-md-3">
                                    <div class="box_pro" style="height: 350px;">
                                        <div class="price_tag">&#8377;<?php echo $product->price; ?></div>
                                        <div><a href="<?php echo  base_url().'/product?name='.$product->slug  ?>"><img height="156px" width="222px" src="<?php echo base_url(); ?>/images/products/<?php echo (!empty($product->product_main_image[0]->image)) ? $product->product_main_image[0]->image : ''; ?>" alt=""></a></div>
                                        <h1><?php echo $product->name; ?></h1>
                                        <p><?php echo $product->short_desc; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- // PRODUCTS AREA END // -->
<div class="clearfix"></div>
<!-- // CLINIC CONT AREA START // -->
<!--<div class="clinic_area">
    <div class="clinic_inner animatedParent">
        <div class="container">
            <div class="row">
                <h1>CLINIC</h1>
                <div class="col-md-12">
                    <div class="box_left">
                        <p class="animated bounceInRight go">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam nec lobortis ex, vel luctus ligula. Vivamus molestie velit ut urna facilisis gravida. Aliquam erat volutpat. Maecenas sed hendrerit enim. Praesent eu dignissim augue. Integer odio lectus, sodales sit amet scelerisque a, condimentum at magna. Fusce laoreet tellus ut volutpat molestie. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam nec lobortis ex, vel luctus ligula. Vivamus molestie velit ut urna facilisis gravida. Aliquam erat volutpat. Maecenas sed hendrerit enim. Praesent eu dignissim augue. Integer odio lectus, sodales sit amet scelerisque a, condimentum at magna. Fusce laoreet tellus ut volutpat molestie. </p>
                    </div>
                    <div class="box_right animated bounceInLeft go"><img src="<?php echo $baseUrl; ?>/img/img4.jpg" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // CLINIC AREA END // -->
<!--<div class="clearfix"></div>
<!-- // CONSUMER CONT AREA START // -->
<!--<div class="consumer_area">
    <div class="container">
        <div class="row">
            <div class="consumer_inner animatedParent">        
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="box_right2">
                            <h1>Consumer Experience</h1>
                            <p class="animated bounceInRight go">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam nec lobortis ex, vel luctus ligula. Vivamus molestie velit ut urna facilisis gravida. Aliquam erat volutpat. Maecenas sed hendrerit enim. Praesent eu dignissim augue. Integer odio lectus, sodales sit amet scelerisque a, condimentum at magna. Fusce laoreet tellus ut volutpat molestie.</p>           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box_right3">
                            <a href="joinus.html">JOIN US</a>            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // CONSUMER AREA END // -->
<div class="clearfix"></div>