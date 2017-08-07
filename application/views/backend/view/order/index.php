<?=$this->data_view['breadcrumb']?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-briefcase fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> <?=number_format($data['result']['total_amount'],0,'.','.')?> đ</div>
                <div class="desc"> Tổng giá trị đơn hàng </div>
            </div>
            <a class="more" href="javascript:;"></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number"> <?=number_format($data['result']['total_order'],0,'.','.')?></div>
                <div class="desc"> Tổng số đơn hàng </div>
            </div>
            <a class="more" href="javascript:;"></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> <?=number_format($data['result']['total_average'],0,'.','.')?> đ</div>
                <div class="desc"> Tổng giá trị trung bình / đơn hàng </div>
            </div>
            <a class="more" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase">Danh sách</span>
                </div>
                <?=$this->data_view['dataTable']['column_html']?>                
                <?=$this->data_view['dataTable']['export_html']?>
            </div>
            
            <? $this->load->view($this->_base_view_path.'view/include/datatable') ?>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>


