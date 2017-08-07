<?
    $data_table_title = 'undefined';
    $data_table_link = null;
    if(isset($data['detail'][$data['detail']['data_table'].'_title'])){
        $data_table_title = $data['detail'][$data['detail']['data_table'].'_title'];
        $data_table_link = $data['detail']['data_table'].'/edit/'.$data['detail']['data_id'];
    }
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Chi tiết bình luận</h4>
</div>
<div class="modal-body">
    <form action="#" class="form-horizontal">   
        <div class="portlet-body">
            <div class="timeline">
                <!-- TIMELINE ITEM -->
                <div class="timeline-item">
                    <div class="timeline-badge">
                        <img class="timeline-badge-userpic" src="<?=$data['detail']['cus_image']?>"/> </div>
                    <div class="timeline-body">
                        <div class="timeline-body-arrow"> </div>
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <a href="javascript:;" class="timeline-body-title font-blue-madison"><?=$data['detail']['cus_fullname']?></a>
                                <span class="timeline-body-time font-grey-cascade">Vào lúc: <?=date('d-m-Y G:i',$data['detail']['time'])?></span>
                            </div>
                            
                            <div class="timeline-body-head-actions">
                                <div class="btn-group">
                                    <button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Thao tác
                                        <i class="fa fa-angle-down">
                                        </i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="javascript:;" onclick="create_popup('comment/popup_reply/<?=$data['detail']['id']?>')">Phản hồi </a>
                                        </li>
                                        <!-- <li>
                                            <a href="comment/edit/<?=$data['detail']['id']?>">Chỉnh sửa </a>
                                        </li> -->
                                        <li class="divider"> </li>
                                        <li>
                                            <a href="javascript:;" posturl="comment/set_status/is_active/0/<?=$data['detail']['id']?>" onclick="quickAction(this)">Ẩn </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" posturl="comment/set_status/is_spam/1/<?=$data['detail']['id']?>" onclick="quickAction(this)">Spam </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" posturl="comment/set_status/is_delete/1/<?=$data['detail']['id']?>" onclick="quickAction(this)">Xóa </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
    
                        <div class="timeline-body-content">
                            <span>
                                Thuộc bài: <a href="<?=$data_table_link!=null?$data_table_link:'javascript:;'?>"><?=$data_table_title?></a>, 
                                Email: <a href="<?=$data_table_link!=null?$data_table_link:'javascript:;'?>"><?=$data['detail']['cus_email']?></a>, 
                                Phone: <a href="javascript:;"><?=$data['detail']['cus_email']?></a></span>
                            <hr />
                            <span class="font-grey-cascade"><?=strip_tags($data['detail']['content'])?></span>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <a class="btn blue" href="comment/detail/<?=$data['detail']['id']?>">Xem chi tiết</a>
    <a class="btn green" onclick="create_popup('comment/popup_reply/<?=$data['detail']['id']?>'); return false;">Phản hồi</a>
</div>