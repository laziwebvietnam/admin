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
        <?
    }
?>

<div class="row">
    <div class="col-md-4 page-404" style="text-align: right;">
        <div class="number font-green"> 404 </div>
    </div>
    <div class="col-md-8 page-404" style="text-align: left;">
        
        <div class="details">
            <h3>Lỗi - không xác định liên kết</h3>
            <p> Chúng tôi không thể tìm được link bạn muốn truy cập.
                <br>
                Bạn có thể <a href=""> quay lại trang chủ </a> hoặc <a onclick="window.history.back()">quay lại trang trước đó</a>. </p>
        </div>
    </div>
</div>
