<h3>Product List</h3>
<?
	$data['pageList'] = $data['list']['page'];
	$data['list'] = $data['list']['data'];

	$this->load->view($this->_base_view_path.'product/demo/list',$data);
?>

<table>
	<tbody id="ajaxLoadCart">
		
	</tbody>
</table>


<span id="cartTotalamount"></span>