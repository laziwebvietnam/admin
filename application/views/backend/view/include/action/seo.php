<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <span class="caption-subject font-green sbold uppercase">Tối ưu hóa SEO</span>
        </div>
        <ul class="nav nav-tabs tabs-reversed">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
                    Facebook
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="#portlet_tab_seo_facebook_vi" tabindex="-1" data-toggle="tab" aria-expanded="true"> Tiếng Việt </a>
                    </li>
                    <li>
                        <a href="#portlet_tab_seo_facebook_en" tabindex="-1" data-toggle="tab"> Tiếng Anh </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown active">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
                    Google
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li class="active">
                        <a href="#portlet_tab_seo_vi" tabindex="-1" data-toggle="tab" aria-expanded="true"> Tiếng Việt </a>
                    </li>
                    <li>
                        <a href="#portlet_tab_seo_en" tabindex="-1" data-toggle="tab"> Tiếng Anh </a>
                    </li>
                </ul>
            </li>
            
        </ul>
    </div>

    <?
        // $info_tab = array(
        //     array('id'=>'seo_vi','title'=>'Tiếng Việt'),
        //     array('id'=>'seo_en','title'=>'Tiếng Anh'),
        //     array('id'=>'seo_facebook','title'=>'Facebook'),
        // );
        // create_tab('Tối ưu hóa SEO',false,$info_tab);
    ?>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane active" id="portlet_tab_seo_vi">
                <div class="form-body">
                    <?
                        //$this->load->view($this->_base_view_path.'view/include/seo_preview');
                        create_input('seo[title]',lang('title_seo'),isset($data['seo'])?$data['seo']['title']:'',false,80,'Tiêu đề hiển thị trên Google');
                        create_textarea('seo[desc]',lang('desc_seo'),isset($data['seo'])?$data['seo']['desc']:'',false,200,'Mô tả hiển thị trên Google');
                        create_textarea('seo[keyword]',lang('keyword_seo'),isset($data['seo'])?$data['seo']['keyword']:'',false,200,'Từ khóa muốn tối ưu');
                    ?>
                    
                </div>
            </div>
            <div class="tab-pane" id="portlet_tab_seo_en">
                <div class="form-body">
                    <?
                        //$this->load->view($this->_base_view_path.'view/include/seo_preview');
                        create_input('seo[en_title]',lang('title_seo'),isset($data['seo'])?$data['seo']['en_title']:'',false,80,'Tiêu đề hiển thị trên Google');
                        create_textarea('seo[en_desc]',lang('desc_seo'),isset($data['seo'])?$data['seo']['en_desc']:'',false,200,'Mô tả hiển thị trên Google');
                        create_textarea('seo[en_keyword]',lang('keyword_seo'),isset($data['seo'])?$data['seo']['en_keyword']:'',false,null,'Từ khóa muốn tối ưu');
                    ?>
                </div>
            </div>
            <div class="tab-pane" id="portlet_tab_seo_facebook_vi">
                <div class="form-body">
                    <?
                        create_input('seo[title_facebook]',lang('title_seo_facebook'),isset($data['seo'])?$data['seo']['title_facebook']:'',false,80,'Tiêu đề hiển thị trên Facebook');
                        create_textarea('seo[desc_facebook]',lang('desc_seo_facebook'),isset($data['seo'])?$data['seo']['desc_facebook']:'',false,255,'Mô tả hiển thị trên Facebook');
                        create_image('seo[image]',lang('image_facebook'),isset($data['seo'])?$data['seo']['image']:null);
                    ?>
                </div>
            </div>
            <div class="tab-pane" id="portlet_tab_seo_facebook_en">
                <div class="form-body">
                    <?
                        create_input('seo[en_title_facebook]',lang('title_seo_facebook'),isset($data['seo'])?$data['seo']['en_title_facebook']:'',false,80,'Tiêu đề hiển thị trên Facebook');
                        create_textarea('seo[en_desc_facebook]',lang('desc_seo_facebook'),isset($data['seo'])?$data['seo']['en_desc_facebook']:'',false,255,'Mô tả hiển thị trên Facebook');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>