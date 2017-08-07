<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Bạn có chắc muốn xóa <?=$data['count']?> <?=lang($data['table'])?> này?</h4>
    
</div>
<div class="modal-body">
    <div class="alert alert-warning alert-dismissable">
        Thao tác này sẽ xóa các <?=lang($data['table'])?> bạn đã chọn. Thao tác này không thể khôi phục.
    </div>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button class="btn btn-danger"
                posturl="<?=$data['table']?>/delete_action<?=isset($data['id'])?('/'.$data['id']):''?>" 
                onclick="quickAction(this);">Xóa</button>
</div>