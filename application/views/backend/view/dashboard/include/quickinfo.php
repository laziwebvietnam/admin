<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$data['info']['order']?>"></span>
                </div>
                <div class="desc"> Đơn hàng </div>
            </div>
            <a class="more" href="order"> Xem chi tiết
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$data['info']['contact']?>"></span>
                </div>
                <div class="desc"> Liên hệ </div>
            </div>
            <a class="more" href="contact"> Xem chi tiết
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$data['info']['product']?>"></span></div>
                <div class="desc"> Sản phẩm </div>
            </div>
            <a class="more" href="product"> Xem chi tiết
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number"> 
                    <span data-counter="counterup" data-value="<?=$data['info']['article']?>"></span></div>
                <div class="desc"> Bài viết </div>
            </div>
            <a class="more" href="article"> Xem chi tiết
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>