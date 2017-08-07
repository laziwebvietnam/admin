<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Xóa Phương thức</h4>
        </div>
        <div class="modal-body">
            <form class="row" id="modalRemoveFee">
                <input type="hidden" name="id" value="<?= $fee['id']; ?>">
                <div class="form-group" field-id="title">
                    <div class="col-md-12">
                        <p>Bạn muốn xóa Phương thức: <?= $fee[$this->_lang . 'title']; ?>?</p>
                    </div>
                </div>
                <div class="button-wrap">
                    <a id="feeFormSubmit" href="javascript:(0);" class="btn green" onclick="$('#modalRemoveFee').submit();">Xóa</a>
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

    $('#modalRemoveFee').submit(function (e) {
        e.preventDefault();
        $('#feeFormSubmit').hide();
        $('#feeFormLoader').show();
            
        var ajax = $.post('ship_fee/ajax_removeFee', $(this).serializeObject());
        ajax.success(function (status) {
            if (status) {
                location.reload();
                // $('#data-table').prepend(html);

                // $('html,body').animate({
                //     scrollTop: $("#data-table").offset().top
                // }, 'slow');
            } else {
                alert('Xóa Phương thức thất bại !');
            }
        });
    });
</script>