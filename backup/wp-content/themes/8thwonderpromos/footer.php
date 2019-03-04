<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

			<footer>
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<ul class="footer-nav">
								<li class="current-menu-item"><a href="https://www.8thwonderpromos.com/" title="Home">Home</a></li>
								<li><a href="https://pool.8thwonderpromos.com" title="Pool">Pool</a></li>
								<li><a href="javascript:void(0);" title="Store">Store</a></li>
								<li><a href="https://pool.8thwonderpromos.com/contact" title="Contact">Contact</a></li>
								<li><a href="https://pool.8thwonderpromos.com/crate" title="Crate">Crate</a></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<a href="#" title="8thWonder" class="ftr-logo"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/blacklogo.png" alt=""></a>
							<p class="cpyryt">&copy; <script type="text/javascript">var today=new Date(); document.write(today.getFullYear());</script> 8th Wonder Promos. All Rights Reserved</p>
							<ul class="social-icons">
								<li><a href="https://www.facebook.com/8thwonderpromos-143829159612633" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="https://twitter.com/8thwonderpromos" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="https://www.instagram.com/8thwonderrecordpool" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
								<li><a href="https://www.youtube.com/channel/UCfODYpiz94l_OU-l6G7y5Pg" title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="otherlink">
								<li class="current-menu-item"><a href="https://pool.8thwonderpromos.com/terms" title="Terms">Terms</a></li>
								<li><a href="https://pool.8thwonderpromos.com/privacy" title="Privacy">Privacy</a></li>
								<li><a href="https://pool.8thwonderpromos.com/copyright" title="Copyright">Copyright</a></li>
								<li><a href="https://pool.8thwonderpromos.com/faq" title="F.A.Q">F.A.Q</a></li>
								<li><a href="https://pool.8thwonderpromos.com/feedback" title="Feedback">Feedback</a></li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<script src="https://codeorigin.jquery.com/jquery-1.10.2.min.js" data-cookieconsent="necessary"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
		<script defer src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.flexslider.js"></script>

		<script type="text/javascript">
			(function($) {

			  'use strict';

			  $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function(e) {
				var $target = $(e.target);
				var $tabs = $target.closest('.nav-tabs-responsive');
				var $current = $target.closest('li');
				var $parent = $current.closest('li.dropdown');
					$current = $parent.length > 0 ? $parent : $current;
				var $next = $current.next();
				var $prev = $current.prev();
				var updateDropdownMenu = function($el, position){
				  $el
					.find('.dropdown-menu')
					.removeClass('pull-xs-left pull-xs-center pull-xs-right')
					.addClass( 'pull-xs-' + position );
				};

				$tabs.find('>li').removeClass('next prev');
				$prev.addClass('prev');
				$next.addClass('next');
				
				updateDropdownMenu( $prev, 'left' );
				updateDropdownMenu( $current, 'center' );
				updateDropdownMenu( $next, 'right' );
			  });
			  $(document).on("click", ".decline", function(){
					window.close();
					var objWindow = window.open(location.href, "_self");
					objWindow.close();
			  });
			})(jQuery);
			$(window).load(function(){
			  $('.flexslider').flexslider({
				animation: "slide",
				start: function(slider){
				  $('body').removeClass('loading');
				}
			  });
			});
			$(window).on('load',function(){
				$("#notificationModal").modal({show: true,backdrop: false});
			});
		</script>
	</body>
</html>
