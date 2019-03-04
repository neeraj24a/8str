<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<title><?php bloginfo( 'name' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/boostrap.tab.resposive.js">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/resposive.css">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/black.css">
	<link rel="SHORTCUT ICON" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
</head>

<body <?php body_class(); ?>>
<div id="layout-wrapper">
	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-2">
					<a href="/" class="logo" title="8thWonder"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt=""></a>
				</div>
				<div class="col-sm-7">
					<div class="top-nav-holder">
						<div class="navbar navbar-inverse">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="collapse navbar-collapse" id="miller-navbar">
								<ul class="nav navbar-nav">
									<li class="current-menu-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Home">Home</a></li>
									<li><a href="https://pool.8thwonderpromos.com/" title="Pool">Pool</a></li>
									<li><a href="javascript:void(0);" title="Store">Store</a></li>
									<li><a href="https://pool.8thwonderpromos.com/contact" title="Contact">Contact</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<a href="https://www.8thwonderpromos.com/amember/signup" title="Join For Free" class="join-fr-free">Join For Free</a>				
					<a href="https://pool.8thwonderpromos.com/login" title="Login" class="home_login">Login</a>
				</div>
			</div>
		</div>
		<a class="blk-wht-circle">
			<span class="black-hemi"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/black-hemisphere.png" alt=""></span>
			<span class="white-hemi"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/white-hemisphere.png" alt=""></span>
		</a>
	</header>
