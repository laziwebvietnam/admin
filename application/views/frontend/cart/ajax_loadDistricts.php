<option value="">Vui lòng chọn Quận / Huyện</option>
<?php
  if ($districts != null) {
    foreach ($districts as $key => $district) {
      ?>
        <option value="<?= md6($district['id']); ?>"><?= $district[$this->_lang . 'title']; ?></option>
      <?php
    }
  }
?>