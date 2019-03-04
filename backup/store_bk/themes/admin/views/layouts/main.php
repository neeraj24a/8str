<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <?php
      $baseUrl = Yii::app()->theme->baseUrl; 
      $cs = Yii::app()->getClientScript();
      Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
	<link rel="stylesheet" href="<?php echo $baseUrl;?>/plugins/bootstrap-datepicker/bootstrap-datepicker3.css">
    <link rel="stylesheet" href="<?php echo $baseUrl;?>/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $baseUrl;?>/dist/css/skins/_all-skins.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo $baseUrl;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url().'/admin'; ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Admin</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo $baseUrl;?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo Yii::app()->session['first_name'].' '.Yii::app()->session['last_name']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo $baseUrl;?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url().'/admin/logout'; ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $baseUrl;?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo Yii::app()->session['first_name'].' '.Yii::app()->session['last_name']; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="<?php echo base_url()."/admin/category"; ?>"><i class="fa fa-users"></i> <span>Categories</span></a></li>
            <li><a href="<?php echo base_url()."/admin/product"; ?>"><i class="fa fa-users"></i> <span>Products</span></a></li>
            <li><a href="<?php echo base_url()."/admin/pages"; ?>"><i class="fa fa-users"></i> <span>Page Contents</span></a></li>
            <li><a href="<?php echo base_url()."/admin/qna"; ?>"><i class="fa fa-users"></i> <span>Q&A</span></a></li>
            <li><a href="<?php echo base_url()."/admin/banners"; ?>"><i class="fa fa-users"></i> <span>Banners</span></a></li>
			<li><a href="<?php echo base_url()."/admin/adminusers"; ?>"><i class="fa fa-users"></i> <span>Users</span></a></li>
		  </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 901px;">
        <!-- Main content -->
        <?php echo $content; ?> 
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2015-2016.</strong> All rights reserved.
      </footer>
     
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <!--<script src="<?php echo $baseUrl;?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      //$.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $baseUrl;?>/bootstrap/js/bootstrap.min.js"></script>
	<!-- Bootstrap Date Picker -->
	<script src="<?php echo $baseUrl;?>/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<!-- Select2 -->
    <script src="<?php echo $baseUrl;?>/plugins/select2/select2.full.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo $baseUrl;?>/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo $baseUrl;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo $baseUrl;?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $baseUrl;?>/plugins/knob/jquery.knob.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $baseUrl;?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $baseUrl;?>/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo $baseUrl;?>/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $baseUrl;?>/dist/js/demo.js"></script>
  </body>
</html>
