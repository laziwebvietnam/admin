<div class="page-bar">
    <ul class="page-breadcrumb">
        <?
            if($breadcrumb){
                $n = count($breadcrumb)-1;
                foreach($breadcrumb as $key=>$row){
                    $alias = $key==$n?'javascript:;':$row['alias'];
                    $icon = $key==$n?'':'<i class="fa fa-circle"></i>';
                    ?>
                    <li>
                        <a href="<?=$alias?>"><?=$row['title']?></a>
                        <?=$icon?>
                    </li>
                    <?
                }
            }
        ?>
    </ul>
    <!-- <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a onclick="printBill('<?= md6($data['detail']['id']); ?>');" class="btn green btn-import" href="javascript:void(0);">
                In Hóa Đơn <i class="fa fa-download"></i>
            </a>
        </div>
    </div> -->
</div>

<h3 class="page-title"><?=lang($this->data_view['pageTitle'])?></h3>

<?
    $classStatus = $this->data_view['dataTable']['otherInfo']['status']['is_active'][$data['detail']['is_active']];
?>
<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    <input type="hidden" name="type_action" value="<?=$data['detail']['id']!=null?'edit':'create'?>" />
    <input type="hidden" name="id" value="<?=$data['detail']['id']?>" />
    <input type="hidden" name="set_alias" value="<?=$this->data_view['dataCreate']['alias']==false?'false':'true'?>" />
    <div class="row">
        <div class="col-md-8">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Danh sách sản phẩm</span>
                    </div>              
                </div>
                
                <div class="portlet-body">
                    <div class="dataTables_wrapper no-footer">
                        
                        <div class="dataTables_wrapper">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
                                <thead>
                                    <tr id="data-table-field">
                                        <th> STT </th>
                                        <th> Tên sản phẩm</th>
                                        <th> Giá gốc</th>                                    
                                        <th> Giá bán</th>
                                        <th> Số lượng</th>
                                        <th> Tổng tiền </th>
                                    </tr>
                                </thead>
                                <tbody id="data-table">
                                    <?
                                        if($data['list_product'] != null){
                                            foreach($data['list_product'] as $key=>$row){
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?=$key+1?></td>
                                                    <td><a target="_blank" href="product/edit/<?=$row['id_product']?>"><?=$row['product_title']?></a></td>
                                                    <td><?=number_format($row['price'],0,'.','.')?> đ</td>
                                                    <td><?=number_format($row['price_sale'],0,'.','.')?> đ</td>
                                                    <td><?=$row['quantity']?></td>
                                                    <td><?=number_format($row['total'],0,'.','.')?> đ</td>
                                                </tr>
                                                <?
                                            }
                                        }

                                        if ($data['detail']['id_coupon'] || $data['detail']['ship_fee']) {
                                            ?>
                                            <tr>
                                                <td colspan="5">Tạm tính</td>
                                                <td colspan="2"><b><?=number_format($data['detail']['total_amount'],0,'.','.')?> đ</b></td>
                                            </tr>
                                            <?php
                                        }
                                    
                                        if($data['detail']['id_coupon']!=0){
                                            $cou_value = $data['detail']['coupon_value'];
                                            $cou_type = return_valueKey($this->_template['coupon'],'id',$data['detail']['coupon_type'],'title');
                                            if($data['detail']['coupon_type']=='real_price'){
                                                $value = number_format((int)$data['detail']['coupon_value'],0,'.','.') . ' đ';
                                            }else if($data['detail']['coupon_type']=='percent_price'){
                                                $value = number_format((int)$data['detail']['coupon_value'],0,'.','.') . '%';
                                            }

                                            ?>
                                            <tr>
                                                <td colspan="5">Mã coupon sử dụng</td>
                                                <td colspan="2">
                                                    <a target="_blank" href="coupon/edit/<?=$data['detail']['id_coupon']?>"><?=$data['detail']['coupon_code']?></a>
                                                </td>
                                            </tr>
                                            <?
                                            if($data['detail']['coupon_type']!='gift'){
                                                ?>
                                                <tr>
                                                    <td colspan="5">Tổng chi phí giảm</td>
                                                    <td colspan="2">
                                                        <b><?=number_format($data['detail']['total_price_promotion'],0,'.','.')?> đ</b>
                                                    </td>
                                                </tr>
                                                <?   
                                            }
                                        }
                                        
                                        if ($data['detail']['ship_fee'] != 0) {
                                            ?>
                                            <tr>
                                                <td colspan="5">Phí giao hàng (Phương thức: <?= $data['detail']['title_ship_fee']; ?>)</td>
                                                <td colspan="2"><?=number_format($data['detail']['ship_fee'],0,'.','.')?> đ</td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="5">Thành tiền</td>
                                        <td colspan="2"><b><?=number_format($data['detail']['total_amount_sale'] + $data['detail']['ship_fee'],0,'.','.')?> đ</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
            <div class="row">
                <div class="col-md-12">
                    <table id="user" class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2"><b>Thông tin người đặt</b></td>
                            </tr>
                            <tr>
                                <td> Họ tên </td>
                                <td> <a><?=$data['detail']['cus_fullname']?></a></td>
                            </tr>
                            <tr>
                                <td> Số điện thoại</td>
                                <td> <a><?=$data['detail']['cus_phone']?></a></td>
                            </tr>
                            <tr>
                                <td> Email </td>
                                <td> <a><?=$data['detail']['cus_email']?></a></td>
                            </tr>
                            <tr>
                                <td> Địa chỉ  </td>
                                <td> <a><?=$data['detail']['cus_address']?></a></td>
                            </tr>
                            <?php
                            if ($data['detail']['city_title']) {
                                ?>
                                <tr>
                                    <td> Tỉnh / Thành phố  </td>
                                    <td> <a>
                                        <?=$data['detail']['city_title']?>
                                    </a></td>
                                </tr>
                                <?php
                            }

                            if ($data['detail']['district_title']) {
                                ?>
                                <tr>
                                    <td> Quận / Huyện  </td>
                                    <td> <a>
                                        <?=$data['detail']['district_title']?>
                                        
                                    </a></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2"> <span class="required sbold font-red"> *Ghi chú: </span> <i><?=$data['detail']['note']?></i> </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green sbold uppercase">Thao tác</span>
                    </div>
                </div>
                 <div class="portlet-body form">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <div class="actions" style="float: right;">
                                    <div class="btn-group">
                                        <a class="btn btn-sm default dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Cập nhật trạng thái
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/0/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Mới                                  
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/1/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Đã xác nhận                                  
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/2/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Chưa thanh toán
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/3/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Đã thanh toán chưa gửi hàng                       
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/4/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Hoàn tất                      
                                                </a>
                                            </li>
                                            
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/5/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Bị hoàn trả                                  
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_active/6/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                                    Bị hủy                          
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/delete_popup" typepopup="1" onclick="quickAction(this)">
                                                    Xóa                                        
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <span>Trạng thái </span>
                                <span class="sbold <?=$classStatus?>" style="float: right;"><?=lang('is_active_'.$data['detail']['is_active'])?></span>
                            </div>
                            
                            <div class="col-md-12">
                                <span>Ngày đặt </span>
                                <span class="sbold" style="float: right;"><?=date('g:i a d-m-Y',$data['detail']['time'])?></span>
                            </div>
                            <div class="col-md-12">
                                <span>Người quản lý </span>
                                <span class="sbold" style="float: right;"><?=$data['detail']['u_update_fullname']?></span>
                            </div>
                            <div class="col-md-12">
                                <span>Lần cập nhật sau cùng </span>
                                <span class="sbold" style="float: right;"><?=date('g:i a d-m-Y',$data['detail']['time_update'])?></span>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success" style="float: right;width:100%">ĐĂNG DỮ LIỆU</button>
                            </div>
                        </div>
                        <div class="form-group" field-id="note_admin">
                            <div class="col-md-12">
                                <textarea name="note_admin" class="form-control" rows="4" placeholder="Ghi chú đơn hàng của quản trị viên..."><?=$data['detail']['note_admin']?></textarea>
                                <span class="help-block help-block-error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</form>