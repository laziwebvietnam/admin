<h2>Form cài đặt mật khẩu mới</h2>
<div id="user_setNewPass"></div>
<form method="post" id="formSetNewPass" action-submit="user/actionSetNewPass">
	<input type="hidden" name="id" value="<?=md6($data['userDetail']['id'])?>">
	<input type="hidden" name="passcode" value="<?=$data['userDetail']['resetpasscode']?>">
	<input type="text" name="password" placeholder="password"/> <br/>
	<input type="text" name="password_confirm" placeholder="password confirm"> <br>
	<button type="submit">Sent</button>
</form>