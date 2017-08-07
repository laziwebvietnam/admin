<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Thêm 05 sản phẩm vào danh mục</h4>
</div>
<div class="modal-body">
    <form action="#" class="form-horizontal">
        <?
            $select_array = $this->My_model->getlist('category',array('type'=>1),0,999,'position asc');
            create_select('id_category','Loại sản phẩm',null,true,$select_array,null,3);
        ?>
        
        <div class="form-group">
            <label class="control-label col-md-3">Chọn danh mục sản phẩm</label>
            <div class="col-md-9">
            <?
                create_checkbox('is_special','Sản phẩm nổi bật');
                create_checkbox('is_new','Sản phẩm mới');
                create_checkbox('is_promotion','Sản phẩm khuyến mãi');
                create_checkbox('is_stock','Hết hàng');
                create_checkbox('is_active','Ẩn sản phẩm');
            ?>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button class="btn green" data-dismiss="modal">Cập nhật</button>
</div>