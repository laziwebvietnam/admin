<?=$this->data_view['breadcrumb']?>
<?
    $data['detail'] = isset($data['detail'])?$data['detail']:null;
    $data['detail'] = $data['detail'];
?>
<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    
    <input type="hidden" name="type_action" value="<?=$data['detail']['id']!=null?'edit':'create'?>" />
    <input type="hidden" name="id" value="<?=$data['detail']['id']?>" />
    <input type="hidden" name="set_alias" value="<?=$this->data_view['dataCreate']['alias']==false?'false':'true'?>" />
    <div class="row">
        <div class="col-md-8">
            <div class="portlet light bordered">
                <?
                    create_tab('Thông tin',false,null);
                ?>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="form-body">
                                <?
                                    create_input('fullname',lang('fullname'),$data['detail']['fullname']);
                                    create_input('phone',lang('phone'),$data['detail']['phone']);
                                    create_input('email',lang('email'),$data['detail']['email']);
                                    create_input('address',lang('address'),$data['detail']['address']);
                                    create_textarea('desc',lang('desc'),$data['detail']['desc'],false);
                                    create_textarea('note',lang('note'),$data['detail']['note'],false);   
                                    create_image('image',lang('image'),$data['detail']['image'],false);                                 
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
                        create_select_('form',null,$data['detail']['form'],true,$this->data_view['formname'],null,0);
                        create_checkbox('is_active',lang('is_active'),1,$data['detail']!=null?$data['detail']['is_active']:1,false,null,4);
                    ?>
                </div>
            </div>
        </div>
        <?
            $this->load->view($this->_base_view_path.'view/include/action/action',$data);
        ?>
        </div>
    </div>
</form>

