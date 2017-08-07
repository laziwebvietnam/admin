<!-- END LOGIN FORM -->
<!-- BEGIN FORGOT PASSWORD FORM -->
<form id="form-forgotpass" class="forget-form" action="user/forgotpass_action" method="post" onsubmit="formForgotPass();return false;">
    <h3 class="font-green">Phục hồi mật khẩu?</h3>
    <div class="alert alert-danger display-hide">
        
    </div>
    <p>&nbsp;Nhập địa chỉ email tài khoản mà bạn đăng ký.</p>
    <div class="form-group">
        <input class="form-control placeholder-no-fix" type="text" placeholder="Email..." name="email" /> 
        
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn btn-default">Quay lại</button>
        <button type="submit" onclick="formForgotPass();return false;" class="btn btn-success uppercase pull-right">Đổi mật khẩu</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->