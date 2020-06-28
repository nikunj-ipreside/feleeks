var storage = $.localStorage;



/************************** Start Custom Theme Option ***************************************/
 function getBaseURL() {
        var loc = window.location;
        var baseURL = loc.protocol + "//" + loc.hostname;
        if (typeof loc.port !== "undefined" && loc.port !== "") baseURL += ":" + loc.port;
        // strip leading /
        var pathname = loc.pathname;
        if (pathname.length > 0 && pathname.substr(0,1) === "/") pathname = pathname.substr(1, pathname.length - 1);
        var pathParts = pathname.split("/");
        if (pathParts.length > 0) {
            for (var i = 0; i < pathParts.length; i++) {
                if (pathParts[i] !== "") baseURL += "/" + pathParts[i];
            }
        }
        return baseURL;
    }
$(document).ready(function(){	

	function getUrlVars(){
      var vars = [], hash;
      var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++){
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      return vars;
    }//function getUrlVars()

    /******start init*******/
    var urll = getBaseURL();
    var cssurl = urll.replace('/index.php','');
    var cssPath = cssurl + '/catalog/view/theme/opc_electronic_electron_2501/assets/css/';
    // console.log(cssPath+"theme-custom.css");//theme-custom.css
    var demo_theme = getUrlVars()["demo-theme"];

	$('#themecolor1').minicolors();
    $('#themebgcolor2').minicolors();
	/******end init*******/
  function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
  }

	function setCustomeTheme(){ 
    $.get( cssPath+"theme-custom.css", function( data ) {
      // console.log(cssPath + "theme-custom.css");
     $('.ttvcms-custom-theme').html('');
     if (storage.get("theme_color") != '' && storage.get("theme_color") != undefined) {
        data = replaceAll(data,'#maincolor1',storage.get("theme_color"));
        $(".ttvcms-custom-theme").html( "<style>"+data+"</style>");
     }
    });
  }
	function setBoxLayout(obj){
      if($(obj).find('.toggle.btn.btn-default').hasClass('off')){
          $('.ttv-main-div').addClass('ttv-box-layout container');
          $('.ttv-main-div').removeClass('ttv-full-layout');

          $('.ttvtheme-background-patten, .ttvtheme-background-color').show();
          if(storage.get("theme-bg-status")){
          	$('body').css('background-image',storage.get("theme-bg-pattern"));
        	$('body').css('background-color','');
          }else{
			$('body').css('background-color', storage.get("theme-bg-color"));
        	$('body').css('background-image', "");
          }          
          storage.set("box-layout", true);//save localStorage
      }else{
          $('.ttv-main-div').addClass('tvcms-full-layout');
          $('.ttv-main-div').removeClass('ttv-box-layout container');

          $('.ttvtheme-background-patten, .ttvtheme-background-color').hide();
          storage.set("box-layout", false);//save localStorage
      }
    }
    function getPattenSetting(obj){
      	// $(obj).addClass('active');
        $('.ttvtheme-pattern-image').each(function(){
          if ($(this).css('background-image') == storage.get("theme-bg-pattern")) {
            $(this).addClass('active');
          }
        });
        $('body').css('background-image',storage.get("theme-bg-pattern"));
        $('body').css('background-color','');
    }
    function getBgColorSetting(obj){
		$('body').css('background-color', storage.get("theme-bg-color"));
        $('body').css('background-image', "");
        obj.parent().find('.minicolors-swatch-color').css('background-color',storage.get("theme-bg-color"));
    }
	function getCustomSetting(){
		if(!storage.get("themeControl")){
        	resetCustomSetting();
    	}
    	$('.ttvselect-theme #select_theme option[value="' + storage.get("theme") + '"]').prop('selected', true);
    	setCustomeTheme();
		if($('.ttvselect-theme #select_theme').val().match(/theme_custom/g)){
			$('.ttvtheme-color-one').show();
			$('#themecolor1').parent().find('.minicolors-swatch-color').css('background-color',storage.get("theme_color"));
		}else{
			$('.ttvtheme-color-one').hide();
		}
		if(storage.get("box-layout")){
			var obj = $(".ttvtheme-box-layout-option");
			setBoxLayout(obj);
	        if(storage.get("theme-bg-status")){
	        	getPattenSetting($('.ttvtheme-pattern-image'));
	        }else{
				getBgColorSetting($('#themebgcolor2'));
	        }
	        obj.trigger('click');
	    }else{
	    	$('.ttvtheme-background-patten, .ttvtheme-background-color').hide();
	    }
	    if(!storage.get("menu-sticky")){
	    	$('.ttvtheme-menu-sticky-option').trigger('click');
	    }
	}
	function resetCustomSetting(){
		storage.removeAll();
	    storage.set("themeControl", true);
	    storage.set("theme", "");
	    storage.set("theme_color", "");
	    storage.set("box-layout", false);
	    storage.set("menu-sticky", true);
	    storage.set("themeColor1", '#fff');//default color1
	    var urll = getBaseURL();
      var cssurl = urll.replace('/index.php','');
      var cssPathpattern = cssurl + '/image/catalog/themevolty/pattern/pattern14.png';

      storage.set("theme-bg-pattern", "url("+ cssPathpattern +")");//save storage
	    storage.set("theme-bg-color", '#000');//default color2
	    storage.set("theme-bg-status", true);//patten bg*/
	}

	$(window).load(function(){
		getCustomSetting();
	});

	$('.ttvcmstheme-control .ttvtheme-control-icon').click(function(){
		//console.log('click');
		var themeOptionWrapper = $('.ttvcmstheme-control .ttvtheme-control-wrapper');
		if(themeOptionWrapper.hasClass('open')){
			themeOptionWrapper.removeClass('open');
      $('.ttvcmstheme-control').removeClass('open');
		}else{
			themeOptionWrapper.addClass('open');
      $('.ttvcmstheme-control').addClass('open');
		}
	});

	$('.ttvselect-theme #select_theme').on('change',function(e){
      e.preventDefault();
      var themeVal = $(this).val();
      var themeColorVal = $('option:selected', this).attr('data-color');
      // console.log(themeColorVal);
      storage.set("theme", themeVal);//save localStorage
      storage.set("theme_color", themeColorVal);//save localStorage
      $('.ttvtheme-color-one').hide();
      if(themeVal == ""){
        $('.ttvcms-custom-theme').html("");
      	$('.minicolors .themecolor1').hide();
      }else if(themeVal.match(/theme_custom/g)){
      	  $('.ttvtheme-color-one').show();
      	  var theme_color = $('#themecolor1').val();
      	  storage.set("theme_color", theme_color);
      	  setCustomeTheme();
      }else{
          setCustomeTheme();
      }
    });
    $('#themecolor1').on('change',function(e){      
      var theme_color = $(this).val();
      storage.set("theme_color", theme_color);
       setCustomeTheme();
    });
   
    $('.ttvtheme-box-layout-option').on('click',function(e){
      setBoxLayout(this);
    }); 
    $('.ttvtheme-pattern-image').on('click',function(e){
    	$('.ttvtheme-pattern-image').removeClass('active');
      	$(this).addClass('active');
        $('body').css('background-image',$(this).css('background-image'));
        storage.set("theme-bg-pattern", $(this).css('background-image'));//save localStorage
        $('body').css('background-color','');
        storage.set("theme-bg-status",true);
    });
     $('#themebgcolor2').on('change',function(e){
		$('body').css('background-color', $(this).val());
        $('body').css('background-image', "");     
        storage.set("theme-bg-status", false);
        storage.set("theme-bg-color", $(this).val());
    });
    $('.ttvtheme-menu-sticky-option').on('click',function(e){
      if($(this).find('.toggle.btn.btn-default').hasClass('off')){
        $('#header').addClass('sticky');
        storage.set("menu-sticky", true);//save localStorage
      }else{
        $('#header').removeClass('sticky');
        $('#wrapper').css('margin-top', '0px');
        storage.set("menu-sticky", false);//save localStorage
      }
    });
 	$('.ttvtheme-control-reset').on('click',function(e){
      resetCustomSetting();
      location.reload(); 
    });
});

/************************** End Custom Theme Option ***************************************/