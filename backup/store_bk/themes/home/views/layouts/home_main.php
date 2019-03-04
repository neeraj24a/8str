<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome to Naturation Biopharma.</title>

        <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
        Yii::app()->clientScript->registerCoreScript('jquery');
        ?>


        <link href="<?php echo $baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>/css/animate.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css">
        <script  type="text/javascript" src="<?php echo $baseUrl; ?>/js/sliderunit.js"></script>
    </head>
    <body>
        <div class="maincontainer">
            <!-- HEADER AREA START -->
            <?php require_once('header.php'); ?>
            <!-- // HEADER AREA END // -->
            <?php echo $content; ?>
            <!-- // FOOTER AREA START  // -->
            <?php require_once('footer.php'); ?>
            <!-- // FOOTER AREA END  // -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <script src="<?php echo $baseUrl; ?>/js/bootstrap.min.js"></script>
            <script type="text/javascript">jssor_1_slider_init();</script>
    </body>
</html>
