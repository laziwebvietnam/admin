<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/table-datatables-rowreorder.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<!--script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script-->
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-maxlength.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>

<script type="text/javascript">
    function printBill(md6_id){
        var ajax = $.post('order/printBill/' + md6_id);
        
        ajax.error(function(){
            console.log('error_print'); 
        });
        
        ajax.success(function(data_return){
            data_return = jQuery.parseJSON(data_return);
            if(data_return.checkRole==false){
                create_popup('home/loadPopupViewRoleFalse');
                return;
            }
            //console.clear();
            var win = window.open( '', '' );
            win.document.close();
            win.document.write(data_return.html);
            
            setTimeout(function() {
                win.print();
                win.close();
            }, 500);
        });
    }
</script>