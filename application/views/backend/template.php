<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <?
        /** Head */
        $this->load->view($this->_base_view_path.'master/head');
    ?>

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <?
            /** Header */
            $this->load->view($this->_base_view_path.'master/top');
        ?>
    
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <?
                    /** Navbar */
                    $this->load->view($this->_base_view_path.'master/left');
                ?>                
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                     <?                    
                        /** Theme setting */
                        //$this->load->view($this->_base_view_path.'master/include/theme_setting');
                        
                        /** Content */
                        $this->load->view($content['view'],array('data'=>$content['data']));
                       
                    ?>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <?
                /** Content top */
                ///$this->load->view($this->_base_view_path.'master/include/top');
            ?>
        </div>
        <?
            /** Footer */
            $this->load->view($this->_base_view_path.'master/footer');
        ?>
        
        <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?=$this->_base_url_template_admin?>/assets/global/img/loading-spinner-grey.gif" alt="" class="loading"/>
                        <span> &nbsp;&nbsp;Loading... </span>
                    </div>
                </div>
            </div>
        </div>
        
    </body>

</html>