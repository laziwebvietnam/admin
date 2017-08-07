<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Thông tin tài khoản</h4>
</div>
<div class="modal-body">
    <form id="form-submit" 
          action="user/user_changeInfo" method="post" 
          class="form-horizontal"
          onsubmit="formPopupSubmit();return false;">   
          <input type="hidden" name="type_action" value="edit" />
          <input type="hidden" name="id" value="<?=$this->data['user']['id']?>" />
        <?
            create_input('fullname',lang('fullname'),$this->data['user']['fullname'],false,null,null,3);
            create_input('email',lang('email'),$this->data['user']['email'],false,null,null,3);
            create_input('phone',lang('phone'),$this->data['user']['phone'],false,null,null,3);
            //create_input_image('image',lang('image'),$this->data['user']['image'],false,null,3);
            create_input(null,'Ngày khởi tạo',date('d-m-Y G:i',$this->data['user']['time']),false,null,null,3,true);
            create_input(null,'Lần đăng nhập cuối cùng',date('d-m-Y G:i',$this->data['user']['time_login']),false,null,null,3,true);
        ?>
        
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button type="submit" onclick="formPopupSubmit();return false;" class="btn green">Cập nhật</button>
</div>