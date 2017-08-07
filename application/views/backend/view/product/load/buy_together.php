<?
    if(isset($data['product_buy_together'])){
?>
<div class="portlet light bordered product_buy_together">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-green sbold uppercase">Sản phẩm mua kèm</span>
        </div>
    </div>
     <div class="portlet-body form">
        <div class="form-body">
            <?
                if($data['product_buy_together']){
                    foreach($data['product_buy_together'] as $item){
                        ?>
                        <div class="form-group">
                            <div class="col-md-10">
                                <a target="_blank" href="product_buy_together/edit/<?=$item['id']?>">
                                    <?=$item['pro_relative_title']?>
                                </a>
                                <br/>
                                <span><?=number_format($item['price_sale'],0,'.','.') ?>đ</span>
                                <span class="price_nosale">
                                    <?=number_format($item['price_nosale'],0,'.','.') ?>đ
                                </span>
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-icon-only btn-default" href="javascript:;" 
                                    posturl="product_buy_together/delete_once_popup/<?=$item['id']?>" 
                                    typepopup="1" onclick="quickAction(this)">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>
                        </div>
                        <?
                    }
                }
            ?>
            
            <div class="form-group">
                <div class="col-md-12">
                    <a class="product_buy_together" href="product_buy_together/create?id_product_main=<?=$data['detail']['id']?>" target="_blank">
                        <i class="fa fa-plus"></i> Thêm sản phẩm mua kèm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<? } ?>