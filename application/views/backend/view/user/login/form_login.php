<!-- BEGIN LOGIN FORM -->
<form id="form-login" class="login-form" action="user/login_action" method="post">
    <h3 class="form-title font-green">Đăng nhập hệ thống</h3>
    <div class="alert alert-danger display-hide">
        
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Tên đăng nhập</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" placeholder="Tên đăng nhập hoặc email..." name="email" /> 
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" placeholder="Mật khẩu..." name="password" /> 
    </div>
    <div class="form-actions">
        <button type="submit" class="btn green uppercase">Đăng nhập</button>
        <a href="javascript:;" id="forget-password" class="forget-password">Quên mật khẩu?</a>
    </div>
</form>
<!-- END LOGIN FORM -->