<?php
            if (!empty($recommended_list)) {
                foreach ($recommended_list as $recommended) {
                    if (!empty($recommended->profile_pic)) {
                        $user_file = $recommended->profile_pic;
                    } else {
                        $user_file = "no_dj1.jpg";
                    }
                    ?>
               <a href="<?php echo base_url() ?>/home/dj?user=<?php echo $recommended->username; ?>">
                    <li>
                        <div class="left_thumb">
                            <img src="<?php echo base_url(); ?>/assets/user-profile/<?php echo $user_file; ?>">
                        </div>
                        <div class="left_con">
                            <?php echo $recommended->username; ?> <i class="fa fa-star fc_red"></i>
                            <div class="small_sec"><span><i class="fa fa-users"></i> <?php echo count($recommended->followers_list); ?></span> <span><i class="fa fa-volume-up"></i> <?php echo count($recommended->songs_list) + count($recommended->videos_list) ?></span></div>
                        </div>
                        <div class="flow_p">
                            <a href="javascript:void(0)" class="btn" data-dj="<?php echo $recommended->id; ?>" data-user ="<?php echo Yii::app()->user->id; ?>" id="follow_unfollow_recommend">
                            Follow
                            </a>
                        </div>                             
                    </li>
               </a>     
                    <?php
                }
            }
            else 
            {
            ?>    
            <li>
                No Records
            </li>
            <?php     
            }    
            ?>