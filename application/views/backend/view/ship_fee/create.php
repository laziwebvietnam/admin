<?=$this->data_view['breadcrumb']?>

<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    <input type="hidden" name="type_action" value="create" />
    <input type="hidden" name="id" value="" />
    <div class="row">
        <div class="col-md-8" id="load_fees">
            <div id="fee_loader" style="text-align: center; display: none;">
                <img src="<?= base_url(); ?>template/backend/assets/image/loading.gif" style="width: 100px; margin: 50px;">
            </div>
            <div id="fee_content">
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="portlet light bordered">
                <?
                    create_tab('Tỉnh / Thành phố');
                ?>
                <div class="portlet-body form">
                    <div class="form-body">
                        <?
                            create_select('id_location',null,'',true,$data['location'],null,0);
                        ?>
                    </div>
                </div>
            </div>
            <?
            // $this->load->view($this->_base_view_path.'view/include/action/action',$data);
            ?>
        </div>
    </div>
</form>

<div class="modal fade modal-edit" id="modal-fee">

</div>