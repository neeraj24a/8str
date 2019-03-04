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
<!doctype html>
<html lang="<?= Yii::$app->language ?>" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
        <link rel="SHORTCUT ICON" href="<?php echo base_url(); ?>/images/logo.png">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta charset="UTF-8">
        <title><?= Html::encode($this->title) ?></title>
        <meta property="og:site_name" content="8thwonderpromos">
        <meta property="og:url" content="index.html">
        <meta property="og:title" content="8thwonderpromos">
        <meta property="og:type" content="website">
        <meta property="og:description" content="8thwonderpromos">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="8thwonderpromos">
        <meta name="twitter:description" content="8thwonderpromos">
        <link href="//fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet" type="text/css" media="all" />
        <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        <![endif]-->
        <?php $active = Yii::$app->controller->action->id; ?>
        <?php if($active == 'checkout' || $active == 'payment'): ?>
        <link href="<?php echo Url::toRoute("/css/cart-style.css"); ?>" rel="stylesheet">
        <?php endif; ?>
        <script>
            var base_url = <?php echo Url::toRoute('/'); ?>
        </script>
    </head>
    <body class="template-index">
        <?php $this->beginBody() ?>
        <?php require_once 'header.php'; ?>
        <div class="page-container" id="PageContainer">
            <main class="main-content" id="MainContent" role="main">
                <?= $content ?>
            </main>
            <?php require_once 'footer.php'; ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
