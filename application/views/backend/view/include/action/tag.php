<div class="portlet light bordered">
    <?
        create_tab('Tags');
    ?>
    <div class="portlet-body form">
        <div class="form-body">
            <?
                $tag_selected = isset($data['tag_selected'])?$data['tag_selected']:array();
                $tag_selected = return_arrayKey($tag_selected,'id');
                $input_tag = array();
                if($data['tag_complete']){
                    foreach($data['tag_complete'] as $row){
                        $input_tag['dataComplete'][] = array(
                            'id'=>$row['alias'],
                            'name'=>$row['title'],
                            'selected'=>in_array($row['id'],$tag_selected)
                        );                    
                    }
                }
                if($data['tag_suggest']){
                    foreach($data['tag_suggest'] as $row){
                        $input_tag['dataAdd'][] = array(
                            'id'=>$row['alias'],
                            'name'=>$row['title']
                        );
                    }
                }
                
                create_input_tag('id_tag',null,$input_tag,0);
            ?>
            
        </div>
    </div>
</div>