
<form action="<?=$this->_table?>action_popup" class="form-horizontal" onsubmit="">
    <?
        create_input('title','Tên danh mục',null,true,null,null,3);
        create_select('id_category','Chọn danh mục cha',null,false,$cate,null,3);
    ?>
    <div class="modal-footer">
        <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
        <button type="button" class="btn btn-success">Thêm mới</button>
    </div>
</form>