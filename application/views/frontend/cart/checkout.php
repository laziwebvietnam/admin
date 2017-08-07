<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <base href="<?= base_url(); ?>" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no">

    <link href='template/frontend/css/font-awesome.min.css' rel='stylesheet' type='text/css' media='all' />
    <link href='template/frontend/css/check_out.min.css' rel='stylesheet' type='text/css' media='all' />

    <!-- jquery
    ============================================ -->
    <script src="template/frontend/js/vendor/jquery-1.11.3.min.js"></script>

    <?= $this->load->view($this->_base_view_path . 'include/masterpage/seo'); ?>

</head>

<body class="step1">

    <span class="fbtracker-checkout"></span>
    <a href="gio-hang"><h1><span class="btn-back">Quay về giỏ hàng</span>  Phụ kiện chuẩn men</h1></a>

    <div class="container clearfix">
        <form method="post" id="formOrder" autocomplete="off" action-submit="cart/action">
            <input type="hidden" name="form" value="order">
            <input type="hidden" name="coupon" value="<?= $this->session->userdata('coupon') != null ? $this->session->userdata('coupon') : ''; ?>">

            <div class="col-4 step1">
                <h2>Thông tin giao hàng</h2>


                <!-- <div class="user-login"><a href="#">Đăng ký tài khoản mua hàng</a> | <a href="#">Đăng nhập</a></div> -->

                <div class="line"></div>
                <div class="form-info">

                    <!-- <label class="color-blue">Mua không cần tài khoản</label> -->


                    <div class="new_order" id="forminfo" >

                        <div class="form-group">
                            <input onchange="getCustomerByMail(this.value, 'formOrder')" placeholder="Email" id="order_email" name="email" class="formcontrol" type="email" value="" />
                            <p>Email</p>
                        </div>
                        <div class="form-group">
                            <input placeholder="Họ tên" class="formcontrol" id="billing_address_full_name" name="fullname" type="text" />
                            <p>Họ tên</p>
                        </div>
                        <div class="form-group">
                            <input placeholder="Số điện thoại" id="billing_address_phone" class="formcontrol" name="phone" title="Số điện thoại" type="text" value=""  />
                            <p>Số điện thoại</p>
                        </div>
                        <div class="form-group">
                            <input placeholder="Địa chỉ" id="billing_address_address1" class="formcontrol" name="address" type="text" value="" />
                            <p>Địa chỉ</p>
                        </div>

                        <div class="form-group ctrl-city">
                            <div class='custom-dropdown'>
                                <select id="billing_address_province" name="city" class="formcontrol" 
                                onchange="loadDistricts(this.value);">
                                    <option value="">Vui lòng chọn Tỉnh / Thành phố</option>
                                    <?php
                                      if ($cities != null) {
                                        foreach ($cities as $key => $city) {
                                          ?>
                                            <option value="<?= md6($city['id']); ?>" ><?= $city[$this->_lang . 'title']; ?></option>
                                          <?php
                                        }
                                      }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ctrl-district" id="shipping_district_container">
                            <div class='custom-dropdown'>
                                <select id="shipping_district" name="district" class="formcontrol"
                                onchange="loadShipFee(this.value);">
                                    <option value="">Vui lòng chọn Quận / Huyện</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ctrl-district" id="shipping_district_container">
                            <div class='custom-dropdown'>
                                <select id="shipping_district" name="id_ship_fee" class="formcontrol" onchange="reloadTotal();">
                                    <option value="">Vui lòng chọn Phương thức Giao hàng</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea id="billing_note" placeholder="Ghi chú đơn hàng" name="note" rows="3" class="formcontrol ordernote"></textarea>
                            <p>Ghi chú đơn hàng</p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div id="purchase-form" >

                <div class="col-4">
                    <!-- Vận chuyển & Thanh Toán -->
                    <!-- <div class="ctrl-shipping">
                        <h3 class="h-shipping ">Vận chuyển</h3>
                        <div class="form-group ">
                            <div class='custom-dropdown'><select class="drop_shipping" name="shipping_rate"></select></div>
                        </div>
                    </div> -->

                    <h3>Thanh toán</h3>
                    <div class="shiping-ajax">

                        <label class="lb-method">
                            <input class="input-method" type="radio" checked="checked" name="method" value="Thanh toán khi giao hàng (COD)" />
                            <span class="label-radio"> Thanh toán khi giao hàng (COD)</span>
                        </label>

                        <label class="lb-method">
                            <input class="input-method" type="radio" name="method" value="Chuyển khoản qua ngân hàng" />
                            <span class="label-radio"> Chuyển khoản qua ngân hàng</span>
                        </label>

                        <div class="list-bank">
                            <?= valueByKey($this->_template['config_website'], $this->_lang . 'accounts'); ?>
                        </div>

                    </div>

                </div>
                
                <div class="col-4">
                    <div class="box-cart">
                        <h2>Đơn hàng</h2> 
                        <span>(<?= $this->cart->total_items(); ?> sản phẩm)</span>
                        <div class="cart-items">
                        <?php
                        $has_sale = false;

                        foreach ($this->cart->contents() as $key => $product) {
                            if (!$has_sale) {
                                $has_sale = $product['options']['sale'] == 'N/A' ? false : true;
                            }
                            ?>
                            <div class="list_item cart-item">
                                <span><?= $product['qty']; ?> x</span>
                                <span><?= $product['name']; ?></span>
                                <span class="price"><?= $product['price'] == 1 ? 'Liên hệ' : number_format($product['price'] * $product['qty'], 0, '.', ',') . '₫'; ?></span>
                                <p class="variant-title">
                                    <?= $product['options']['color'] != 'N/A' ? 'Màu sắc: ' . $product['options']['color'] . '<br>' : ''; ?>
                                    <?= $product['options']['size'] != 'N/A' ? 'Kích thước: ' . $product['options']['size'] . '<br>' : ''; ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                            <div class="list_item cart-item">
                                <span>Tổng Khối lượng:</span>
                                <span class="price"><?= $total_weight; ?> (kg)</span>
                            </div>
                        </div>

                        <?php
                        if ($has_sale) {
                            echo valueByKey($this->_template['config_website'], $this->_lang . 'checkout_text');
                            ?>
                            <input type="hidden" name="coupon_code" class="couponcode">
                            <?php
                        } else {
                            ?>
                            <a class="btn-coupon btn-arrow" href="javascript:void(0);" onclick="$('.box-cart .use-coupon').slideToggle(300);">
                                <span></span> Sử dụng mã giảm giá
                            </a>
                            <div class="use-coupon">
                                <div class="form-group" style="margin: 0 0 15px 0;">
                                    <input name="coupon_code" onchange="checkCoupon(this.value); reloadTotal();" class="couponcode" placeholder="Nhập mã giảm giá">
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div id="totalReload">
                            <div class="total-checkout">
                                Tổng cộng
                                <span><?= $total < 1000 ? 'Liên hệ' : number_format($total, 0, '.', ',') . '₫'; ?></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-checkout">Đặt hàng</button>
                    
                    <?= valueByKey($this->_template['config_website'], $this->_lang . 'checkout_desc'); ?>

                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="template/frontend/lazi/function.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/cart.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/contact.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/customer.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/form.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/custom.js"></script>
    <script type="text/javascript" src="template/frontend/lazi/template.js"></script>

    <link rel="stylesheet" type="text/css" href="template/frontend/lazi/toastr.css">
    <script type="text/javascript" src="template/frontend/lazi/toastr.min.js"></script>

</body>

</html>