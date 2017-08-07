
<h3>Product List</h3>
<table style="width:100%;border:1px solid">
	<thead>
		<th style="border:1px solid">id</th>
		<th style="border:1px solid">title</th>
		<th style="border:1px solid">price</th>
		<th style="border:1px solid">promotion</th>
		<th style="border:1px solid">action</th>
	</thead>
	<tbody>
		<?
			if($data['list']){
				foreach($data['list'] as $item){
					?>
					<tr>
						<td style="border:1px solid"><?=$item['id']?></td>
						<td style="border:1px solid"><?=$item['title']?></td>
						<td style="border:1px solid"><?=$item['price_result']?></td>
						<td style="border:1px solid"><?=$item['promotion']?>%</td>
						<td style="border:1px solid">
							<a href="javascript:;" data-id="<?=md6($item['id'])?>" onclick="addToCart(this)">Add</a>
						</td>
					</tr>
					<?
				}
			}
		?>
	</tbody>
</table>

<h3>Cart list</h3>
<table style="width:100%;border:1px solid">
	<thead>
		<th style="border:1px solid">id</th>
		<th style="border:1px solid">title</th>
		<th style="border:1px solid">price</th>
		<th style="border:1px solid">promotion</th>
		<th style="border:1px solid">quantity</th>
		<th style="border:1px solid">total</th>
		<th style="border:1px solid">action</th>
	</thead>
	<tbody id="ajaxLoadCart">
		
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2" style="border:1px solid">Tổng tiền</td>
			<td colspan="5" style="border:1px solid">
				<span id="cartTotalAmount"></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border:1px solid">Mã giảm giá</td>
			<td colspan="5" style="border:1px solid">
				<input type="text" placeholder="nhập mã giảm giá" onchange="checkCouponCode(this.value)"><br/>
				<div id="checkCouponCodeAlert" style="color:red"></div>
			</td>
		</tr>
		<tr>
			<td>
				<a href="javascript:;" onclick="destroyCart()">Destroy</a>
			</td>
		</tr>
	</tfoot>	
</table>

<h3>Form order</h3>
<div id="orderSuccess"></div>
<form method="post" id="formOrder" action-submit="cart/action">
	<input type="hidden" name="form" value="order">
	<input type="hidden" name="coupon">
	<input type="text" name="email" placeholder="email" onchange="getCustomerByMail(this.value,'formOrder')">
	<input type="text" name="phone" placeholder="phone">
	<input type="text" name="fullname" placeholder="fullname">
	<input type="text" name="address" placeholder="address"> <br/><br/>
	<textarea name="note" placeholder="note" cols="95" rows="4"></textarea> <br/> <br/>
	<input type="submit" value="submit" onsubmit="saveOrder('formOrder'); return false;">
</form>



<script type="text/javascript">
	$(document).ready(function(){
		loadCartByAjax();
	});
</script>
