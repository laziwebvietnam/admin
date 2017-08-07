<?
    
    $i = $data['list']['start'];
    $newstring = 'is_active_a';
    
    foreach($data['list']['data'] as $row){
        $status_position = array(
            'is_delete_1','is_spam_1','is_read_0','is_reply_0','is_active_0',
            'is_reply_1','is_read_1','is_spam_0','is_active_1'
        );
        
        $data_id = $row['id'];
        $status_field = '';
        $status_value = '';
        if($status_position!=null){
            foreach($status_position as $status){
                $position = strrpos($status,'_'); // $pos = 7, not 0
                $field = substr($status,0,$position);
                $value = substr($status,$position+1);
                if($row[$field]==$value){
                    $status_field = $field;
                    $status_value = $value;
                    break;
                }
            }
        }
        $class = $this->data_view['dataTable']['otherInfo']['status'][$status_field][$status_value];
        $onclick = "onclick=\"create_popup('comment/popup_detail/$data_id')\""
        
        ?>
        <tr class="odd gradeX">
            <td class="checkedbox">
                <input type="checkbox" class="checkboxes" value="<?=$row['id']?>" /> 
            </td>
            <td data-value-export='<?=$row['id']?>'><?=$row['id']?></td>
            <td data-value-export='<?=$row['cus_fullname']?>' <?=$onclick?>>
                <a><?=$row['cus_fullname']?></a>
            </td>
            <td data-value-export='<?=$row['cus_email']?>' class="hidden"><?=$row['cus_email']?></td>
            <td data-value-export='<?=$row['cus_phone']?>' class="hidden"><?=$row['cus_phone']?></td>
            <td data-value-export='<?=sub_text(strip_tags($row['content']),100)?>' <?=$onclick?>><?=sub_text(strip_tags($row['content']),100)?></td>
            <td data-value-export='<?=date('d-m-Y G:i',$row['time'])?>' class="hidden"><?=date('d-m-Y G:i',$row['time'])?></td>
            <td data-value-export='<?=lang($status_field.'_'.$status_value)?>'>
                <span class="<?=$class?>">
                    <?=lang($status_field.'_'.$status_value)?>  
                </span>
            </td>
        </tr>
        <?
        $i++;
    }
?>