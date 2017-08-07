<?
	if($list){

		foreach($list as $key=>$item){
			$proBuyTogether = isset($item['idProductMain'])?true:false;
			$totalAmount = 0;
			$totalAmount = $item['price']>1?$item['price']*$item['qty']:0;
			$item['price'] = $item['price']>1?$item['price']:0;
			?>
			<tr>
				<td style="border:1px solid"><?=$item['id']?></td>
				<td style="border:1px solid">
					<?=$item['name']?>
					<?
						if($proBuyTogether){
							echo '<br/>sản phẩm mua kèm - idProduct = '.$item['idProductMain'];
						}
					?>	
				</td>
				<td style="border:1px solid"><?=number_format($item['price'],0,'.','.')?></td>
				<td style="border:1px solid"><?=$item['options']['promotion']?>%</td>
				<td style="border:1px solid">
					<input type="number" <?=$proBuyTogether==true?'readonly="true"':''?> id="<?=$key?>_quantity" value="<?=$item['qty']?>" style="width:50px"/>
				</td>
				<td style="border:1px solid">
					<?=number_format($totalAmount,0,'.','.')?>
				</td>
				<td style="border:1px solid">
					<a href="javascript:;" data-key="<?=$key?>" data-id="<?=md6($item['id'])?>" onclick="updateCart(this)">Update</a>
					<a href="javascript:;" data-key="<?=$key?>" data-id="<?=md6($item['id'])?>" onclick="removeCart(this)">Remove</a>
				</td>
			</tr>
			<?
		}
	}
?>

		