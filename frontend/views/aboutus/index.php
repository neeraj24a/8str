<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = "About Us";
?>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>About Us</h1>
            </div>
            <div class="col-second">
                <p>Who we are.</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center flex-wrap justify-content-end">
                    <a href="<?php echo Url::toRoute('/'); ?>">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#">About Us</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container m-b-100">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="billing-title mt-20 mb-10">About Us</h3>
            <div class="row">
                <div class="col-lg-12">
                    This text coming soon.
                </div>
            </div>
        </div>
    </div>
</div>