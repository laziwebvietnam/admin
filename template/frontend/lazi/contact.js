var laziContactExcute_sentmail = false;

var laziContact = {
	sentMail: function(idContact){
        var defer = $.Deferred();
		if(laziContactExcute_sentmail==true){
			defer.reject('spam');
			return defer.promise();
		}
        if(typeof idContact === 'undefined'){
            return;
        }
		laziContactExcute_sentmail = true;
		var actionUrl = 'contact/sentMail/'+idContact;
		var ajax = $.post(actionUrl);

		return ajax.then(function(data_log){
			data_log = jQuery.parseJSON(data_log);
			laziContactExcute_sentmail = false;
			return data_log;
		});
    }
};

$(document).ready(function(){
    $('#formContact').submit(function(e){
        e.preventDefault();
        var formId = $(this);
        laziForm.submit(formId)
            .then(function(data_log){
                /** success */
                if(data_log.status=='success'){
                    saveContactSuccess(formId,data_log);
                    laziContact.sentMail(data_log.info.idContact);
                }
                /** fail */
                else{
                    saveContactFail(formId,data_log);
                }
                return data_log;
            });
    });

    $('#formContact :input').change(function(e){
        var nameElement = $(this)[0].name;
        var formId = $('#formContact');
        laziForm.setValidation(formId,nameElement);
    });
});