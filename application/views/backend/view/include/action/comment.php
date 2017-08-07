<?
    if(isset($data['detail'])){
        if($data['detail']!=null){
            
            
            $where = array('tb.data_table'=>$this->_table,'tb.data_id'=>$data['detail']['id']);
            $this->db->flush_cache();
            $commentByTable = $this->M_comment->get_all($where,0,5);
            $status_position = array(
                'is_delete_1','is_spam_1','is_read_0','is_reply_0','is_active_0',
                'is_reply_1','is_read_1','is_spam_0','is_active_1'
            );
            
?>
<div class="portlet light bordered">
    <?
        create_tab('Bình luận ('.count($commentByTable).')',true,null,false);
    ?>
    <div class="portlet-body" style="display: none;">
        <div class="timeline">
            <!-- TIMELINE ITEM -->
            <?
                if($commentByTable!=null){
                    
                    foreach($commentByTable as $row){
                        $status_field = '';
                        $status_value = '';
                        if($status_position!=null){
                            foreach($status_position as $status){
                                $position = strrpos($status,'_'); // $pos = 7, not 0
                                $field = substr($status,0,$position);
                                $value = substr($status,$position+1);
                                if($row[$field]==$value){
                                    $status_field = $field;
                                    $status_value = $value;
                                    break;
                                }
                            }
                        }
                        ?>
                        
                        <div class="timeline-item">
                            <div class="timeline-badge">
                                <img class="timeline-badge-userpic" src="<?=$row['cus_image']?>"/> 
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-body-arrow"> </div>
                                <div class="timeline-body-head">
                                    <div class="timeline-body-head-caption">
                                        <a href="javascript:;" class="timeline-body-title font-blue-madison"><?=$row['cus_fullname']?></a>
                                        <span class="timeline-body-time font-grey-cascade">Vào lúc: <?=date('d-m-Y G:i',$row['time'])?></span>
                                        
                                    </div>
                                    
                                    <div class="timeline-body-head-actions">
                                        <div class="btn-group">
                                            <button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Thao tác
                                                <i class="fa fa-angle-down">
                                                </i>
                                            </button>
                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li>
                                                    <a href="javascript:;" onclick="create_popup('comment/popup_reply/<?=$row['id']?>')">Phản hồi </a>
                                                </li>
                                                <li>
                                                    <a href="comment/edit/<?=$row['id']?>">Chỉnh sửa </a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;" posturl="comment/set_statusByGET/comment/is_active/0/<?=$row['id']?>" onclick="quickAction(this)">Ẩn </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" posturl="comment/set_statusByGET/comment/is_spam/1/<?=$row['id']?>" onclick="quickAction(this)">Spam  </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" posturl="comment/set_statusByGET/comment/is_delete/1/<?=$row['id']?>" onclick="quickAction(this)">Xóa </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
            
                                <div class="timeline-body-content">
                                    <span>Email: <a><?=$row['cus_email']?></a>, 
                                    Phone: <a><?=$row['cus_phone']?></a></span>, 
                                    Trạng thái: <span class="font-red-thunderbird"><?=lang($status_field.'_'.$status_value)?></span>
                                    <hr />
                                    <span class="font-grey-cascade"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                        ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </span>
                                </div>
                            </div>
                        </div>
                        
                        <?    
                    }
                }
            ?>
            <!-- END TIMELINE ITEM -->
            
        </div>
    </div>
</div>
<?    
    }
}
?>