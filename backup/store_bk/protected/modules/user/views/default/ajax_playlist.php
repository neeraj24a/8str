<?php
$baseUrl = Yii::app()->theme->baseUrl;
?>   
<ul class="a_list i_page">

            <?php
            if (!empty($playlists)) {
                $count = 1;
                foreach ($playlists as $playlist) {
                    ?>    
                    <li>
                        <div class="i_info"> 
                            <a href="javascript:void(0)"  data-id="<?php echo $playlist->id; ?>" class="playlist_songs">
                            <img src="<?php echo $baseUrl; ?>/img/alb1.jpg" /> 
                            </a>
                        </div>
                        <div class="i_titel">
                            <div class="it_l"><?php echo $count; ?></div>
                            <div  class="it_m">
                                <h5><?php echo $playlist->name; ?></h5>
                            </div>
                        </div>
                    </li>  


                    <?php
                    $count = $count + 1;
                }
            }
            ?>



        </ul>