<h2>Tag</h2>
<?
	if($data['tag']){
		foreach($data['tag'] as $key=>$item){
			$alias = 'tag/art-'.$item[$this->_lang.'alias']
			?>
			<a href="<?=$alias?>"><?=$item[$this->_lang.'title']?></a>
			<?
			if(($key+1)!=count($data['tag'])){
				echo " | ";
			}
		}
	}
?>
<h2>Detail article</h2>
<?
	echo '<pre>';
	print_r($data['detail']);
?>