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
                    <div class="dataTables_wrapper">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
                            <?=$this->data_view['dataTable']['thead_html']?>
                            <tbody id="data-table">
                                <?
                                    if($data['list']['data'] != null){
                                        $i = $data['list']['start'];
                                        $type_voucher = 'real_price';
                                        foreach($data['list']['data'] as $row){
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="checkedbox">
                                                    <input type="checkbox" class="checkboxes" value="<?=$row['id']?>" /> 
                                                </td>
                                                <?
                                                    foreach($this->data_view['tableField'] as $key=>$field){
                                                        $this->data_view['dataTable']['otherInfo']['detail'] = $row;
                                                        $this->data_view['dataTable']['otherInfo']['linkDetail'] = isset($field['linkDetail'])?true:false;
                                                        $type = isset($field['type'])?$field['type']:'text';
                                                        $data_content = loadDatabyField($type,$field['name'],$row,$this->data_view['dataTable']['otherInfo']);
                                                        $class = isset($field['hidden'])?'hidden':'';

                                                        if($field['name']=='type'){
                                                            $type_voucher = $data_content['html'];
                                                            $data_content['html'] = return_valueKey($this->_template['coupon'],'id',$data_content['html'],'title');

                                                        }else if($field['name']=='value'){
                                                            if($type_voucher=='real_price'){
                                                                $data_content['html'] = number_format((int)$data_content['html'],0,'.','.') . 'đ';
                                                            }else if($type_voucher=='percent_price'){
                                                                $data_content['html'] = number_format((int)$data_content['html'],0,'.','.') . '%';
                                                            }
                                                        }

                                                        ?>
                                                        <td class="<?=$class?>" data-value-export='<?=$data_content['export']?>'><?=$data_content['html']?></td>
                                                        <?
                                                    }
                                                ?>
                                            </tr>
                                            <?
                                            $i++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <? $this->load->view($this->_base_view_path.'view/include/pageList/pagelist'); ?>
                </div>
            </div>

        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>


