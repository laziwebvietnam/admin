<div class="copyright"> 2016 © Lazi Team. Admin Dashboard Template. </div>
<!--[if lt IE 9]>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?=$this->_base_url_template_admin?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$this->_base_url_template_admin?>/assets/laziweb_login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    jQuery('#forget-password').click(function() {
        jQuery('.login-form').hide();
        jQuery('.forget-form').show();
    });

    jQuery('#back-btn').click(function() {
        jQuery('.login-form').show();
        jQuery('.forget-form').hide();
    });

</script>