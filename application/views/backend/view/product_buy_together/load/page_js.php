<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/table-datatables-rowreorder.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<!--script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script-->
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-maxlength.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>

<script>
    
$(document).ready(function(){

    $('[name="id_pro_relative"]').change(function(){
    	form_submit_check_validation('onchange','id_pro_main');
    	getPricePro($(this).val());
    });

    $('[name="id_pro_main"]').change(function(){
    	form_submit_check_validation('onchange','id_pro_relative');
    });	

    var idPro = $('select[name="id_pro_relative"]').val();
    var typeAction = $('#form-submit').find('[name="type_action"]').val();
    if(typeAction=='edit'){
    	getPricePro(idPro);
    }
    

    function getPricePro($idPro){
		var url = 'product/getPriceByPro/'+$idPro;
		var ajax = $.post(url);
		ajax.success(function(dataLog){
			dataLog = jQuery.parseJSON(dataLog);
			if(dataLog.status=='success'){
				$('#form-submit').find('input[name="price"]').val(dataLog.price);
			}else{
				console.log(dataLog);
			}
		})
	}
});

</script>