<h3>Article List</h3>

<table style="width:100%;border:1px solid">
	<thead>
		<th style="border:1px solid">id</th>
		<th style="border:1px solid">title</th>
	</thead>
	<tbody>
		<?
			if($data['list']['data']){
				foreach($data['list']['data'] as $item){
					$alias = return_valueKey($this->_template['typeCategory'],'id','article','alias'); 
				    $alias = base_url().$alias.$item[$this->_lang.'alias'];
					?>
					<tr>
						<td style="border:1px solid"><?=$item['id']?></td>
						<td style="border:1px solid"><a href="<?=$alias?>"><?=$item['title']?></a></td>
					</tr>
					<?
				}
			}
		?>
	</tbody>
</table>

<tfoot>
	<?=$data['list']['page']?>
</tfoot>