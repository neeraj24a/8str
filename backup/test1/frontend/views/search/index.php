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

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
            <div class="col-first">
                <h1>Shop</h1>
            </div>
            <div class="col-second">
                <p>So you have your new digital camera and clicking away to glory anything and everything in sight.</p>
            </div>
            <div class="col-third">
                <nav class="d-flex align-items-center justify-content-end">
                    <a href="<?php echo Url::toRoute('/'); ?>">Home<i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="javascript:void(0);">Shop</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container m-b-100">
    <div class="organic-section-title text-center">
        <h3>Searched Products</h3>
    </div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all-product" role="tabpanel" aria-labelledby="all-tab">
            <div class="row grid">
                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_product',
                    'pager' => [
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'maxButtonCount' => 3,
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>