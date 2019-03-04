<?php

use yii\widgets\ListView;
use yii\helpers\Url;
$this->title = 'Shop';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="shopify-section">
    <div>
        <header class="collection-header">
            <div class="page-width">
                <div class="section-header text-center">
                    <h1>SHOP</h1>
                </div>
            </div>
            <div class="filters-toolbar-wrapper">
                <div class="page-width">
                    <div class="filters-toolbar">
                        <div class="filters-toolbar__item filters-toolbar__item--count">
                            <span class="filters-toolbar__product-count">Filters</span>
                        </div>
                        <div class="filters-toolbar__item text-right">
                            <label for="SortBy" class="label--hidden">Category</label>
                            <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort" style="width: 200px;">
                                <option value="all" selected="selected">All</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat->slug; ?>"><?php echo $cat->category; ?></option>
                                <?php endforeach; ?>
                                <option value="audio-drops">Audio Drops</option>
                                <option value="video-drops">Video Drops</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php foreach($products as $key => $val): ?>
        <div class="page-width">
            <?php if($key != 'audio-drops' && $key != 'video-drops' && sizeof($val) > 0): ?>
                <?php $category = ''; $cat_url = ''; ?>
                <div class="section-header text-center">
                    <?php foreach($categories as $cat): ?>
                        <?php if($cat->slug == $key): ?>
                            <h2>
                                <?php 
                                    $category = $cat->category; 
                                    $cat_url = Url::toRoute('/shop/category?name='.$cat->slug);
                                    echo $cat->category; 
                                ?>
                            </h2>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="grid grid--uniform grid--view-items">
                    <?php foreach($val as $product): ?>
                        <?php
                            $arr = explode("../", $product->main_image);
                            $img = \yii\helpers\Url::toRoute($arr[1]);
                        ?>
                    <div class="grid__item grid__item--featured-collections small--one-half medium-up--one-fifth">
                       <div class="grid-view-item">
                          <a class="grid-view-item__link grid-view-item__image-container" href="<?php echo Url::toRoute('/shop/detail?product='.$product->slug); ?>">
                             <div class="featured-collections grid-view-item__image-wrapper">
                                <div style="padding-top:100.0%;">
                                   <img
                                      class="featured-collections-img grid-view-item__image"
                                      src="<?php echo $img; ?>"
                                      data-src="<?php echo $img; ?>"
                                      data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                                      data-aspectratio="1.0"
                                      data-sizes="auto"
                                      alt="<?php echo $product->name; ?>">
                                </div>
                             </div>
                             <noscript>
                                <img class="grid-view-item__image" src="<?php echo $img; ?>" alt="<?php echo $product->name; ?>" style="max-width: 195.0px;">
                             </noscript>
                             <div class="h4 grid-view-item__title"><?php echo $product->name; ?></div>
                             <div class="grid-view-item__meta">
                                <!-- snippet/product-price.liquid -->
                                <span class="visually-hidden">Regular price</span>
                                <span class="product-price__price">$<?php echo $product->unit_price; ?></span>
                             </div>
                          </a>
                       </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center goto-link-wrapper padding-bottom border-bottom">
                  <a href="<?php echo $cat_url; ?>" class="btn btn--secondary btn--has-icon-before return-link">
                      Show All <?php echo $category; ?>
                  </a>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <div class="page-width">
            <div class="section-header text-center">
                <h2>AUDIO DROPS</h2>
            </div>
            <div class="grid grid--uniform grid--view-items">
                <?php foreach($products['audio-drops'] as $drop): ?>
                    <?php
                        if($drop->youtube != '' && $drop->type == 'video'){
                          $video_id = getUtubeId($drop->youtube);
                        }
                        if($drop->type == 'video'){
                          $img = 'https://img.youtube.com/vi/'.$video_id.'/hqdefault.jpg';
                        } else{
                          $img = Url::toRoute('/images/audio-drop.png');
                        }
                    ?>
                <div class="grid__item grid__item--featured-collections small--one-half medium-up--one-fifth">
                   <div class="grid-view-item">
                      <a class="grid-view-item__link grid-view-item__image-container" href="<?php echo Url::toRoute('/djdrops/details?drop='.$drop->slug); ?>">
                         <div class="featured-collections grid-view-item__image-wrapper">
                            <div style="padding-top:100.0%;">
                               <img
                                  class="featured-collections-img grid-view-item__image"
                                  src="<?php echo $img; ?>"
                                  data-src="<?php echo $img; ?>"
                                  data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                                  data-aspectratio="1.0"
                                  data-sizes="auto"
                                  alt="<?php echo $drop->title; ?>">
                            </div>
                         </div>
                         <noscript>
                            <img class="grid-view-item__image" src="<?php echo $img; ?>" alt="<?php echo $drop->title; ?>" style="max-width: 195.0px;">
                         </noscript>
                         <div class="h4 grid-view-item__title"><?php echo $drop->title; ?></div>
                         <div class="grid-view-item__meta">
                            <!-- snippet/product-price.liquid -->
                            <span class="visually-hidden">Regular price</span>
                            <span class="product-price__price">$<?php echo $drop->price; ?></span>
                         </div>
                      </a>
                   </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center goto-link-wrapper padding-bottom border-bottom">
              <a href="<?php echo Url::toRoute('/shop/category?name=audio-drops'); ?>" class="btn btn--secondary btn--has-icon-before return-link">
                  View All Audio Drops
              </a>
            </div>
        </div>
        <div class="page-width">
            <div class="section-header text-center">
                <h2>VIDEO DROPS</h2>
            </div>
            <div class="grid grid--uniform grid--view-items">
                <?php foreach($products['video-drops'] as $drop): ?>
                    <?php
                        if($drop->youtube != '' && $drop->type == 'video'){
                          $video_id = getUtubeId($drop->youtube);
                        }
                        if($drop->type == 'video'){
                          $img = 'https://img.youtube.com/vi/'.$video_id.'/hqdefault.jpg';
                        } else{
                          $img = Url::toRoute('/images/audio-drop.png');
                        }
                    ?>
                <div class="grid__item grid__item--featured-collections small--one-half medium-up--one-fifth">
                   <div class="grid-view-item">
                      <a class="grid-view-item__link grid-view-item__image-container" href="<?php echo Url::toRoute('/djdrops/details?drop='.$drop->slug); ?>">
                         <div class="featured-collections grid-view-item__image-wrapper">
                            <div style="padding-top:100.0%;">
                               <img
                                  class="featured-collections-img grid-view-item__image"
                                  src="<?php echo $img; ?>"
                                  data-src="<?php echo $img; ?>"
                                  data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                                  data-aspectratio="1.0"
                                  data-sizes="auto"
                                  alt="<?php echo $drop->title; ?>">
                            </div>
                         </div>
                         <noscript>
                            <img class="grid-view-item__image" src="<?php echo $img; ?>" alt="<?php echo $drop->title; ?>" style="max-width: 195.0px;">
                         </noscript>
                         <div class="h4 grid-view-item__title"><?php echo $drop->title; ?></div>
                         <div class="grid-view-item__meta">
                            <!-- snippet/product-price.liquid -->
                            <span class="visually-hidden">Regular price</span>
                            <span class="product-price__price">$<?php echo $drop->price; ?></span>
                         </div>
                      </a>
                   </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center goto-link-wrapper">
              <a href="<?php echo Url::toRoute('/shop/category?name=video-drops'); ?>" class="btn btn--secondary btn--has-icon-before return-link">
                  View All Video Drops
              </a>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("
	$(document).ready(function(){
		$('#SortBy').on('change', function(){
			if($(this).val() == 'all'){
				window.location.href = base_url+'shop';
			} else {
				window.location.href = base_url+'shop/category?name='+$(this).val();
			}
		});
	});
");
?>