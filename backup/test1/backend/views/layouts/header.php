<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                    <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                </button>
            </div>
            <a class="navbar-brand" href="<?php echo Url::toRoute("/dashboard"); ?>" style="margin-top: -12px;">
                Dashboard
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo Url::toRoute("/dashboard"); ?>">
                        <i class="material-icons">dashboard</i>
                        <p>
                            <span class="d-lg-none d-md-block">Stats</span>
                        </p>
                        <div class="ripple-container"></div></a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" class="dropdown-toggle" id="userMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="hidden-lg hidden-md">Profile</p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuLink">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="<?php echo Url::toRoute("/logout"); ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>