<?=$this->data_view['breadcrumb']?>
<?
    $slug = $this->uri->segment(3);
    $status_position = array(
        'is_delete_1','is_spam_1','is_read_0','is_reply_0',
        'is_reply_1','is_read_1','is_spam_0'
    );
    
    $status_field = '';
    $status_value = '';
    if($status_position!=null){
        foreach($status_position as $status){
            $position = strrpos($status,'_'); // $pos = 7, not 0
            $field = substr($status,0,$position);
            $value = substr($status,$position+1);
            if($data['detail'][$field]==$value){
                $status_field = $field;
                $status_value = $value;
                break;
            }
        }
    }
?>
<div class="inbox">
    <div class="row">
        <div class="col-md-3">
            <div class="inbox-sidebar">
                <!--a href="contact/create" data-title="Compose" class="btn red compose-btn btn-block">
                    <i class="fa fa-edit"></i> Thêm mới 
                </a-->
                <ul class="inbox-nav">
                    <li class="<?=$slug=='inbox'?'active':''?>">
                        <a href="contact/inbox" data-type="inbox" data-title="Mới"> Liên hệ mới
                            <span class="badge badge-success"><?=$data['count']['inbox']?></span>
                        </a>
                    </li>
                    <li class="<?=$slug=='noreply'?'active':''?>">
                        <a href="contact/noreply" data-type="noreply" data-title="Chưa phản hồi"> Chưa phản hồi
                            <span class="badge badge-danger"><?=$data['count']['noreply']?></span>
                        </a>
                    </li>
                    <li class="<?=$slug==''?'active':($slug=='index'?'active':'')?>">
                        <a href="contact" data-type="" data-title="Tất cả"> Tất cả
                            
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="<?=$slug=='delete'?'active':''?>">
                        <a href="contact/delete" class="sbold uppercase" data-type="delete" data-title="Đã xóa"> Đã xóa
                            <span class="badge badge-info"><?=$data['count']['delete']?></span>
                        </a>
                    </li>
                    <li class="<?=$slug=='reply'?'active':''?>">
                        <a href="contact/reply" data-type="reply" data-title="Đã phản hồi"> Đã phản hồi
                            <span class="badge badge-warning"><?=$data['count']['reply']?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            
            <div class="inbox-header inbox-view-header">
                <h1 class="pull-left"><?=$data['detail']['title']?>
                    <a href="javascript:;"> <?=lang($status_field.'_'.$status_value)?> </a>
                </h1>
                <div class="pull-right">
                    <div class="btn-group">
                        <a class="btn green reply-btn" href="contact/replyContact/<?=$data['detail']['id']?>"> 
                            <i class="fa fa-reply"></i> Phản hồi
                        </a>
                    </div>
                </div>
            </div>
            <div class="inbox-view-info">
                <div class="row">
                    <div class="col-md-7">
                        <span class="sbold"><?=$data['detail']['cus_fullname']?></span>
                        <span><a>&#60;<?=$data['detail']['cus_email']?>&#62;</a></span> 
                        <span class="sbold">vào lúc</span> <span><?=date('g:i A d-m-Y',$data['detail']['time'])?></span><br />
                        <span class="sbold">Địa chỉ: </span> <span><?=$data['detail']['cus_address']?></span><br />
                        <span class="sbold">Điện thoại: </span> <span><a><?=$data['detail']['cus_phone']?></a></span>
                    </div>
                    <div class="col-md-5 inbox-info-btn">
                        <div class="btn-group">
                            <a class="btn btn-sm default dropdown-toggle" href="javascript:;" data-toggle="dropdown"> 
                                Cập nhật trạng thái <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_reply/0/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                        Chưa phản hồi                                        
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_reply/1/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                        Đã phản hồi                                        
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_spam/1/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                        Spam                                     
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="tool-action" posturl="<?=$this->_table?>/set_statusByGET/<?=$this->_table?>/is_spam/0/<?=$data['detail']['id']?>" typepopup="" onclick="quickAction(this)">
                                        Không spam                                     
                                    </a>
                                </li> -->
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;" onclick="create_popup('contact/delete_popup');"> Xóa  </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="inbox-view">
                <?=$data['detail']['content']?>
            </div>      
        </div>
    </div>
</div>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->



