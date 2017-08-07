function setCookie(name, value, minutes) {
    var d = new Date();
    d.setTime(d.getTime() + (minutes*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = name + "=" + value + "; " + expires;
}

function checkCookie(name) {
    var cookie =getCookie(name);
    if (cookie!="") {
        return true;
    }return false;
}

function getCookie(name) {
    var name = name + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function deleteCookie(name) {
    document.cookie = name +'=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
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


function checkValidation(formId,validation,formData,nameElement){
    if(typeof nameElement === 'undefined'){
        resetValidation();
        for(key in validation){
            showError(key,validation[key].alert);
        }
    }else{
        for(key in validation){
            if(key==nameElement){
                showError(key,validation[key].alert);
                return false;
            }
        }
        hideError(nameElement);
    }


    function hideError(name){
        formId.find('[name="'+name+'"]').removeClass('error');
    }

    function showError(name,error){
        formId.find('[name="'+name+'"]').addClass('error');
        laziAlert.alertError(error);
    }

    function resetValidation(){
        for(key in formData){
            formId.find('[name="'+key+'"]').removeClass('error');
        }
    }
}

function logCopy(){
    function disableselect(e){ return false }

    function reEnable(){ return true }

    document.onselectstart=new Function ("return false")

    if (window.sidebar){ document.onmousedown=disableselect; document.onclick=reEnable }
}

function logRightMouse(){

    function disableIE() {
        if (document.all) {
            return false;
        }
    }

    function disableNS(e) {
        if (document.layers || (document.getElementById && !document.all)) {
            if (e.which == 2 || e.which == 3) {
                alert(msg);
                return false;
            }
        }
    }
    if (document.layers) {
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown = disableNS;
    } else {
        document.onmouseup = disableNS;
        document.oncontextmenu = disableIE;
    }
    document.oncontextmenu = new Function("return false");
}