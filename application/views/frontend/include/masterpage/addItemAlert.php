<style type="text/css">
  #toastrImage {
    width: 50px; float: left;
  }
  #toastrInfo {
    padding-left: 10px;
    width: 173px;
    float: left;
  }
  #toastrInfo span {
    font-size: 16px;
  }
  #toastrInfo strong {
    font-size: 20px;
  }
  #toastrDetail {
    margin-right: 10px;
    border: 1px solid white;
    color: white;
    background: none;
  }
  #toastrCart {
    background: white;
    color: #51A351;
  }
</style>

<?php
$pre = return_valueKey($this->_template['typeCategory'], 'id', 'product', 'alias');
?>

<div>
  <img id="toastrImage" src="<?= $product['image']; ?>"/>
  <div id="toastrInfo">
    <span><?= $product[$this->_lang . 'title']; ?></span>
    <br>
    <strong>+<?= $qty; ?></strong>
  </div>
  <div class="clearfix"></div>
</div>
<div style="margin-top: 10px;">
  <button id="toastrDetail" type="button" class="btn" onclick="window.location.href='<?= $this->_BASE_URL . $pre . $product[$this->_lang . 'alias']; ?>'">Chi tiết</button>
  <button id="toastrCart" type="button" class="btn" onclick="window.location.href='gio-hang'">Giỏ hàng</button>
</div>