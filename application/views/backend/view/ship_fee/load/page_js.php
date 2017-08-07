<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/table-datatables-rowreorder.min.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<!--script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script-->
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-bootstrap-maxlength.js" type="text/javascript"></script>
<script src="<?=$this->_base_url_template_admin?>/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>

<script>

    function validateFee() {
        $('.price_validate').change(function () {
          var val = $(this).val().replace(/[^0-9\.]/g, '');
          if (Number(val) < 0 || (Number(val) > 0 && Number(val) < 1000))
            val = 1000;
          $(this).val(val);
        });

        $('.min_validate').change(function () {
          var val = $(this).val().replace(/[^0-9\.]/g, ''),
              max = $('input[name=max]').val();
          
          if (max) {
            if (Number(val) >= Number(max)) {
                val = Number(max) - 1;
                $(this).css('border', '1px solid red');
                load_toastr('', 'Giá trị Từ phải bé hơn Đến', 'error');
            } else {
                val = Number(val);
                $(this).css('border', '1px solid #c2cad8');
            }
          }
          $(this).val(val);
        });

        $('.max_validate').change(function () {
          var val = $(this).val().replace(/[^0-9\.]/g, ''),
              min = $('input[name=min]').val();
          
          if (min) {
            if (Number(val) <= Number(min)) {
                val = '';
                $(this).css('border', '1px solid red');
                load_toastr('', 'Giá trị Đến phải lớn hơn Từ', 'error');
            } else {
                val = Number(val);
                $(this).css('border', '1px solid #c2cad8');
            }
          }
          $(this).val(val);
        });
    }

    function validateFeeForm(id_form, has_alert) {
        var thisForm = $(id_form),
            data = {
                title: thisForm.find('input[name=title]').val(),
                fee: thisForm.find('input[name=fee]').val(),
            },
            type = thisForm.find('select[name=type]').val(),
            min = thisForm.find('input[name=min]').val(),
            max = thisForm.find('input[name=max]').val(),
            can_submit = true;

        for (var i in data) {
            if (data[i] == '') {
                thisForm.find('input[name=' + i + ']').css('border', '1px solid red');
                if (has_alert) {
                    load_toastr('', thisForm.find('input[name=' + i + ']').data('title') + ' không được rỗng', 'error');
                }
                can_submit = false;
            } else {
                thisForm.find('input[name=' + i + ']').css('border', '1px solid #c2cad8');
            }
        }

        if (min) {
            if (min == 0 && !max) {
                thisForm.find('input[name=max]').css('border', '1px solid red');
                if (has_alert) {
                    load_toastr('', 'Nếu Giá trị Từ là 0 thì Giá trị Đến không được rỗng', 'error');
                }
                can_submit = false;
            } else {
                thisForm.find('input[name=min]').css('border', '1px solid #c2cad8');
                thisForm.find('input[name=max]').css('border', '1px solid #c2cad8');
            }

            if (!type) {
                thisForm.find('select[name=type]').siblings('button').css('border', '1px solid red');
                if (has_alert) {
                    load_toastr('', 'Giá trị Tính theo loại không được rỗng', 'error');
                }
                can_submit = false;
            } else {
                thisForm.find('select[name=type]').siblings('button').css('border', '1px solid #c2cad8');
            }
        } else {
            if (max && !type) {
                thisForm.find('select[name=type]').siblings('button').css('border', '1px solid red');
                if (has_alert) {
                    load_toastr('', 'Giá trị Tính theo loại không được rỗng', 'error');
                }
                can_submit = false;
            } else if (!max && type) {
                thisForm.find('input[name=min]').css('border', '1px solid red');
                thisForm.find('input[name=max]').css('border', '1px solid red');
                if (has_alert) {
                    load_toastr('', 'Giá trị Từ và Đến không được rỗng', 'error');
                }
                can_submit = false;
            } else {
                thisForm.find('select[name=type]').siblings('button').css('border', '1px solid #c2cad8');
                thisForm.find('input[name=min]').css('border', '1px solid #c2cad8');
                thisForm.find('input[name=max]').css('border', '1px solid #c2cad8');
            }
        }

        return can_submit;
    }

    function openModalFee(action, id=0) {
        var id_location = $('select[name=id_location]').val(),
            ajax = $.post('ship_fee/openModalFee/' + id_location + '/' + action + '/' + id);
        
        ajax.success(function (html) {
            $('#modal-fee').html(html);
            $('#modal-fee').modal('show');
        });
    }

    function loadFees(id, id_ship_fee) {
        var id_ship_fee = typeof id_ship_fee==='undefined'?0:id_ship_fee,
            ajax = $.post('ship_fee/loadFees/' + id + '/' + id_ship_fee);

        ajax.success(function (html) {
            $('#fee_loader').hide();
            $('#fee_content').html(html);
            $('#fee_content').show();
        });
    }

    $('select[name=id_location]').change(function () {
        $('#fee_content').hide();
        $('#fee_loader').show();

        setTimeout(function () {
            if (!$('[field-id="id_location"]').hasClass('has-error')) {
                loadFees($('select[name=id_location]').val());
            } else {
                $('#fee_loader').hide();
            }
        }, 500);
    });

    $(document).ready(function(){
        tag_autocomplete_create(); 

    });

</script>