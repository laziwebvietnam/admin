<?=$this->data_view['breadcrumb']?>
<?
    $data_title = isset($data['detail'][$data['detail']['data_table'].'_title'])?$data['detail'][$data['detail']['data_table'].'_title']:'';
?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">
                        <?=lang($data['detail']['data_table'])?>: 
                        <a href="<?=$data['detail']['data_table']?>/edit/<?=$data['detail']['data_id']?>">
                            <?=$data_title?>
                        </a>
                    </span>
                </div>            
            </div>
            
            <div class="portlet-body">
                <div class="dataTables_wrapper no-footer">
                    
                    <div class="dataTables_wrapper">
                        <div class="timeline">
                            <!-- TIMELINE ITEM -->
                            <?
                                $data['list'] = array_merge(array($data['parent']),$data['child']);
                                $data['id_active'] = $data['detail']['id'];
                                $this->load->view($this->_base_view_path.'view/comment/include/commentList',$data);
                            ?>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>


