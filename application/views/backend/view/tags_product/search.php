<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="">Bảng điều khiển</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=$this->_base_url?>product">Bảng điều khiển</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:;">Thêm mới</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Tìm kiếm sản phẩm </h3>

<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Thêm mới thất bại!</strong> Vui lòng thông báo kĩ thuật viên để được hỗ trợ kịp thời. <a class="alert-link" href="javascript:;">Liên hệ tại đây</a>
</div>

<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Bạn không có quyền truy cập!</strong> Vui lòng kiểm tra lại quyền truy cập hoặc thông báo kĩ thuật viên để được hỗ trợ kịp thời. <a class="alert-link" href="javascript:;">Liên hệ tại đây</a>
</div>
<div class="m-heading-1 border-green m-bordered">
    <h3>Bộ lọc tìm kiếm nâng cao</h3>
    <div class="row">
        <?
            create_input_search('title','Tên sản phẩm',null,'Nhập tên sản phẩm...',4);
            create_input_search('price','Giá từ',null,'Vd: 50.000',2);
            create_input_search('price','Giá đến',null,'Vd: 100.000',2);
        ?>
    </div>
    <div class="row">
        <?
            $category = $this->My_model->getlist('category',array(),0,999,'position asc');
            create_select_search('id_category','Loại sản phẩm',null,$category,4);
            $array_tag = array(
                array('id'=>1,'title'=>'A'),
                array('id'=>2,'title'=>'B'),
                array('id'=>3,'title'=>'C')
            );
            create_input_tag('id_tag','Tags',$array_tag,null,4);
        ?>
        
    </div>
    <div class="row">
        <?
            $array_checkbox = array(
                array('name'=>'is_special','title'=>'Sản phẩm nổi bật','value'=>1,'checked'=>true),
                array('name'=>'is_new','title'=>'Sản phẩm mới','value'=>1),
                array('name'=>'is_promotion','title'=>'Sản phẩm khuyến mãi','value'=>1,'checked'=>true),
                array('name'=>'is_stock','title'=>'Đã hết hàng','value'=>1),
                array('name'=>'is_active','title'=>'Đã ẩn','value'=>1),
                array('name'=>'is_draft','title'=>'Lưu nháp','value'=>1)
            );
            create_checkbox_search_multy('Trạng thái sản phẩm',$array_checkbox,12);
        ?>
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn green">
                <i class="fa fa-search"></i> Tìm kiếm
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <?
                $field = array(
                    array('title'=>'Hình','name'=>'image'),
                    array('title'=>'Tên','name'=>'title'),
                    array('title'=>'Loại','name'=>'id_category'),
                    array('title'=>'Giá','name'=>'price','type'=>'price'),
                    array('title'=>'Hiển thị','name'=>'is_active','type'=>'status'),
                    array('title'=>'Giá giảm','name'=>'price_promotion','type'=>'price')
                );
                $datatable = array(
                    'list'=>$this->My_model->getlist('product'),
                    'field'=>$field
                );
            ?>
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">Kết quả tìm kiếm</span>
                </div>
               
                <div class="dt-button-collection hidden">
                    <a class="dt-button buttons-columnVisibility active" data-field="stt"><span>STT</span></a>
                    <a class="dt-button buttons-columnVisibility active" data-field="image"><span>Hình</span></a>
                    <a class="dt-button buttons-columnVisibility active" data-field="title"><span>Tên</span></a>
                    <a class="dt-button buttons-columnVisibility active" data-field="category"><span>Loại</span></a>
                    <a class="dt-button buttons-columnVisibility active" data-field="price"><span>Giá</span></a>
                    <a class="dt-button buttons-columnVisibility active" data-field="is_active"><span>Trạng thái</span></a>
                </div>                
            </div>
            
            <div class="portlet-body">
                <div class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dt-buttons">
                                <a class="dt-button btn dark btn-outline" onclick="print();"><span>In</span></a>
                                <a class="dt-button btn green btn-outline" onclick="pdf();"><span>Xuất file PDF</span></a>
                                <a class="dt-button btn purple btn-outline" onclick="csv();"><span>Xuất file CSV</span></a>
                                <a class="dt-button buttons-collection buttons-colvis btn dark btn-outline"><span>Columns</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dataTables_length">
                                    <label>
                                        <select name="sample_1_length" class="form-control input-sm input-xsmall input-inline">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="-1">All</option>
                                        </select> dữ liệu
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="dataTables_filter">
                                    <label>Tìm kiếm:
                                        <input type="search" class="form-control input-sm input-small input-inline" placeholder="Nhập từ cần tìm ..."/>
                                    </label>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="dataTables_wrapper">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="sorting_disabled" rowspan="2">
                                        <input id="data-table-checkbox" type="checkbox" class="group-checkable" value="1" />
                                    </th>
                                    <th id="data-table-action"  colspan="6" class="hidden">
                                        <div class="btn-group">
                                            <a class="btn red btn-outline" href="javascript:;" data-toggle="dropdown">
                                                <i class="fa fa-share"></i>
                                                <span class="hidden-xs"> Chọn thao tác (đang chọn <span id="data-table-count">0</span> sản phẩm) </span>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                <li>
                                                    <a href="javascript:;" class="tool-action">
                                                        Hiện
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="tool-action">
                                                        Ẩn
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="tool-action" onclick="create_popup('product/popup_delete');">
                                                        Xóa
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="tool-action" onclick="create_popup('product/popup_tag');">
                                                        Thêm tags
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="tool-action" onclick="create_popup('product/popup_tag');">
                                                        Xóa tags
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="tool-action" onclick="create_popup('product/popup_product_add_category');">
                                                        Thêm sản phẩm vào danh mục
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="tool-action" onclick="create_popup('product/popup_product_add_category');">
                                                        Xóa sản phẩm khỏi danh mục
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </th>
                                </tr>
                                <tr id="data-table-field">
                                    <th data-field="stt" class="sorting_asc" status="active"> STT </th>
                                    <th data-field="image" class="sorting"> Hình</th>
                                    <th data-field="title" class="sorting"> Tên</th>                                    
                                    <th data-field="category" class="sorting"> Loại</th>
                                    <th data-field="price" class="sorting"> Giá </th>
                                    <th data-field="is_active" class="sorting"> Trạng thái </th>
                                </tr>
                            </thead>
                            <tbody id="data-table">
                                <?
                                    for($i=1;$i<=10;$i++){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <input type="checkbox" class="checkboxes" value="<?=$i?>" /> 
                                            </td>
                                            <td><?=$i?></td>
                                            <td><a href="javascript:void(0)"> Tên sản phẩm #<?=$i?></a></td>
                                            <td>
                                                <img src="http://laziweb.com/public/uploads/images/mau-thiet-ke/doanh-nghiep/thumb-homedecor.JPG" width="70px" />
                                            </td>
                                            <td>
                                                Loại sản phẩm
                                            </td>
                                            <td><?=number_format(rand(200000,1000000),0,'',',')?></td>
                                            <td data-field="is_active">
                                                
                                                <?
                                                    if(rand(0,1)==1){
                                                        ?>
                                                        <span class="label label-sm label-success">Đang hiện</span>
                                                        <?
                                                    }else{
                                                        ?>
                                                        <span class="label label-sm label-warning"> Đang ẩn </span>
                                                        <?
                                                    }
                                                ?>
                                                
                                            </td>
                                        </tr>
                                        <?
                                    }
                                ?>
                            
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">Showing 1 to 5 of 25 records</div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_full_number">
                                <ul class="pagination" style="visibility: visible;">
                                    <li class="prev disabled"><a href="javascript:void(0)" title="First"><i class="fa fa-angle-double-left"></i></a></li>
                                    <li class="prev disabled"><a href="javascript:void(0)" title="Prev"><i class="fa fa-angle-left"></i></a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li><a href="javascript:void(0)">2</a></li>
                                    <li><a href="javascript:void(0)">3</a></li>
                                    <li><a href="javascript:void(0)">4</a></li>
                                    <li><a href="javascript:void(0)">5</a></li>
                                    <li class="next"><a href="javascript:void(0)" title="Next"><i class="fa fa-angle-right"></i></a></li>
                                    <li class="next"><a href="javascript:void(0)" title="Last"><i class="fa fa-angle-double-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>