<h2>Tag</h2>
<?
	if($data['tag']){
		foreach($data['tag'] as $key=>$item){
			$alias = 'tag/prod-'.$item[$this->_lang.'alias']
			?>
			<a href="<?=$alias?>"><?=$item[$this->_lang.'title']?></a>
			<?
			if(($key+1)!=count($data['tag'])){
				echo " | ";
			}
		}
	}
?>
<h2>Detail product</h2>
<?
	// echo '<pre>';
	// print_r($data['detail']);
?>

<h2>Product buy together</h2>
<input type="number" id="<?=md6($data['detail']['id'])?>_quantity" name="lz-pro-quantity" value="1" style="width:50px" onchange="laziCart.showPriceReview();"><br/>
<input type="hidden" name="lz-pro-price-result" value="<?=$data['detail']['price_result']?>">
Total-price: <span data-id="lz-cart-total-item-price"><?=$data['detail']['price_result']?></span> <br/><br/>
<table style="width:100%;border:1px solid">
	
	<thead>
		<th style="border:1px solid"></th>
		<th style="border:1px solid">id</th>
		<th style="border:1px solid">title</th>
		<th style="border:1px solid">price</th>
		<th style="border:1px solid">price_sale</th>
		<th style="border:1px solid">promotion</th>
	</thead>
	<tbody>
		<?
			if($data['buyTogether']){
				foreach($data['buyTogether'] as $item){
					$alias = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
				    $alias = base_url().$alias.$item[$this->_lang.'alias'];
					?>
					<tr>
						<td style="border:1px solid">
							<input type="checkbox" name="buy_together[]" 
								onchange="laziCart.showPriceReview();" data-id="<?=md6($item['id'])?>" 
								data-id-main="<?=md6($data['detail']['id'])?>" 
								data-price="<?=$item['price_sale']?>">
						</td>
						<td style="border:1px solid"><?=$item['id']?></td>
						<td style="border:1px solid"><a href="<?=$alias?>"><?=$item['title']?></a></td>
						<td style="border:1px solid"><?=$item['price_result']?></td>
						<td style="border:1px solid"><?=$item['price_sale']?></td>
						<td style="border:1px solid"><?=$item['promotion']?></td>
					</tr>
					<?
				}
			}
		?></button>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">
				<button data-id="<?=md6($data['detail']['id'])?>" onclick="addTogether(this)">Đặt Mua</button>
			</td>
		</tr>		
	</tfoot>
</table>
<br/>
<table>
	<tbody id="ajaxLoadCart">
		
	</tbody>
</table>
<span id="cartTotalamount"></span>