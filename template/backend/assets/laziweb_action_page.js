/*** load view popup */
function quickAction(thisBtn){
    var url = $(thisBtn).attr('postUrl'),
        popup = $(thisBtn).attr('typePopup');
    if(popup==1){
        create_popup(url);
    }else{
        ajaxQuickAction(url);
    }
}

function create_popup(url){
    var id_executed_ = $('#id_executed').val(),
        table_ = $('#table_executed').val(),
        data = {
            id_executed:id_executed_,
            table:table_
        };
        ajax = $.post(url,data);
        
        //console.log(id_executed_);
    
    ajax.success(function(data_return){
        var data_json = jQuery.parseJSON(data_return);
        if(data_json.checkRole==false){
            create_popup('home/loadPopupViewRoleFalse');
            return;
        }
        $('#ajax').find('.modal-body').html(data_json.html);
        $('#ajax').modal('show');
        
        setTimeout(reload_after_popup,300);
        
    });
}

function reload_after_popup(){
    ComponentsBootstrapSelect.init();
    $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    App.init();
    reload_editor();
    tag_autocomplete_create(); 
}

function ajaxQuickAction(url){
    var id_executed_ = $('#id_executed').val(),
        table_ = $('#table_executed').val(),
        data = {
            id_executed:id_executed_,
            table:table_
        };
        ajax = $.post(url,data);
    
    ajax.success(function(data_return){
        var data_json = jQuery.parseJSON(data_return);
        if(data_json.checkRole==false){
            create_popup('home/loadPopupViewRoleFalse');
            return;
        }

        if(data_json.status=='success' && data_json.reload==true){
            window.location.reload();
        }else{
            create_popup_alert('Thông báo',data_json.log,'danger');
            //;return false;
        }
    });
}

function create_popup_alert(strong_text_,normal_text_,typeValue_){
    var table = $('#table_executed').val();
    var url = table+'/show_alert_popup';
    var data = {
        strong_text:strong_text_,
        normal_text:normal_text_,
        typeValue:typeValue_
    };
    var ajax = $.post(url,data);
    ajax.success(function(html){
        $('#ajax').find('.modal-body').html(html);
        $('#ajax').modal('show');
    });
} 
/** Submit Form */
function submit_popupTag(thisBtn){
    var url = $(thisBtn).attr('postUrl'),
        data = $('#form-tag').serializeArray(),
        ajax = $.post(url,data);
    
    ajax.error(function(){
        console.log('error_submit_popupTag'); 
    });
    
    ajax.success(function(html){
        var data_return = jQuery.parseJSON(html);
        if(data_return.status=='success'){
            if(data_return.reload==true){
                window.location.reload();
            }else{
                load_toastr('Chỉnh sửa thành công');
            }
        }else{
            load_toastr('Chỉnh sửa thất bại',data_return.log,'warning');
        }
    })
}
function submit_popupCate(thisBtn){
    var url = $(thisBtn).attr('postUrl'),
        data = $('#form-cate').serializeArray(),
        ajax = $.post(url,data);
    
    ajax.error(function(){
        console.log('error_submit_popupCate'); 
    });
    
    ajax.success(function(html){
        var data_return = jQuery.parseJSON(html);
        if(data_return.status=='success'){
            if(data_return.reload==true){
                window.location.reload();
            }else{
                load_toastr('Chỉnh sửa thành công');
            }
        }else{
            load_toastr('Chỉnh sửa thất bại',data_return.log,'warning');
        }
        // console.log(data_return);
    })
}



/** submit form create */
function form_validation_submit(type){
    var table = $('#table_executed').val();
    var url_submit = $('#form-submit').attr('action');//table+'/action';
    if(type=='savedraft' || type=='preview'){
        url_submit+='/savedraft';
    }
    
    var data = form_validation_returnData();
    console.clear();
    //console.log(data);
    disableBtnFormSubmit(true);
    var ajax = $.post(url_submit,data);
    
    ajax.error(function(){
        console.log('error_form_validation_submit'); 
    });
    ajax.success(function(data_log){
        data_log = jQuery.parseJSON(data_log);
        if(data_log.status=='success'){
            var tableExecute = $('#table_executed').val();
            var tablePreview = '/'+$('#table_executed').val()+'/preview/'+data_log.id_insert;
            var tablePreviewStatus = $('#table_preview').val()=='true'?true:false;
            var linkReload = tableExecute; /** linkReload = list page */
            
            /** link back */
            var linkBack = document.referrer;
            if(linkBack.indexOf(linkReload)>0){
                //linkReload = linkBack;
            }           
            
            //var textAlert = 'Tự động quay lại <a class="btn default" href="'+linkReload+'">trang danh sách <span id="countDown" class="badge badge-danger">5</span></a>.<br/> (bấm tắt để hủy)';
            
            
            if(type=='preview'){
                window.open(tablePreview);
            }
            
            /** pageAction: type action of page */
            pageAction = $('#form-submit').find('input[name="type_action"]').val();
            var pageInfo = {
                    action:pageAction,
                    linkreload:linkReload
                };
            load_toastr('Thêm mới thành công',null,'success',pageInfo);
        }else{
            disableBtnFormSubmit(false);
        }
    })    
}
/** Disable Button in form Submit */
function disableBtnFormSubmit(disabled){  
    
    $('#form-submit').find('button').map(function(e,thisBtn){
        if(disabled==true){
            $(thisBtn).attr('disabled','');
        }else{
            $(thisBtn).removeAttr('disabled','');
        }
    })
}
/** field_name_changing: name input changing */

function form_submit_check_validation(type,field_name_changing){
    var data = form_validation_returnData();
    var formid = $('#form-submit');
    var table = $('#table_executed').val();    
    var url_validate = table+'/set_validation';
    
    disableBtnFormSubmit(true);
    var ajax = $.post(url_validate,data);
    
    var type = type==null?'onchange':type;
    // console.log(type);
    var field_name_first = ''; /** field name for scrool to */
    ajax.error(function(){
        console.log('error_submit_formValidation'); 
    });
    
    ajax.success(function(data_validation_error){
        disableBtnFormSubmit(false);
        data_validation_error = jQuery.parseJSON(data_validation_error);
        //console.log(data_validation_error);
        /** if input onchange => check_validation s.t just in that field */
        if(type=='onchange'){
            check_validation(field_name_changing);
        }else{
            check_validation();
            form_validation_scroolTo(field_name_first);
            if(data_validation_error.length != 0){
                form_validation_alert('validation_fail');
            }
        }
        if(data_validation_error.length == 0 && (type=='submit' || type=='savedraft' || type=='preview')){
            form_validation_submit(type);
        }
        
        function check_validation(field_name_changing){
            if(field_name_changing != null){
                var hasError = field_name_changing in data_validation_error;
                if(hasError==true){
                    var form_group = formid.find('div[field-id="'+field_name_changing+'"]');
                    form_group.removeClass('has-success').addClass('has-error');
                    form_group.find('.help-block-error').html(data_validation_error[field_name_changing].alert);
                    
                    field_name_first = field_name_changing;
                }
            }else{
                for(key in data_validation_error){
                    var form_group = formid.find('div[field-id="'+key+'"]');
                    form_group.removeClass('has-success').addClass('has-error');
                    form_group.find('.help-block-error').html(data_validation_error[key].alert);
                    
                    if(field_name_first == ''){
                        field_name_first = key;
                    }
                }
            }
            form_validation_setSuccessField(data_validation_error,field_name_changing);
        }
    });
}

$('#form-submit :input').change(function(){
    form_validation_onchange($(this).attr('name'));
});

$('[name="title"]').change(function(){
    form_validation_return_alias('alias',$(this).val(),null,true);
    setSeodata('title');
});

$('[name="en_title"]').change(function(){
     form_validation_return_alias('en_alias',$(this).val(),'en',true);
     setSeodata('en_title','en');
});

$('[name="alias"]').change(function(){
    form_validation_return_alias('alias',$(this).val());
});

$('[name="en_alias"]').change(function(){
    form_validation_return_alias('en_alias',$(this).val(),'en');
});

function form_validation_onchange(field_name){
    form_submit_check_validation('onchange',field_name);
}

function form_validation_return_alias(field_name,text,lang,notChangeUpdate){    
    var set_alias = $('#form-submit').find('[name="set_alias"]').val();
    /** if have set alias */
    if(set_alias=='true'){
        lang = lang==null?'':lang;  
        notChangeUpdate = notChangeUpdate==null?false:notChangeUpdate;

        var table = $('#table_executed').val();
        var url = table+'/set_alias/'+lang;
        var type_ = $('#form-submit').find('[name="type_action"]').val();
        var id_ = parseInt($('#form-submit').find('[name="id"]').val());
        id_ = isNaN(id_)==true?0:id_;
        
        if(type_=='edit' && notChangeUpdate==true){
            return true;
        }

        var data = {
                title:text,
                table:table,
                type:type_,
                id:id_
            };
        var ajax = $.post(url,data);
        ajax.error(function(){
            console.log('error_form_validation_return_alias');
        });
        
        ajax.success(function(data_return){
            data_return = jQuery.parseJSON(data_return);
            if(data_return.status=='fail'){
                return;
            }
            $('#form-submit').find('[name="'+field_name+'"]').val(data_return.alias);
            form_submit_check_validation('onchange',field_name);
            //$('#form-submit').find('[name="'+field_name+'"]').change();
        });
    }
}

function setSeodata(field_name,lang){
    var status_set_alias = $('#form-submit').find('[name="set_alias"]').val();
    if(status_set_alias==false){
        return false;
    }

    lang = typeof lang=='undefined'?'':lang;
    lang = lang=='en'?'en_':lang;
    var value = $('#form-submit').find('[name="'+field_name+'"]').val();
    if($('#form-submit').find('[name="seo['+lang+'title]"]').val(value)==''){
        $('#form-submit').find('[name="seo['+lang+'title]"]').val(value);
        $('#form-submit').find('[name="seo['+lang+'title_facebook]"]').val(value);
    }
    if($('#form-submit').find('[name="seo['+lang+'desc]"]').val(value)==''){
        $('#form-submit').find('[name="seo['+lang+'desc]"]').val(value);
        $('#form-submit').find('[name="seo['+lang+'desc_facebook]"]').val(value);
    }
    if($('#form-submit').find('[name="seo['+lang+'keyword]"]').val(value)==''){
        $('#form-submit').find('[name="seo['+lang+'keyword]"]').val(value);
    }   
}

/** check that input has error or not */
function form_validation_setSuccessField(data_validation_error,field_name_changing){
    var data = form_validation_returnData();
    var formid = $('#form-submit');
    if(field_name_changing!=null){

        var haveError = field_name_changing in data_validation_error;
        
        if(haveError==false){
            var form_group = formid.find('div[field-id="'+field_name_changing+'"]');
            removeError(form_group);
        }
        
    }else{
        for(key in data){
            var form_group = formid.find('div[field-id="'+key+'"]');
            var haveError = key in data_validation_error;
            if(haveError==false){
                removeError(form_group);
            }
        }
    }
    function removeError(form_group){
        if(form_group.hasClass('has-error')){
            form_group.removeClass('has-error');           
        }
        if(form_group.hasClass('has-success')==false){
            form_group.addClass('has-success');            
        }        
        form_group.find('.help-block-error').html(null);
    }
}

function form_validation_returnData(){
    /** Add editor value on json */
    for(var instanceName in CKEDITOR.instances){
        var editor = CKEDITOR.instances[instanceName];
        editor.updateElement();
        
    }
    
    var data = $('#form-submit').serializeObject();
    
    
    $('.input-frame').bind("DOMNodeInserted",function(){
        //var name = $(this).closest('.form-group').attr('field-id');
        /** add onchange images */
        //form_validation_onchange(name);
    });
    return data;
}

function form_validation_scroolTo(field_name){
    if(field_name==''){return;}
    var div_field_name = $('#form-submit').find('div[field-id="'+field_name+'"]');
    scroolToFieldName();
    function scroolToFieldName(){
        openTab();
        if (div_field_name.length) {
            $('html, body').animate({
                scrollTop: div_field_name.offset().top-60
            }, 1000);
            
            div_field_name.find('[name="'+field_name+'"]').focus();
        }
        
    }
    
    function openTab(){
        var findClass_formBody = div_field_name.closest('div.form-body'); /** find form-body */
        var findClass_tabPane = findClass_formBody.parent();
        
        /** For config page */
        var findClass_tabPaneConfig = div_field_name.closest('div.portlet-body');
        var findClass_navTab = findClass_tabPaneConfig.find('ul.nav-tabs');
        
        /** Case 1: It's a tab Pane */
        if(findClass_tabPane.hasClass('tab-pane')){
            /** If tab no active, make it active ^___^ */
            if(findClass_tabPane.hasClass('active')==false){                
                var getIdTabNumber = findClass_tabPane.attr('id');
                getIdTabNumber = getIdTabNumber.substring(12, getIdTabNumber.length);                
                $('#form-submit').find('a[href="#portlet_tab_'+getIdTabNumber+'"]').click();
                findClass_tabPane.click();
            }
        }
        else if(findClass_navTab.hasClass('nav')){
            var find_tabPaneId  = div_field_name.closest('div.tab-pane').attr('id');
            findClass_navTab.find('a[href="#'+find_tabPaneId+'"]').click();
        }       
        
        /** Case 2: It's not a tab Pane and It's closing (display:none)' 
                    Check <a> in <div class=tool>, if it close => make it open 
        */
        else{
            var findClass_portletBody = div_field_name.closest('div.portlet-body'); 
            var findClass_portletLight = findClass_portletBody.prev();
            var findClass_collapse = findClass_portletLight.find('div.tools').children('a');
            
            if(findClass_collapse.attr('class')=='expand'){
                findClass_collapse.click();
            }
        }
    }
    
}

function form_validation_alert(type){
    if(type=='validation_fail'){
        load_toastr('','Vui lòng nhập đầy đủ thông tin','error');
    }
}
$.fn.serializeObject = function() {
    "use strict";
    var i = [],
        a = {},
        b = function(b, c) {
            var d = a[c.name];
            i.push(c.name);
            if("undefined" != typeof d && d !== null){
                if($.isArray(d)){
                    d.push(c.value)
                }else{
                    a[c.name] = [d, c.value]
                }
            }else{
                a[c.name] = c.value
            }
        };
    return $.each(this.serializeArray(), b), a;
};

/** end submit function */

/** set limit on DataTable */
function setLimit(thisSelect){
    var url = 'home/setLimitDatatable',
        table_ = $('#table_executed').val(),
        limit_ = $(thisSelect).val(),
        data = {
            table:table_,
            limit:limit_
        },
        ajax = $.post(url,data);
    
    ajax.error(function(){
        console.log('error_');    
    });
    
    ajax.success(function(html){
        var data_return = jQuery.parseJSON(html);
        if(data_return.status=='success'){
            console.log(data_return.status);
            window.location.reload();
        }
    });
}

/** set sort by s.t on DataTable */
function ajaxSetsortby(thisTh){
    th_sort_change(thisTh);
    var url = 'home/setSortbyDatatable',
        table_ = $('#table_executed').val(),
        name_ = $(thisTh).attr('data-name'),
        val_ = $(thisTh).attr('data-val-change'),
        data = {
            table:table_,
            name:name_,
            val:val_
        },
        ajax = $.post(url,data);
        
    ajax.error(function(){
        console.log('error_ajaxSetsortby');    
    });
    
    ajax.success(function(html){
        var data_return = jQuery.parseJSON(html);
        if(data_return.status=='success'){
            console.log(data_return.status);
            window.location.reload();
        }
    });
}

function check_seodata(lang){
    var str_check_ = $('[name="title_seo_check"]').val(),
        title_ = $('[name="title"]').val(),
        title_seo_ = $('[name="title_seo"]').val(),
        desc_seo_ = $('textarea[name="desc_seo"]').val(),
        keyword_seo_ = $('[name="keyword_seo"]').val(),
        alias_ = $('[name="alias"]').val(),
        long_detail_ = editor_long_detail.getData(),
        data = {
            str_check:str_check_,
            title:title_,
            title_seo:title_seo_,
            desc_seo:desc_seo_,
            keyword_seo:keyword_seo_,
            alias:alias_,
            long_detail:long_detail_,
        };
    
    var ajax = $.post('/admin/admin/check_seodata',data);
    
    ajax.error(function(){
        console.log('error_check_seodata'); 
    });
    
    ajax.success(function(html){
        console.log(html);
    });
}

function finder_complete(inputname){
    console.log(inputname + ' chenged!');
    $('[name="'+inputname+'"]').parents('.form-group has-error:eq(0)').removeClass('form-group has-error');
    /** img_editor_jquery.js dong 90 */
}