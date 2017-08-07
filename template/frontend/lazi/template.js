var laziAlert = {
    alertSuccess: function(content){
        toastr.options = {
            "closeButton": true,
            "timeOut": 5000,
        };
        toastr.success(content);
    },
    alertError: function(content){
        toastr.options = {
            "closeButton": true,
            "timeOut": 5000,
        };
        toastr.error(content);
    },
    alertAddItem: function(content){
        toastr.options = {
            "closeButton": true,
            "timeOut": 5000,
        };
        toastr.success(content);
    }
}

function loadDistricts(md6_id) {
  var ajax = jQuery.post('cart/ajax_loadDistricts/' + md6_id);

  ajax.success(function (html) {
    jQuery('select[name=district]').html(html);
    jQuery('select[name=id_ship_fee]').html('<option value="">Vui lòng chọn Phương thức Giao hàng</option>');
  });
}

function loadShipFee(md6_id) {
  var ajax = jQuery.post('cart/ajax_loadShipFee/' + md6_id);

  ajax.success(function (html) {
    jQuery('select[name=id_ship_fee]').html(html);
  });
}

function checkCoupon(couponCode){
  laziCart.checkCouponCode(couponCode)
          .then(function(data_log){
            // console.log(data_log);
            if(data_log.status=='success'){
              laziAlert.alertSuccess('<strong>' + data_log.info.title + '</strong><br>Mã Giảm giá hợp lệ!');
            }else{
              laziAlert.alertError(data_log.log);
            }
          });
}

function reloadTotal(){
  var data = {
        id_ship_fee: $('select[name=id_ship_fee]').val(),
        coupon_code: $('input[name=coupon_code]').val()
      },
      ajax = jQuery.post('cart/ajax_reloadTotal', data);

  ajax.success(function (html) {
    jQuery('#totalReload').html(html);
  }); 

}

// function qtyDown(id) {
//   qty_el = document.getElementById('qty_' + id);
//   qty = qty_el.value;
//   if (!isNaN(qty) && qty > 1) {
//     qty_el.value = parseInt(qty_el.value) - 1
//   }
//   return false;
// }

// function qtyUp(id) {
//   qty_el = document.getElementById('qty_' + id);
//   qty = qty_el.value;
//   if (!isNaN(qty) && qty < 10) {
//     qty_el.value = parseInt(qty_el.value) + 1
//   }
//   return false;
// }

// function load_more(page, alias, ctrl, button) {
//   var data = {
//       page: page,
//       alias: alias,
//     };

//   switch (ctrl) {
//     case 'article':
//       var ajax = jQuery.post('article/load_more', data);
//       break;
//     case 'product':
//       var ajax = jQuery.post('product/load_more', data);
//       break;
//   }

//   ajax.success(function (html) {
//     jQuery(button).parent('.ws-more-btn-holder').before(html);
//     jQuery(button).data('val', (jQuery(button).data('val') + 1));

// //  reload #box_more
//   });
// }

// jQuery(document).ready(function () {
//   loadCartByAjax();

//   jQuery('input.pressnumber').keyup(function () {
//       var val = jQuery(this).val().replace(/[^0-9\.]/g, '');
//       if (Number(val) <= 0)
//         val = 1;
//       if (Number(val) > 50)
//         val = 50;
//       jQuery(this).val(val);
//     });
//     jQuery('input.pressnumber').blur(function () {
//       var val = jQuery(this).val();
//       if (Number(val) <= 0)
//         val = 1;
//       if (Number(val) > 50)
//         val = 50;
//       jQuery(this).val(val);
//     });
// });