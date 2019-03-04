<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Html::encode($this->title) ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="off-canvas-sidebar login-page">
        <?php $this->beginBody() ?>
        <nav class="navbar navbar-expand-lg bg-primary navbar-transparent navbar-absolute" color-on-scroll="500">
            <div class="container">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#">Login To Dashboard</a>
                </div>
            </div>
        </nav>
        <div class="wrapper wrapper-full-page">
            <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('img/login.jpg'); background-size: cover; background-position: top center;">
                <div class="container">
                    <?php echo $content; ?> 
                </div>
                <footer class="footer ">
                    <div class="container">
                        <div class="copyright pull-right">
                            © <script>document.write(new Date().getFullYear())</script><a href="#">CRM</a>.
                        </div>
                    </div>
                </footer>
            </div>
        </div><!-- ./wrapper -->
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>