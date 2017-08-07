<?
    if($data['list']['data'] != null){
        $i = $data['list']['start'];
        
        foreach($data['list']['data'] as $row){
            ?>
            <tr class="odd gradeX">
                <td class="checkedbox">
                    <input type="checkbox" class="checkboxes" value="<?=$row['id']?>" /> 
                </td>
                <?
                    foreach($this->data_view['tableField'] as $key=>$field){
                        $this->data_view['dataTable']['otherInfo']['detail'] = $row;
                        $this->data_view['dataTable']['otherInfo']['linkDetail'] = isset($field['linkDetail'])?true:false;
                        $type = isset($field['type'])?$field['type']:'text';
                        $data_content = loadDatabyField($type,$field['name'],$row,$this->data_view['dataTable']['otherInfo']);
                        $class = isset($field['hidden'])?'hidden':'';
                        ?>
                        <td class="<?=$class?>" data-value-export='<?=$data_content['export']?>'><?=$data_content['html']?></td>
                        <?
                    }
                ?>
            </tr>
            <?
            $i++;
        }
    }
?>