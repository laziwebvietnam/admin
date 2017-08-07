<?=$this->data_view['breadcrumb']?>

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

