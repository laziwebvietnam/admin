<?
    if($this->_property==true){
?>

<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <span class="caption-subject font-green sbold uppercase">Thuộc tính sản phẩm</span>
        </div>

        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
        </div>



    </div>
    <div class="portlet-body form" id="product-property-form">
        <?
            if(isset($data['pro_property'])){
                if($data['pro_property']){
                    foreach($data['pro_property'] as $key=>$row){
                        $price = $row[0]['price'];
                        $sizeChecked = array();
                        if($row){
                            foreach($row as $propertyDetail){
                                $sizeChecked[] = $propertyDetail['id_size'];
                            }
                        }

                    ?>
                    <div class="row">
                    <?
                        // $tag_pro_size = isset($data['pro_size_checked'])?$data['pro_size_checked']:array();
                        // $tag_pro_size = return_arrayKey($tag_pro_size,'id');
                        $input_tag_pro_size = array();
                        if($data['pro_size']){
                            foreach($data['pro_size'] as $size){
                                $input_tag_pro_size['dataComplete'][] = array(
                                    'id'=>$size['alias'],
                                    'name'=>$size['title'],
                                    'selected'=>in_array($size['id'],$sizeChecked)
                                );                    
                            }
                        }
                        
                        create_input_tag_search_multy('pro_size','pro_size_'.$key,lang('pro_size'),$input_tag_pro_size,7,true);

                        create_input_search('price_size[]',lang('price_size'),$price,'Giá',3);
                    ?>
                        <div class="col-md-2 property_button_remove">
                            <a href="javascript:;" class="btn red" onclick="perperty_button_remove(this)"> Xóa
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                    <?
                    }
                }
            }
            
        ?>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 property_button_add">
                <a href="javascript:;" class="btn green"> Thêm
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<? } ?>

<style type="text/css">
.property_button_remove, .property_button_add{
    margin-top:25px;
}
.property_button_remove a, .property_button_add a{
    float:right;
}

</style>