<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?=lang($data['type_action'])?> danh mục cho <?=$data['count']?> <?=lang($data['table'])?></h4>
    
</div>
<div class="modal-body">
    <form id="form-cate" class="form-horizontal">
        <input type="hidden" name="type_action" value="<?=$data['type_action']?>" />
        <input type="hidden" name="table" value="<?=$data['table']?>" />
        <input type="hidden" name="id_executed" value="<?=$data['id_executed']?>" />
        <?
            if($this->data_view['cate_popup']['status']){
                foreach($this->data_view['cate_popup']['status'] as $row){
                    create_checkbox($row,lang($data['table']).' '.lang($row));
                }
            }
            
        ?>
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button class="btn green"  
            postUrl="<?=$data['table']?>/cate_action"
            data-dismiss="modal"
            onclick="submit_popupCate(this)">Cập nhật</button>
</div>
