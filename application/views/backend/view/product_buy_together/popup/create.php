<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Thêm mới sản phẩm mua kèm thuộc sản phẩm - <?=$data['proDetail']['title']?></h4>
</div>
<div class="modal-body">
	<form id="formPopup" class="form-horizontal" action="product_buy_together/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
		<input type="hidden" name="id_pro_main" value="<?=$data['proDetail']['id']?>" />
		<input type="hidden" name="type_action" value="create" />
		<?
			create_select_('id_pro_relative',lang('pro_relative'),null,true,$data['proList'],null,null,3);
		?>
		<input type="submit" name="">
	</form>
	
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button class="btn btn-danger">Xóa</button>
</div>