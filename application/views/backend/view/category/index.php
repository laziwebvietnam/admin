<?=$this->data_view['breadcrumb']?>
<input type="hidden" id="id_executed" />
<input type="hidden" id="table_executed" value="<?=$this->_table?>" />
<input type="hidden" id="category_type" value="<?=$data['type']?>" />
<div class="row">
    <div class="col-md-8">
        <div class="portlet box">
            <div class="portlet-body">
                <div id="tree" >
                
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        jsTree_data(); 
    });

</script>