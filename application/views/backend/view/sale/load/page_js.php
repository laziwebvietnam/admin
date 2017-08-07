<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/table-datatables-rowreorder.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<!--script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script-->
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-maxlength.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>

<script>
    
$(document).ready(function(){
    tag_autocomplete_create();

    $('.product_button_add a').click(function(){
        // var num = $('#product-product-form').find('div.row').length;
        var url = 'sale/addProduct';
        var ajax = $.post(url);
        ajax.success(function(html){
            $('#product-product-form').find('.row').last().before(html);
        })
    });
});

function product_button_remove(thisBtn) {
    $(thisBtn).closest('div.row').remove();
}

</script>