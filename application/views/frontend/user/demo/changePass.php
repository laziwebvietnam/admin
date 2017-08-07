<h2>Form đổi mật khẩu</h2>
<?
	print_r($this->data['customer']);
?>
<div id="user_changePassAlert"></div>
<form method="post" id="formChangePass" action-submit="user/actionChangePass">
<input type="hidden" name="id" value="<?=md6($this->data['customer']['id'])?>">
	<input type="text" name="password" placeholder="password"> <br>
	<input type="text" name="new_password" placeholder="new password"> <br>
	<input type="text" name="new_password_confirm" placeholder="new password confirm"> <br/>
	<button type="submit">Sent</button>
</form>