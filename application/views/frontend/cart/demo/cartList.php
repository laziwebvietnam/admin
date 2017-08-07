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
			<td style="border:1px solid">Tổng tiền</td>
			<td style="border:1px solid">
				<span id="cartTotalAmount"></span>
			</td>
		</tr>
		<tr>
			<td>
				<a href="javascript:;" onclick="destroyCart()">Destory</a>
			</td>
		</tr>
	</tfoot>	
</table>