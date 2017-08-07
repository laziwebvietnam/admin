<?=$this->data_view['breadcrumb']?>
<?
    $data['detail'] = isset($data['detail'])?$data['detail']:null;
    $data['detail'] = $data['detail'];

    /** get alias */
    $alias_link = array();
    $type = $this->_table; /** type of category */
    $alias = return_valueKey($this->_template['typeCategory'],'id',$type,'alias'); 
    $alias_link['vi'] = base_url().$alias;
    $alias_link['en'] = base_url().'en/'.$alias;
?>
<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    
    <input type="hidden" name="type_action" value="<?=$data['detail']['id']!=null?'edit':'create'?>" />
    <input type="hidden" name="id" value="<?=$data['detail']['id']?>" />
    <input type="hidden" name="set_alias" value="<?=$this->data_view['dataCreate']['alias']==false?'false':'true'?>" />
    <div class="row">
        <div class="col-md-8">
            <div class="portlet light bordered">
                <?
                    $info_tab = array(
                        array('id'=>1,'title'=>'Tiếng Việt'),
                        array('id'=>2,'title'=>'Tiếng Anh'),
                    );
                    create_tab('Thông tin',false,$info_tab);
                ?>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab_1">
                            <div class="form-body">
                                <?
                                    create_input('title',lang('title'),$data['detail']['title'],true);
                                    create_input_addon('alias',lang('alias'),$alias_link['vi'],$data['detail']['alias'],true);
                                    create_textarea('desc',lang('desc'),$data['detail']['desc']);
                                    create_editor('content',lang('content'),$data['detail']['content']);
                                    
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="portlet_tab_2">
                            <div class="form-body">
                                 <?
                                    create_input('en_title',lang('title'),$data['detail']['en_title'],true);
                                    create_input_addon('en_alias',lang('alias'),$alias_link['en'],$data['detail']['en_alias'],true);
                                    create_textarea('en_desc',lang('desc'),$data['detail']['en_desc']);
                                    create_editor('en_content',lang('content'),$data['detail']['en_content']);
                                 ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet light bordered">
                <?
                    create_tab('Hình ảnh');
                ?>
                <div class="portlet-body form">
                    <?
                        create_image('image',lang('image'),$data['detail']['image']);
                        create_image('images',lang('images'),$data['detail']['images'],false,true);
                    ?>
                </div>
            </div>
            <?
                $this->load->view($this->_base_view_path.'view/include/action/comment');
                
                $this->load->view($this->_base_view_path.'view/include/action/seo',$data);
            ?>
        </div>
        <div class="col-md-4">
            <div class="portlet light bordered">
            <?
                create_tab('Danh mục & trạng thái');
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <?
                        create_select('id_category',null,$data['detail']['id_category'],true,$data['category'],null,0);
                    ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <a href="category/article" target="_blank"><i class="fa fa-plus"></i> Thêm loại bài viết</a>
                            <!-- onclick="create_popup('category/quick_create/product');" -->
                        </div>
                    </div>
                    <?
                        create_checkbox('is_special',lang('is_special'),1,$data['detail']!=null?$data['detail']['is_special']:0,false,null,4);
                        create_checkbox('is_active',lang('is_active'),1,$data['detail']!=null?$data['detail']['is_active']:1,false,null,4);
                        
                    ?>
                </div>
            </div>
        </div>
        <?
            $this->load->view($this->_base_view_path.'view/include/action/tag',$data);
            $this->load->view($this->_base_view_path.'view/include/action/action',$data);
        ?>
        </div>
    </div>
</form>

