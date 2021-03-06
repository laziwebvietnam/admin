<?=$this->data_view['breadcrumb']?>

<form>
<div class="m-heading-1 border-green m-bordered">
    <h3>Bộ lọc tìm kiếm nâng cao</h3>
    <div class="row">
        <?
            create_input_search('title',lang('title'),isset($_GET['title'])?$_GET['title']:'','Nhập tiêu đề...',4);
            create_select_search_basic('id_user','Người đăng',isset($_GET['id_user'])?$_GET['id_user']:'',$data['user'],'fullname',3);
            create_datetimepicker_range_search('Thời gian',array('name'=>'dayTo','val'=>isset($_GET['dayTo'])?$_GET['dayTo']:''),array('name'=>'dayEnd','val'=>isset($_GET['dayEnd'])?$_GET['dayEnd']:''));
        ?>
    </div>
    <div class="row">
        <?
            create_select_search('id_category',lang('id_category'),isset($_GET['id_category'])?$_GET['id_category']:-1,$data['category'],4);
            
            $tag_selected = isset($_GET['id_tag'])?$_GET['id_tag']:'';
            $tag_selected = return_tag_byString($tag_selected);
            $input_tag['dataComplete'] = array();
            if($data['tag_complete']){
                foreach($data['tag_complete'] as $row){
                    $input_tag['dataComplete'][] = array(
                        'id'=>$row['alias'],
                        'name'=>$row['title'],
                        'selected'=>in_array($row['alias'],$tag_selected)
                    );                    
                }
            }            
            create_input_tag_search('id_tag',lang('id_tag'),$input_tag,8);
        ?>
        
    </div>
    <div class="row">
        <?
            $array_checkbox = array();
            if($this->data_view['cate_popup']['status'] != null){
                foreach($this->data_view['cate_popup']['status'] as $row){
                    $array_checkbox[] = array(
                        'name'=>$row,
                        'title'=>$row,
                        'value'=>1,
                        'checked'=>isset($_GET[$row])?true:false
                    );
                }
            }
            create_checkbox_search_multy('Trạng thái sản phẩm',$array_checkbox,4);
        ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn green">
                <i class="fa fa-search"></i> Tìm kiếm
            </button>
        </div>
    </div>
</div>
</form>
<? if($data['list']!=null){ ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase">Kết quả tìm kiếm</span>
                </div>
                <?=$this->data_view['dataTable']['column_html']?>
                <?=$this->data_view['dataTable']['export_html']?>
            </div>
            <? $this->load->view($this->_base_view_path.'view/include/datatable') ?>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<? } ?>
