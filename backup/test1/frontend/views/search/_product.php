<?php $cat = \backend\models\Category::findOne($model->category)->category; ?>
<div class="col-lg-3 col-md-4 col-sm-6 list <?php echo $cat; ?>" data-category="<?php echo $cat; ?>">
    <div class="single-organic-product">
        <?php
        $arr = explode("../", $model->main_image);
        $img = \yii\helpers\Url::toRoute($arr[1]);
        ?>
        <img src="<?php echo $img; ?>" alt="" class="img-fluid">
        <h3 class="price">$<?php echo $model->unit_price; ?></h3>
        <span class="text"><?php echo $model->name; ?></span>
        <div class="bottom d-flex align-items-center">
            <a href="javascript:void(0);" class="addToCart" data-slug="<?php echo $model->slug; ?>"><span class="lnr lnr-cart"></span></a>
            <a href="javascript:void(0);" class="productDetail" data-slug="<?php echo $model->slug; ?>" data-toggle="modal" data-target="#productModal"><span class="lnr lnr-frame-expand"></span></a>
        </div>
    </div>
</div>