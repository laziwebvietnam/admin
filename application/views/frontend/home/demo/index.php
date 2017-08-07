<?	
	/** Note */
	//$this->load->view();
?>


<ul>
<?
	if($this->_template['menu']){
		foreach($this->_template['menu'] as $level_0_item){
			$alias = $level_0_item[$this->_lang.'alias'];
			$where = array(
					'is_active'=>1,
					'is_delete'=>0,
					'id_parent'=>$level_0_item['id']
				);
			$level_1 = $this->My_model->getlist('category',$where,0,999,'position asc');
			?>
			<li>
				<a href="<?=$alias?>"><?=$level_0_item[$this->_lang.'title']?></a>
				<?
					if($level_1){
						echo "<ul>";
						foreach($level_1 as $level_1_item){
							$alias_level_1 = $alias.'/'.$level_1_item[$this->_lang.'alias'];
							$where = array(
								'is_active'=>1,
								'is_delete'=>0,
								'id_parent'=>$level_1_item['id']
							);
							$level_2 = $this->My_model->getlist('category',$where,0,999,'position asc');
							?>
							<li><a href="<?=$alias_level_1?>"><?=$level_1_item[$this->_lang.'title']?></a>
							<?
								if($level_2){
									echo "<ul>";
									foreach($level_2 as $level_2_item){
										$alias_level_2 = $alias.'/'.$level_2_item[$this->_lang.'alias'];
										$where = array(
											'is_active'=>1,
											'is_delete'=>0,
											'id_parent'=>$level_2_item['id']
										);
										$level_2 = $this->My_model->getlist('category',$where,0,999,'position asc');
										?>
										<li><a href="<?=$alias_level_2?>"><?=$level_2_item[$this->_lang.'title']?></a>

										</li>
										<?
									}
									echo "</ul>";
								}
							?>
							</li>
							<?
						}
						echo "</ul>";
					}
				?>
			</li>
			<?
		}
	}
?>
</ul>