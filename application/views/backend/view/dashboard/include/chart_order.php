<div class="col-md-6 col-sm-6">
    <!-- BEGIN PORTLET-->
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-red-sunglo hide"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">Doanh thu</span>
                <span class="caption-helper">số liệu 07 ngày gần đây</span>
            </div>
            <div class="actions">
                <div class="btn-group">
                    <a href="" class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Bộ lọc
                        <span class="fa fa-angle-down"> </span>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li class="active">
                            <a onclick="changeChartOrder(this)" href="javascript:;" dateTo="<?=date('Y-m-d',time()-86400*7)?>" dateEnd="<?=date('Y-m-d',time())?>"> 01 tuần</a>
                        </li>
                        <li>
                            <a onclick="changeChartOrder(this)" href="javascript:;" dateTo="<?=date('Y-m-d',time()-86400*14)?>" dateEnd="<?=date('Y-m-d',time())?>"> 02 tuần</a>
                        </li>
                        <li>
                            <a onclick="changeChartOrder(this)" href="javascript:;" dateTo="<?=date('Y-m-d',time()-86400*31)?>" dateEnd="<?=date('Y-m-d',time())?>"> 01 tháng</a>
                        </li>
                        <li>
                            <a onclick="changeChartOrder(this)" href="javascript:;" dateTo="<?=date('Y-m-d',time()-86400*62)?>" dateEnd="<?=date('Y-m-d',time())?>"> 02 tháng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div id="site_activities_loading">
                <img src="../template/backend/assets/global/img/loading.gif" alt="loading" /> </div>
            <div id="site_activities_content" class="display-none">
                <div id="site_activities" style="height: 228px;"> </div>
            </div>
            <div style="margin: 20px 0 10px 30px">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-6 text-stat">
                        <span class="label label-sm label-success"> Tổng doanh thu: </span>
                        <h3 id="chart_order_total"></h3>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6 text-stat">
                        <span class="label label-sm label-info"> Số hàng đơn hàng: </span>
                        <h3 id="chart_order_qty"></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PORTLET-->
</div>