<div class="col-md-6 col-sm-6">
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <i class="icon-bubbles font-red"></i>
                <span class="caption-subject font-red bold uppercase">LIÊN HỆ</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#portlet_comments_1" data-toggle="tab"> Chưa xem </a>
                </li>
                <li>
                    <a href="#portlet_comments_2" data-toggle="tab"> Chưa trả lời </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_comments_1">
                        <!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            <?
                                if($data['info']['contact_noread'] != null){
                                    foreach($data['info']['contact_noread'] as $row){
                                        ?>
                                        <div class="mt-comment">
                                            <div class="mt-comment-body">
                                                <div class="mt-comment-info">
                                                    <span class="mt-comment-author"><?=$row['cus_fullname']?></span>
                                                    <span class="mt-comment-date"><?=date('d-m-Y G:i:a',$row['time'])?></span>
                                                </div>
                                                <div class="mt-comment-text"> <?=$row['content']?> </div>
                                                <div class="mt-comment-details">
                                                    <ul class="mt-comment-actions">
                                                        <li>
                                                            <a href="contact/readContact/<?=$row['id']?>">Xem chi tiết</a>
                                                        </li>
                                                        <li>
                                                            <a href="contact/replyContact/<?=$row['id']?>">Trả lời</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" onclick="create_popup('contact/delete_once_popup/<?=$row['id']?>')">Xóa</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                    }
                                }  
                            ?>
                        </div>
                        <!-- END: Comments -->
                    </div>
                    <div class="tab-pane" id="portlet_comments_2">
                        <!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            <?
                                if($data['info']['contact_noreply'] != null){
                                    foreach($data['info']['contact_noreply'] as $row){
                                        ?>
                                        <div class="mt-comment">
                                            <div class="mt-comment-body">
                                                <div class="mt-comment-info">
                                                    <span class="mt-comment-author"><?=$row['cus_fullname']?></span>
                                                    <span class="mt-comment-date"><?=date('d-m-Y G:i:a',$row['time'])?></span>
                                                </div>
                                                <div class="mt-comment-text"> <?=$row['content']?> </div>
                                                <div class="mt-comment-details">
                                                    <ul class="mt-comment-actions">
                                                        <li>
                                                            <a href="contact/readContact/<?=$row['id']?>">Xem chi tiết</a>
                                                        </li>
                                                        <li>
                                                            <a href="contact/replyContact/<?=$row['id']?>">Trả lời</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" onclick="create_popup('contact/delete_once_popup/<?=$row['id']?>')">Xóa</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                    }
                                }  
                            ?>
                        </div>
                        <!-- END: Comments -->
                    </div>
                </div>
            </div>
            <div class="scroller-footer">
                <div class="btn-arrow-link pull-right">
                    <a href="contact">Xem tất cả</a>
                    <i class="icon-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>