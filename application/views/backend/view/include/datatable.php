<div class="portlet-body">
    <div class="dataTables_wrapper no-footer">
        <?=$this->data_view['dataTable']['limit_html']?>
        <div class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
                <?=$this->data_view['dataTable']['thead_html']?>
                <tbody id="data-table">
                    <? $this->load->view($this->_base_view_path.'view/include/pageList/dataList'); ?>
                </tbody>
            </table>
        </div>
        <? $this->load->view($this->_base_view_path.'view/include/pageList/pagelist'); ?>
    </div>
</div>