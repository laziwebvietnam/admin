<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Phản hồi bình luận</h4>
</div>
<div class="modal-body">
    <form id="form-submit" 
          action="comment/action_reply" method="post" 
          class="form-horizontal"
          onsubmit="form_validation_submit_comment();return false;">   
        <input type="hidden" name="id_parent" value="<?=$data['detail']['id']?>" />
        <input type="hidden" name="is_reply" value="1" />
        <input type="hidden" name="data_id" value="<?=$data['detail']['data_id']?>"/>
        <input type="hidden" name="data_table" value="<?=$data['detail']['data_table']?>">
      
        <?
            create_editor('content',null,null,false,null,0);
        ?>
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" onclick="create_popup('comment/popup_detail/<?=$data['detail']['id']?>');return false;">Quay lại</button>
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button type="submit" class="btn green" onclick="form_validation_submit_comment();" aria-hidden="true" >Gửi</button>
</div>
<!-- data-dismiss="modal" -->