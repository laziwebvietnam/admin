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
        
        <? $this->load->view($this->_base_view_path.'view/user/login/form_login') ?>
        <? $this->load->view($this->_base_view_path.'view/user/login/form_forgotpass') ?>
    </div>
    <? $this->load->view($this->_base_view_path.'view/user/login/footer') ?>
</body>

</html>