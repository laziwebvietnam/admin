<?php
if ($fee != 0 || $coupon) {
    ?>
    <div class="total-price">
        Tạm tính
        <label>
            <?php
            if ($total < 1000) {
                echo 'Liên hệ';
            } else {
                echo number_format($total, 0, '.', ',') . '₫';
            }
            ?>
        </label>
    </div>
    <?php
}

if ($coupon) {
    if (is_numeric($coupon)) {
        ?>
        <div class="shiping-price">
            Coupon
            <label>- <?= number_format($coupon, 0, '.', ','); ?>₫</label>
        </div>
        <?php
    } else {
        ?>
        <div class="shiping-price">
            Coupon
            <label><?= $coupon; ?></label>
        </div>
        <?php
        $coupon = 0;
    }
    
}

if ($fee != 0) {
    ?>
    <div class="shiping-price">
        Phí vận chuyển
        <label><?= number_format($fee, 0, '.', ','); ?>₫</label>
    </div>
    <?php
}

$sumTotal = $fee + $total - $coupon;
$sumTotal = $sumTotal < 0 ? 0 : $sumTotal;
?>

<div class="total-checkout">
    Tổng cộng
    <span>
    <?php
    if ($sumTotal < 1000 && $sumTotal != 0) {
        echo 'Liên hệ';
    } else {
        echo number_format($sumTotal, 0, '.', ',') . '₫';
    }
    ?>
    </span>
</div>