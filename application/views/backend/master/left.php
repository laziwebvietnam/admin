<!-- BEGIN SIDEBAR -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
        <li class="sidebar-toggler-wrapper hide">
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler"> </div>
            <!-- END SIDEBAR TOGGLER BUTTON -->
        </li>
        <li class="sidebar-search-wrapper">
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
            <form class="sidebar-search  " action="product/search" method="GET">
                <a href="javascript:;" class="remove">
                    <i class="icon-close"></i>
                </a>
                <div class="input-group">
                    <input type="text" class="form-control" name="title" placeholder="Tìm kiếm sản phẩm...">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </a>
                    </span>
                </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <?
            if($this->_master_info['menuleft'] != null){
                $first = true;
                $statusActive = false;
                $current_class = CI_Router::$current_class;
                $current_action = CI_Router::$current_action;
                $slug = $current_class;
                $slug .= ($current_action=='index' || $current_action=='')?'':'/'.$current_action;
                $slug = $slug=='home'?'':$slug;

                foreach($this->_master_info['menuleft'] as $link=>$row){
                    if($row['show']==false){
                        continue;
                    }
                    $class = 'nav-item';
                    $class .= $first==true?' start':'';
                    $statusActiveMenuParent = false;
                    if(isset($row['child'])){
                        if($link==$current_class && $statusActive==false){
                            $class .= ' active open'; 
                            $statusActive = true;
                            $statusActiveMenuParent = true;
                        }
                        
                    }else{
                        if($slug==$link && $statusActive==false){
                            $class .= ' active open';   
                            $statusActive = true;
                            $statusActiveMenuParent = true;
                        }
                    }

                    $link_parent = isset($row['child'])?'javascript:;':$link;                    
                    $span_child = isset($row['child'])?'<span class="arrow"></span>':'';
                    
                    ?>
                    <li class="<?=$class?>">
                        <a href="<?=$link_parent?>" class="nav-link nav-toggle">
                            <i class="<?=$row['icon']?>"></i>
                            <span class="title"><?=$row['title']?></span>
                            <?=$span_child?>
                        </a>
                        <?
                            if(isset($row['child'])){
                                ?>
                                <ul class="sub-menu">
                                <?
                                    foreach($row['child'] as $link_sub=>$sub_menu){
                                        if(substr($link_sub,0,1)!='/'){
                                            $link_child = $link.'/'.$link_sub;
                                        }else{
                                            $link_child = substr($link_sub,1,strlen($link_sub));
                                        }
                                        $class_child = 'nav-item';
                                        $class_child .= ($statusActiveMenuParent==true && $current_action==$link_sub)?' active ':'';
                                        ?>
                                        <li class="nav-item <?=$class_child?>">
                                            <a href="<?=$link_child?>" class="nav-link ">
                                                <span class="title"><?=$sub_menu['title']?></span>
                                                <!--span class="badge badge-danger">2</span-->
                                            </a>
                                        </li>
                                        <?
                                    }
                                ?>
                                </ul>
                                <?
                            }
                        ?>
                    </li>
                    <?
                    $first = false;
                }
            }  
        ?>
    </ul>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->