var laziExcuted_formlogin = false;
var laziExcuted_formforgotPass = false;

$('#form-login').submit(function(e){
    e.preventDefault();
    if(laziExcuted_formlogin==true){
        return;
    }
    laziExcuted_formlogin = true;

    var url = $('#form-login').attr('action');
    var data = $('#form-login').serializeArray();
    var ajax = $.post(url,data);
    ajax.success(function(dataLog){
        dataLog = jQuery.parseJSON(dataLog);
        var removeAlert = false;
        
        if(dataLog.status=='success'){
            removeAlert = true;
            $('#form-login').find('button[type="submit"]').attr('disabled');
            window.location.href = '';
            return;
        }else{
            $('#form-login').find('.alert-danger').html('');
            if(dataLog.info!=null){                
                for(key in dataLog.info){
                    $('#form-login').find('.alert-danger').append('<p>'+dataLog.info[key].alert+'</p>');
                }
                $('#form-login').find('.alert-danger').removeClass('display-hide');
            }else{
                removeAlert = true;
            }
            
            if(dataLog.log!=null){
                $('#form-login').find('.alert-danger').removeClass('display-hide');
                $('#form-login').find('.alert-danger').append('<p>'+dataLog.log+'</p>');
                removeAlert = false;
            }

            $('#form-login').find('.alert-danger').stop(true,true).fadeOut(250).fadeIn(500);
        }
        laziExcuted_formlogin = false;
        
        if(removeAlert==true){
            $('#form-login').find('.alert-danger').stop(true,true).addClass('display-hide');
        }
    });
    
});

$('#form-configNewPass').submit(function(e){
    e.preventDefault();
    var formname = $('#form-configNewPass');
    var url = formname.attr('action');
    var data = formname.serializeArray();
    var ajax = $.post(url,data);
    ajax.success(function(dataLog){       
        
        dataLog = jQuery.parseJSON(dataLog);
        var removeAlert = false;
        
        if(dataLog.status=='success'){
            removeAlert = true;
            formname.find('button[type="submit"]').attr('disabled');
            window.location.href = '';
            return;
        }else{
            formname.find('.alert-danger').html('');
            if(dataLog.info!=null){                
                for(key in dataLog.info){
                    formname.find('.alert-danger').append('<p>'+dataLog.info[key].alert+'</p>');
                }
                formname.find('.alert-danger').removeClass('display-hide');
            }else{
                removeAlert = true;
            }
            
            if(dataLog.log!=null){
                formname.find('.alert-danger').removeClass('display-hide');
                formname.find('.alert-danger').append('<p>'+dataLog.log+'</p>');
                removeAlert = false;
            }

            formname.find('.alert-danger').stop(true,true).fadeOut(250).fadeIn(500);
        }
        laziExcuted_formlogin = false;
        
        if(removeAlert==true){
            formname.find('.alert-danger').stop(true,true).addClass('display-hide');
        }
    });
})

function formForgotPass(){
    if(laziExcuted_formforgotPass==true){
        return;
    }
    laziExcuted_formforgotPass = true;
    var url = $('#form-forgotpass').attr('action');
    var data = $('#form-forgotpass').serializeArray();
    var ajax = $.post(url,data);
    
    ajax.success(function(dataLog){
        dataLog = jQuery.parseJSON(dataLog);
        var showAlert = false;
        $('#form-forgotpass').find('.alert-danger').html('');
        if(dataLog.status=='success'){
            $('#form-forgotpass').find('.alert-danger').append('<p>'+dataLog.log+'</p>');
            document.getElementById("form-forgotpass").reset();
            $('#form-forgotpass').find('button[type="submit"]').attr('disabled','true');
            showAlert = true;
        }else{
            if(dataLog.info!=null){
                for(key in dataLog.info){
                    $('#form-forgotpass').find('.alert-danger').append('<p>'+dataLog.info[key].alert+'</p>');
                }
                showAlert = true;
            }else{
                showAlert = false;
            }
            
            if(dataLog.log!=null){
                showAlert = true;
                $('#form-forgotpass').find('.alert-danger').append('<p>'+dataLog.log+'</p>');
            }
        }
        
        if(showAlert==true){
            $('#form-forgotpass').find('.alert-danger').removeClass('display-hide');
        }else{
            $('#form-forgotpass').find('.alert-danger').addClass('display-hide');
        }

        laziExcuted_formforgotPass = false;
    });
}