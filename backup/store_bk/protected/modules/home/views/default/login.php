<!-- breadcrumb start -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li class="active">Login</li>
                </ul><!-- end breadcrumb -->
            </div><!-- end col -->    
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- breadcrumb end -->

<!-- section start -->

<section class="section white-backgorund">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <h2 class="title">Sign in to your account</h2>
                    </div><!-- end col -->
                </div><!-- end row -->

                <hr class="spacer-5"><hr class="spacer-20 no-border">

                <div class="row">
                    <div class="col-sm-12 col-md-10 col-lg-8">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'login-form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => array(
                                'autcomplete' => "off",
                                'class' => 'form-horizontal'
                            ),
                        ));
                        ?>
                        <!--<form class="form-horizontal">-->
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                  <?php echo $form->textField($model, 'username', array('class' => 'form-control input-md', 'id' =>"username", 'placeholder' => 'Username')); ?>
                                  <?php echo $form->error($model, 'username'); ?>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                  <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-md', 'id' =>"password", 'placeholder' => 'Password')); ?>
                                  <?php echo $form->error($model, 'password'); ?>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox-input mb-10">
                                        <input id="remember" class="styled" type="checkbox">
                                        <label for="remember">
                                            Remember me
                                        </label>
                                    </div><!-- end checkbox-input -->
                                </div><!-- end col -->
                                <div class="col-sm-offset-2 col-sm-10">
                                    <label><a href="forgot-password.html">Forgot Password</a></label>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default round btn-md"><i class="fa fa-lock mr-5"></i> Login</button>
                                </div>
                            </div><!-- end form-group -->
                        <?php $this->endWidget(); ?>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end col -->
        </div><!-- end row -->                
    </div><!-- end container -->
</section>

<!-- section end -->