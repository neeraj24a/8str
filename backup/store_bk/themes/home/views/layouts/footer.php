 <footer class="footer_area">
                <div>
                    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAxmD29mDTH4lGaO1IueTSmvyxFIFz1YHM'></script>
							<div style='overflow:hidden;height:360px;width:100%;'>
  								<div id='gmap_canvas' style='height:360px;width:100%;'></div>
  									<style>
    									#gmap_canvas img{max-width:none!important;background:none!important}
  									</style>
							</div> 
							<a href='https://www.add-map.net/'>google maps widget for website</a> 
							<script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=cfc08dd02918ab26dc6fdbfc63f6eda9db892306'></script>
							<script type='text/javascript'>
								function init_map(){
									var myOptions = {
										zoom:14,
										center:new google.maps.LatLng(19.072171139234626,72.9049500589356),
										mapTypeId: google.maps.MapTypeId.ROADMAP
									};
									map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
									marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(19.072171139234626,72.9049500589356)});
									infowindow = new google.maps.InfoWindow({content:'<strong>Naturaxion</strong><br>'});
									google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});
									infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);
							</script>
                </div>
                <div class="footer_top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <!--<div class="col-md-3">
                                    <div class="footer_widget_two">
                                        <h1>SIGN UP FOR OUR NEWSLETTER</h1>
                                        <label>
                                            <input name="" type="text" placeholder="Your email address">
                                            <input name="" type="submit" value="">
                                        </label>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam nec lobortis ex, vel luctus ligula. Vivamus molestie velit ut urna facilisis gravida. Aliquam erat volutpat. Maecenas sed hendrerit enim. Praesent eu dignissim augue. Integer odio lectus, sodales sit amet scelerisque a, condimentum at magna. Fusce laoreet tellus ut volutpat molestie. </p>
                                    </div>
                                </div>-->
                                <div class="col-md-3">
                                    <div class="footer_widget_two">
                                        <h1>PAGE LINKS</h1>
                                        <ul>
                                            <li><a href="<?php echo base_url()."/faq";  ?>"><strong>*</strong> FAQ</a></li>
                                            <li><a href="<?php echo base_url()."/products";  ?>"><strong>*</strong> Products</a></li>
                                            <li><a href="<?php echo base_url()."/contact-us";  ?>"><strong>*</strong> Contact Us</a></li>
                                            <li><a href="<?php echo base_url()."/about-us";  ?>"><strong>*</strong> About Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--<div class="col-md-3">
                                    <div class="footer_widget_two">
                                        <h1>BUSINESSES</h1>
                                        <ul>
                                            <li><a href="#">Our Growth Accelerators</a></li>
                                            <li><a href="#">Fact Sheet</a></li>
                                            <li><a href="#">Branded Formulations</a></li>
                                            <li><a href="#">Biopharmaceuticals</a></li>
                                            <li><a href="#">Research Services</a></li>
                                            <li><a href="#">Active Discovery Program</a></li>
                                        </ul>
                                    </div>
                                </div>-->
                                <div class="col-md-3">
                                    <div class="footer_widget_two">
                                        <h1>OUR LOCATIONS</h1>
                                        <ul>
                                            <li>NATURATION (P) LTD. Mumbai – 400001.</li>
                                            <li>022 1234 5678/5677</li>
                                            <li>+91 9831023020 / 9330103355</li>
                                            <li>Email: <a href="mailto" style="font-size: 12px;">hr.naturaxion@gmail.com</a></li>
                                            <!--li>Careers: <a href="#">Apply now!</a></li-->
                                        </ul>
                                    </div>
                                    <div class="footer_icon">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-user"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="footer_bottom" style="text-align: right;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copy_right ac">
                                    <p>naturaxion.com © 2017 | <a href="#">Privacy Policy</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>