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
			if($list){
				foreach($list as $item){
					$alias = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
				    $alias = base_url().$alias.$item[$this->_lang.'alias'];
					?>
					<tr>
						<td style="border:1px solid"><?=$item['id']?></td>
						<td style="border:1px solid"><a href="<?=$alias?>"><?=$item['title']?></a></td>
						<td style="border:1px solid"><?=$item['price_result']?></td>
						<td style="border:1px solid"><?=$item['promotion']?>%</td>
						<td style="border:1px solid">
							<a href="javascript:;" data-id="<?=md6($item['id'])?>" onclick="addToCart(this, 'alert')">Add</a>
						</td>
					</tr>
					<?
				}
			}
		?>
	</tbody>
</table>

<tfoot>
	<?
		if(isset($pageList)){
			echo $pageList;
		}
	?>
</tfoot>