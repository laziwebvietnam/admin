<div class="table-toolbar">
    <div class="row">
        <div class="col-md-6">
            <div class="dataTables_length">
                <label>
                    <select class="form-control input-sm input-xsmall input-inline" 
                            onchange="setLimit(this)">
                        <?
                            $limit_selected = $this->data_view['dataTable']['limit_val'];
                            if($this->data_view['dataTable']['limit'] != null){                                
                                foreach($this->data_view['dataTable']['limit'] as $val){
                                    ?>
                                    <option <?=$limit_selected==$val?'selected':''?> 
                                            value="<?=$val?>"><?=$val?></option>
                                    <?
                                }
                            }
                        ?>
                        <option value="999999" <?=$limit_selected==999999?'selected':''?>>Tất cả</option>
                    </select> dữ liệu
                </label>
            </div>
        </div>
        <? if($this->data_view['dataTable']['field_search']!=false){ ?>
        <div class="col-md-6 col-sm-12">
            <div class="dataTables_filter">
                <form action="<?=CI_Router::$current_class.'/'.CI_Router::$current_action?>">
                    <label>Tìm kiếm:
                        <input type="text" class="form-control input-sm input-small input-inline" 
                                name="<?=$this->data_view['dataTable']['field_search']?>" 
                                placeholder="<?=lang('placeholder_search_'.$this->data_view['dataTable']['field_search'])?>"
                                value="<?=isset($_GET[$this->data_view['dataTable']['field_search']])?$_GET[$this->data_view['dataTable']['field_search']]:''?>"/>
                    </label>
                    <button type="submit" class="btn green">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>                                
        </div>
        <? } ?>
    </div>
</div>