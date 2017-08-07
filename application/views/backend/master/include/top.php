<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler">
    <i class="icon-login"></i>
</a>
<div class="page-quick-sidebar-wrapper" data-close-on-body-click="true">
    <div class="page-quick-sidebar">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                    <span class="badge badge-danger">2</span>
                </a>
            </li>
            <li>
                <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                    <span class="badge badge-success">7</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                            <i class="icon-bell"></i> Alerts </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                            <i class="icon-info"></i> Notifications </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                            <i class="icon-speech"></i> Activities </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                            <i class="icon-settings"></i> Settings </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="tab-content">
            <?
                /** Tab #quick_sidebar_tab_1: User */
                $this->load->view($this->_base_view_path.'master/include/top/user');
                
                /** Tab #quick_sidebar_tab_2: Alert */
                $this->load->view($this->_base_view_path.'master/include/top/alert');
                
                /** Tab #quick_sidebar_tab_2: More */
                $this->load->view($this->_base_view_path.'master/include/top/more');                
            ?>
            
            
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR -->