<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/table-datatables-rowreorder.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-maxlength.js" type="text/javascript"></script>

<!-- date time picker -->
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script>

    
$(document).ready(function(){
    tag_autocomplete_create(); 
    App.handleBootstrapConfirmation();
    addActionOnConfirmationButton();

    
    $('[name="price"]').change(function(){
		form_submit_check_validation('onchange','price_promotion');
    });

    $('[name="price_promotion"]').change(function(){
    	form_submit_check_validation('onchange','price');
    });

    $('.property_button_add a').click(function(){
        var num = $('#product-property-form').find('div.row').length;
    	var url = 'product/addProperty/'+num;
        var ajax = $.post(url);
        ajax.success(function(tagHtml){
            var data_return = jQuery.parseJSON(tagHtml);

            if(data_return.status=='success'){
                $('#product-property-form').find('.row').last().before(data_return.html);
                tag_autocomplete_create();
                form_validation_returnData();
                App.handleBootstrapConfirmation();
                addActionOnConfirmationButton();

                $('#form-submit :input').change(function(){
                    form_validation_onchange($(this).attr('name'));
                });
            }
        });
    });
});

function propertyButtonRemove(thisBtn){
    $(thisBtn).closest('div.row').remove();
}

function addActionOnConfirmationButton(){
    $('.property_button_remove').find('a').attr('onclick','propertyButtonRemove(this)');

}

</script>