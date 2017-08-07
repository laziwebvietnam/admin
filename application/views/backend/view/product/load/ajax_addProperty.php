<div class="row">
    <?
        // $tag_pro_size = isset($data['pro_size_checked'])?$data['pro_size_checked']:array();
        // $tag_pro_size = return_arrayKey($tag_pro_size,'id');
        $input_tag_pro_size = array();
        if($pro_size){
            foreach($pro_size as $row){
                $input_tag_pro_size['dataComplete'][] = array(
                    'id'=>$row['alias'],
                    'name'=>$row['title'],
                    'selected'=>false
                );                    
            }
        }
        
        create_input_tag_search_multy('pro_size','pro_size_'.$pro_size_id,lang('pro_size'),$input_tag_pro_size,7,true);

        create_input_search('price_size[]',lang('price_size'),null,'Giá',3);

    ?>
    <div class="col-md-2 property_button_remove">
        <!-- a class="btn red-mint" data-toggle="confirmation" data-placement="right" data-btn-ok-label="Đồng ý" data-btn-ok-icon="icon-like" data-btn-ok-class="btn-success" data-btn-cancel-label="Không"
                                    data-btn-cancel-icon="icon-close" data-btn-cancel-class="btn-danger">
            Xóa <i class="fa fa-remove"></i>
        </a> -->
        <a href="javascript:;" class="btn red" onclick="perperty_button_remove(this)"> 
        	Xóa 
        	<i class="fa fa-remove"></i>
    	</a>
    </div>
</div>
