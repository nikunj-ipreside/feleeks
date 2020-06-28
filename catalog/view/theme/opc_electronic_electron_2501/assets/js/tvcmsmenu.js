$(document).ready(function () {
    var current_url = window.location.href;
    
    $('.ttvmain-menu .ttvmenu-main-wrapper .ttvmenu-link').each(function () {
        var link = $(this).attr('href');
        if(current_url.indexOf(link) !== -1) {
            $(this).closest('.ttvmenu-main-wrapper').addClass('active');
        }
    });

    $('.ttvhorizontal-menu .ttvmega-menu-container').each(function () {
        if($(this).hasClass('right')) {
            if($(this).hasClass('full-width')) {
                $(this).closest('li').removeClass().addClass('ttvmenu-main-wrapper mega-right');
            } else {
                $(this).closest('li').removeClass().addClass('ttvmenu-main-wrapper right');

                var menu = $('.ttvmenu-bars').offset();
                var dropdown = $(this).parent().offset();

                var dropdownRight = $('.ttvmenu-bars').outerWidth() - dropdown.left;

                var i = (dropdownRight + $(this).outerWidth()) - ($('.ttvmenu-bars').outerWidth());

            }
        }

        if($(this).hasClass('left')) {
            if($(this).hasClass('full-width') == false) {
                var menu = $('.ttvmenu-bars').offset();
                var dropdown = $(this).parent().offset();

                var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('.ttvmenu-bars').outerWidth());

               
            }
        }
    });

    $('.ttvsub-menu-container').each(function () {
        var total_cols = 0;
        $(this).find('.ttvsub-item-content-two').each(function () {
            var cols = parseFloat($(this).data('cols'));
            if(total_cols == 0) {
                $(this).css('clear', 'left');
            }
            total_cols += cols;
            if(total_cols > 12) {
                $(this).css('clear', 'left');
                total_cols = cols;
            }
            if(total_cols == 12) {
                total_cols = 0;
            }
        });
    });

    $(document).on('click', '.ttvvertical-menu-top .ttvmenu-bars', function() {
        $(this).parent().find('.ttvmain-menu-top-items').toggleClass('open');
    });

    $(document).on('click', '#ttvcmsmobile-horizontal-menu .ttvhorizontal-menu-icon', function() {
        var mobileViewSize = 992;
        if (document.body.clientWidth < mobileViewSize) {
           
        $(this).parent().find('.ttvmain-menu-top-items').toggleClass('open');
        }
    });

    $(document).on('click', '.ttvmain-menu-top-items .ttvmenu-close-btn', function() {
        $(this).parent().removeClass('open');
    });

    $(document).on('click', '.a-plus', function() {
            $('.li-plus').hide();
            $('.over').show();
    });
    $(document).on('click', '.a-minus', function() {

            $('.over').hide();
            $('.li-plus').show();
    });

    $('.ttvmain-menu').each(function () {
         var mobileViewSize = 992;
        if (document.body.clientWidth > mobileViewSize) {
            $(this).find('.ttvmenu-main-wrapper').hover(
                function () {
                        $('.ttvsub-menu-container').hide();
                        $(this).find('.ttvsub-menu-container').show();
                },

                function () {
                    $(this).find('.ttvsub-menu-container').hide();
                }
            );


            $(this).find('.ttvmenu-secound-item').hover(
                function () {

                        $('.ttvflyout-third-items').hide();
                        $(this).find('.ttvflyout-third-items').show();
                    
                },

                function () {

                        $(this).find('.ttvflyout-third-items').hide();
                    
                }
            );
        }
    });
    //start mobile vertical menu
    $(document).on('click', '.ttvmenu-main-wrapper .jsttvmnu-toggle-icon', function() {
        $(this).parent().find('.ttvsub-menu-container').toggleClass('open');
    });
    $(document).on('click', '.ttvmenu-secound-item .ttvmnu-toggle-icon', function() {
        $(this).parent().find('.ttvflyout-third-items').toggleClass('open');
    });
    //end mobile vertical menu

    //start horizontal vertical menu
    $(document).on('click', '.ttvmenu-main-wrapper .ttvmobileherozintal', function() {
        $(this).parent().find('.ttvsub-menu-container').toggleClass('open');
    });
    $(document).on('click', '.ttvjssubsubmenufluottype', function() {
        if($(this).parent().find('.ttvflyout-third-items:hidden').length == 0){
            $(this).parent().find('.ttvflyout-third-items').hide();
        }else{
             $('.ttvflyout-third-items').hide();
            $(this).parent().find('.ttvflyout-third-items').show();
        }
    });

    //end horizontal vertical menu
})