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
                    $info_tab = array(
                        array('id'=>1,'title'=>'Tiếng Việt'),
                        array('id'=>2,'title'=>'Tiếng Anh'),
                    );
                    //create_tab('Thông tin',false,$info_tab);
                ?>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab_1">
                            <div class="form-body">
                                <?
                                    create_input('title',lang('title'),$data['detail']['title'],true);
                                    create_editor('desc',lang('desc'),$data['detail']['desc']);
                                    create_input('value',lang('value'),$data['detail']['value'],true);
                                    
                                    $input_day = array(
                                        'dayTo'=>array('name'=>'time_start','val'=>$data['detail']['time_start']),
                                        'dayEnd'=>array('name'=>'time_end','val'=>$data['detail']['time_end'])
                                    );
                                    create_datetimepicker_range('Thời gian',$input_day['dayTo'],$input_day['dayEnd']);
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <?= $this->load->view($this->_base_view_path.'view/sale/load/product',$data); ?>

        </div>
        <div class="col-md-4">
            <div class="portlet light bordered">
            <?
                create_tab('Thể loại & trạng thái');
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <?
                        create_select_('type',null,$data['detail']==null?$data['detail']['type']:$data['detail']['type'],true,$this->_template['sale'],null,null,0);
                        create_checkbox('is_active',lang('is_active'),1,$data['detail']!=null?$data['detail']['is_active']:1,false,null,4);
                    ?>
                </div>
            </div>
        </div>
        <?
            //$this->load->view($this->_base_view_path.'view/include/action/tag',$data);
            $this->load->view($this->_base_view_path.'view/include/action/action',$data);
        ?>
        </div>
    </div>
</form>

