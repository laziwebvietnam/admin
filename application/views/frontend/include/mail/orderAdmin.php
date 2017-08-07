<table style="width:100%">
    <thead>
        <th style="text-align:left">Sản phẩm</th>
        <th style="text-align:right">Giá gốc</th>
        <th style="text-align:right">Giá bán</th>
        <th style="text-align:right">Số lượng</th>
        <th style="text-align:right">Tổng tiền</th>
    </thead>
    <tbody>
    <?
        if($listProductOrder){
            foreach($listProductOrder as $item){
                $alias = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
				$alias = base_url().$alias.$item['prod_alias'];
                $item['price'] = $item['price']==0?'Liên hệ':number_format($item['price'],0,'.','.');
                $item['price_sale'] = $item['price_sale']==0?'Liên hệ':number_format($item['price_sale'],0,'.','.');
                $item['total'] = $item['total']==0?'Liên hệ':number_format($item['total'],0,'.','.');
                ?>
                <tr>
                    <td><a href="<?=$alias?>"><?=$item['prod_title']?></a></td>
                    <td style="text-align: right;"><?=$item['price']?></td>
                    <td style="text-align: right;"><?=$item['price_sale']?></td>
                    <td style="text-align: right;"><?=$item['quantity']?></td>
                    <td style="text-align: right;"><?=$item['total']?></td>
                </tr>
                <?
            }
        }
    ?>
    </tbody>
    <br/>
    <tfoot>
        
        <?
            if($detailOrder['coupon_id']!=null){
                ?>
                <tr>
                    <td colspan="4" style="font-weight: bold;">Mã khuyến mãi sử dụng: </td>
                    <td style="font-weight: bold;text-align: right;"><?=$detailOrder['coupon_code']?></td>
                </tr>
                <tr>
                    <td colspan="4">Tổng chi phí giảm: </td>
                    <td style="font-weight: bold;text-align: right;">- <?=$detailOrder['total_price_promotion']==0?'0':number_format($detailOrder['total_price_promotion'],0,'.','.');?></td>
                </tr>
            <?}
        ?>
        
        <tr>
            <td colspan="4" style="font-weight: bold;">Tổng tiền</td>
            <td style="font-weight: bold;text-align: right;"><?=$detailOrder['total_amount_sale']==0?'Liên hệ':number_format($detailOrder['total_amount_sale'],0,'.','.');?></td>
        </tr>
    </tfoot>    
</table>

<br />
<strong>Thông tin người đặt:</strong> <br />
- Họ tên: <?=$detailOrder['cus_fullname']?> <br />
- Điện thoại: <a href="tel:<?=$detailOrder['cus_phone']?>"><?=$detailOrder['cus_phone']?></a><br />
- Email: <a href="mailto:<?=$detailOrder['cus_email']?>"><?=$detailOrder['cus_email']?></a><br />
- Địa chỉ: <?=$detailOrder['cus_address']?><br />
- Ghi chú: <?=$detailOrder['note']?>

<br /><br />
<strong>Thông tin giao hàng:</strong> <br />
- Họ tên: <?=$detailOrder['ship_fullname']?> <br />
- Điện thoại: <a href="tel:<?=$detailOrder['ship_phone']?>"><?=$detailOrder['ship_phone']?></a><br />
- Email: <a href="mailto:<?=$detailOrder['ship_email']?>"><?=$detailOrder['ship_email']?></a><br />
- Địa chỉ: <?=$detailOrder['ship_address']?><br />

<br />
<p style="font-style: italic;">Quản trị viên có thể quản lý đơn hàng và cập nhật tình trạng đơn hàng tại: <a style="font-weight: bold;" href="<?=base_url()?>admin/order/edit/<?=$detailOrder['id']?>">TẠI ĐÂY</a></p>