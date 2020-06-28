  var voucher = {
  'add1': function() {

  },
  'remove1': function(key) {
    $.ajax({
      url: 'index.php?route=checkout/cart/remove',
      type: 'post',
      data: 'key=' + key,
      dataType: 'json',
      beforeSend: function() {
        $('#_desktop_cart > button').button('loading');
      },
      complete: function() {
        $('#_desktop_cart > button').button('reset');
      },

      success: function(json) {
        // Need to set timeout otherwise it wont update the total
        var re = new RegExp(/^\d+/); 
        var m = re.exec(json['total']);

          // Need to set timeout otherwise it wont update the total
          setTimeout(function () {
            $('.cart-total').html(m);
          }, 100);

        if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
          location = 'index.php?route=checkout/cart';
        } else {
          $('#cartdropdwon > ul').load('index.php?route=common/cart/info ul li');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }
}

var cart = {
  'add1': function(product_id, quantity) {
    quantity = $('#cart_quantity'+ product_id +'').val();
    $.ajax({
      url: 'index.php?route=checkout/cart/add',
      type: 'post',
      data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
      dataType: 'json',
      beforeSend: function() {
        $('#_desktop_cart > button').button('loading');
      },
      complete: function() {
        $('#_desktop_cart > button').button('reset');
      },
      success: function(json) {
        $('.alert-dismissible, .text-danger').remove();

        if (json['redirect']) {
          location = json['redirect'];
        }

        if (json['success']) {

          if (!!$.prototype.fancybox){
                      $.fancybox.open([
                          {
                              type: 'inline',
                              autoScale: true,
                              minHeight: 30,
                              minWidth: "40%",
                              content: '<p class="fancybox-success"> ' + json['success'] + ' </p>'
                          }
                      ], {
                          padding: 0
                      });
                  }else{
                      alert(full_notic);
                  } 

          var re = new RegExp(/^\d+/); 
          var m = re.exec(json['total']);

          // Need to set timeout otherwise it wont update the total
          setTimeout(function () {
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
  },
  'update1': function(key, quantity) {
    $.ajax({
      url: 'index.php?route=checkout/cart/edit',
      type: 'post',
      data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
      dataType: 'json',
      beforeSend: function() {
        $('#_desktop_cart > button').button('loading');
      },
      complete: function() {
        $('#_desktop_cart > button').button('reset');
      },
      success: function(json) {
        // Need to set timeout otherwise it wont update the total

        var re = new RegExp(/^\d+/); 
          var m = re.exec(json['total']);

          // Need to set timeout otherwise it wont update the total
          setTimeout(function () {
            $('.cart-total').html(m);
          }, 100);

        if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
          location = 'index.php?route=checkout/cart';
        } else {
          $('#cartdropdwon > ul').load('index.php?route=common/cart/info ul li');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'remove1': function(key) {
    $.ajax({
      url: 'index.php?route=checkout/cart/remove',
      type: 'post',
      data: 'key=' + key,
      dataType: 'json',
      beforeSend: function() {
        $('#_desktop_cart > button').button('loading');
      },
      complete: function() {
        $('#_desktop_cart > button').button('reset');
      },
      success: function(json) {
          // Need to set timeout otherwise it wont update the total
          var re = new RegExp(/^\d+/); 
          var m = re.exec(json['total']);

          // Need to set timeout otherwise it wont update the total
          setTimeout(function () {
            $('.cart-total').html(m);
          }, 100);


        if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
          location = 'index.php?route=checkout/cart';
        } else {
          $('#cartdropdwon > ul').load('index.php?route=common/cart/info ul li');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }
}

var wishlist = {
  'add1': function(product_id) {
    $.ajax({
      url: 'index.php?route=account/wishlist/add',
      type: 'post',
      data: 'product_id=' + product_id,
      dataType: 'json',
      success: function(json) {
        console.log(json);
        $('.alert-dismissible').remove();

        if (json['redirect']) {
          location = json['redirect'];
        }
        //js themevolty error// 
        if (json['success']) {

          if (!!$.prototype.fancybox){
                      $.fancybox.open([
                          {
                              type: 'inline',
                              autoScale: true,
                              minHeight: 30,
                              minWidth: "40%",
                              content: '<p class="fancybox-success"> ' + json['success'] + ' </p>'
                          }
                      ], {
                          padding: 0
                      });
                  }else{
                      alert(full_notic);
                  } 

        }

        thenum = json['total'].match(/\d+/)[0];
        

        $('.cart-wishlist-number').html(thenum);

        $('#wishlist-total').attr('title', json['total']);

        //$('html, body').animate({ scrollTop: 0 }, 'slow');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'remove': function() {

  }
}

var compare = {
  'add1': function(product_id) {
    $.ajax({
      url: 'index.php?route=product/compare/add',
      type: 'post',
      data: 'product_id=' + product_id,
      dataType: 'json',
      success: function(json) {
        $('.alert-dismissible').remove();
        if (json['success']) {
          if (!!$.prototype.fancybox){
                      $.fancybox.open([
                          {
                              type: 'inline',
                              autoScale: true,
                              minHeight: 30,
                              minWidth: "40%",
                              content: '<p class="fancybox-success"> ' + json['success'] + ' </p>'
                          }
                      ], {
                          padding: 0
                      });
                  }else{ 
                      alert(full_notic);
                    }

          //$('#content').parent().before('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          thenum = json['total'].match(/\d+/)[0];
        
          $('.count-product').html(thenum);

          //$('html, body').animate({ scrollTop: 0 }, 'slow');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'remove': function() {

  }
}
