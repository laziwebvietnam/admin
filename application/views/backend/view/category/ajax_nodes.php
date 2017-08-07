
<?
    if($data!=null){
        echo "<ul>";
        $action_create = "<li data-jstree='{ \"data_type\":\"\", \"parent\" : \"\",\"type\" : \"\"}' class=\"jstree-node jstree-closed jstree-last category-create\"><i class=\"jstree-icon jstree-ocl\" role=\"presentation\"></i><a class=\"jstree-anchor\" onclick=\"category_create(this)\"><i class=\"jstree-icon jstree-themeicon\" role=\"presentation\"></i>Thêm mới</a></li>";
        $level_now = 0;
        $open_tag = false;
        $close_tag = false;
        
        $action_create_lv0 = $this->data_view['unLockCreate']['level_0']['lock']==false?$action_create:'';
        foreach($data as $key=>$row){
            $next_level = isset($data[$key+1])?$data[$key+1]['level']:-1;
            $data_id = $row['id'];
            $open_tag = $row['level']<2?"\"opened\":true,":"";
            $data_jstree = "data-jstree='{ $open_tag \"id\":\"$data_id\",\"data_type\":\"".$row['data_type']."\", \"parent\" : \"".$row['parent']."\",\"type\" : \"".$row['type']."\"}'";
            
            $action_up = "<a onclick=\"change_position(".$row['id'].",'up')\">Up</a>";
            $action_down = "<a onclick=\"change_position(".$row['id'].",'down')\">Down</a>";
            $action_edit = "<a onclick=\"category_edit($data_id)\">Edit</a>";
            $action_delete = "<a onclick=\"create_popup('$this->_table/delete_once_popup/$data_id');\">Delete</a>";
            $action_delete = ($row['level']==0&&$this->data['user']['id_role']!=1)?'':$action_delete;           
            $modify = "<div class=\"modify\">$action_up $action_down $action_edit $action_delete</div>";
            
            
            echo "<li id='$data_id' $data_jstree>".$row['title'].$modify;
            /** if next level < now level */
            if($level_now != $next_level && $level_now < $next_level ){
                echo "<ul>";
            }else if($level_now != $next_level && $level_now > $next_level){
                if(isset($data[$key+1])){
                    echo "<ul>$action_create</ul></li>";
                    for($i=0;$i<($level_now-$next_level);$i++){
                        echo "$action_create</ul></li>";
                    }
                }else{
                    for($i=0;$i<$level_now;$i++){
                        echo "<ul>$action_create</ul></li></ul>";
                    }
                    echo "<ul>$action_create</ul></li>";
                }
            }else if($level_now==$next_level){
                echo "<ul>$action_create</ul></li>";
            }
            
            $level_now = $level_now!=$next_level?$next_level:$level_now;
        }
        echo $action_create;
        echo "</ul>";
    }
?>
    
