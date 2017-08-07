<?=$this->data_view['breadcrumb']?>

<form>
<div class="m-heading-1 border-green m-bordered">
    <h3>Bộ lọc tìm kiếm nâng cao</h3>
    <div class="row">
        <?
            create_input_search('fullname','Tên người đặt',isset($_GET['fullname'])?$_GET['fullname']:'','Tên người đặt...',4);
            create_input_search('phone','Điện thoại người đặt',isset($_GET['phone'])?$_GET['phone']:'','Điện thoại người đặt...',4);
            create_input_search('address','Địa chỉ người đặt',isset($_GET['address'])?$_GET['address']:'','Địa chỉ người đặt...',4);
        ?>
    </div>
    <div class="row">
        <?
            create_datetimepicker_range_search('Thời gian',array('name'=>'dayTo','val'=>isset($_GET['dayTo'])?$_GET['dayTo']:''),array('name'=>'dayEnd','val'=>isset($_GET['dayEnd'])?$_GET['dayEnd']:''));
            create_input_search('min_price',lang('min_price'),isset($_GET['min_price'])?$_GET['min_price']:'','Vd: 50.000',2);
            create_input_search('max_price',lang('max_price'),isset($_GET['max_price'])?$_GET['max_price']:'','Vd: 100.000',2);
            
            $array_checkbox[] = 
                array('name'=>'is_active','title'=>lang('is_active_0'),'value'=>0,'checked'=>isset($_GET['is_active'])?($_GET['is_active']==0?true:false):false);
            $array_checkbox[] = 
                array('name'=>'is_active','title'=>lang('is_active_0'),'value'=>0,'checked'=>isset($_GET['is_active'])?($_GET['is_active']==0?true:false):false);
        ?>
    </div>
    <div class="row">
        <?
            //create_checkbox_search_multy('Trạng thái đơn hàng',$array_checkbox,12);
        ?>
        <div class="col-md-12" field-id="">
            <div class="form-group">
                <label>Trạng thái đơn hàng</label>
                <br />

                <input id="field-is_active_0" type="radio" class="form-control" name="is_active" value="0" 
                    <?=isset($_GET['is_active'])?($_GET['is_active']==0?"checked=''":false):null?> />
                <label for="field-is_active_0">Mới</label>

                <input id="field-is_active_1" type="radio" class="form-control" name="is_active" value="1"
                    <?=isset($_GET['is_active'])?($_GET['is_active']==1?"checked=''":false):null?> />
                <label for="field-is_active_1">Đã xác nhận</label>

                <input id="field-is_active_2" type="radio" class="form-control" name="is_active" value="2"
                    <?=isset($_GET['is_active'])?($_GET['is_active']==2?"checked=''":false):null?> />
                <label for="field-is_active_2">Chưa thanh toán</label>

                <input id="field-is_active_3" type="radio" class="form-control" name="is_active" value="3"
                    <?=isset($_GET['is_active'])?($_GET['is_active']==3?"checked=''":false):null?> />
                <label for="field-is_active_3">Đã thanh toán chưa gửi hàng</label>

                <input id="field-is_active_4" type="radio" class="form-control" name="is_active" value="4"
                    <?=isset($_GET['is_active'])?($_GET['is_active']==4?"checked=''":false):null?> />
                <label for="field-is_active_4">Hoàn tất</label>    

                <input id="field-is_active_5" type="radio" class="form-control" name="is_active" value="5"
                    <?=isset($_GET['is_active'])?($_GET['is_active']==5?"checked=''":false):null?> />
                <label for="field-is_active_5">Bị hoàn trả</label>

                <input id="field-is_active_6" type="radio" class="form-control" name="is_active" value="6"
                    <?=isset($_GET['is_active'])?($_GET['is_active']==6?"checked=''":false):null?> />
                <label for="field-is_active_6">Bị hủy</label>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn green">
                <i class="fa fa-search"></i> Tìm kiếm
            </button>
        </div>
    </div>
</div>
</form>
<? if($data['list']!=null){ ?>
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
            
            <? $this->load->view($this->_base_view_path.'view/include/datatable') ?>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<? } ?>
