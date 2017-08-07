<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?=lang($data['type_action'])?> tags cho <?=$data['count']?> <?=lang($data['table'])?></h4>
    
</div>
<div class="modal-body">
    <form id="form-tag" class="form-horizontal">
        <input type="hidden" name="type_action" value="<?=$data['type_action']?>" />
        <input type="hidden" name="table" value="<?=$data['table']?>" />
        <input type="hidden" name="id_executed" value="<?=$data['id_executed']?>" />
        <?
            if($data['tag_complete']){
                foreach($data['tag_complete'] as $row){
                    $data['input_tag']['dataComplete'][] = array(
                        'id'=>$row['alias'],
                        'name'=>$row['title']
                    );                    
                }
            }
            
            if($data['tag_suggest']){
                foreach($data['tag_suggest'] as $row){
                    $data['input_tag']['dataAdd'][] = array(
                        'id'=>$row['alias'],
                        'name'=>$row['title']
                    );
                }
            }
            create_input_tag('id_tag','Chọn tag',$data['input_tag'],0);
        ?>
    </form>
</div>
<div class="modal-footer">
    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Hủy</button>
    <button class="btn green"  
            postUrl="<?=$data['table']?>/tag_action"
            data-dismiss="modal"
            onclick="submit_popupTag(this)">Cập nhật</button>
</div>
