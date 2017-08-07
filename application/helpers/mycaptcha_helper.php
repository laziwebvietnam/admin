<?php
if(!function_exists('create_captcha'))
{
    function create_captcha($form='unknow')
    {
        echo '<img src="public/captcha?form='.$form.'" height="30" class="img-captcha" />
        <img class="btn-refesh-captcha" src="public/images/core/refresh.png" height="30"/>';
    }
}
if(!function_exists('captcha_is_correct'))
{
    function captcha_is_correct($form='unknow')
    {
        if(isset($_SESSION['security_code'][$form])&&(isset($_POST['captcha'])||isset($_POST['txtcaptcha'])))
        {
            $ct=isset($_POST['captcha'])?$_POST['captcha']:(isset($_POST['txtcaptcha'])?$_POST['txtcaptcha']:'');
            $t=($_SESSION['security_code'][$form]==strtolower($ct));
            unset($_SESSION['security_code'][$form]);
            return $t;
        }
        return false;
    }
}
?>