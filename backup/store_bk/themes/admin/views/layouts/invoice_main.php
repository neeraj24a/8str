<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <?php
      $baseUrl = Yii::app()->theme->baseUrl; 
      $cs = Yii::app()->getClientScript();
      Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/dist/css/invoice.css">
  </head>
  <body>
  		<?php echo $content; ?> 
  </body>
</html>