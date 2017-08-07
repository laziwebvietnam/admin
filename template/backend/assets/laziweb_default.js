
$(document).ready(function(){
     loadTop_contact();
});


function loadTop_contact(){
    var ajax = $.post('master/loadNewContact');
    
    ajax.error(function(){
        console.log('error_loadTop_contact'); 
    });
    
    ajax.success(function(dataReturn){
        var TotalText = dataReturn.total==0?'':dataReturn.total;
        dataReturn = jQuery.parseJSON(dataReturn);
        $('#topContact_content').html(dataReturn.html);
        $('#topContact_total_1').html(TotalText);
        $('#topContact_total_2').html(dataReturn.total);
        
        $("time.lazitimeago").timeago();
    });
}

function formPopupSubmit(thisForm){
    var thisForm = $('#form-submit');
    var url = $(thisForm).attr('action');
    var data = $(thisForm).serializeObject();
    var ajax = $.post(url,data);
    ajax.success(function(dataLog){
        dataLog = jQuery.parseJSON(dataLog);
        var field_name_first = '';
        if(dataLog.info!=null){
            check_validation(dataLog.info);
        }else if(dataLog.status=='success'){
            $('#ajax').modal('hide');
            load_toastr('Cập nhật thành công',dataLog.log);
        }
        
        function check_validation(dataValidation){
            for(key in dataValidation){
                var form_group = thisForm.find('div[field-id="'+key+'"]');
                form_group.addClass('has-error');
                form_group.find('.help-block-error').html(dataValidation[key].alert);
                if(field_name_first == ''){
                    field_name_first = key;
                }
            }
            form_validation_setSuccessField(dataValidation);
        }
    });
}

function formResetPass(){
    var url = 'user/user_ActionResetPass';
    var ajax = $.post(url);
    
    ajax.success(function(dataLog){
        console.log(dataLog);
        dataLog = jQuery.parseJSON(dataLog);
        if(dataLog.status=='success'){
            $('#ajax').modal('hide');
            load_toastr('Khôi phục thành công',dataLog.log);
        }else{
            load_toastr('Khôi phục thất bại',dataLog.log,'warning');
        }
    });
}

/** TOASTR, ALERT */
function load_toastr(title,desc,type,pageInfo){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "5000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "onclick":function(et){
            console.log(et);
        }
    }
    /** action with create, edit page */
    if(typeof pageInfo !== 'undefined'){
        if(pageInfo.action=='edit' || pageInfo.action=='create'){
            actionPageAction();
        }
    }
    
    show();
    
    /** Action when page's edit or create */
    function actionPageAction(){
        /** change desc */
        desc = 'Tự động quay lại <a class="btn default" href="'+pageInfo.linkreload+'">trang danh sách <span id="countDown" class="badge badge-danger">5</span></a>.<br/> (bấm tắt để hủy)';

        /** set timeout */
        toastr.options.timeOut = 10000;
        toastr.options.extendedTimeOut = 10000;
        
        /** count down & reload */
        var i=5;
        obj_time=setInterval(function(){  
            $('span#countDown').html(i);
            if(i==0){
                clearInterval(obj_time);
                window.location.href=pageInfo.linkreload;
                /*
                if(tablePreviewStatus==true){
                    window.open(tablePreview);
                }*/
            }
            i--;
        },1000);
        /** clear count down */
        toastr.options.onHidden = function(e) { 
            clearInterval(obj_time);
            /** if edit page & close toastr then not disabled Button */
            if(pageAction=='edit'){
                disableBtnFormSubmit(false);
            }
        };
    }
    
    /** show popup */
    function show(){
        type = type==null?"success":type;
        if(type=='success'){
            toastr.success(desc, title);
        }else if(type=='warning'){
            toastr.warning(desc, title);
        }else if(type=='error'){
            toastr.error(desc, title);
        }else if(type=='info'){
            toastr.info(desc, title);
        }
    }
}