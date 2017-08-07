<?=$this->data_view['breadcrumb']?>

<form>
<div class="m-heading-1 border-green m-bordered">
    <h3>Bộ lọc tìm kiếm nâng cao</h3>
    <div class="row">
        <?
            create_select_search_basic('id_user','Quản trị viên',isset($_GET['id_user'])?$_GET['id_user']:'',$data['user'],'fullname',3);
            create_select_search_basic('id_customer','Người dùng',isset($_GET['id_customer'])?$_GET['id_customer']:'',$data['customer'],'fullname',3);
            create_datetimepicker_range_search('Thời gian',array('name'=>'dayTo','val'=>isset($_GET['dayTo'])?$_GET['dayTo']:''),array('name'=>'dayEnd','val'=>isset($_GET['dayEnd'])?$_GET['dayEnd']:''));
        ?>
    </div>
    <div class="row">
        <?
            create_select_search_basic('type','Loại nhật kí',isset($_GET['type'])?$_GET['type']:'',$data['type'],'title',3);
            
        ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn green">
                <i class="fa fa-search"></i> Tìm kiếm
            </button>
        </div>
    </div>
</div>
</form>
<? if($data['list']!=null){ ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase">Kết quả tìm kiếm</span>
                </div>
                <?=$this->data_view['dataTable']['column_html']?>
                <?=$this->data_view['dataTable']['export_html']?>
            </div>
            <div class="portlet-body">
                <div class="dataTables_wrapper no-footer">
                    <?=$this->data_view['dataTable']['limit_html']?>
                    <? if($data['list']['data'] != null){ ?>
                    <div class="dataTables_wrapper">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
                            <?=$this->data_view['dataTable']['thead_html']?>
                            <tbody id="data-table">
                                <? $this->load->view($this->_base_view_path.'view/notification/include/dataList'); ?>
                            </tbody>
                        </table>
                    </div>
                    <? $this->load->view($this->_base_view_path.'view/include/pageList/pagelist'); ?>
                    <? } ?>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<? } ?>
