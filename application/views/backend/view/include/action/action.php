<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-green sbold uppercase">Thao tác</span>
        </div>
    </div>
     <div class="portlet-body form">
        <div class="form-body">
        
            <? /*
            <div class="form-group">
                <div class="col-md-12">
                    <?
                        if(isset($this->data_action['savedraft'])){
                            if($this->data_action['savedraft']==true){
                                echo "<button type=\"button\" class=\"btn default\" onclick=\"form_submit_check_validation('savedraft')\" disable>Lưu nháp</button>";
                            }
                        }
                        if(isset($this->data_action['preview'])){
                            if($this->data_action['preview']==true){
                                echo "<button type=\"button\" class=\"btn default\" onclick=\"form_submit_check_validation('preview')\" style=\"float: right;\">Lưu nháp & xem trước</button>";
                            }
                        }
                    ?>
                    
                    
                </div>
            </div>
            */ ?>
            <div class="form-group">
                <?
                    if(isset($data['detail'])){
                        if($data['detail'] != null){
                            $status = '';
                            if(isset($data['detail']['is_active'])){
                                if($data['detail']['is_active']==1){
                                    $status = 'Đã đăng';
                                }else{
                                    $status = 'Đang ẩn';
                                }
                            }
                            
                            if(isset($data['detail']['is_draft'])){
                                if($data['detail']['is_draft']==1){
                                    $status = 'Lưu nháp';
                                };
                            }
                            ?>
                            <div class="col-md-12">
                                <span>Trạng thái </span>
                                <span class="sbold" style="float: right;">
                                <?=$status?>
                                </span>
                            </div>
                            <div class="col-md-12">
                                <span>Ngày tạo </span>
                                <span class="sbold" style="float: right;">
                                <?
                                    if(isset($detail['time'])){
                                        echo date('g:i A d-m',$detail['time']);
                                    }
                                ?>
                                </span>
                            </div>
                            <div class="col-md-12">
                                <span>Người tạo </span>
                                <span class="sbold" style="float: right;">
                                <?
                                    if(isset($detail['id_user'])){
                                        echo $detail['u_fullname'];
                                    } 
                                ?>
                                </span>
                            </div>
                            <div class="col-md-12">
                                <span>Lần cập nhật sau cùng </span>
                                <span class="sbold" style="float: right;">
                                <?
                                    if(isset($detail['time_update'])){
                                        echo date('g:i A d-m',$detail['time_update']);
                                    }
                                ?>
                                </span>
                            </div>
                            <div class="col-md-12">
                                <span>Người sửa sau cùng</span>
                                <span class="sbold" style="float: right;">
                                    <?
                                        if(isset($detail['id_user_update'])){
                                            echo $detail['u_update_fullname'];
                                        }
                                    ?>
                                </span>
                            </div>
                        <?
                        }
                    }
                ?>
                
                <!--div class="col-md-12">
                    <span>Đánh giá SEO</span>
                    <span class="sbold" style="float: right;">Tốt (7/10)</span>
                </div-->
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success" style="float: right;width:100%">ĐĂNG DỮ LIỆU</button>
                </div>
            </div>
        </div>
    </div>
</div>