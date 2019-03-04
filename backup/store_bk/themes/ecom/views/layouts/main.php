<!DOCTYPE html>
<html lang="en">
    <head>
        <title>8thwonderpromos - Store</title>
        <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
        Yii::app()->clientScript->registerCoreScript('jquery');
        ?>
        <meta charset="utf-8">
        <meta name="description" content="8thwonderpromos - Store">
        <meta name="author" content="Diamant Gjota" />
        <meta name="keywords" content="dj, recordpool, records, vj, disc jockey, video jockey, audio drops, video drops" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--Favicon-->
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">
        <!-- css files -->
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/owl.carousel.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/owl.theme.default.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/animate.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/swiper.css" />

        <!-- this is default skin you can replace that with: dark.css, yellow.css, red.css ect -->
        <link id="pagestyle" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/default.css" />

        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800&amp;subset=latin-ext" rel="stylesheet">

    </head>
    <body>
        <?php require_once('header.php'); ?>
        <?php echo $content; ?>
        <?php require_once('footer.php'); ?>
        <script>
            var themePath = "<?php echo $baseUrl; ?>";
            var base_url = "<?php echo base_url(); ?>";
            var cart_size = <?php echo $cart_size; ?>;
        </script>
        <!-- JavaScript Files -->
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/jquery.downCount.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/nouislider.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/jquery.sticky.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/star-rating.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/wow.min.js"></script>
        <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>-->
        <!--<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/gmaps.js"></script>-->
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/swiper.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/main.js"></script>
    </body>