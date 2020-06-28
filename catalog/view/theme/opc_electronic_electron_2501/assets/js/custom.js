/****************STRAT loading*************/
$(window).load(function() {
	$('.ttvcms-loading-overlay').fadeOut('slow');
	$(".ttvcmsnewsletterpopup").fadeIn("slow");

	/************ Start To Change Left Column Position in Mobile Size *********************************/
	changePositionLeftColumnMobileView();
	$(window).resize(function() {
		changePositionLeftColumnMobileView();
	});

	function changePositionLeftColumnMobileView() {
		// set Mobile view size 991
		var mobileViewSize = 991;
		if (document.body.clientWidth > mobileViewSize) {
			$('#column-left').insertBefore('#content');
			$('#column-left').insertBefore('#content-wrapper');
		} else {
			$('#column-left').insertAfter('#content');
			$('#column-left').insertAfter('#content-wrapper');
		}
		if (document.body.clientWidth <= 575) {
			$('.ttvcms-header-myaccount').insertBefore('#_desktop_cart');
		} else {
			$('#_desktop_cart').insertBefore('.ttvcms-header-myaccount');
			//$('#column-left').insertAfter('#content-wrapper');
		}
	}
	/************ End To Change Left Column Position in Mobile Size *********************************/


	/****************** Start Default Left Right Panel Hide *********************************************/
	var showCountPanelLeft = 0;
	var showCountPanelRight = 0;

	if ($('.ttvcms-left-column-wrapper').html() != undefined) {
		if ($('#column-left').html() != undefined) {
			$('#column-left').addClass('ttv-left-right-panel-hide');
			showCountPanelLeft = 1;
		} else {
			$('.ttvcms-left-column-wrapper').remove();
			$('#column-left').removeClass('ttv-left-right-panel-hide');
		}
	} else {
		$('#column-left').removeClass('ttv-left-right-panel-hide');
		$('.ttvcms-left-column-wrapper').remove();
	}

	if ($('.ttvcms-right-column-wrapper').html() != undefined) {
		if ($('#column-right').html() != undefined) {
			$('#column-right').addClass('ttv-left-right-panel-hide');
			showCountPanelRight = 1;
		} else {
			$('.ttvcms-right-column-wrapper').remove();
			$('#column-right').removeClass('ttv-left-right-panel-hide');
			$('.ttvcms-right-column-wrapper').addClass('col-xs-12 col-md-1 col-lg-1');
			$('.ttv-left-search-totle-product').removeClass('col-sm-6 col-md-2 col-lg-2');
			$('.ttv-left-search-totle-product').addClass('col-sm-6 col-md-3 col-lg-3');


		}
	} else {
		$('#column-right').removeClass('ttv-left-right-panel-hide');
		$('.ttvcms-right-column-wrapper').remove();
		$('.ttvcms-right-column-wrapper').addClass('col-xs-12 col-md-1 col-lg-1');
		$('.ttv-left-search-totle-product').removeClass('col-sm-6 col-md-2 col-lg-2');
		$('.ttv-left-search-totle-product').addClass('col-sm-6 col-md-3 col-lg-3');
	}

	if (showCountPanelLeft == 1 || showCountPanelRight == 1) {
		$('#content').addClass('ttvcontent-full-width');
		$('#content-wrapper').addClass('ttvcontent-full-width');
	}


	/****************** End Default Left Right Panel Hide *********************************************/

	// if (ttvCMSCUSTOMSETTING_HOVER_IMG  !== undefined && ttvCMSCUSTOMSETTING_HOVER_IMG  == '0') {
	// 	$('.ttvproduct-hover-img').hide();
	// }
});
/*start button link*/
	$(document).on("click",".jsbtnlink",function() {
		var sliderurl = $(this).attr('data-id');
		if(sliderurl != ''){
	   		window.location = sliderurl;
		}
	});
/*end button link*/
$(document).on('click', '#column-left .ttvleft-column-close-btn, #column-right .ttvright-column-close-btn', function() {
	if ($(this).parent().parent().hasClass('open')) {
		$('.ttv-left-right-panel-hide').removeClass('open');
		$('.modal-backdrop.fade.in').remove();
	}
});
$(document).on('keyup',function(e) {
	    if (e.key === "Escape") {
	     	if ($('#column-left .ttvleft-column-close-btn, #column-right .ttvright-column-close-btn').parent().parent().hasClass('open')) {
				$('.ttv-left-right-panel-hide').removeClass('open');
				$('.modal-backdrop.fade.in').remove();
			}
	    }
});
/******************END loading*************/

$(document).ready(function() {

	$('#selecttitlesortset').text($('#selecttitlesortget').text());
	$('#selecttitleshowset').text($('#selecttitleshowget').text());

	// "use strict";

	// set Mobile view size 991
	var mobileViewSize = 991;

	// check function is defined or not
	function isFunction(fn) {
		return typeof fn === 'function';
	}

	searchclassadd();
	/************ Start close dropdown When open other dropdown in mobile view **************/
	$(window).resize(function() {
		removeDefaultDropdown();
		searchclassadd();
	});

	function searchclassadd() {
		if (document.body.clientWidth <= mobileViewSize) {
			$('.ttvsearch-header-display-full').addClass('col-xl-8 col-lg-12 col-md-12 col-sm-12  col-xs-12');
		} else {
			$('.ttvsearch-header-display-full').removeClass('col-xl-8 col-lg-12 col-md-12 col-sm-12  col-xs-12');
		}
	}
	function removeDefaultDropdown() {
		// Header My Account Dropdown
		$('#header .ttv-account-dropdown').removeClass('open');
		$('#header').find('.ttvcms-header-myaccount .ttv-myaccount-btn').removeClass('open');
		$('#header').find('.ttvcms-header-myaccount .ttv-account-dropdown').removeClass('open').hide();

		// Header Search Dropdown
		$('#header .ttvcmsheader-search .ttvsearch-open').show();
		$('#header .ttvcmsheader-search .ttvsearch-close').hide();
		$('#header .ttvcmsheader-search .ttvsearch-header-display-wrappper').removeClass('open');

		// Header My Account Dropdown
		$('#header .ttv-account-dropdown').removeClass('open');
		$('#header').find('.ttvcms-header-myaccount .ttv-myaccount-btn').removeClass('open');
		$('#header').find('.ttvcms-header-myaccount .ttv-account-dropdown').removeClass('open').hide();

		// language Dropdown
		$('.ttvcms-header-language .ttv-language-btn').removeClass('open');
		$('.ttv-language-dropdown').removeClass('open').hide();

		// Currency Dropdown
		$('.ttvcms-header-currency .ttv-currency-btn').removeClass('open');
		$('.ttv-currency-dropdown').removeClass('open').hide();

		if (document.body.clientWidth <= mobileViewSize) {
			// horizontal menu
			$('#ttvcms-mobile-view-header .ttvmenu-button').removeClass('open');
			$('#ttvcmsmobile-horizontal-menu #ttv-top-menu').removeClass('open');

			// Cart Dropdown
			$('.ttvcms-header-cart .ttvcmscart-show-dropdown').removeClass('open');

			// Vertical Menu DropDown
			$('.ttvcmsvertical-menu .ttvallcategories-wrapper, .ttvcmsvertical-menu .ttvverticalmenu-dropdown').removeClass('open').removeAttr('style');
			
		} else {
			// Vertical Menu DropDown
			$('.ttvcmsvertical-menu .ttvallcategories-wrapper').removeClass('open');
			$('.ttvcmsvertical-menu .ttvverticalmenu-dropdown').removeClass('open').stop(false).slideUp(500, "swing").removeAttr('style');
		}
	}
	/************ End close dropdown When open other dropdown in mobile view **************/
	/******************** Start Comman Drop-Down Functions *******************************************/
	var dropDownParentClass = '';
	var dropDownClass 		= '';

	// this function is use Toggle dropdown
	function ttvDropDown(parentClass, dropdownClass, closeOtherDropdown) {
		$(document).on('click', parentClass, function(e) {
			$('.dropdown-backdrop').remove();
			if ($(dropdownClass).hasClass('open')) {
				$(dropdownClass).removeClass('open').stop(false).slideUp(500, "swing");
				$(parentClass).removeClass('open');
			} else {
				if (closeOtherDropdown == true) {
					removeDefaultDropdown();
				}
				$(dropdownClass).addClass('open').stop(false).slideDown(500, "swing");
				$(parentClass).addClass('open');
			}
			e.stopPropagation();
		});
	}
	//ttvDropDown

	/******************** End Drop-Down Functions *******************************************/

	/********************* Start Account DropDown js *****************************************/
	dropDownParentClass = '.ttvcms-header-myaccount .ttv-myaccount-btn';
	dropDownClass = '.ttv-account-dropdown';
	$(dropDownClass).hide();
	ttvDropDown(dropDownParentClass, dropDownClass, true);
	/********************* End Account DropDown js *****************************************/

	/********************* Start Language DropDown js *****************************************/
	dropDownParentClass = '.ttvcms-header-language .ttv-language-btn';
	dropDownClass = '.ttv-language-dropdown';
	$(dropDownClass).hide();
	ttvDropDown(dropDownParentClass, dropDownClass, false);
	/********************* End Language DropDown js *****************************************/

	/********************* Start Currency DropDown js *****************************************/
	dropDownParentClass = '.ttvcms-header-currency .ttv-currency-btn';
	dropDownClass = '.ttv-currency-dropdown';
	$(dropDownClass).hide();
	ttvDropDown(dropDownParentClass, dropDownClass, false);
	/********************* End Currency DropDown js *****************************************/

	/********************* Start Mobile View js *****************************************/
	
	function showView(){
		if (document.body.clientWidth <= mobileViewSize) {//for mobile view
			 // moveDataInMobileView('#ttvcmsdesktop-vertical-menu', '#ttvcmsmobile-vertical-menu');
			moveDataInMobileView('#ttvcmsdesktop-main-menu', '#ttvcmsmobile-horizontal-menu');
			// moveDataInMobileView('.ttvcmsheader-search', '#ttvcmsmobile-search');
		 	moveDataInMobileView('.ttvcmsheader-nav-right', '#ttvcmsmobile-header-right');
		 	moveDataInMobileView('#ttvcmsdesktop-logo', '#ttvcmsmobile-header-logo');
	 		// moveDataInMobileView('.ttvsearch-header-display-wrappper', '#ttvcmsmobile-vertical-menu');

			 // console.log('moveDataInMobileView');
		}else{//for desktop view
			// moveDataInDesktopView('#ttvcmsdesktop-vertical-menu', '#ttvcmsmobile-vertical-menu');
			// moveDataInMobileView('.ttvcmsheader-search', '#ttvcmsmobile-search');
			moveDataInDesktopView('.ttvcmsheader-nav-right', '#ttvcmsmobile-header-right');
			moveDataInDesktopView('#ttvcmsdesktop-logo', '#ttvcmsmobile-header-logo');
			// console.log('moveDataInDesktopView');
		}

		// if (document.body.clientWidth <= 575) {//In mobile view
			// moveDataInMobileView('.ttvmenu-button-wrapper', '#ttvcmsmobile-horizontal-menu-left');
		// }else{
		// 	moveDataInDesktopView('.ttvmenu-button-wrapper', '#ttvcmsmobile-horizontal-menu-left');
		// }
	}//showView

	function moveDataInMobileView(desktopClass, mobileClass) {    
		if($(desktopClass).html() != ''){
			$(mobileClass).html($(desktopClass).html());
			$(desktopClass).html('');
		}
	}

	function moveDataInDesktopView(desktopClass, mobileClass) {
		//console.log($(mobileClass).html());
		if($(mobileClass).html() !== ''){
			$(desktopClass).html($(mobileClass).html());      
			$(mobileClass).html('');
		}
	}

	showView();//default landing call for mobile view
	$(window).resize(function(){
		showView();
	});

	/********************* End Mobile View js *****************************************/

	/****************** Start Cart Js *******************************************/
	cartDropDownJs();
	$(window).resize(function() {
		cartDropDownJs();
	});

	function cartDropDownJs() {
		$(document).on('click', '#_desktop_cart .ttvheader-cart-wrapper a', function() {
			if (document.body.clientWidth <= mobileViewSize) {
				if ($('#_desktop_cart .ttvcmscart-show-dropdown').hasClass('open')) {
					$('#_desktop_cart .ttvcmscart-show-dropdown').removeClass('open');
				} else {
					removeDefaultDropdown();
					$('#_desktop_cart .ttvcmscart-show-dropdown').addClass('open');
				}
			}
		});

		$(document).on('mouseenter', '#_desktop_cart .ttvheader-cart-wrapper', function() {
			if (document.body.clientWidth > mobileViewSize) {
				removeDefaultDropdown();
				$('#_desktop_cart .ttvcmscart-show-dropdown').addClass('open');
			}
		});

		$(document).on('mouseleave', '#_desktop_cart .ttvheader-cart-wrapper', function() {
			if (document.body.clientWidth > mobileViewSize) {
				$('#_desktop_cart .ttvcmscart-show-dropdown').removeClass('open');
			}
		});
	} //cartDropDownJs
	/****************** End Cart Js *******************************************/

	//*************************start top-menu js *************************/

	$(window).resize(function(){
		$('.ttvmain-menu-dropdown').removeClass('open');
	});

	function DesktopMenu(ttv){
		if (document.body.clientWidth > mobileViewSize) 
		{
			var obj = ttv;
			var extraWidth = 0;
			var new_width_popup = 0;
			var wrapWidthPopup = $(obj).find('.ttvmain-menu-sub-menu').outerWidth(true);
			var wrapHeightPopup = $(obj).find('.ttvmain-menu-sub-menu').outerHeight(true);				
			var actualWidthPopup = $(obj).find('.ttvmain-menu-sub-menu').width();
			extraWidth = wrapWidthPopup - actualWidthPopup;
			var new_width_popup = $(obj).find('.ttvmain-menu-sub-menu .top-menu').outerWidth(true);
			var menuWidth = $('.ttvcmsmain-menu-wrapper').width();
			var subMenuLiWidth = $(obj).find('.ttvmain-menu-sub-menu > ul > li').outerWidth(true);
			var totalSubMenu = $(obj).find('.ttvmain-menu-sub-menu > ul > li').length;  
			var popupFinalWidth = (totalSubMenu * subMenuLiWidth)+40;
			var menuTopOffset = $(".ttvcms-header-menu-offer-wrapper").offset();//menu top margin or other spacing
			var menuLiHeightOffset  = $(obj).offset();//menu inside top position like table
			var menuLiHeight  = $(obj).outerHeight(true);//line height of menu
			var menuPopopTop  = (menuLiHeightOffset.top - menuTopOffset.top) + menuLiHeight;

			var new_outer_width_popup = new_width_popup + extraWidth;
			if(popupFinalWidth > menuWidth){
				popupFinalWidth = menuWidth+40;
			}
			if(popupFinalWidth > new_outer_width_popup){
				new_outer_width_popup = popupFinalWidth;
			}
			if(wrapHeightPopup >= 400){//auto scroll when popup is bigger
				$(obj).find('.ttvmain-menu-sub-menu').addClass('ttv-auto-scroll');
			}else{
				$(obj).find('.ttvmain-menu-sub-menu').removeClass('ttv-auto-scroll');
			}
			var wraper = $('.ttvcmsmain-menu-wrapper');
			var wWraper = wraper.outerWidth();
			var posWraper = wraper.offset();
			var pos = $(obj).offset();
			var xLeft = pos.left - posWraper.left;
			if ((xLeft + new_outer_width_popup) > wWraper) xLeft = wWraper - new_outer_width_popup;
			$(obj).find('.ttvmain-menu-sub-menu').css('left', xLeft);
			$(obj).find('.ttvmain-menu-sub-menu').css('top',menuPopopTop);
			$(obj).find('.ttvmain-menu-sub-menu').css('width', popupFinalWidth);
			//$(obj).find('.ttvmain-menu-sub-menu').stop(true, true).slideDown(500, 'swing');//show popup
			$(obj).find('.ttvmain-menu-sub-menu').addClass('ttv-desk-open');
			
		}
	}
	$('.ttvmenu-toggle-icon').click(function(){
		DesktopMenu($(this).parent().parent());
	});

	$('.ttvcmsmain-menu-wrapper > .ttv-header-menu > li').hover(function() {
		DesktopMenu(this);
	},function(){
		$(this).find('.ttvmain-menu-sub-menu').removeClass('ttv-desk-open');//hide popup
	});

	$(document).on('click','#ttvcms-mobile-view-header .ttvmenu-button', function(e){
		e.preventDefault();
		if ($('#ttvcmsmobile-horizontal-menu #ttv-top-menu').hasClass('open')) {
			$('#ttvcmsmobile-horizontal-menu #ttv-top-menu').removeClass('open');
			$('.modal-backdrop.fade.in').remove();
		} else {
			removeDefaultDropdown();
			$('#ttvcmsmobile-horizontal-menu #ttv-top-menu').addClass('open');
			if ($('body').find('.modal-backdrop.fade').html() === undefined){
	       		$('body').append('<div class="modal-backdrop fade in"></div>');
          	}
			e.stopPropagation();
		}
	});

	$(document).on('click','.modal-backdrop.fade',function(){
		$('#ttvcmsmobile-horizontal-menu #ttv-top-menu').removeClass('open');
		$(this).remove();
	});
	
	$(document).on('click','#ttvcmsmobile-horizontal-menu #ttv-top-menu .ttvhorizontal-menu-drop-down-icon', function(e){
		$(this).parent().parent().find('.ttvmain-menu-mobile-dropdown').css('display','block');
	});

	$(document).on('click', '#ttvcmsmobile-horizontal-menu .ttv-has-child .ttvmenu-link-wrapper .ttvmenu-toggle-icon i', function(){
		if ($(this).hasClass('open')) {
			$(this).removeClass('open');
			$(this).parent().parent().next('.ttvmain-menu-mobile-dropdown').removeClass('open').stop(false).slideUp(500, "swing");
		} else {					
			$('#ttvcmsmobile-horizontal-menu .ttvmain-menu-dropdown').css('left', '0').css('top','0').css('width', '100%');
			$(this).addClass('open');
			$(this).parent().parent().next('.ttvmain-menu-mobile-dropdown').addClass('open').stop(false).slideDown(500, "swing");
		}
	});


	//************************************end Top-menu js******************************************************/
	
		/******************* Start Menu Sticky Js ********************************************/
	menuStickyJs();
	$(document).on('scroll', function(){
		var menu_sticky =  localStorage.getItem('menu-sticky') || 'true';
		if(menu_sticky == 'true'){
			menuStickyJs();
		}else{
			$('.ttvcms-header-menu-offer-wrapper').removeClass('sticky');
		}
		bottomTotop();
	});
	
	function menuStickyJs(){
		var checkMenuSticky = $('body').attr('data-menu-sticky');
		if (checkMenuSticky == '1') {
			var startMenuStickyHeight = 450;
			var scrollHeight = $(document).scrollTop();
			if (document.body.clientWidth > mobileViewSize) {
				// Desktop View Sticky
				if (scrollHeight > startMenuStickyHeight) {
					$('.ttvcms-header-menu-offer-wrapper').addClass('sticky');
					$('#wrapper').css('margin-top', $('.ttvcms-header-menu-offer-wrapper').height()+'px');
				} else{
					$('.ttvcms-header-menu-offer-wrapper').removeClass('sticky');
					$('#wrapper').css('margin-top','0px');
				}
			}
		}
	}
	function bottomTotop(){
		var startMenuStickyHeight = 450;
		var scrollHeight = $(document).scrollTop();
		if (scrollHeight > startMenuStickyHeight) {
			$('.ttvbottom-to-top').fadeIn('slow');
		} else {
			$('.ttvbottom-to-top').fadeOut('slow');
		}
	}
	/******************* End Menu Sticky Js ********************************************/

	/****************** Start Product Timer Js *******************************************/
	var result = setInterval(function() {
		$('.ttvproduct-timer').each(function() {
			var time = $(this).attr('data-end-time');

			var countDownDate = new Date(time.replace(/ /g, "T") + 'Z');
			var now = new Date().getTime();

			var distance = countDownDate - now;

			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			var data = days + '' + hours + '' + minutes + '' + seconds + '';

			$(this).find('.ttvproduct-timer-box .days').html(days);
			$(this).find('.ttvproduct-timer-box .hours').html(hours);
			$(this).find('.ttvproduct-timer-box .minutes').html(minutes);
			$(this).find('.ttvproduct-timer-box .seconds').html(seconds);
			$(this).find('.complated').hide();

			if (distance < 0) {
				clearInterval(x);
				data = "complate";
				$(this).find('.ttvproduct-timer-wrapper').hide();
				$(this).find('.ttvproduct-timer-complated').show(data);
			}
		});
			ttvallprodctbalance();
	}, 1000);
	/****************** End Product Timer Js *******************************************/
	/******** Start Scroll to Top js ***************************/
	$(document).on('click', '.ttvbottom-to-top .ttvbottom-to-top-icon', function() { // When arrow is clicked
		scrollToTop();
	});

	function scrollToTop() {
		$('body,html').animate({
			scrollTop: 0 // Scroll to top of body
		}, 500);
	}
	/******** End Scroll to Top js ***************************/
	/*************** Start Left Right Column Js *************************************************/

	// Left panel hide show.
	$(document).on('click', '.ttvcms-left-column-wrapper .ttv-left-pannal-btn-wrapper', function(e) {
		e.preventDefault();
		if ($('#column-left').hasClass('open')) {
			$('#column-left').removeClass('open');
			$('.modal-backdrop.fade.in').remove();
		} else {
			$('#column-left').addClass('open');
			$('body').append('<div class="modal-backdrop fade in"></div>');
			e.stopPropagation();
		}
	});

	// Right Panel Hide show
	$(document).on('click', '.ttvcms-right-column-wrapper .ttv-right-pannal-btn-wrapper', function(e) {
		e.preventDefault();
		if ($('#column-right').hasClass('open')) {
			$('#column-right').removeClass('open');
			$('.modal-backdrop.fade.in').remove();
		} else {
			$('#column-right').addClass('open');
			$('body').append('<div class="modal-backdrop fade in"></div>');
			e.stopPropagation();
		}
	});

	$(document).on('click', '#column-left .ttvleft-column-close-btn, #column-right .ttvright-column-close-btn', function() {
		if ($(this).parent().parent().hasClass('open')) {
			$('.ttv-left-right-panel-hide').removeClass('open');
			$('.modal-backdrop.fade.in').remove();
		}
	});

	// Left - right Panel Close. 
	$(document).on('click', '.modal-backdrop.fade.in', function() {
		if ($('#column-left.ttv-left-right-panel-hide, #column-right.ttv-left-right-panel-hide').hasClass('open')) {
			$('#column-left.ttv-left-right-panel-hide, #column-right.ttv-left-right-panel-hide').removeClass('open');
			$('.modal-backdrop.fade.in').remove();
		}
	});

	/******************  left account/information Js *******************************************/
	accountInfoTitleToggle();
	$(window).resize(function() {
		accountInfoTitleToggle();
	});

	function accountInfoTitleToggle() {
		$('.ttvleft-right-title-toggle').on('click', function(e) {
			e.preventDefault();
			if (document.body.clientWidth <= mobileViewSize) {
				if ($(this).hasClass('open')) {
					$(this).removeClass('open');
					$(this).parent().parent().find('.ttv-accountinfo-wrapper').removeClass('open').stop(false).slideUp(500, "swing");
				} else {
					$(this).addClass('open');
					$(this).parent().parent().find('.ttv-accountinfo-wrapper').addClass('open').stop(false).slideDown(500, "swing");
				}
			}
			e.stopPropagation();
		});
	}
	/****************** End account/information Js *******************************************/

	/******************************** tooltip ************************/
	$(function() {
		'use strict';

		var popoverConfig = {
			trigger: 'hover',
			template: [
				'<div class="popover ttvtooltip" role="tooltip">',
				'<div class="popover-arrow"></div>',
				'<h3 class="popover-title"></h3>',
				//'<div class="popover-content"></div>',
				'</div>'
			].join(''),
			placement: 'top',
			container: 'body',
		};

		initPopovers();

		function initPopovers() {
			$('[data-toggle="ttvtooltip"]').popover(popoverConfig);
		}
	});
	/*************** end tooltip***********************/

	/*********************** Start Product Category page View ******************************/
	// Start Grid View
	function removeClassesOfView() {
		$('#products').removeClass('grid grid-2 list list-2 catalog');
	}

	$(document).on('click', '.ttvcmsproduct-grid-list .ttvproduct-grid', function() {
		removeClassesOfView();
		$('#products').addClass('grid');
		$('.gridimg1').removeClass('hidden');
		$('.gridimg').addClass('hidden');
	});
	// End Grid View

	// Start Grid-2 View
	$(document).on('click', '.ttvcmsproduct-grid-list .ttvproduct-grid-2', function() {
		removeClassesOfView();
		$('.gridimg').removeClass('hidden');
		$('.gridimg1').addClass('hidden');
		$('#products').addClass('grid-2');
	});
	// End Grid-2 View

	// Start List View
	$(document).on('click', '.ttvcmsproduct-grid-list .ttvproduct-list', function() {
		removeClassesOfView();
		$('#products').addClass('list');
	});
	// End List View

	// Start List-2 View
	$(document).on('click', '.ttvcmsproduct-grid-list .ttvproduct-list-2', function() {
		removeClassesOfView();
		$('#products').addClass('list-2');
	});
	// End List-2 View

	// Start catalog View
	$(document).on('click', '.ttvcmsproduct-grid-list .ttvproduct-catalog', function() {
		removeClassesOfView();
		$('#products').addClass('catalog');
	});
	// End catalog View

	/*********************** End Product Category page View ******************************/
	/******************* Start Footer Toggle ***********************************************/
	$('.footer-container .ttvfooter-title-wrapper').on('click',function(e){
		if (document.body.clientWidth > mobileViewSize) {
			e.stopPropagation();
		}
	});
	/******************* End Footer Toggle ***********************************************/
	changeTabTitles();
	$(window).resize(function(){
		changeTabTitles();
	});
	function changeTabTitles()
	{
	 	if (document.body.clientWidth <= 767 && document.body.clientWidth > 575) {
	 		$('.ttvtab-product .ttvtab-title-wrapper').insertAfter('.ttvtab-product .ttvcmsmain-title-wrapper');
	 	} else {
	 		$('.ttvtab-product .ttvtab-title-wrapper').insertAfter('.ttvtab-product .ttvcmsmain-title-wrapper .ttvcms-main-title');
	 	}
	}

	$(document).on('click','.ttvcms-header-menu .ttvmain-menu-open', function(){
  		if(document.body.clientWidth >= 768 ) {
			$(this).addClass('open');
			$('.ttvcms-header-menu').find('.ttvcmsheader-main-menu-wrapper').addClass('open');
			$('body').addClass('ttvactive-search');
		}
  	});

	$(document).on('click','.ttvcms-header-menu .ttvmain-menu-close', function(){
  		if(document.body.clientWidth >= 768 ) {
			$(this).removeClass('open');
			$('.ttvcms-header-menu').find('.ttvcmsheader-main-menu-wrapper').removeClass('open');
			$('body').removeClass('ttvactive-search');
		}
  	});
});
/**************** Start catalog Quentity Increment Decrement *************************/

$(document).on('click', '.ttvproduct-cart-quentity-increment', function() {
	var obj = $(this).parent();
	var qty = parseInt(obj.find('.ttvproduct-cart-quentity').val()) + 1;
	obj.find('.ttvproduct-cart-quentity').val(qty);
});

$(document).on('click', '.ttvproduct-cart-quentity-decrement', function() {
	var obj = $(this).parent();
	var qty = parseInt(obj.find('.ttvproduct-cart-quentity').val()) - 1;
	if (qty >= 1) {
		obj.find('.ttvproduct-cart-quentity').val(qty);
		obj.parent().find('.ttvproduct-cart-catalog-btn form input[name=qty]').val(qty);
	}
});

$(document).on('blur', '.ttvproduct-cart-quentity', function() {
	var obj = $(this).parent();
	var qty = parseInt(obj.find('.ttvproduct-cart-quentity').val());
	if (qty > 1 && qty != NaN) {
		obj.find('.ttvproduct-cart-quentity').val(qty);
		obj.parent().find('.ttvproduct-cart-catalog-btn form input[name=qty]').val(qty);
	} else {
		qty = 1;
		obj.find('.ttvproduct-cart-quentity').val(qty);
		obj.parent().find('.ttvproduct-cart-catalog-btn form input[name=qty]').val(qty);
	}
});

/**************** End catalog Quentity Increment Decrement *************************/

$(document).ready(function () {
		// **********************START MOUSE HOVER*****************
		var mousehover = $('.mousehoverimage').text();
		if (mousehover != 1) {
			$('.ttvproduct-hover-img').hide();
		}
		// **********************ENd MOUSE HOVER*******************
		var mobileViewSize = 991;
		if (document.body.clientWidth > mobileViewSize) {
			if($('.ttv-category-sub-page')[0]){
				if (!$('#column-left').parent().hasClass('row')) {
					$('#column-left,#column-right,#content-wrapper').wrapAll("<div class='row'></div>");					
				} 
			}
			else {
				if ($('#column-left.ttv-left-right-panel-hide').parent().hasClass('row')) {
					$('#column-left.ttv-left-right-panel-hide').removeClass('row');
				}
				else if ($('#column-right.ttv-left-right-panel-hide').parent().hasClass('row')) {
					$('#column-right.ttv-left-right-panel-hide').removeClass('row');
				}
			}
			if ($('#js-product-list').html() !== undefined){
				$('#content-wrapper').parent().removeClass('row');
			}
		}
});

/*start quickview*/
$(document).on('click', '.ttvproduct-quick-btn.quickview', function() {
	var product_id = $(this).attr('data-quickviewid');
	var obj = $('.modal-body');
	obj.html('');
	if (product_id.length != 0) {
		$.ajax({
			type: 'POST',
			url: 'index.php?route=common/tvcmscustomlink/quickview&product_id=' + encodeURIComponent(product_id),
			cache: false,
          	contentType: false,
         	processData: false,
			success: function(data) {
				obj.html(data);
				$('#quickviewdata').modal('show');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	}
});
/*end quickview */

$(window).resize(function(){
	ttvallprodctbalance();
});
function ttvallprodctbalance(){
	$(".ttvproduct-wrapper.grid .product-description").balance();
	$(".ttvproduct-wrapper.grid-2 .product-description").balance();
}
 /*************** Start left Right  Product Toggle in Mobile Size ***************************************************/
  leftRightProductTitleToggle();
  $(window).resize(function(){
    $('.ttvleft-right-penal-all-block .ttvleft-right-title-toggle, .ttvleft-right-penal-all-block .ttvleft-product-wrapper-info').removeClass('open');
    leftRightProductTitleToggle();
  });
  function leftRightProductTitleToggle()
  {
    $('.ttvleft-right-penal-all-block .ttvleft-right-title-toggle').on('click', function(e){
      e.preventDefault();
      if(document.body.clientWidth <= 1199){
        if($(this).hasClass('open')) {
          $(this).removeClass('open');
          $(this).parent().parent().find('.ttvleft-product-wrapper-info').removeClass('open').stop(false).slideUp(500, "swing");
        } else {
          $(this).addClass('open');
          $(this).parent().parent().find('.ttvleft-product-wrapper-info').addClass('open').stop(false).slideDown(500, "swing");
        }
      }
      e.stopPropagation();
    });
  }
  /*************** End left Right  Product Toggle in Mobile Size ***************************************************/
