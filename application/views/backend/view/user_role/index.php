<?=$this->data_view['breadcrumb']?>
<form id="form-submit" class="form-horizontal" action="<?=$this->_table?>/action"
      method="post" onsubmit="form_submit_check_validation('submit');return false;">
    <input type="hidden" name="actions" />
    <input type="hidden" name="id" value="<?=$data['detail']['id']?>" />
    <input type="hidden" name="type_action" value="edit"/>
    <input type="hidden" name="is_active" value="<?=$data['detail']['is_active']?>">
    <div class="row">
        <div class="form-body">
            <div class="col-md-8">
            <?
                create_select_('id_role_select',null,$data['detail']['id'],true,$data['user_role'],null,0,7);
            ?>  
            </div>
            <div class="col-md-4">
                
                <?
                    if($data['detail']!=null){
                        ?>
                        <button type="submit" class="btn green" style="float: right;">Cập nhật</button>
                        <a class="btn btn-danger" style="float: right;margin-right:10px" onclick="create_popup('user_role/delete_once_popup/<?=$data['detail']['id']?>');">Xóa</a>
                        <a class="btn default" style="float: right;margin-right:10px" href="user_role/editInfo/<?=$data['detail']['id']?>");">Sửa</a>
                        <?
                    }
                ?>
                
            </div>
        </div>
    </div>
    <hr />

    <?

        if($data['list'] != null){
            $i = 0;
            $detailRole = $data['detail']['actions'];
            $roleListByUser = explode(',',$detailRole);
            foreach($data['list'] as $table=>$item){
                if($i%4==0){?>
                    <div class="row">
                <?}?>
                <div class="col-md-3">
                    <div class="jstree_role" id="table-<?=$table?>">
                        <ul>
                            <li data-jstree='{"opened":false,"selected":false}' id="<?=$table?>">
                                <a class="jstree-"><?=lang($table)?></a>
                                <ul>    
                                <?
                                    if($item != null){
                                        foreach($item as $val=>$role){
                                            $selected = in_array($val,$roleListByUser)==true?'true':'false';
                                            ?>
                                            
                                            <li id="<?=$val?>" data-jstree='{"selected":<?=$selected?>}'><a><?=$role?></a></li>
                                            
                                            <?
                                        }
                                    }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    
                </div>
                <?
                if(($i+1)%4==0){?>
                    </div>
                <?}
                $i++;
            }
        }
    ?>
</form>