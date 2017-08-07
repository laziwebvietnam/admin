<?
    $noAction = true;
    if(isset($this->data_view['dataTable']['quickAction'])){
        if($this->data_view['dataTable']['quickAction']!=null){
            $noAction = false;
        }
    }
?>

<thead>
    <tr>
        <th class="sorting_disabled h40" rowspan="2">
            <input id="data-table-checkbox" type="checkbox" class="group-checkable" value="1" />
        </th>
        <th id="data-table-action"  colspan="6" class="hidden h40">
            <div class="btn-group">
                <a class="btn red btn-outline" href="javascript:;" data-toggle="<?=$noAction==false?'dropdown':''?>">
                    <i class="fa fa-share"></i>
                    <span class="hidden-xs"> Chọn thao tác (đang chọn <span id="data-table-count">0</span> <?=lang($this->_table)?>) </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-left">
                    <?
                        if(isset($this->data_view['dataTable']['quickAction'])){
                            if($this->data_view['dataTable']['quickAction'] != null){
                                foreach($this->data_view['dataTable']['quickAction'] as $row){
                                    ?>
                                    <li>
                                        <a href="javascript:;" class="tool-action"
                                            postUrl="<?=$row['action']?>"
                                            typePopup="<?=$row['popup']?>"
                                            onclick="quickAction(this)">
                                            <?=$row['title']?>
                                        </a>
                                    </li>
                                    <?
                                }
                            }
                        }
                    ?>
                </ul>
            </div>
        </th>
    </tr>
    <?
        if(isset($this->data_view['tableField'])){
            if($this->data_view['tableField']){
                echo "<tr id=\"data-table-field\">";
                foreach($this->data_view['tableField'] as $key=>$row){
                    $key = "Field_".$row['name'];
                    $name = $row['name'];
                    $title = $row['title'];
                    $class = 'sorting';
                    $val_change = 'asc';
                    if($this->data_view['dataTable']['field_sort']['name']==$row['name']){
                        $val_change = $this->data_view['dataTable']['field_sort']['status']=='asc'?'desc':'asc';
                    }
                    $status = '';

                    if($this->data_view['dataTable']['field_sort']['name']==$row['name']){
                        $class .= '_'.$this->data_view['dataTable']['field_sort']['status'];
                        $status = 'active';
                    }
                    $class .= isset($row['hidden'])?' hidden':'';
                    echo "<th data-field=\"$key\" 
                              data-name=\"$name\"
                              data-val-change=\"$val_change\"
                              class=\"$class\" 
                              status=\"$status\"
                              onclick=\"ajaxSetsortby(this)\"> $title </th>";            
                }
                echo "</tr>";
            }
        }
    ?>
</thead>