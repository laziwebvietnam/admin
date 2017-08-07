<div class="table-bill-wrap" style="height: 27.3cm;width: 21cm;padding: 1cm 1.5cm;margin: auto;">
  <table class="table table-bordered table-bill" style="border: 1px solid #e7ecf1;border-collapse: collapse;border-spacing:0;width: 100%;max-height: 100%;max-width: 100%;">
      <tr>
          <td style="line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;">
              <img src="http://demo2.laziweb.com/nhasach_public/public/uploads/images/hinh-he-thong/logo.jpg" class="img-responsive" alt="">
          </td>
          <td colspan="3" style="padding: 8px; border: 1px solid #e7ecf1;" class="text-right">
              <p style="margin-top: 3px;margin-bottom: 5px;"><strong>Mã đơn hàng: <?= $data['detail']['id']; ?></strong></p>
              <p style="margin-top: 3px;margin-bottom: 5px;"><strong>Ngày đặt hàng: <?= date('d/m/Y', $data['detail']['time']); ?></strong></p>
          </td>
      </tr>
      <tr>
          <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;"><strong>Từ</strong></td>
          <td colspan="3" style="padding: 8px; border: 1px solid #e7ecf1;"><strong>Đến</strong></td>
      </tr>
      <tr>
          <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;">DOXA BOOKS</td>
          <td colspan="3" style="padding: 8px; border: 1px solid #e7ecf1;">
              <p style="margin-top: 3px;margin-bottom: 5px;">Họ tên khách: <?= $data['detail']['cus_fullname']; ?></p>
              <p style="margin-top: 3px;margin-bottom: 5px;">Địa chỉ: <?= $data['detail']['cus_address']; ?></p>
              <p style="margin-top: 3px;margin-bottom: 5px;">Điện thoại: <?= $data['detail']['cus_phone']; ?></p>
          </td>
      </tr>
      <?php
      $qty = 0;

        if ($data['list_product'] != null) {
          foreach ($data['list_product'] as $key => $product) {
            $qty += $product['quantity'];
          }
        }
      ?>
      <tr>
          <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;"><strong>Nội dung hàng (tổng SL sản phẩm: <?= $qty; ?>)</strong></td>
          <td colspan="3" style="padding: 8px; border: 1px solid #e7ecf1;"></td>
      </tr>
      <tr>
          <td class="product-list" colspan="4" style="padding: 0px; border: 1px solid #e7ecf1;">
              <div class="product-list-wrap" style="height: 400px;overflow-y: hidden;">
                  <table class="table table-bordered table-product-list" style="border-collapse: collapse;border-spacing:0;width: 100%;max-height: 100%;max-width: 100%;">
                  <?php
                    if ($data['list_product'] != null) {
                      foreach ($data['list_product'] as $key => $product) {
                        ?>
                        <tr>
                            <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;"><?= $product['product_title']; ?></td>
                            <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;">Số lượng: <?= $product['quantity']; ?></td>    
                            <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;">Đơn giá: <?= number_format($product['price'], 0, '.', ','); ?>₫</td>
                            <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;">Tiền: <?= number_format($product['total'], 0, '.', ','); ?>₫</td>
                        </tr>
                        <?php
                      }
                    }
                  ?>
                      
                  </table>
              </div>
              <strong style="display: block;padding: 8px;"><i>Một số sản phẩm có thể bị ẩn do danh sách quá dài</i></strong>
          </td>
      </tr>
      <tr>
          <td style="padding: 8px;line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;">
              <p style="margin-top: 3px;margin-bottom: 5px;"><strong>Tiền Thu Người Nhận:</strong></p>
              <p class="price" style="font-size: 25px;padding-top: 20px;padding-bottom: 20px;"><?= number_format($data['detail']['total_amount_sale'], 0, '.', ','); ?>₫</p>
              <p style="margin-top: 3px;margin-bottom: 5px;"><strong>Ghi Chú:</strong></p>
              <p style="margin-top: 3px;margin-bottom: 5px;"><?= $data['detail']['note']; ?></p>
          </td>
          <td style="padding: 8px; line-height: 1.42857;vertical-align: top;border: 1px solid #e7ecf1;text-align: center;padding-top: 30px;height: 220px;">
              <p style="margin-top: 3px;margin-bottom: 5px;"><strong>Nhân viên lấy hàng ký nhận</strong></p>
              <p style="margin-top: 3px;margin-bottom: 5px;"><small>(kí và ghi rõ họ tên)</small> </p>
          </td>
      </tr>
  </table>
</div>