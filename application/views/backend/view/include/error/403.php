<link href="<?=$this->_base_url_template_admin?>/assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
<?
    if(!__IS_AJAX__){
        ?>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href=""><?=lang('home/index')?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Thông báo lỗi</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-4 page-404" style="text-align: right;">
                <div class="number font-green"> 403 </div>
            </div>
            <div class="col-md-8 page-404" style="text-align: left;">
                
                <div class="details">
                    <h3>Lỗi - bạn không có quyền hạn truy cập vào liên kết</h3>
                    <p> 
                        Quyền của bạn không đủ để truy cập liên kết. <br /> 
                        Vui lòng liên hệ với <b>quản trị viên cấp cao</b> để nâng quyền
                        hoặc thông báo cho quản trị viên. 
                        <br/>Xin cám ơn.
                        <br/><br />
                        Bạn có thể <a href=""> quay lại trang chủ </a> hoặc <a onclick="window.history.back()">quay lại trang trước đó</a>. </p>
                </div>
            </div>
        </div>
        <?
    }else{
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Thông báo</h4>
            
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 page-404" style="text-align: center;">
                    <div class="number font-green"> 403 </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 page-404" style="text-align: left;">
                    
                    <h3>Lỗi - bạn không có quyền hạn truy cập vào liên kết</h3>
                    <p> 
                        Quyền của bạn không đủ để truy cập liên kết. <br /> 
                        Vui lòng liên hệ với <b>quản trị viên cấp cao</b> để nâng quyền
                        hoặc thông báo cho quản trị viên. 
                        <br/>Xin cám ơn.
                        <br/><br />
                        Bạn có thể <a href=""> quay lại trang chủ </a> hoặc <a onclick="window.history.back()">quay lại trang trước đó</a>. </p>
                
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Tắt thông báo</button>
        </div>
        <?
    }
?>



