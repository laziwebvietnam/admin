<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Thêm Phương thức</h4>
        </div>
        <div class="modal-body">
            <form class="row" id="modalAddFee">
                <input type="hidden" name="id_location" value="<?= $id_location; ?>">
                <div class="form-group" field-id="title">
                    <div class="col-md-12">
                        <p>Tên Phương thức Vận chuyển</p>
                        <div class="input-icon right">
                            <i class="fa tooltips show_error" data-original-title=""></i>
                            <input id="field_title" type="text" class="form-control" data-maxlength="" data-title="Tên Phương thức" name="title">
                            <span class="help-block help-block-error"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="col-md-6">
                        <p>Tính theo</p>
                        <select id="field_action_modal" name="type" class="form-control bs-select" data-live-search="true" >
                            <option value="">Mời chọn...</option>
                            <?php
                              if ($this->_template['typeFee'] != null) {
                                foreach ($this->_template['typeFee'] as $key => $type) {
                                  ?>
                                  <option value="<?= $type['id']; ?>"><?= $type['title']; ?></option>
                                  <?php
                                }
                              }
                            ?>
                        </select>
                        <span class="help-block help-block-error"></span>
                    </div>
                    <div class="col-md-3">
                        <p>Từ</p>
                        <div class="input-icon right">
                            <i class="fa tooltips show_error" data-original-title=""></i>
                            <input id="field_min" type="text" class="form-control min_validate" data-maxlength="" name="min">
                            <span class="help-block help-block-error"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>Đến</p>
                        <div class="input-icon right">
                            <i class="fa tooltips show_error" data-original-title=""></i>
                            <input id="field_max" type="text" class="form-control max_validate" data-maxlength="" name="max">
                            <span class="help-block help-block-error"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" field-id="fee">
                    <div class="col-md-12">
                        <p>Chi Phí</p>
                        <div class="input-icon right">
                            <i class="fa tooltips show_error" data-original-title=""></i>
                            <input id="field_fee" type="text" class="form-control price_validate" data-maxlength="" data-title="Chi Phí" name="fee">
                            <span class="help-block help-block-error"></span>
                        </div>
                    </div>
                </div>
                <?php
                  if ($locations != null) {
                    ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <p>Quận / Huyện</p>
                        </div>
                    </div>
                    <?php
                    foreach ($locations as $key => $location) {
                      ?>
                        <input type="hidden" name="id_district" value="<?= $location['id']; ?>">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <i class="fa tooltips show_error" data-original-title=""></i>
                                    <input id="field_district" type="text" class="form-control" data-maxlength="" name="district" disabled value="<?= $location[$this->_lang . 'title']; ?>">
                                    <span class="help-block help-block-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <i class="fa tooltips show_error" data-original-title=""></i>
                                    <input id="field_fee_location" type="text" class="form-control price_validate" data-maxlength="" name="fee_location">
                                    <span class="help-block help-block-error"></span>
                                </div>
                            </div>
                        </div>
                      <?php
                    }
                  }
                ?>
                <div class="button-wrap">
                    <a id="feeFormSubmit" href="javascript:(0);" class="btn green" onclick="$('#modalAddFee').submit();">Thêm</a>
                    <img id="feeFormLoader" src="<?= base_url(); ?>template/backend/assets/image/loading.gif" style="width: 30px; display: none;">
                </div>
            </form> 
        </div>
        
    </div>
</div>

<style type="text/css">
    .modal-edit .button-wrap {
        text-align: center;
    }
    .modal-edit .button-wrap .btn-modal-edit {
        display: inline-block;
        padding: 5px 15px;
        background-color: #f2f2f2;
        -webkit-border-radius: 3px !important;
        -moz-border-radius: 3px !important;
        border-radius: 3px !important;
    }
</style>

<script type="text/javascript">    

    $(document).ready(function () {
        ComponentsBootstrapSelect.init();
        validateFee();
    });

    $('#modalAddFee :input').change(function () {
        validateFeeForm('#modalAddFee');
    });

    $('#modalAddFee').submit(function (e) {
        e.preventDefault();
        $('#feeFormSubmit').hide();
        $('#feeFormLoader').show();

        var thisForm = $(this),
            can_submit = validateFeeForm('#modalAddFee', true);

        // if ((min || max) && !type) {
        //     thisForm.find('select[name=type]').siblings('button').css('border', '1px solid red');
        //     can_submit = false;
        // } 

        // if {
        //     if (type) {
        //         thisForm.find('input[name=min]').css('border', '1px solid red');
        //         thisForm.find('input[name=max]').css('border', '1px solid red');
        //         can_submit = false;
        //     }
        // }

        if (can_submit) {
            thisForm.find('input').css('border', '1px solid #c2cad8');
            thisForm.find('select').siblings('button').css('border', '1px solid #c2cad8');
            
            var ajax = $.post('ship_fee/ajax_addFee', thisForm.serializeObject());
            
            ajax.success(function (status) {
                if (status) {
                    window.location.href = 'ship_fee/edit/' + thisForm.find('[name=id_location]').val();
                    // $('#data-table').prepend(html);

                    // $('html,body').animate({
                    //     scrollTop: $("#data-table").offset().top
                    // }, 'slow');
                } else {
                    alert('Thêm Phương thức thất bại !');
                }
            });
        } else {
            $('#feeFormLoader').hide();
            $('#feeFormSubmit').show();
            $("#modal-fee").animate({
                scrollTop: 0
            }, 500);
        }
    });
</script>