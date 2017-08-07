<h2>Form đăng ký</h2>
<div id="user_signUpAlert"></div>
<form method="post" id="formSignUp" action-submit="user/actionSignUp">
	<input type="hidden" name="form" value="signup"/>
	<input type="text" name="email" placeholder="email" onchange="getCustomerByMail(this.value,'formSignUp')"/> <br/>
	<input type="text" name="password" placeholder="password"> <br>
	<input type="text" name="password_confirm" placeholder="password confirm"> <br/>
	<input type="text" name="fullname" placeholder="fullname"/> <br/>
	
	<input type="text" name="phone" placeholder="phone"/><br/>
	<input type="text" name="address" placeholder="address"/><br/>
	<button type="submit">Sent</button>
</form>