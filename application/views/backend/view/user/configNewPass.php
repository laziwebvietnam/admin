<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<? $this->load->view($this->_base_view_path.'view/user/login/head') ?>

<body class=" login">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="">
            <img src="<?=$this->_base_url_template_admin?>/assets/image/logo-login.png" height="40px"/> </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        
        <!-- BEGIN LOGIN FORM -->
        <form id="form-configNewPass" class="login-form" action="user/configNewpass_action" method="post">
            <input type="hidden" name="id" value="<?=md6($userDetail['id'])?>" />
            <h3 class="form-title font-green">Cài đặt mật khẩu mới</h3>
            <div class="alert alert-danger display-hide">
                
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Mật khẩu mới</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" placeholder="Mật khẩu mới..." name="password" /> 
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Nhập lại mật khẩu mới</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" placeholder="Nhập lại mật khẩu mới..." name="password_confirm" /> 
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase">Đổi mật khẩu</button>
            </div>
        </form>
        <!-- END LOGIN FORM -->
        
        
        
    </div>
    <? $this->load->view($this->_base_view_path.'view/user/login/footer') ?>
</body>

</html>