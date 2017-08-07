<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Đổi mật khẩu</h4>
</div>
<div class="modal-body">
    <form id="form-submit" 
          action="user/user_changePass" method="post" 
          class="form-horizontal"
          onsubmit="formPopupSubmit();return false;">   
          <input type="hidden" name="type_action" value="edit" />
        <?
            create_input_password('password_old','Mật khẩu cũ',null,false,null,null,3);
            create_input_password('password_new','Mật khẩu mới',null,false,null,null,3);
            create_input_password('password_confirm','Nhập lại mật khẩu mới',null,false,null,null,3);
        ?>
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button type="submit" onclick="formPopupSubmit();return false;" class="btn green">Đổi mật khẩu</button>
</div>