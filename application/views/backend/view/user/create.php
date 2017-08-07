<?=$this->data_view['breadcrumb']?>
<?
    $data['detail'] = isset($data['detail'])?$data['detail']:null;
    $data['detail'] = $data['detail'];
?>
<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    
    <input type="hidden" name="type_action" value="<?=$data['detail']['id']!=null?'edit':'create'?>" />
    <input type="hidden" name="id" value="<?=$data['detail']['id']?>" />
    <div class="row">
        <div class="col-md-8">
            <div class="portlet light bordered">
                <?
                    create_tab('Thông tin');
                ?>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab_1">
                            <div class="form-body">
                                <?
                                    create_input('username',lang('username'),$data['detail']['username'],true,30,null,2,$data['detail']!=null?true:false);
                                    create_input_password('password','Mật khẩu',null,true,30,'Nhập mật khẩu nếu bạn muốn đổi mật khẩu quản trị viên này');
                                    create_input('fullname',lang('fullname'),$data['detail']['fullname']);
                                    create_input('email',lang('email'),$data['detail']['email']);
                                    create_input('phone',lang('phone'),$data['detail']['phone']);
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet light bordered <?=$data['detail']==null?'hidden':''?>">
                <?
                    create_tab('Nhật kí hoạt động');
                ?>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab_1">
                            <div class="form-body">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
                                    <thead>
                                        <tr id="data-table-field">
                                            <th> Thời gian </th>
                                            <th> Thao tác</th>      
                                        </tr>
                                    </thead>
                                    <tbody id="data-table">
                                        <?
                                            if(isset($data['noti'])){
                                                if($data['noti']!=null){
                                                    foreach($data['noti'] as $row){
                                                        $time = date('d-m-Y G:i',$row['time']);
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td><?=$time?></td>
                                                                <td><?=$row['alert']?></td>
                                                            </tr>
                                                            <?
                                                    }
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <a class="btn btn-warning" href="">Xem tất cả</a>
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
                        create_select_('id_role',null,$data['detail']['id_role'],true,$data['role'],null,0);
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