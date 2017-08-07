var pressFieldOnForm_excute = false;


var laziCustomer = {
    signUp: function(formId){
        laziForm.submit(formId)
            .then(function(data_log){
                if(data_log.status=='success'){
                    formSignUpSuccess(formId,data_log);
                }else if(!data_log.validation){
                    formSignUpFail(formId,data_log);
                }
            });
    },

    signIn: function(formId){
        laziForm.submit(formId)
            .then(function(data_log){
                if(data_log.status=='success'){
                    formSignInSuccess(formId,data_log);
                }else if(!data_log.validation){
                    formSignInFail(formId,data_log);
                }
            });
    },

    changeInfo: function(formId){
        laziForm.submit(formId)
            .then(function(data_log){
                console.log(data_log);
                if(data_log.status=='success'){
                    formChangeInfoSuccess(formId,data_log);
                }else if(!data_log.validation){
                    formChangeInfoFail(formId,data_log);
                }
            });
    },

    changePass: function(formId){
        laziForm.submit(formId)
            .then(function(data_log){
                console.log(data_log);
                if(data_log.status=='success'){
                    formChangePassSuccess(formId,data_log);
                }else if(!data_log.validation){
                    formChangePassFail(formId,data_log);
                }
            });
    },

    forgotPass: function(formId){
        laziForm.submit(formId)
            .then(function(data_log){
                if(data_log.status=='success'){
                    formForgotPassSuccess(formId,data_log);
                }else if(!data_log.validation){
                    formForgotPassFail(formId,data_log);
                }
            });
    },

    setNewPass: function(formId){
        laziForm.submit(formId)
            .then(function(data_log){
                if(data_log.status=='success'){
                    formSetNewPassSuccess(formId,data_log);
                }else if(!data_log.validation){
                    formSetNewPassFail(formId,data_log);
                }
            });
    }
};

function getCustomerByMail(emailValue,formId){
    if(pressFieldOnForm_excute==true && typeof formId != 'undefined'){
        return;
    }
    pressFieldOnForm_excute = true;
    var data = {
        email:emailValue
    };
    var ajax = $.post('customer/getCustomerByMail',data);

    ajax.success(function(data_log){
        data_log = jQuery.parseJSON(data_log);
        if(data_log.status=='success'){
            pressFieldOnForm(data_log.info,formId);
        }
        pressFieldOnForm_excute = false;
    });

    function pressFieldOnForm(customerInfo,formId){
        formId = $('#'+formId);
        data = formId.serializeObject();
        // console.log(customerInfo);
        for(key in data){
            // console.log(customerInfo.key);
            if(data[key]==''){
                formId.find('[name="'+key+'"]').val(customerInfo[key]);
                if (customerInfo[key]) {
                    formId.find('[name="'+key+'"]').removeClass('error');
                }
            }
        }
    }
}

$('#formSubscribe').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziForm.submit(formId)
        .then(function(data_log){
            /** success */
            if(data_log.status=='success'){
                saveSubscribeSuccess(formId,data_log);
            }
            /** fail */
            else{
                saveSubscribeFail(formId,data_log);
            }
            return data_log;
        });
});

$('#formSubscribe :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formSubscribe');
    laziForm.setValidation(formId,nameElement);
});

$('#formSignUp').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziCustomer.signUp(formId);
});

$('#formSignUp :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formSignUp');
    laziForm.setValidation(formId,nameElement);
});

$('#formSignIn').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziCustomer.signUp(formId);
});

$('#formSignIn :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formSignIn');
    laziForm.setValidation(formId,nameElement);
});

$('#formChangeInfo').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziCustomer.changeInfo(formId);
});

$('#formChangeInfo :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formChangeInfo');
    laziForm.setValidation(formId,nameElement);
});

$('#formChangePass').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziCustomer.changePass(formId);
});

$('#formChangePass :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formChangePass');
    laziForm.setValidation(formId,nameElement);
});

$('#formForgotPass').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziCustomer.forgotPass(formId);
});

$('#formForgotPass :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formForgotPass');
    laziForm.setValidation(formId,nameElement);
});

$('#formSetNewPass').submit(function(e){
    e.preventDefault();
    var formId = $(this);
    laziCustomer.setNewPass(formId);
});

$('#formSetNewPass :input').change(function(e){
    var nameElement = $(this)[0].name;
    var formId = $('#formSetNewPass');
    laziForm.setValidation(formId,nameElement);
});