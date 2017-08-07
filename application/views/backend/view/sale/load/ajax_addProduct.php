<div class="row">
<?
    create_select_div10('products[]',false,null,false,$products,'title');
?>
    <div class="col-md-2 product_button_remove">
        <a href="javascript:;" class="btn red" onclick="product_button_remove(this)"> Xóa
            <i class="fa fa-remove"></i>
        </a>
    </div>
</div>
<script type="text/javascript">
  reload_after_popup();
</script>