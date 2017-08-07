<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> 2016 &copy;
        <a href="http://laziweb.com" title="Thiết kế website chuyên nghiệp" target="_blank">Laziweb!</a>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!--[if lt IE 9]>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->

<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<? 
    if(isset($this->data_view['script'])){
        if($this->data_view['script']==true){
            $view = $this->_base_view_path.'view/'.$this->_table.'/load/script';
            $this->load->view($view); 
        }
    }
?>

<!-- END PAGE LEVEL PLUGINS -->
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?=$this->_base_url_template_admin?>/assets/global/scripts/app.min.js" type="text/javascript"></script>

<? 
    if(isset($this->data_view['page_js'])){
        if($this->data_view['page_js']==true){
            $view = $this->_base_view_path.'view/'.$this->_table.'/load/page_js';
            $this->load->view($view); 
        }
    }
?>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?=$this->_base_url_template_admin?>/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="<?=$this->_base_url_template_admin?>/assets/laziweb_listpage.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/laziweb_action_page.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/laziweb_default.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery.timeago.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/ckeditor/ckeditor/ckeditor.js" type="text/javascript" ></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/ckeditor/ckfinder/ckfinder.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/editor_img/js/img_editor.jquery.js" type="text/javascript"></script>
<link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/editor_img/css/style.css" rel="stylesheet"/>
<script src="<?=$this->_base_url_template_admin?>/assets/laziweb_editor.js" type="text/javascript"></script>

<input type="hidden" id="id_executed" value="<?=isset($content['data']['detail'])?$content['data']['detail']['id']:''?>"/>
<input type="hidden" id="table_executed" value="<?=$this->_table?>" />
<input type="hidden" id="table_preview" value="<?=isset($this->data_action['preview'])?($this->data_action['preview']==true?'true':'false'):'false'?>" />