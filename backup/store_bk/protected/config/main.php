<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once( dirname(__FILE__) . '/../components/helpers.php');
require(dirname(__FILE__) . '/global.php');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'remix',
    'theme' => 'ecom',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'defaultController' => 'home',
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin',
        'home',
    ),
    // application components
    'components' => array(
        'Smtpmail'=>array(
            'class'=>'application.extensions.smtpmail.PHPMailer',
            'Host'=>"smtp.gmail.com",
            'Username'=>'arommatech@gmail.com',
            'Password'=>'neeraj@priyranjan',
            'Mailer'=>'smtp',
            'Port'=>465,
            'SMTPAuth'=>true, 
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'faq' => 'home/default/faq',
                'products' => 'home/default/products',
                'product' => 'home/default/product',
                'product-category' =>'home/default/productCategory',
                'about-us' => 'home/default/about',
                'add-to-cart' => 'home/default/addToCart',
                'remove-from-cart' => 'home/default/removeFromCart',
                'cart' => 'home/default/cart',
                'shipping' => 'home/default/shipping',
                'review' => 'home/default/review',
                'checkout' => 'home/default/checkout',
                'confirmation' => 'home/default/confirmation',
                'declined' => 'home/default/declined',
                'your-orders' => 'home/default/orders',
                'order-detail' => 'home/default/orderDetail',
                'login' => 'home/default/login',
                'contact-us' => 'home/default/contact',
                '<module:(admin)>/<controller:\w+>/<action:\w+>/<id:(.*?)>' => '<module>/<controller>/<action>/<id>',
                '<module:(admin)>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:(admin)>/<controller:\w+>' => '<module>/<controller>',
                '<module:(gii)>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:(gii)>/<controller:\w+>' => '<module>/<controller>',
                '<module:\w+>/<action:\w+>/<id:(.*?)>' => '<module>/default/<action>/<id>',
                '<module:\w+>/<action:\w+>' => '<module>/default/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
     'params' => $global
);
