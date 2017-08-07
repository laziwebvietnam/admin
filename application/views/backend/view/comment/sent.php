<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="">Bảng điều khiển</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:void(0)">Liên hệ</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Quản lý liên hệ</h3>

<div class="inbox">
    <div class="row">
        <div class="col-md-3">
            <div class="inbox-sidebar">
                <a href="contact/sent" data-title="Compose" class="btn red compose-btn btn-block">
                    <i class="fa fa-edit"></i> Gửi liên hệ </a>
                <ul class="inbox-nav">
                    <li class="active">
                        <a href="contact/index" data-type="inbox" data-title="Inbox"> Liên hệ mới
                            <span class="badge badge-success">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="contact/index" data-type="sent" data-title="Sent"> Chưa phản hồi 
                            <span class="badge badge-danger">8</span>
                        </a>
                    </li>
                    <li>
                        <a href="contact/index" data-type="draft" data-title="Draft"> Tất cả
                            
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="contact/index" class="sbold uppercase" data-title="Trash"> Đã xóa
                            <span class="badge badge-info">23</span>
                        </a>
                    </li>
                    <li>
                        <a href="contact/index" data-type="inbox" data-title="Promotions"> Đã phản hồi
                            <span class="badge badge-warning">2</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="inbox-body">
                <div class="inbox-header">
                    <h1 class="pull-left">Danh sách</h1>
                    <form class="form-inline pull-right" action="index.html">
                        <div class="input-group input-medium">
                            <input type="text" class="form-control" placeholder="Nhập email...">
                            <span class="input-group-btn">
                                <button type="submit" class="btn green">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                <form class="inbox-compose form-horizontal" id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                    <div class="inbox-compose-btn">
                        <button class="btn green">
                            <i class="fa fa-check"></i>Gửi</button>
                        <button class="btn default">Lưu nháp</button>
                    </div>
                    <div class="inbox-form-group mail-to">
                        <label class="control-label">Mail nhận:</label>
                        <div class="controls controls-to">
                            <input type="text" class="form-control" name="to">
                        </div>
                    </div>
                    <div class="inbox-form-group">
                        <label class="control-label">Tiêu đề:</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="subject"> </div>
                    </div>
                    <div class="inbox-form-group">
                        <textarea class="inbox-editor inbox-wysihtml5 form-control editor" name="message" rows="12"></textarea>
                    </div>
                
                    <!-- The template to display files available for download -->
                    
                    <div class="inbox-compose-btn">
                        <button class="btn green">
                            <i class="fa fa-check"></i>Gửi</button>
                        <button class="btn default">Lưu nháp</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->



