<?=$this->data_view['breadcrumb']?>
<?
    $slug = $this->uri->segment(3);
?>
<div class="inbox">
    <div class="row">
        <div class="col-md-3">
            <div class="inbox-sidebar">
                <!--a href="contact/sent" data-title="Compose" class="btn red compose-btn btn-block">
                    <i class="fa fa-edit"></i> Thêm mới 
                </a-->
                <ul class="inbox-nav">
                    <li class="<?=$slug=='inbox'?'active':''?>">
                        <a href="contact/inbox" data-type="inbox" data-title="Mới"> Liên hệ mới
                            <span class="badge badge-success"><?=$data['count']['inbox']?></span>
                        </a>
                    </li>
                    <li class="<?=$slug=='noreply'?'active':''?>">
                        <a href="contact/noreply" data-type="noreply" data-title="Chưa phản hồi"> Chưa phản hồi
                            <span class="badge badge-danger"><?=$data['count']['noreply']?></span>
                        </a>
                    </li>
                    <li class="<?=$slug==''?'active':($slug=='index'?'active':'')?>">
                        <a href="contact" data-type="" data-title="Tất cả"> Tất cả
                            
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="<?=$slug=='delete'?'active':''?>">
                        <a href="contact/delete" class="sbold uppercase" data-type="delete" data-title="Đã xóa"> Đã xóa
                            <span class="badge badge-info"><?=$data['count']['delete']?></span>
                        </a>
                    </li>
                    <li class="<?=$slug=='reply'?'active':''?>">
                        <a href="contact/reply" data-type="reply" data-title="Đã phản hồi"> Đã phản hồi
                            <span class="badge badge-warning"><?=$data['count']['reply']?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
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
                                            <? $this->load->view($this->_base_view_path.'view/contact/include/dataList'); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <? $this->load->view($this->_base_view_path.'view/include/pageList/pagelist'); ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->



