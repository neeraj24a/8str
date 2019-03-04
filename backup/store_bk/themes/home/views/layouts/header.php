<div class="header_top">
    <div class="container">
        <div class="row">
            <div class="leftcol">
                <ul>
                    <li><img src="<?php echo $baseUrl; ?>/img/phone.png" alt=""> 022 1234 5678/5677</li>
                    <li><img src="<?php echo $baseUrl; ?>/img/mail.png" alt=""> <a href="mailto" style="color:#9cc603;">hr.naturaxion@gmail.com</a></li>
                    <li><a href="<?php echo base_url().'/career'; ?>">Career</a></li>
                    <li>&nbsp;</li>
                </ul>
            </div>
            <div class="rightcol">
                <div class="social_icon">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-user"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <!--<li>
                            <input name="Search" type="text" placeholder="Search....">
                        </li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header_bottom">
    <div class="container">
        <div class="row">
            <div class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo $baseUrl; ?>/img/logo.png" alt=""></a></div>
            <div class="navigation">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <?php
                        //echo $this->action->Id;
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Home', 'url' => array('/'), 'active' => $this->action->Id == 'index' ? true : false),
                                // 'Products' menu item will be selected no matter which tag parameter value is since it's not specified.
                                array('label' => 'Products', 'url' => array('/products'), 'active' => $this->action->Id == 'products' ? true : false),
                                array('label' => 'About Us', 'url' => array('/about-us'), 'active' => $this->action->Id == 'about' ? true : false),
                                array('label' => 'Faq', 'url' => array('/faq'), 'active' => $this->action->Id == 'faq' ? true : false),
                                array('label' => 'Contact Us', 'url' => array('/contact-us'), 'active' => $this->action->Id == 'contact' ? true : false),
                            ),
                            'htmlOptions' => array(
                                'class' => 'nav navbar-nav',
                            ),
                        ));
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>