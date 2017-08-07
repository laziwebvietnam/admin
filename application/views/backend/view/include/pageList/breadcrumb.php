<div class="page-bar">
    <ul class="page-breadcrumb">
        <?
            if($breadcrumb){
                $n = count($breadcrumb)-1;
                foreach($breadcrumb as $key=>$row){
                    $alias = $key==$n?'javascript:;':$row['alias'];
                    $icon = $key==$n?'':'<i class="fa fa-circle"></i>';
                    ?>
                    <li>
                        <a href="<?=$alias?>"><?=$row['title']?></a>
                        <?=$icon?>
                    </li>
                    <?
                }
            }
        ?>
    </ul>
    <?
        if($this->data_view['btnCreate']==true){
            ?>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <a class="btn green" href="<?=$this->_table?>/create"> <?=lang('create')?>
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <?
        }
    ?>
</div>

<h3 class="page-title"><?=lang($this->data_view['pageTitle'])?></h3>
