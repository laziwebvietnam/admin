<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <span class="caption-subject font-green sbold uppercase">Danh sách Sản phẩm</span>
        </div>

        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
        </div>
    </div>
    <div class="portlet-body form" id="product-product-form">
        <?
        if (isset($products) && $products) {
            foreach ($products as $product) {
                ?>
                <div class="row">
                <?
                    create_select_div10('products[]',false,md6($product['id']),false,$data['products'],'title');
                ?>
                    <div class="col-md-2 product_button_remove">
                        <a href="javascript:;" class="btn red" onclick="product_button_remove(this)"> Xóa
                            <i class="fa fa-remove"></i>
                        </a>
                    </div>
                </div>
                <?
            }
        }
        ?>
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 product_button_add">
                <a href="javascript:;" class="btn green"> Thêm
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>