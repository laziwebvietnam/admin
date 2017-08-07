function addToCart(thisBtn, action){
	var productId = $(thisBtn).data('id');
	var productQuantity = $(thisBtn).data('qty');
	laziCart.insert(productId,productQuantity)
		.then(function (data_log) {
			addToCartAfter(data_log, action)
		}, function(err){
			console.log(err);
		});
}

function addTogether(thisBtn){
	var productId = $(thisBtn).data('id');
	var quantity = $('#'+productId+'_quantity').val();
	laziCart.insertTogether(productId,quantity)
		.then(function (data_log) {
			addToCartAfter(data_log)
		}, function(err){
			console.log(err);
		});
}

function removeCart(thisBtn){
	var cartKey = $(thisBtn).data('key');
	laziCart.remove(cartKey)
		.then(function (data_log) {
			removeCartAfter(data_log)
		}, function(err){
			console.log(err);
		}); 
}

function updateCart(thisBtn){
	var cartKey = $(thisBtn).data('key');
	var productId = $(thisBtn).data('id');
	var productQuantity = $('#'+cartKey+'_quantity').val();
	laziCart.update(productId,productQuantity,cartKey)
		.then(function(data_log){
			updateCartAfter(data_log)
		}, function(err){
			console.log(err);
		});
}

function destroyCart(){
	laziCart.destroy()
		.then(function(data_log){
			destroyCartAfter(data_log);
		}, function(err){
			console.log(err);
		});
}


var laziCartExcute_insert = false; /** status click add to cart */
var laziCartExcute_insertBuyTogether = false;
var laziCartExcute_getInfo = false;
var laziCartExcute_remove = false;
var laziCartExcute_update = false;
var laziCartExcute_destory = false;
var laziCartExcute_saveOrder = false;
var laziCartExcute_sentmail = false;
var laziCartExcute_checkCoupon = false;

var laziCart = {
	insert: function(productId, quantity){
		var defer = $.Deferred();
		if(laziCartExcute_insert==true){
			defer.reject('spam');
			return defer.promise();
		}
		laziCartExcute_insert = true;
		if(productId==null){
			defer.reject('productId is undefined');
			return defer.promise();
		}

		quantity = typeof quantity==='undefined'?1:quantity;
		quantity = parseFloat(quantity);

		var actionUrl = 'cart/add/'+productId+'/'+quantity;
		var ajax = $.post(actionUrl);

		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_insert = false;
			return data_log;
		});
	},

	insertTogether: function(productId, quantity){
		var defer = $.Deferred();
		if(laziCartExcute_insertBuyTogether==true){
			defer.reject('spam');
			return defer.promise();
		}
		laziCartExcute_insertBuyTogether = true;
		if(productId==null){
			defer.reject('productId is undefined');
			return defer.promise();
		}
		productBuyTogether = [];getDataProductBuyTogether();

		quantity = typeof quantity==='undefined'?1:quantity;
		quantity = parseFloat(quantity);

		var actionUrl = 'cart/add/'+productId+'/'+quantity;
		var data = {
			type:'buyTogether',
			productBuyTogether:productBuyTogether
		};
		// console.log(productBuyTogether);
		var ajax = $.post(actionUrl,data);

		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_insertBuyTogether = false;
			loadCartByAjax();
			return data_log;
		});

		function getDataProductBuyTogether(){
    		$('input[name="buy_together[]"]:checked').map(function(){
    			var idPro = $(this).data('id');
    			productBuyTogether.push(idPro);
    		});
    	}
	},

	update: function(productId,quantity,key){
		var defer = $.Deferred();
		if(laziCartExcute_update==true){
			defer.reject('Spam');
			return defer.promise();
		}
		laziCartExcute_update = true;
		if(productId==null){
			defer.reject('productId is undefined');
			return defer.promise();
		}

		if(typeof quantity === 'undefined'){
			defer.reject('quantity is undefined');
			return defer.promise();
		}

		var actionUrl = 'cart/update/'+productId+'/'+quantity+'/'+key;
		console.log(actionUrl);
		var ajax = $.post(actionUrl);

		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_update = false;
			return data_log;
		});
	},

	remove: function(cartKey){
		var defer = $.Deferred();
		if(laziCartExcute_remove==true){
			defer.reject('spam');
			return defer.promise();
		}
		laziCartExcute_remove = true;
		if(cartKey==null){
			defer.reject('cartKey is undefined');
			return defer.promise();
		}

		var actionUrl = 'cart/remove/'+cartKey;
		var ajax = $.post(actionUrl);
		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_remove = false;
			return data_log;
		});
	},

	destroy: function(){
		var defer = $.Deferred();
		if(laziCartExcute_destory==true){
			defer.reject('spam');
			return defer.promise();
		}
		laziCartExcute_destory = true;

		var actionUrl = 'cart/destroy';
		var ajax = $.post(actionUrl);
		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_destory = false;
			return data_log;
		});
	},

	getInfo: function(couponCode){
		var defer = $.Deferred();
		if(laziCartExcute_getInfo==true){
			defer.reject('spam');
			return defer.promise();
		}
		laziCartExcute_getInfo = true;

		var actionUrl = 'cart/getAllInfo';
		var data = {
			couponCode:couponCode
		};
		var ajax = $.post(actionUrl,data);

		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_getInfo = false;
			return data_log;
		});
	},
    
    sentMail: function(idOrder,type){
        var defer = $.Deferred();
		if(laziCartExcute_sentmail==true){
			defer.reject('spam');
			return defer.promise();
		}
        if(typeof idOrder === 'undefined'){
            return;
        }
		laziCartExcute_sentmail = true;
        type = typeof type === 'undefined'?'':type;
		var actionUrl = 'cart/sentMail/'+idOrder+'/'+type;
		var ajax = $.post(actionUrl);

		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_sentmail = false;
			return data_log;
		});
    },

    checkCouponCode: function(code){
    	var defer = $.Deferred();
    	if(laziCartExcute_checkCoupon==true){
    		defer.reject('spam');
			return defer.promise();
    	}
    	if(typeof code === 'undefined'){
    		defer.reject('undefined');
    		return defer.promise();
    	}
    	laziCartExcute_checkCoupon = true;
    	var actionUrl = 'cart/checkCoupon';
    	var data = { code:code };
    	var ajax = $.post(actionUrl,data);
    	return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziCartExcute_checkCoupon = false;
			return data_log;
		});
    },

    showPriceReview: function(){
    	var idElement = 'lz-cart-total-item-price';
    	var quantity = $('input[name="lz-pro-quantity"]').val();
    	quantity = parseInt(quantity);
    	var price = $('input[name="lz-pro-price-result"]').val();
    	var total = quantity * price;
    	var priceProBuyTogether = 0;
    	getPriceProductBuyTogether();
    	total = total + priceProBuyTogether;

    	$('[data-id="'+idElement+'"]').html(total);

    	function getPriceProductBuyTogether(){
    		$('input[name="buy_together[]"]:checked').map(function(){
    			var proPrice = $(this).data('price');
    			priceProBuyTogether += parseInt(proPrice);
    		});
    	}
    }
}

$(document).ready(function(){
	$('#formOrder').submit(function(e){
		e.preventDefault();
		var formId = $(this);
		laziForm.submit(formId)
			.then(function(data_log){
                /** success */
                if(data_log.status=='success'){
                    saveOrderSuccess(formId,data_log);
                    laziCart.sentMail(data_log.info.idOrder);
                }
                /** fail */
                else{
                    saveOrderFail(formId,data_log);
                }
                return data_log;
            });
	});

	$('#formOrder :input').change(function(e){
		var nameElement = $(this)[0].name;
		var formId = $('#formOrder');
		laziForm.setValidation(formId,nameElement);
	});
});