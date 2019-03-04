$(document).ready(function(){
    
    //sticky nav
    $(".navbar").sticky({topSpacing:0});
    
    // yamm menu
    $(document).on('click', '.yamm .dropdown-menu', function(e) {
        e.stopPropagation();
    })
    
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        event.preventDefault(); 
        event.stopPropagation(); 
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
    });
    
    //tootltip
    $('[data-toggle="tooltip"]').tooltip();
    
    //Popover
    $('[data-toggle="popover"]').popover();
    
    //owl carousel 5 Columns
    $(".owl-carousel.column-5").owlCarousel({
        nav : true, // Show next and prev buttons
        navText: false,
        dots: false,
        items: 5,
        margin: 15,
        responsiveClass: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    
    //owl carousel 4 Columns
    $(".owl-carousel.column-4").owlCarousel({
        nav : true, // Show next and prev buttons
        navText: false,
        dots: false,
        items: 4,
        margin: 15,
        responsiveClass: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });
    
    //owl carousel 3 Columns
    $(".owl-carousel.column-3").owlCarousel({
        nav : true, // Show next and prev buttons
        navText: false,
        dots: false,
        items: 3,
        margin: 15,
        responsiveClass: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        }
    });
    
    //owl slider
    $('.slider').owlCarousel({
        animateOut: 'zoomOut',
        nav : true, // Show next and prev buttons
        navText: false,
        dots: true,
        items: 1,
        margin: 0,
        smartSpeed: 450
    });
    
    //owl product-showcase
    $('.product-showcase').owlCarousel({
        animateOut: 'lightSpeedOut',
        nav : true, // Show next and prev buttons
        navText: false,
        dots: true,
        items: 1,
        margin: 0,
        smartSpeed: 450
    });
    
    //owl next prev icons
    $(".owl-carousel .owl-next").addClass("fa fa-angle-right");
    $(".owl-carousel .owl-prev").addClass("fa fa-angle-left");
    
    //CountDown
    $('.countdown').downCount({
        date: '10/21/2017 12:00:00',
        offset: +1
    }, function () {
        //alert('WOOT WOOT, done!');
    });
    
    //CountDown
    $('.countdown-product').downCount({
        date: '10/21/2017 12:00:00',
        offset: +1
    }, function () {
        //alert('WOOT WOOT, done!');
    });
    
    // Range Slider
    var rangeSlider  = document.querySelector('.ui-range-slider');
    if(typeof rangeSlider !== 'undefined' && rangeSlider !== null) {
        var dataStartMin = parseInt(rangeSlider.parentNode.getAttribute( 'data-start-min' ), 10),
            dataStartMax = parseInt(rangeSlider.parentNode.getAttribute( 'data-start-max' ), 10),
            dataMin = parseInt(rangeSlider.parentNode.getAttribute( 'data-min' ), 10),
            dataMax = parseInt(rangeSlider.parentNode.getAttribute( 'data-max' ), 10),
            dataStep = parseInt(rangeSlider.parentNode.getAttribute( 'data-step' ), 10);
        var valueMin = document.querySelector('.ui-range-value-min span'),
            valueMax = document.querySelector('.ui-range-value-max span'),
            valueMinInput = document.querySelector('.ui-range-value-min input'),
            valueMaxInput = document.querySelector('.ui-range-value-max input');
        noUiSlider.create(rangeSlider, {
            start: [ dataStartMin, dataStartMax ],
            connect: true,
            step: dataStep,
            range: {
                'min': dataMin,
                'max': dataMax
            }
        });
        rangeSlider.noUiSlider.on('update', function(values, handle) {
            var value = values[handle];
            if ( handle ) {
                valueMax.innerHTML  = Math.round(value);
                valueMaxInput.value = Math.round(value);
            } else {
                valueMin.innerHTML  = Math.round(value);
                valueMinInput.value = Math.round(value);
            }
        });
    }
    
    //back to top
    $('body').append('<a href="javascript:void(0);" id="back-to-top"><i class="fa fa-angle-up"></i></a>');
    
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 200) {
            $('#back-to-top').fadeIn(200);
        } else {
            $('#back-to-top').fadeOut(200);
        }
    });
    $('#back-to-top').click(function() {
        $('body,html').animate({
            scrollTop : 0
        }, 500);
    });
    
    //wow for animate.css
    new WOW().init();
    
    
    //toggle theme settings
    $("body").append(
        $('<div/>', {
            'class': 'toggleButtonSettings'
        }),
        $('<div/>', {
            'class': 'toggleSettings'
        })
    );
    
    $('.toggleButtonSettings').append(
        $('<i/>',{
            'class': 'fa fa-cog'
        })
    );
    
    $('.toggleSettings').append(
        $('<div/>',{
            'class': 'themeColors'
        })
    );
    
    $('.themeColors').append(
        $('<a/>',{
            'class': 'color',
            'style': 'background-color:#0cd4d2'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/default.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#2599e6'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-blue.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#7ade20'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-green.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#e63e2d'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-red.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#a452f8'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-purple.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#80b543'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-greenery.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#bd967a'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-brown.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#f55788'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-pink.css');
            }
        }), $('<a/>',{
            'class': 'color',
            'style': 'background-color:#f4b330'
        }).on({
            'click': function() {
                document.getElementById('pagestyle').setAttribute('href', themePath + '/css/skin-orange.css');
            }
        })
    )
    /*
    $(".home1").append(
        $('<img/>', {
            'src': 'img/home_small_01.png',
            'width': '100%'
        })
    );
    $(".home2").append(
        $('<img/>', {
            'src': 'img/home_small_02.png',
            'width': '100%'
        })
    );
    $(".home3").append(
        $('<img/>', {
            'src': 'img/home_small_03.png',
            'width': '100%'
        })
    );
    $(".home4").append(
        $('<img/>', {
            'src': 'img/home_small_04.png',
            'width': '100%'
        })
    );
    $(".home5").append(
        $('<img/>', {
            'src': 'img/home_small_05.png',
            'width': '100%'
        })
    );
    $(".home6").append(
        $('<img/>', {
            'src': 'img/home_small_06.png',
            'width': '100%'
        })
    );
    $(".home7").append(
        $('<img/>', {
            'src': 'img/home_small_07.png',
            'width': '100%'
        })
    );*/
    
    $(".toggleButtonSettings").click(function(){
        if($(this).css("margin-right") == "240px")
        {
            $('.toggleSettings').animate({"margin-right": '-=240'});
            $('.toggleButtonSettings').animate({"margin-right": '-=240'});
        }
        else
        {
            $('.toggleSettings').animate({"margin-right": '+=240'});
            $('.toggleButtonSettings').animate({"margin-right": '+=240'});
        }
    });
    
    $(".add-to-cart").on('click', function(){
        var product = $(this).attr("data-product");
        $.ajax({
            url: base_url+'/add-to-cart',
            method: "POST",
            data: {product: product, quantity: 1}
        }).done(function(data){
            var result = JSON.parse(data);
            $('#cart-items li').each(function(i)
            {
               if($(this).attr('id') == result['slug']){
                   $(this).remove();
               }
            });
            var html = '<li id="'+result['slug']+'"> \n\
                            <a href="'+base_url+'/product?name='+result['slug']+'" class="product-image">\n\
                                <img src="'+base_url+'/images/products/'+result['image']+'" alt="'+result['name']+'">\n\
                            </a>\n\
                            <div class="product-details">\n\
                                <div class="close-icon"> \n\
                                    <a href="javascript:void(0);" class="remove-from-cart" data-product="'+result['slug']+'"><i class="fa fa-close"></i></a>\n\
                                </div>\n\
                                <p class="product-name"> \n\
                                    <a href="shop-single-product-v1.html">'+result['name']+'</a> \n\
                                </p>\n\
                                <strong>'+result['quantity']+'</strong> x <span class="price text-primary">$'+result['price']+'</span>\n\
                            </div><!-- end product-details -->\n\
                        </li><!-- end item -->';
            if(cart_size > 0){
                $("#cart-option").show();
                $(".cart-empty").remove();
            }
            cart_size++;
            $("#cart_count").html("("+cart_size+")");
            $("#cart-items").append(html);
        }).fail(function(){
            alert("not-added-to-cart");
        });
    });
    
    $(document).on("click", ".remove-from-cart", function(){
        var product = $(this).attr("data-product");
        $.ajax({
            url: base_url+'/remove-from-cart',
            method: "POST",
            data: {product: product}
        }).done(function(data){
            if(data == "removed"){
                $('#cart-items li').each(function(i)
                {
                   if($(this).attr('id') == product){
                       $(this).remove();
                   }
                });
            }
            cart_size--;
            $("#cart_count").html("("+cart_size+")");
            if(cart_size == 0){
                $("#cart-option").hide();
                $("#cart-items").append('<li class="cart-empty">Your Cart Is Empty!</li>');
            }
        }).fail(function(){
            alert("not-removed-from-cart");
        });
    });
    
});