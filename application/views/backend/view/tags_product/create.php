<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="">Bảng điều khiển</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="tags_product">Tags product</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:;">Thêm mới</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Thêm mới sản phẩm</h3>

<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Thêm mới thất bại!</strong> Vui lòng thông báo kĩ thuật viên để được hỗ trợ kịp thời. <a class="alert-link" href="javascript:;">Liên hệ tại đây</a>
</div>

<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Bạn không có quyền truy cập!</strong> Vui lòng kiểm tra lại quyền truy cập hoặc thông báo kĩ thuật viên để được hỗ trợ kịp thời. <a class="alert-link" href="javascript:;">Liên hệ tại đây</a>
</div>
<form action="#" class="form-horizontal">
    <div class="row">
        <div class="col-md-8">
            <div class="portlet light bordered">
                <?
                    $info_tab = array(
                        array('id'=>1,'title'=>'Tiếng Việt'),
                        array('id'=>2,'title'=>'Tiếng Anh'),
                    );
                    create_tab('Thông tin sản phẩm',false,$info_tab);
                ?>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab_1">
                            <div class="form-body">
                                <?
                                    create_input('title','Tên');
                                    create_input_addon('alias','Đường dẫn','http://laziweb.com/');
                                    
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="portlet_tab_2">
                            <div class="form-body">
                                 <?
                                    create_input('en_title','Tên');
                                    create_input_addon('en_alias','Đường dẫn','http://laziweb.com/');
                                 ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="portlet light bordered">
            <?
                create_tab('Danh mục & trạng thái');
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    
                    <?
                        create_checkbox('is_active','Ẩn tags');
                    ?>
                    
                </div>
            </div>
        </div>
            <?
                $this->load->view($this->_base_view_path.'view/include/action');
            ?>
            
            
        </div>
    </div>
    <div class="row">
    </div>
</form>