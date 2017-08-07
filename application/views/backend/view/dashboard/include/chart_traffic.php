
<div class="col-md-6 col-sm-6">
    <!-- BEGIN PORTLET-->
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bar-chart font-green"></i>
                <span class="caption-subject font-green bold uppercase">Lượt truy cập</span>
                <span class="caption-helper">số liệu 07 ngày gần đây</span>
                
            </div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <label class="btn red btn-outline btn-circle btn-sm active" onclick="changeChartTraffic(this)">
                        <input type="radio" name="options" class="toggle" dateTo="<?=date('Y-m-d',time()-86400*7)?>" dateEnd="<?=date('Y-m-d',time())?>"/>Tuần
                    </label>
                    <label class="btn red btn-outline btn-circle btn-sm" onclick="changeChartTraffic(this)">
                        <input type="radio" name="options" class="toggle" dateTo="<?=date('Y-m-d',time()-86400*31)?>" dateEnd="<?=date('Y-m-d',time())?>"/>Tháng
                    </label>
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div id="site_statistics_loading">
                <img src="../template/backend/assets/global/img/loading.gif" alt="loading" /> 
            </div>
            <div id="site_statistics_content" class="display-none">
                <div id="site_statistics" class="chart"> </div>
            </div>
        </div>
    </div>
    <!-- END PORTLET-->
</div>
