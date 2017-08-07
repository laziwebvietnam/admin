<?=$this->data_view['breadcrumb']?>

<form>
<div class="m-heading-1 border-green m-bordered">
    <h3>Bộ lọc tìm kiếm nâng cao</h3>
    <div class="row">
        <?
            create_input_search('title',lang('title'),isset($_GET['title'])?$_GET['title']:'','Nhập tên blank...',4);
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
            create_checkbox_search_multy('Trạng thái sản phẩm',$array_checkbox,12);
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
