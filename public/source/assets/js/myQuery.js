$(function(){

    $('.lazy').Lazy();  //LazyLoad


/** =====Begin: Hover hiển tổng tiền giỏ hàng nhỏ bên phải ==== */
    $('#btnCart').hover(function () {
       $('.fix-cart-info').show();
        }, function () {
           $('.fix-cart-info').hide();
        }
    );

/** =====End: Hover hiển tổng tiền giỏ hàng nhỏ bên phải ==== */

/** =====Begin: Click hiển thị nội dung giỏ hàng lớn ==== */
  $('#show_cart').click(function() {
    if ( $('.fix-cart-list').css('display')==='none' ) {
        $('.fix-cart-list').slideToggle();
        $('i', this).removeClass('fa-angle-double-up');
        $('i', this).addClass('fa-angle-double-down');
    } else {
        $('.fix-cart-list').slideToggle();
        $('i', this).removeClass('fa-angle-double-down');
        $('i', this).addClass('fa-angle-double-up');
    }
});
/** =====End: Click hiển thị nội dung giỏ hàng lớn ==== */


/**=============Begin: nút trượt to top ===================*/
    $(window).scroll(function () {
        var viTri = $('body,html').scrollTop();
        if(viTri >=100){
            $('#btnTotop').show();
        }else{
            $('#btnTotop').hide();
        }
    });

    $('#btnTotop').click(function (e) {
        e.preventDefault();
        $('html, body').animate( {scrollTop:0},500 );
    });
/**============End: nút trượt to top =====================*/

/**=============Begin: scroll chuột ẩn menu ================ */

    // $(window).scroll(function () {
    //     console.log($('body,html').scrollTop());
    //     var viTri = $('body,html').scrollTop();
    //     if(viTri >=10){
    //         console.log('lam thoi');
    //          $('nav.menu').addClass('scroll-menu');
    //     }
    //     else{
    //         $('nav.menu').removeClass('scroll-menu');
    //     }
    // });

/**=============End: scroll chuột ẩn menu ================== */
$(document).ready(function ()
{
    /*Menu*/
    $(function() {
        menu = $('#menuTop .menu');
        $('#pull-menu-top').on('click', function(e) {
            e.preventDefault();
            $( "ul.menu>li.nav-item>ul" ).removeClass('hover');
            menu.slideToggle();
        });
    });

    $( ".menu>li" ).hover(
        function() {
            if( $(window).width() > 992 ) {
                $('.bg-menu').show();
            }
        }, function() {
            if( $(window).width() > 992 ) {
                $('.bg-menu').hide();
            }
        }
    );

    $(window).resize(function(){
        var w = $(window).width();
        if(w > 992 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });
    $('ul').each(function(){
        var blankCheck = $(this).html().trim();
        if(0== blankCheck.length) {
            $(this).hide();
        }
    });
    $("ul.menu li").each(function () {
        var $sub = $(this).children('ul');
        if ($sub.children().length !== 0) {
            $sub.parent().append('<i class="fa fa-chevron-down fa-fw show-sub-menu"></i>');
        } else {
            $sub.remove();
        }
    });

    var w = $(window).width();
    menu_show(w);

    $(window).resize(function(e) {
        var w = $(window).width();
        menu_show(w);
    }); /*Resize trình duyệt*/

    function menu_show(w) {
        if( w > 992 ) {
            $('.show-sub-menu').css('display', 'none');
        } else {
            $('.show-sub-menu').css('display', 'block');
        }
    }

    $('i.show-sub-menu').click(function() {
        var parent = $(this).parent().children('ul');
        if( parent.is(':hidden') ) {
            $(this).removeClass('fa-chevron-down');
            $(this).addClass('fa-chevron-up');
        } else {
            $(this).removeClass('fa-chevron-up');
            $(this).addClass('fa-chevron-down');
            /*fa-chevron-up, fa-chevron-down*/
        }
        parent.slideToggle();
    });

    var hover = $( "ul.menu>li.nav-item>ul" ).hasClass( "hover" );
    if( hover==false ) {
        $( "ul.menu>li.nav-item:first>ul" ).addClass('hover');
    }

    var setTimeoutConst;
    $( "ul.menu>li.nav-item" ).hover(
        function() {
            var delay = 200; var parent = this;
            setTimeoutConst = setTimeout(function(){
                $( "ul.menu>li.nav-item>ul" ).removeClass('hover');
                $( 'ul', parent ).addClass('hover');
            }, delay);
        }, function() {
            clearTimeout(setTimeoutConst);
        }
    );

    $( "#toggleTop" ).hover(
        function() {
            $('span>i', this).removeClass('fa-caret-down').addClass('fa-caret-up');
        }, function() {
            $('span>i', this).removeClass('fa-caret-up').addClass('fa-caret-down');
        }
    );
    /*End*/
    });








})





