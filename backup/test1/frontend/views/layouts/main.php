<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>" class="no-js">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
        <link rel="SHORTCUT ICON" href="<?php echo base_url(); ?>/images/logo.png">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta charset="UTF-8">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        <![endif]-->
        <script>
            var base_url = <?php echo Url::toRoute('/'); ?>
        </script>
    </head>
    <body class="home page-template-default page page-id-10">
        <?php $this->beginBody() ?>
        <div id="layout-wrapper">
            <?php require_once 'header.php'; ?>
            <?= $content ?>
            <?php require_once 'footer.php'; ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>