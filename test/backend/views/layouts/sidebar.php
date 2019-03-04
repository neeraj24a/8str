<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $active = Yii::$app->controller->id; ?>
<div class="sidebar" data-color="rose" data-background-color="black" data-image="../admin/img/sidebar-1.jpg">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->

    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            S
        </a>

        <a href="#" class="simple-text logo-normal">
            Dashboard
        </a>

    </div>

    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="../admin/img/faces/avatar.jpg" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span>
                        <?php echo Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name; ?>
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> Edit Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo Url::toRoute("/logout"); ?>">
                                <span class="sidebar-mini"> S </span>
                                <span class="sidebar-normal"> Logout </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item <?php if ($active == "dashboard") {
                            echo 'active';
                        } ?> ">
                <a class="nav-link" href="<?php echo Url::toRoute("/dashboard"); ?>">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>
            <li class="nav-item  <?php if ($active == "users") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/users"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Users</span>
                </a>
            </li>
            <li class="nav-item  <?php if ($active == "category") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/category"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Categories</span>
                </a>
            </li>
            <li class="nav-item  <?php if ($active == "product") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/products"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Products</span>
                </a>
            </li>
			<li class="nav-item  <?php if ($active == "product") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/printful-products"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Printful Products</span>
                </a>
            </li>
			<li class="nav-item  <?php if ($active == "product") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/printful-product-details"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Printful Product Details</span>
                </a>
            </li>
            <li class="nav-item  <?php if ($active == "drop") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/drop"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Drops</span>
                </a>
            </li>
            <li class="nav-item  <?php if ($active == "banners") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/banners"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Banners</span>
                </a>
            </li>
            <li class="nav-item  <?php if ($active == "orders") {
                            echo 'active';
                        } ?>">
                <a class="nav-link" href="<?php echo Url::toRoute("/orders"); ?>" title="Users">
                    <i class="material-icons">person</i>
                    <span data-localize="sidebar.nav.element.ELEMENTS">Orders</span>
                </a>
            </li>
        </ul>
    </div>
</div>