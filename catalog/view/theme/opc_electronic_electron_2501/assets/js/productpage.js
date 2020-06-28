/*******************************ralateproduct*******************************/

$('.ttvrelated-product-wrapper').owlCarousel({
	loop: false,
	dots: false,
	nav: false,
	responsive: {
		0: { items: 1 },
		320: { items: 1, slideBy: 1 },
		575: { items: 2, slideBy: 1 },
		690: { items: 3, slideBy: 1 },
		768: { items: 3, slideBy: 1 },
		850: { items: 3, slideBy: 1 },
		992: { items: 3, slideBy: 1 },
		1200: { items: 4, slideBy: 1 },
		1600: { items: 4, slideBy: 1 },
		1800: { items: 4, slideBy: 1 }
	},
});

$('.ttvcmsrelated-next-pre-btn .ttvcmsrelated-prev ').click(function(e) {
	e.preventDefault();
	$('.ttvrelated-product-wrapper .owl-nav .owl-prev').trigger('click');
});
$('.ttvcmsrelated-next-pre-btn .ttvcmsrelated-next ').click(function(e) {
	e.preventDefault();
	$('.ttvrelated-product-wrapper .owl-nav .owl-next').trigger('click');
});
/*$(owlClass[i][3]+' .ttv-pagination-wrapper').insertAfter(owlClass[i][3]+' .ttvproduct-wrapper-content-box');
*//*******************************ralateproduct*******************************/

<!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function() {
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert-dismissible, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});

$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert-dismissible, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {

				if (!!$.prototype.fancybox)
					$.fancybox.open([{
						type: 'inline',
						autoScale: true,
						minHeight: 30,
						minWidth: "40%",
						content: '<p class="fancybox-success"> ' + json['success'] + ' </p>'
					}], {
						padding: 0
					});
				else
					alert(full_notic);


				var re = new RegExp(/^\d+/);
				var m = re.exec(json['total']);

				// Need to set timeout otherwise it wont update the total
				setTimeout(function() {
					$('.cart-total').html(m);
				}, 100);


				//$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cartdropdwon > ul').load('index.php?route=common/cart/info ul li');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('.date').datetimepicker({
	language: '{{ datepicker }}',
	pickTime: false
});

$('.datetime').datetimepicker({
	language: '{{ datepicker }}',
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	language: '{{ datepicker }}',
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
		clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#review').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#review').fadeOut('slow');

	$('#review').load(this.href);

	$('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id={{ product_id }}');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id={{ product_id }}',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-dismissible').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$(document).ready(function() {
	var magnific = $('.thumbnails').magnificPopup({
		type: 'image',
		delegate: 'a',
		gallery: {
			enabled: true
		}
	});
	magnific.off('click');
	// prevent the default click event of the link so it will no redirect to the `href`
	magnific.on('click', function(e) {
	  e.preventDefault();
	});
	magnific.on('dblclick', function(){
	  magnific.magnificPopup('open')
	});



	/*******************************single image*******************************/
	$('.ttvsingimage-content-box').owlCarousel({
		loop: false,
		dots: false,
		nav: false,
		responsive: {
			0: { items: 1 },
			320: { items: 2, slideBy: 1 },
			400: { items: 3, slideBy: 1 },
			575: { items: 4, slideBy: 1 },
			768: { items: 2, slideBy: 1 },
			800: { items: 3, slideBy: 1 },
			992: { items: 4, slideBy: 1 },
			1200: { items: 3, slideBy: 1 },
			1800: { items: 3, slideBy: 1 }
		},
	});
	$('.ttvcms-singleimage-pagination-btn .ttvsingleimage-prev').click(function(e) {
		e.preventDefault();
		$('.ttvsingimage-content-box .owl-nav .owl-prev').trigger('click');
	});
	$('.ttvcms-singleimage-pagination-btn .ttvsingleimage-next').click(function(e) {
		e.preventDefault();
		$('.ttvsingimage-content-box .owl-nav .owl-next').trigger('click');
	});
	/*******************************single image*******************************/

	/*product page review button */
	$(".reviews_button").click(function() {
		var tabTop = $(".producttab").offset().top - 160;
		$("html, body").animate({ scrollTop: tabTop }, 1000);
	});

});
if (document.body.clientWidth > 991) {
	var href1 = $('#img_zoom').attr('src');
	$("#img_zoom").elevateZoom({
		zoomType: "inner",
		cursor: "crosshair",
		bgimg : href1
	});
}
$('.thumbnail').click(function(){
	var href = $(this).attr('href');
	$('#img_zoom').attr('src',href);  
	$('#img_zoom').attr('data-zoom-image',href);  
	if (document.body.clientWidth > 991) {
		$("#img_zoom").elevateZoom({
			zoomType: "inner",
			cursor: "crosshair",
			bgimg : href
		});
	}
});
/*zoom product page image */
	/* end */
//-->