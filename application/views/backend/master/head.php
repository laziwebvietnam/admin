<!-- BEGIN HEAD -->
<head>
    <base href="<?=$this->_base_url?>" />
    <meta charset="utf-8" />
    <title>Laziweb Admin System</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN PAGE FIRST SCRIPTS -->
    <script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/pace/pace.min.js" type="text/javascript"></script>
    <!-- END PAGE FIRST SCRIPTS -->
    <!-- BEGIN PAGE TOP STYLES -->
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/pace/themes/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE TOP STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!--link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" /-->
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    
    <? 
        if(isset($this->data_view['css'])){
            if($this->data_view['css']==true){
                $view = $this->_base_view_path.'view/'.$this->_table.'/load/css';
                $this->load->view($view); 
            }
        }
    ?>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?=$this->_base_url_template_admin?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?=$this->_base_url_template_admin?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$this->_base_url_template_admin?>/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?=$this->_base_url_template_admin?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="http://laziweb.com/public/uploads/files/favicon.PNG" /> 
    <link href="<?=$this->_base_url_template_admin?>/assets/laziweb.css" rel="stylesheet" type="text/css" />
    <script src="<?=$this->_base_url_template_admin?>/assets/laziweb_library.js" type="text/javascript"></script>
    <script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
</head>
<!-- END HEAD -->