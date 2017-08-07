<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Bạn có chắc muốn khôi phục dữ liệu này?</h4>
    
</div>
<div class="modal-body">
    <div class="alert alert-warning alert-dismissable">
        Click vào nút khôi phục nếu bạn muốn khôi phục lại dữ liệu này.
    </div>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button class="btn btn-danger"
                posturl="<?=$data['table']?>/restore_action/delete/<?=isset($data['id'])?('/'.$data['id']):''?>" 
                onclick="quickAction(this);">Khôi Phục</button>
</div>