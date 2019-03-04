<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons',
        'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'css/bootstrap.min.css',
        'css/material-dashboard.css',
    ];
    public $js = [
//        'js/core/jquery.min.js',
        'js/core/popper.min.js',
        'js/bootstrap-material-design.min.js',
        'js/plugins/moment.min.js',
        'js/plugins/bootstrap-datetimepicker.min.js',
        'js/plugins/nouislider.min.js',
        'js/plugins/bootstrap-selectpicker.js',
        'js/plugins/bootstrap-tagsinput.js',
        'js/plugins/jasny-bootstrap.min.js',
        'js/plugins/perfect-scrollbar.jquery.min.js',
        'js/plugins/modernizr.js',
        'js/plugins/modernizr.js',
        'js/material-dashboard.js',
        'https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js',
        'https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.js',
        'js/plugins/chartist.min.js',
        'js/plugins/jquery.bootstrap-wizard.js',
        'js/plugins/bootstrap-notify.js',
        'js/plugins/jquery-jvectormap.js',
        'js/plugins/nouislider.min.js',
        'js/plugins/jquery.select-bootstrap.js',
        'js/plugins/sweetalert2.js',
        'js/plugins/jasny-bootstrap.min.js',
        'js/plugins/jasny-bootstrap.min.js',
        'js/plugins/fullcalendar.min.js',
        'js/plugins/demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
    ];
}