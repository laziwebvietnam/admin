<h2>Form liên hệ</h2>
<div id="contactSuccess"></div>
<form method="post" id="formContact" action-submit="contact/action">
	<input type="hidden" name="form" value="contact">
	<input type="text" name="fullname" placeholder="fullname"> <br/>
	<input type="text" name="email" placeholder="email" onchange="getCustomerByMail(this.value,'formContact')"><br/>
	<input type="text" name="phone" placeholder="phone"><br/>
	<input type="text" name="address" placeholder="address"><br/>
	<input type="text" name="title" placeholder="title"><br/>
	<textarea name="content" placeholder="content"></textarea><br/>
	<button type="submit">Sent</button>
</form>