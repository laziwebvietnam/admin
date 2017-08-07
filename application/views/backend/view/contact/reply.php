<?=$this->data_view['breadcrumb']?>
<?
    $slug = $this->uri->segment(3);
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
            <div class="inbox-body">
                <div class="inbox-header">
                    <h1 class="pull-left">Biểu mẫu gửi mail</h1>
                </div>
                <form class="inbox-compose form-horizontal" id="form-submit" action="<?=$this->_table?>/action_sentmail" 
                        onsubmit="form_submit_check_validation('submit');return false;"
                        method="POST">
                    <input type="hidden" name="id" value="<?=$data['detail']['id']?>"/>
                    <input type="hidden" name="email" value="<?=$data['detail']['cus_email']?>"/>
                    <div class="inbox-compose-btn">
                        <button class="btn green"><i class="fa fa-check"></i>Gửi</button>
                        <!--button class="btn default">Lưu nháp</button-->
                    </div>
                    <div class="inbox-form-group mail-to" field-id="email">
                        <label class="control-label">Mail nhận:</label>
                        <div class="controls controls-to">
                            <input type="text" class="form-control" value="<?=$data['detail']['cus_email']?>"/>
                            
                        </div>
                        <span class="help-block help-block-error"></span>
                    </div>
                    <div class="inbox-form-group" field-id="title_reply">
                        <label class="control-label">Tiêu đề:</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="title_reply" value="<?=$data['detail']['title_reply']?>" />
                            <span class="help-block help-block-error"></span> 
                        </div>
                    </div>
                    <div class="inbox-form-group" field-id="content_reply">
                        <textarea class="inbox-editor inbox-wysihtml5 form-control editor" name="content_reply" rows="12"><?=$data['detail']['content_reply']?></textarea>
                        <span class="help-block help-block-error"></span> 
                    </div>
                
                    <!-- The template to display files available for download -->
                    
                    <div class="inbox-compose-btn">
                        <button type="submit" class="btn green">
                            <i class="fa fa-check"></i>Gửi</button>
                        <!--button onclick="form_submit_check_validation('savedraft')" class="btn default">Lưu nháp</button-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
