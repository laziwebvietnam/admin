var laziFormSubmitAction = false;
var laziForm = {
	submit: function(formId){
		var defer = $.Deferred();
		if(laziFormSubmitAction==true){
			defer.reject('spam');
			return defer.promise();
		}
		laziFormSubmitAction = true;
		var actionUrl = formId.attr('action-submit');
		var data = formId.serializeObject();
		data['typeAction'] = 'submit';

		// if (typeof data['method'] === 'undefined') {
		// 	data['typeAction'] = 'submit';
		// } else {
		// 	if (data['method'] == 'Thanh toán trực tuyến') {
		// 		data['typeAction'] = 'checkVTC';
		// 	} else {
		// 		data['typeAction'] = 'submit';
		// 	}
		// }

		var ajax = $.post(actionUrl,data);

		return ajax
		.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziFormSubmitAction = false;
			if(data_log.status=='fail'){
				checkValidation(formId,data_log.validation,data);
			}
			return data_log;

			// if (typeof data['method'] === 'undefined') {
			// 	if(data_log.status=='fail'){
			// 		checkValidation(formId,data_log.validation,data);
			// 	}
			// 	return data_log;
			// } else {
			// 	if (data['method'] == 'Thanh toán trực tuyến') {
			// 		if(data_log.status=='fail'){
			// 			checkValidation(formId,data_log.validation,data);
			// 			return data_log;
			// 		}

			// 		window.location.href = data_log.info.linkVTC;
			// 	} else {
			// 		if(data_log.status=='fail'){
			// 			checkValidation(formId,data_log.validation,data);
			// 		}
			// 		return data_log;
			// 	}
			// }
			
		});
	},

	setValidation: function(formId,nameElement){
		//var actionUrl = formId.attr('action-validation');
		var actionUrl = formId.attr('action-submit');
		var data = formId.serializeObject();
		data['typeAction'] = 'setValidation';
		var ajax = $.post(actionUrl,data);
		return ajax
		.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			checkValidation(formId,data_log.validation,data,nameElement);
		});
	}
}

