<div class="row" style="margin-bottom: 25px;">
    <div class="col-md-9">
    </div>
    <div class="col-md-3">
        <a href="javascript:(0);" class="btn green" onclick="openModalFee('add');"> Thêm Phương thức
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<?php
  if ($fees != null) {
    foreach ($fees as $key => $fee) {
      ?>
        <div id="ship_fee_<?= $fee['id']; ?>" class="portlet light bordered">
            <?
                create_tab($fee[$this->_lang . 'title']);
            ?>
            <div class="portlet-body form">
            <?php
            switch ($fee['type']) {
              case 'weight':
                ?>
                <p>Tính theo: Khối lượng (kg)</p>
                <p>
                  <?php
                  if ($fee['max'] == 0) {
                    echo 'Áp dụng cho Đơn hàng có Khối lượng ' . $fee['min'] . 'kg trở lên.';
                  } elseif ($fee['min'] == 0) {
                    echo 'Áp dụng cho Đơn hàng có Khối lượng ' . $fee['max'] . 'kg trở xuống.';
                  } else {
                    echo 'Áp dụng cho Đơn hàng có Khối lượng từ ' . $fee['min'] . ' đến ' . $fee['max'] . 'kg.';
                  }
                  ?>
                </p>
                <?php
                break;
              case 'price':
                ?>
                <p>Tính theo: Khoảng giá (₫)</p>
                <p>
                  <?php
                  if ($fee['max'] == 0) {
                    echo 'Áp dụng cho Đơn hàng có Tổng giá trị ' . number_format($fee['min'], 0, '.', ',') . '₫ trở lên.';
                  } elseif ($fee['min'] == 0) {
                    echo 'Áp dụng cho Đơn hàng có Tổng giá trị ' . number_format($fee['max'], 0, '.', ',') . '₫ trở xuống.';
                  } else {
                    echo 'Áp dụng cho Đơn hàng có Tổng giá trị từ ' . number_format($fee['min'], 0, '.', ',') . ' đến ' . number_format($fee['max'], 0, '.', ',') . '₫.';
                  }
                  ?>
                </p>
                <?php
                break;
              default:
                break;
            }
            ?>
                <p>Chi phí: <?= number_format($fee['fee'], 0, '.', ','); ?>₫</p>
                <div class="row">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-1">
                        <a href="javascript:(0);" class="btn green" onclick="openModalFee('remove', <?= $fee['id']; ?>);">Xóa</a>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:(0);" class="btn green" onclick="openModalFee('edit', <?= $fee['id']; ?>);">Chỉnh sửa</a>
                    </div>
                </div>
            </div>
        </div>
      <?php
    }
  }

  if ($id_ship_fee != 0)  {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('html body').animate({
                scrollTop: $("#ship_fee_<?= $id_ship_fee; ?>").offset().top - 65
            }, 500);
        });
    </script>
    <?php
  }
?>