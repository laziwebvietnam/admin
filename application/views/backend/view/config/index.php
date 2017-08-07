<?=$this->data_view['breadcrumb']?>
<form id="form-submit" action="<?=$this->_table?>/action" class="form-horizontal"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    <input type="hidden" name="type_action" value="edit" />
    <input type="hidden" name="googlemap_lat" value="<?=isset($data['config']['googlemap_lat'])?$data['config']['googlemap_lat']:null?>" />
    <input type="hidden" name="googlemap_lng" value="<?=isset($data['config']['googlemap_lng'])?$data['config']['googlemap_lng']:null?>" />
    <div class="row"    >
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-purple-soft bold uppercase">Thông tin cấu hình</span>
                    </div>
                    <div class="btn-group pull-right">
                        <button class="btn green" type="submit"> Lưu cấu hình </button>
                    </div>
                </div>
                <div class="portlet-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_config_general" data-toggle="tab"> Cấu hình chung </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Thông tin liên hệ
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#tab_contact_vi" tabindex="-1" data-toggle="tab"> Tiếng Việt </a>
                                </li>
                                <li>
                                    <a href="#tab_contact_en" tabindex="-1" data-toggle="tab"> Tiếng Anh </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> SEO
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#tab_seo_vi" tabindex="-1" data-toggle="tab"> Tiếng Việt </a>
                                </li>
                                <li>
                                    <a href="#tab_seo_en" tabindex="-1" data-toggle="tab"> Tiếng Anh </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li id="config_googlemap">
                            <a href="#tab_googlemap" data-toggle="tab"> Bản đồ </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Thông báo
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#tab_alert_vi" tabindex="-1" data-toggle="tab"> Tiếng Việt </a>
                                </li>
                                <li>
                                    <a href="#tab_alert_en" tabindex="-1" data-toggle="tab"> Tiếng Anh </a>
                                </li>
                            </ul>
                        </li>
                        <li id="config_googlemap">
                            <a href="#tab_config_code" data-toggle="tab"> Cài đặt mã </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!--  Config general -->
                        <div class="tab-pane fade active in" id="tab_config_general">
                            <?
                                create_image('logo','Hình logo (120x120)',isset($data['config']['logo'])?$data['config']['logo']:'');
                                create_image('logo_icon','Hình icon logo (25x25)',isset($data['config']['logo_icon'])?$data['config']['logo_icon']:'');                                  ?>
                        </div>
                        <!--  Config contact (vietnamese) -->
                        <div class="tab-pane fade" id="tab_contact_vi">
                            <?
                                create_input('contact_company','Tên công ty',isset($data['config']['contact_company'])?$data['config']['contact_company']:'');
                                create_input('contact_address','Địa chỉ',isset($data['config']['contact_address'])?$data['config']['contact_address']:'');
                                create_input('contact_hotline','Hotline',isset($data['config']['contact_hotline'])?$data['config']['contact_hotline']:'');
                                create_input('contact_email','Email',isset($data['config']['contact_email'])?$data['config']['contact_email']:'');
                                create_input('social_facebook','Facebook (fanpage, user profile',isset($data['config']['social_facebook'])?$data['config']['social_facebook']:'');
                                create_input('social_google','Google plus',isset($data['config']['social_google'])?$data['config']['social_google']:'');
                                create_input('social_instagram','Instagram',isset($data['config']['social_instagram'])?$data['config']['social_instagram']:'');
                                create_input('social_pinterest','Pinterest',isset($data['config']['social_pinterest'])?$data['config']['social_pinterest']:'');
                            ?>
                        </div>
                        <!-- config contact (english) -->
                        <div class="tab-pane fade" id="tab_contact_en">
                            <?
                                create_input('en_contact_company','Tên công ty',isset($data['config']['en_contact_company'])?$data['config']['en_contact_company']:'');
                                create_input('en_contact_address','Địa chỉ',isset($data['config']['en_contact_address'])?$data['config']['en_contact_address']:'');
                            ?>
                        </div>

                        <!-- config seo (vietnamese) -->
                        <div class="tab-pane fade" id="tab_seo_vi">
                            <?
                                create_input('seo_title_tail','Tiêu đề đuôi',isset($data['config']['seo_title_tail'])?$data['config']['seo_title_tail']:'',true,15,'Tiêu đề đuôi. Vd: Thiết kế website trọn gói - Laziweb');
                                create_input('seo_title','Tiêu đề SEO (mặc định)',isset($data['config']['seo_title'])?$data['config']['seo_title']:'',true,80,'Nội dung thẻ <title>');
                                create_textarea('seo_desc','Mô tả SEO (mặc định)',isset($data['config']['seo_desc'])?$data['config']['seo_desc']:'',true,255,'Nội dung thẻ <meta type=\'description\'>');
                                create_textarea('seo_keyword','Từ khóa SEO (mặc định)',isset($data['config']['seo_keyword'])?$data['config']['seo_keyword']:'',true,255,'Nội dung thẻ <meta type=\'keyword\'>');
                            ?>
                        </div>

                        <!-- config seo (english) -->
                        <div class="tab-pane fade" id="tab_seo_en">
                            <?
                                create_input('en_seo_title_tail','Tiêu đề đuôi',isset($data['config']['en_seo_title_tail'])?$data['config']['en_seo_title_tail']:'',true,15,'Tiêu đề đuôi. Vd: Thiết kế website trọn gói - Laziweb');
                                create_input('en_seo_title','Tiêu đề SEO (mặc định)',isset($data['config']['en_seo_title'])?$data['config']['en_seo_title']:'',true,80,'Nội dung thẻ <title>');
                                create_textarea('en_seo_desc','Mô tả SEO (mặc định)',isset($data['config']['en_seo_desc'])?$data['config']['en_seo_desc']:'',true,255,'Nội dung thẻ <meta type=\'description\'>');
                                create_textarea('en_seo_keyword','Từ khóa SEO (mặc định)',isset($data['config']['en_seo_keyword'])?$data['config']['en_seo_keyword']:'',true,255,'Nội dung thẻ <meta type=\'keyword\'>');
                            ?>
                        </div>

                        <!-- config googlemap -->
                        <div class="tab-pane" id="tab_googlemap">
                            <div class="form-inline margin-bottom-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="gmap_geocoding_address" placeholder="nhập địa chỉ...">
                                    <span class="input-group-btn">
                                        <button class="btn blue" id="gmap_geocoding_btn">
                                            <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            <div id="gmap_geocoding" class="gmaps"> </div>
                        </div>

                        <!-- config alert (vietnamese) -->
                        <div class="tab-pane fade" id="tab_alert_vi">
                            <?
                                create_editor('order_alert_success','Thông báo khi đặt hàng thành công',isset($data['config']['order_alert_success'])?$data['config']['order_alert_success']:'');
                                create_editor('contact_alert_success','Thông báo khi liên hệ thành công',isset($data['config']['contact_alert_success'])?$data['config']['contact_alert_success']:'');
                            ?>
                        </div>

                        <!-- config alert (english) -->
                        <div class="tab-pane fade" id="tab_alert_en">
                            <?
                                create_editor('en_order_alert_success','Thông báo khi đặt hàng thành công',isset($data['config']['en_order_alert_success'])?$data['config']['en_order_alert_success']:'');
                                create_editor('en_contact_alert_success','Thông báo khi liên hệ thành công',isset($data['config']['en_contact_alert_success'])?$data['config']['en_contact_alert_success']:'');
                            ?>
                        </div>

                        <!-- config code -->
                        <div class="tab-pane fade" id="tab_config_code">
                            <?
                                create_textarea('code_ga','Mã google analytics',isset($data['config']['code_ga'])?$data['config']['code_ga']:'',null,null,'Tạo mã tại: http://bit.ly/1KX1Wns');
                                create_textarea('code_chatonline','Mã code chat online',isset($data['config']['code_chatonline'])?$data['config']['code_chatonline']:'',null,null,'Tạo mã tại: http://bit.ly/2ef1Id8');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

