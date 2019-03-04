<?php

use yii\widgets\ListView;
use yii\helpers\Url;
$this->title = $title;
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
                    <h1><?php echo $title; ?></h1>
                </div>
            </div>
            <div class="filters-toolbar-wrapper">
                <div class="page-width">
                    <div class="filters-toolbar">
                        <div class="filters-toolbar__item filters-toolbar__item--count">
                            <span class="filters-toolbar__product-count"><?php echo $total; ?> Items</span>
                        </div>
                        <div class="filters-toolbar__item text-right">
                            <label for="SortBy" class="label--hidden">Category</label>
                            <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort" style="width: 200px;">
                                <option value="all">All</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat->slug; ?>" <?php if($_GET['name'] == $cat->slug): ?> selected<?php endif; ?>><?php echo $cat->category; ?></option>
                                <?php endforeach; ?>
                                <option value="audio-drops"<?php if($_GET['name'] == 'audio-drops'): ?> selected<?php endif; ?>>Audio Drops</option>
                                <option value="video-drops"<?php if($_GET['name'] == 'video-drops'): ?> selected<?php endif; ?>>Video Drops</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-width">
          <div class="grid grid--uniform grid--view-items">
            <?php if(sizeof($products) > 0): ?>
              <?php foreach($products as $product): ?>
                  <?php
                      $arr = explode("../", $product->main_image);
                      $img = \yii\helpers\Url::toRoute($arr[1]);
                  ?>
              <div class="grid__item grid__item--collection-template small--one-half medium-up--one-quarter">
                <div class="grid-view-item">
                  <a href="<?php echo Url::toRoute('/shop/detail?product='.$product->slug); ?>" class="grid-view-item__link grid-view-item__image-container">
                    <div class="product-collection grid-view-item__image-wrapper">
                        <div style="padding-top:100.0%;">
                           <img
                              class="product-collection-img grid-view-item__image"
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
            <?php elseif(sizeof($drops) > 0): ?>
              <?php foreach($drops as $drop): ?>
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
                <div class="grid__item grid__item--featured-collections small--one-half medium-up--one-quarter">
                   <div class="grid-view-item">
                      <a class="grid-view-item__link grid-view-item__image-container" href="<?php echo Url::toRoute('/djdrops/details?drop='.$drop->slug); ?>">
                         <div class="product-collection grid-view-item__image-wrapper">
                            <div style="padding-top:100.0%;">
                               <img
                                  class="product-collection-img grid-view-item__image"
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
              <?php endif; ?>
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
        