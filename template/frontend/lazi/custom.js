/**
 * [addToCartAfter description]
 * @param {[type]} data_log [status Add To Cart]
 */

function addToCartAfter(data_log, action){
	if (data_log.status == 'success') {
		if (action == 'alert') {
      loadCartByAjax();
      laziAlert.alertAddItem(data_log.viewAlert);
		} else {
			window.location.href = action;
		}
    
  }
}

function removeCartAfter(data_log){
	loadCartByAjax();
}

function updateCartAfter(data_log){
	loadCartByAjax();
}

function destroyCartAfter(data_log){
	loadCartByAjax();
}

function loadCartByAjax(couponCode){
	laziCart.getInfo(couponCode)
		.then(function(data_log){
			// $('#cartTop').html(data_log.infoTop);
			// $('#cartTable').html(data_log.infoTable);
      // loadShipFee($('select[name=district]').val());
		});
}

function saveContactSuccess(formId,dataReturn){
  formId.find('input, textarea, button, select').attr('disabled','disabled');
  laziAlert.alertSuccess(dataReturn.info.alert);
}

function saveContactFail(formId,dataReturn){
  if(dataReturn.error){
  	laziAlert.alertError(dataReturn.error);
  }
}

function saveOrderSuccess(formId,dataReturn){
  formId.find('input, textarea, button, select').attr('disabled','disabled');
  laziAlert.alertSuccess(dataReturn.info.alert);
}

function saveOrderFail(formId,dataReturn){
  if(dataReturn.error){
  	laziAlert.alertError(dataReturn.error);
  }
}

function saveSubscribeSuccess(formId,dataReturn){
  formId.find('input, textarea, button, select').attr('disabled','disabled');
  laziAlert.alertSuccess(dataReturn.alert);
}

function saveSubscribeFail(formId,dataReturn){
  if(dataReturn.error){
  	laziAlert.alertError(dataReturn.error);
  }
}

function formSignUpSuccess(formId,dataReturn){
	formId.find('input, textarea, button, select').attr('disabled','disabled');
}

function formSignUpFail(formId,dataReturn){
	if(dataReturn.error){
		$('#user_signUpAlert').html(dataReturn.error);
	}
}

function formSignInSuccess(formId,dataReturn){
	formId.find('input, textarea, button, select').attr('disabled','disabled');
	$('#user_signUpAlert').html('success');
}

function formSignInFail(formId,dataReturn){
	alert('that bai');
}

function formChangeInfoSuccess(formId,dataReturn){
	formId.find('input, textarea, button, select').attr('disabled','disabled');
	$('#user_changeInfoAlert').html('success');
}

function formChangeInfoFail(formId,dataReturn){
	if(dataReturn.error){
		$('#user_changeInfoAlert').html(dataReturn.error);
	}
}

function formChangePassSuccess(formId,dataReturn){
	formId.find('input, textarea, button, select').attr('disabled','disabled');
	$('#user_changePassAlert').html('success');
}

function formChangePassFail(formId,dataReturn){
	if(dataReturn.error){
		$('#user_changePassAlert').html(dataReturn.error);
	}
}

function formForgotPassSuccess(formId,dataReturn){
	formId.find('input, textarea, button, select').attr('disabled','disabled');
	$('#user_forgotPassAlert').html(dataReturn.alert);
}

function formForgotPassFail(formId,dataReturn){
	if(dataReturn.error){
		$('#user_forgotPassAlert').html(dataReturn.error);
	}
}

function formSetNewPassSuccess(formId,dataReturn){
	formId.find('input, textarea, button, select').attr('disabled','disabled');
	$('#user_setNewPass').html(dataReturn.alert);
}

function formSetNewPassFail(formId,dataReturn){
	if(dataReturn.error){
		$('#user_setNewPass').html(dataReturn.error);
	}
}

function checkCouponCode(couponCode){
	laziCart.checkCouponCode(couponCode)
		.then(function(data_log){
			// console.log(data_log);
			if(data_log.status=='success'){
				loadInfoCoupon(data_log.info);
				loadCartByAjax(data_log.info.id);
				$('#formOrder').find('[name="coupon"]').val(data_log.info.id);
			}else{
				$('#checkCouponCodeAlert').html(data_log.log);
				$('#formOrder').find('[name="coupon"]').val(null);
				loadCartByAjax();
			}
		});
}

function loadInfoCoupon(data){
	$('#checkCouponCodeAlert').html('Thong tin coupon').append('<br/>');
	$('#checkCouponCodeAlert').append(' - title: '+data.title).append('<br/>');
	$('#checkCouponCodeAlert').append(' - desc: '+data.desc).append('<br/>');
	$('#checkCouponCodeAlert').append(' - type: '+data.typeText).append('<br/>');
	$('#checkCouponCodeAlert').append(' - value: '+data.valueText).append('<br/>');
}

