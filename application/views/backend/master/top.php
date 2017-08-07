<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="">
                <img src="<?=$this->_base_url_template_admin?>/assets/image/logo-admin.png" height="20px" alt="logo" class="logo-default" /> </a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-envelope-open"></i>
                        <span class="badge badge-default" id="topContact_total_1"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>Bạn có
                                <span class="bold" id="topContact_total_2"></span> <span class="bold">liên hệ</span> mới
                            </h3>
                            <a href="contact">xem tất cả</a>
                        </li>
                        <li>
                            <ul id="topContact_content" class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                            
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile"> <?=$this->data['user']['fullname']?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="javascript:;" onclick="create_popup('user/popup_info')">
                                <i class="icon-user"></i> Thông tin tài khoản </a>
                        </li>
                        <li>
                            <a href="javascript:;" onclick="create_popup('user/popup_changepass')">
                                <i class="icon-lock"></i> Đổi mật khẩu </a>
                        </li>
                        <!--li>
                            <a href="javascript:;" onclick="create_popup('user/popup_resetpass')">
                                <i class="icon-lock"></i> Reset mật khẩu </a>
                        </li-->

                        <li>
                            <a href="notification">
                                <i class="icon-notebook"></i> Nhật kí hoạt động </a>
                        </li>
                        <?
                            if($this->data['user']['id_role']==1 || $this->data['user']['id_role']==2){
                                ?>
                                <li>
                                    <a href="user_role">
                                        <i class="icon-info"></i> Phân quyền </a>
                                </li>
                                <?
                            }
                        ?>
                        
                        <li class="divider"> </li>
                        <li>
                            <a href="user/logout">
                                <i class="icon-logout"></i> Đăng xuất </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->