<?
    
    $i = $data['list']['start'];
    
    foreach($data['list']['data'] as $row){
        $fullname = $row['user_fullname'];
        if($row['type']=='customer'){
            $fullname = $row['cus_fullname'];
        }
        ?>
        <tr class="odd gradeX">
            <td class="checkedbox">
                <input type="checkbox" class="checkboxes" value="<?=$row['id']?>" /> 
            </td>
            <td data-value-export='<?=$row['id']?>'><?=$row['id']?></td>
            <td data-value-export='<?=$fullname?>'><?=$fullname?></td>
            <td data-value-export='<?=strip_tags($row['alert'])?>'>
                <? 
                    echo $row['alert'];
                    if($row['action']=='delete'){
                        ?>
                        , <a href="javascript:;" typepopup="1" onclick="quickAction(this)"
                            posturl="<?=$row['data_table'].'/restore/delete/'.$row['data_id']?>">khôi phục</a>
                        <?
                    }
                ?>
                
            </td>
            <td data-value-export='<?=date('d-m-Y g:i a',$row['time'])?>'><?=date('d-m-Y G:i',$row['time'])?></td>
            <td data-value-export='<?=$row['type']?>'><?=lang('notification_'.$row['type'])?></td>
        </tr>
        <?
        $i++;
    }
?>