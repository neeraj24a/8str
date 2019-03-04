<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/bootstrap.min.css',
        'css/responsive.css',
        'css/font-awesome.min.css',
        'css/style.css',
        'css/audioplayer.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'js/vendor/boostrap.tab.resposive.js',
        'js/vendor/jquery.flexslider.js',
        'js/vendor/xzoom.min.js',
        'js/vendor/jquery.hammer.min.js',
		'js/vendor/source/jquery.fancybox.js',
		'js/vendor/magnific-popup.js',
		'js/vendor/audioplayer.min.js',
        'js/main.js'
    ];
	//'https://www.paypalobjects.com/api/checkout.js',
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
