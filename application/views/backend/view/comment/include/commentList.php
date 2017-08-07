<? if($list){
        foreach($list as $key=>$item){
            $fullname = $item['cus_fullname'];
            $email = $item['cus_email'];
            $phone = $item['cus_phone'];
            $time = 'Vào lúc: '.date('g:i a d/m/Y',$item['time']);
             

            $status_position = array(
                'is_delete_1','is_spam_1','is_read_0','is_reply_0','is_active_0',
                'is_reply_1','is_read_1','is_spam_0','is_active_1'
            );
            
            $status_field = '';
            $status_value = '';
            if($status_position!=null){
                foreach($status_position as $status){
                    $position = strrpos($status,'_'); // $pos = 7, not 0
                    $field = substr($status,0,$position);
                    $value = substr($status,$position+1);
                    if($item[$field]==$value){
                        $status_field = $field;
                        $status_value = $value;
                        break;
                    }
                }
            }
            $status = lang($status_field.'_'.$status_value);

            $class = $key==0?'cmt_parent':'cmt_child';
            $class .= $item['id']==$id_active?' cmt_active':'';
            ?>

            <div class="timeline-item <?=$class?>">
                <div class="timeline-badge">
                    <img class="timeline-badge-userpic" src="../template/backend/assets/pages/media/users/avatar80_1.jpg"> </div>
                <div class="timeline-body">
                    <div class="timeline-body-arrow"> </div>
                    <div class="timeline-body-head">
                        <div class="timeline-body-head-caption">
                            <a href="javascript:;" class="timeline-body-title font-blue-madison"><?=$fullname?></a>
                            <span class="timeline-body-time font-grey-cascade"><?=$time?></span>
                            &nbsp;<a href="javascript:;" class="btn btn-sm default dropdown-toggle"> <?=$status?> </a>
                        </div>
                        
                        <div class="timeline-body-head-actions">
                            <div class="btn-group">
                                <button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Thao tác
                                    <i class="fa fa-angle-down">
                                    </i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="javascript:;" onclick="create_popup('comment/popup_reply/<?=$parent['id']?>')">Phản hồi </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="javascript:;" posturl="comment/set_status/is_active/0/<?=$item['id']?>" onclick="quickAction(this)">Ẩn </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" posturl="comment/set_status/is_spam/1/<?=$item['id']?>" onclick="quickAction(this)">Spam </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" posturl="comment/set_status/is_delete/1/<?=$item['id']?>" onclick="quickAction(this)">Xóa </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>

                    <div class="timeline-body-content">
                        <?
                            if($item['is_admin']==0){
                                ?>
                                <span>
                                    Email: <a><?=$email?></a>, 
                                    Phone: <a><?=$phone?></a>
                                </span>
                                
                                <?
                            }
                        ?>
                        <hr />
                        <span class="font-grey-cascade"> <?=$item['content']?> </span>
                            
                    </div>
                </div>
            </div>

            <?
        }
    }
?>