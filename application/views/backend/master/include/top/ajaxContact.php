<?
    if(isset($list)){
        if($list != null){
            foreach($list as $row){
                $readContact = 'contact/readContact/'.$row['id'];
                ?>
                <li>
                    <a href="<?=$readContact?>">                        
                        <span class="subject">
                            <span class="from"> <?=$row['cus_fullname']?> </span>
                            <time class="time lazitimeago" datetime="<?=date('Y-m-d G:i:s',$row['time'])?>"></time>
                        </span>
                        <div class="message"><?=sub_text(strip_tags($row['content']),120)  ?></div>
                    </a>
                </li>
                <?
            }
        }
    }
?>
        