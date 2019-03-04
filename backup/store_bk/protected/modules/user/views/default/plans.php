<div class="inner_con bg_grey">
    <div class="wraper fc_black">
        <h2 class="fw600 mart15 marb15 titel">Subscription Plan</h2>

        <section id="pricePlans">
            <ul id="plans" class="cd-pricing-wrapper">
                <?php
                if (!empty($plans)) {
                    foreach ($plans as $plan) {
                        ?>         
                        <li class="plan">
                            <ul class="planContainer">
                                <?php
                                $plan_class = "basic_p";
                                if ($plan->plan_type == 'premium') {
                                    $plan_class = "pre_p";
                                } else if ($plan->plan_type == 'pro') {
                                    $plan_class = "pro_p";
                                }
                                ?>
                                <li class="title <?php echo $plan_class; ?>">
                                    <h2><?php echo $plan->plan_name; ?></h2>
                                    <div class="cd-price">
                                        <span class="cd-currency">$</span>
                                        <span class="cd-value"><?php echo $plan->plan_price; ?></span>
                                        <span class="cd-duration"><?php echo $plan->plan_duration; ?></span>
                                    </div>
                                    <span class="sub_t"></span>
                                </li>
                                                    <!--<li class="price"><p class="bestPlanPrice">$20/month</p></li>-->
                                <li>
                                    <ul class="options">
                                        <li class="separetor">
                                            <span>
                                                <strong>
                                                    <em>1</em> <?php echo $plan->plan_desc; ?>
                                                </strong>
                                            </span></li>
                                        <?php if ($plan->plan_type == 'basic') { ?>
                                            <li class="separetor"><span><strong>No Badge</strong></span></li>
                                            <li class="separetor"><span><strong>Adverts</strong></span></li>
                                            <li class="separetor"><span><strong>Profile Customisation</strong></span></li>
                                            <li class="separetor"><span>Basic Statistics</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li ><span>No Extras</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li class="separetor"><span>&nbsp;</span></li>    
                                        <?php } else if ($plan->plan_type == 'premium') { ?>
                                            <li class="separetor"><span><strong>Premium Badge</strong></span></li>
                                            <li class="separetor"><span><strong>No Adverts</strong></span></li>
                                            <li class="separetor"><span><strong>Advanced Profile Customisation</strong></span></li>
                                            <li class="separetor"><span>Basic Statistics</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li ><span>No Extras</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li class="separetor"><span>&nbsp;</span></li>
                                        <?php } else if ($plan->plan_type == 'pro') { ?>
                                            <li class="separetor"><span><strong>Pro Badge</strong></span></li>
                                            <li class="separetor"><span><strong>No Adverts</strong></span></li>
                                            <li class="separetor"><span><strong>Advanced Profile Customisation</strong></span></li>
                                            <li class="separetor"><span>Advanced Statistics</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li ><span>All Latest Updates</span></li>
                                            <li><span>&nbsp;</span></li>
                                            <li class="separetor"><span>&nbsp;</span></li>
                                        <?php } ?>


                                    </ul>
                                </li>
                                <li class="button">
                                    <?php {
                                        if (!empty($user_plan)) {
                                            if ($user_plan->plan_id == $plan->id) {
                                                ?>  
                                                <a href="javascript:void(0)" class="<?php echo $plan_class; ?>"
                                                   data-plan="<?php echo $plan->id; ?>">Current Plan</a>
                                                   <?php
                                               } else {
                                                   ?>   
                                                <a href="javascript:void(0)" class="<?php echo $plan_class; ?> subscription_btn"
                                                   data-plan="<?php echo $plan->id; ?>">Select</a>
                                                   <?php
                                               }
                                           }
                                       }
                                       ?>


                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                }
                ?>


            </ul> <!-- End ul#plans -->
        </section> 
    </div>
</div>

<script src="<?php echo base_url(); ?>/assets/js/home/home.js"></script>
