<!DOCTYPE HTML>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en-us"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="en-us"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="en-us"><![endif]-->
<!--[if gt IE 8]><html class="no-js ie9" lang="en-us"><![endif]-->
<html lang="en-us">

<head>
    <base href="<?=base_url()?>"/>
    <meta charset="utf-8"/>
    <?
        $this->load->view($this->_base_view_path.'include/masterpage/seo');
    ?>
    <script type="text/javascript" src="template/frontend/lazi/jquery-1.12.2.min.js"></script>
</head>

<body>

	<div style="padding:20px">
        <?
            if(isset($content['data']['breadcrumb'])){
                if($content['data']['breadcrumb']){
                    foreach($content['data']['breadcrumb'] as $key=>$item){
                        ?>
                        <a href="<?=$item['alias']?>"><?=$item['title']?></a> 
                        <?
                        if(($key+1)<count($content['data']['breadcrumb'])){
                            echo ' / ';
                        }
                    }
                }
            }


        ?>
		<?	$this->load->view($content['view'],array('data'=>$content['data'])); ?>  
	</div>

    <div class="modal fade alert-popup" id="alert-popup">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
              <p class="text-success">Sản phẩm được thêm vào giỏ hàng thành công  - <a href="thanh-toan">Xem giỏ hàng</a></p>
            </div>
          </div>
        </div>
      </div>

    <script type="text/javascript" src="template/frontend/lazi/function.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/cart.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/contact.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/customer.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/form.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/custom.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/template.js"></script>
    <link rel="stylesheet" type="text/css" href="template/frontend/lazi/custom.css">

    <link rel="stylesheet" type="text/css" href="template/frontend/lazi/toastr.css">
    <script type="text/javascript" src="template/frontend/lazi/toastr.min.js"></script>

</body>
</html>