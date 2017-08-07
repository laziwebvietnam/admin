<?
    if(isset($list)){
        foreach($list as $row){
            
            $classType = 'label-default';
            $icon = 'fa-bell-o';
            
            if($row['action']=='edit'){
                $classType = 'label-warning';
            }else if($row['action']=='create'){
                $classType = 'label-info';
            }else if($row['action']=='delete'){
                $classType = 'label-danger';
            }
            
            $fullname = $row['user_fullname'];
            if($row['type']=='user'){
                $fullname = $row['c_fullname']; 
                $classType = 'label-success';  
                $icon = 'fa-user';
            }
            
            if($row['data_table']=='order'){
                $icon = 'fa-shopping-cart';
            }else if($row['data_table']=='contact'){
                $icon = 'fa-envelope';
            }
            
            
            
            ?>
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm <?=$classType?>">
                                <i class="fa <?=$icon?>"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc"> <?=$fullname?> <?=$row['alert']?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <time class="date lazitimeago" datetime="<?=date('Y-m-d G:i:s',$row['time'])?>"></time>
                </div>
            </li>
            <?
        }
    }
?>
