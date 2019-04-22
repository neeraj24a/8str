$(document).ready(function(){
    $(".js-mobile-nav-toggle").click(function(){
        if($(this).hasClass('mobile-nav--open')){
            $(this).removeClass('mobile-nav--open').addClass('mobile-nav--close');
            $('.mobile-nav-wrapper').addClass('js-menu--is-open').css({"-webkit-transform":"translateY(67px)"});
        } else {
            $(this).removeClass('mobile-nav--close').addClass('mobile-nav--open');
            $('.mobile-nav-wrapper').removeClass('js-menu--is-open').css({"-webkit-transform":"translateY(-100%)"});
        }
    });
    $.ajax({
        url: base_url + "cart/load",
        method: "POST",
        success: function (data) {
        	data = JSON.parse(data);
            $("#CartCount").html(data.quantity);
        }
    });
	
	$("#contact_form").submit(function(e){
		e.preventDefault();
		$('#email-error').html("");
		var email = $("#Email").val();
		var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		if(email != '' && pattern.test(email)){
			var data = "email="+email;
			$.ajax({
				url: base_url + "contact/subscribe",
				method: "POST",
				data: data,
				success: function (data) {
					data = JSON.parse(data);
					if(data['error'] == 'true'){
						$('#email-error').html(data['msg']);
					} else {
						$("#Email").val('');
						$('#email-error').html("");
						$('#email-success').html("Subscribed Successfully!");
					}
					return false;
				}
			});
		} else {
			$('#email-error').html("Enter a valid email.");
		}
	});
});