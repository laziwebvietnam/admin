<option value="">Vui lòng chọn Phương thức Giao hàng</option>
<?php
  if ($ship_fees != null) {
    foreach ($ship_fees as $key => $fee) {
      ?>
        <option value="<?= md6($fee['id']); ?>"><?= $fee[$this->_lang . 'title']; ?> (<?= number_format($fee['fee'], 0, '.', ','); ?>₫)</option>
      <?php
    }
  }
?>