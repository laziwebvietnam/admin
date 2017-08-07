/** FORM COMMENT */
function form_validation_submit_comment(){
    
    var formid = $('#form-submit');
    var data = form_validation_returnData();
    var url = formid.attr('action');
    var ajax = $.post(url,data);
    ajax.error(function(){
        console.log('error_form_validation_submit_comment');
    });
    
    ajax.success(function(data_log){
        data_log = jQuery.parseJSON(data_log);
        console.log(data_log);
        if(data_log.status=='success'){
            window.location.reload();
        }else if(data_log.status=='fail'){
            data_log.info = jQuery.parseJSON(data_log.info);
            for(key in data_log.info){
                var form_group = formid.find('div[field-id="'+key+'"]');
                form_group.addClass('has-error');
                form_group.find('.help-block-error').html(data_log.info[key].alert);
            }
        }   
    });
}
/** END FORM COMMENT */