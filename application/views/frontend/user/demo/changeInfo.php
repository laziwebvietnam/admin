<h2>Form đăng ký</h2>
<?
	print_r($this->data['customer']);
?>
<div id="user_changeInfoAlert"></div>
<form method="post" id="formChangeInfo" action-submit="user/actionChangeInfo">
<input type="hidden" name="id" value="<?=md6($this->data['customer']['id'])?>">
	<input disabled="true" type="text" name="email" placeholder="email" value="<?=$this->data['customer']['email']?>"> <br/>	
	<input type="text" name="fullname" placeholder="fullname" value="<?=$this->data['customer']['fullname']?>" /> <br/>
	
	<input type="text" name="phone" placeholder="phone" value="<?=$this->data['customer']['phone']?>"/><br/>
	<input type="text" name="address" placeholder="address" value="<?=$this->data['customer']['address']?>"/><br/>
	<input type="text" name="password" placeholder="password"> <br>
	<input type="text" name="password_confirm" placeholder="password confirm"> <br/>
	<button type="submit">Sent</button>
</form>