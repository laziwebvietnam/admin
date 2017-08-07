<div class="col-md-6 col-sm-6">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-blue"></i>
                <span class="caption-subject font-blue bold uppercase">Nhật kí hoạt động</span>
            </div>
            <div class="actions">
                <form id="form-notification" onchange="loadNotification()">
                
                    <div class="btn-group">
                        <a class="btn btn-sm blue btn-outline btn-circle" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Bộ lọc
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                            <label><input type="checkbox" name="type[]" checked="" value="admin" /> Quản trị viên</label>
                            <label><input type="checkbox" name="type[]" checked="" value="user"/> Người dùng</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="portlet-body">
            <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                <ul id="loadNotification" class="feeds">
                </ul>
            </div>
            <div class="scroller-footer">
                <div class="btn-arrow-link pull-right">
                    <a href="notification">Xem tất cả</a>
                    <i class="icon-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>