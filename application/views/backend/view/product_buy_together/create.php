<?=$this->data_view['breadcrumb']?>
<?
    $data['detail'] = isset($data['detail'])?$data['detail']:null;
    $data['detail'] = $data['detail'];

    $id_pro_main = isset($_GET['id_product_main'])?$_GET['id_product_main']:0;
    $id_pro_main = $data['detail']['id_pro_main']!=null?$data['detail']['id_pro_main']:$id_pro_main;
?>
<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    
    <input type="hidden" name="type_action" value="<?=$data['detail']['id']!=null?'edit':'create'?>" />
    <input type="hidden" name="id" value="<?=$data['detail']['id']?>" />
    <input type="hidden" name="set_alias" value="<?=$this->data_view['dataCreate']['alias']==false?'false':'true'?>" />
    <input type="hidden" name="price">

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
                                    create_select_('id_pro_main',lang('pro_main'),$id_pro_main,true,$data['product'],null);
                                    create_select_('id_pro_relative',lang('pro_relative'),$data['detail']['id_pro_relative'],true,$data['product'],null);

                                    $input_price = array(
                                        array('name'=>'price_sale','title'=>lang('price_sale'),'val'=>$data['detail']['price_sale']),
                                        array('name'=>'promotion','title'=>lang('promotion'),'val'=>$data['detail']['promotion'])
                                    );
                                    create_input_multy('Giá',$input_price,true);
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
                create_tab('Trạng thái');
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <?
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

