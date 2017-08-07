<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class cart extends Cart_controller{
    // var $configVTC = array(
    //     'destinationUrl' => "https://pay.vtc.vn/cong-thanh-toan/checkout.html",
    //     'txtWebsiteID' => '2026',
    //     'txtCurency' => '1', //1: VND, 2: USD
    //     'txtReceiveAccount' => '0932038696',
    //     'txtParamExt' => '',
    //     'txtSecret' => 'Gamercompany@123',
    //     'txtUrlReturn' => 'gamercompany.vn/ket-qua-thanh-toan',
    //     'txtDescription' => 'Thanh toán đơn hàng trực tuyến Gamercompany'
    // );

    function __construct(){
        parent::__construct();
        $this->load->model('M_product');
    }

    function showCart() {
        echo '<pre>';
        print_r($this->cart->contents());
    }

    function index(){
        $this->load->model('M_product');
        $data['list'] = $this->M_product->frontend_getList(array(),0,5);
        $this->set_seodata();
        $this->load_view('cart/demo/index',$data);
    }

    function checkout(){
        if ($this->cart->contents()) {
            $dataBreadcrumb[$this->_lang . 'title'] = 'Thanh toán';
            $dataBreadcrumb[$this->_lang . 'alias'] = base_url() . 'thanh-toan';
        
            $data = array(
                // 'cities' => $this->My_model->getlist('location', array('is_active' => 1, 'level' => 0, 'position >' => 1), 0, 99, 'position asc'),
                // 'total' => $this->getTotalAmount(),
                // 'total_weight' => $this->getTotalWeight()
            );
        
            $dataSeo = array(
                $this->_lang . 'title' => 'Thanh toán',
                $this->_lang . 'desc' => 'Thanh toán',
                $this->_lang . 'keyword' => 'Thanh toán'
            );
            
            $this->set_seodata(null, null, $dataSeo);
            $this->load->view($this->_base_view_path . 'cart/checkout', $data);
        } else {
            redirect('gio-hang');
        }
        
    }

    function demo_ajaxLoadList($cartInfo=array()){
        //$this->load_message();return;
        $data['list'] = $cartInfo;
        return $this->load->view($this->_base_view_path.'cart/demo/ajaxLoadList',$data,true);
    }

    /**
     * [getAllInfo description]
     * @param  string $typeReturn [description]
     * @return [type]             [description]
     */
    function getAllInfo($typeReturn='json'){
        $cart['info'] = $this->cart->contents();
        $cart['total_before_sale'] = $this->getTotalCart();
        // $couponCode = isset($_POST['couponCode'])?$_POST['couponCode']:null;
        
        $cart['total'] = $this->getTotalAmount();
        $cart['total_text'] = number_format($cart['total'],0,'.','.');
        $cart['total_before_sale_text'] = number_format($cart['total_before_sale'],0,'.','.');
        $cart['item'] = $this->cart->total_items();

        /** load cac view ajax order tai day */
        $cart['infoHtml'] = $this->demo_ajaxLoadList($cart['info']);
        // $cart['infoTop'] = $this->load->view($this->_base_view_path . 'cart/ajax_cartTop', $cart, true);
        // $cart['infoTable'] = $this->load->view($this->_base_view_path . 'cart/ajax_cartTable', $cart, true);
        /*************************************/
        
        if(__IS_AJAX__){
            echo json_encode($cart);
        }else{
            if($typeReturn=='array'){
                return $cart;
            }else{
                $this->load_message();
            }
        }
    }

    function ajax_loadDistricts($md6_id) {
        if (__IS_AJAX__) {
          $data = array(
              'districts' => $this->My_model->getlist('location', array('is_active'=>1,'id_parent'=>md6_decode($md6_id)), 0, 99, 'position asc')
          );
    
          $this->load->view($this->_base_view_path . 'cart/ajax_loadDistricts', $data);
        }
    }

    function ajax_loadShipFee($md6_id) {
        if (__IS_AJAX__) {
          $total_weight = $this->getTotalWeight();
          $total = $this->getTotalCart();

          $ship_fees = array();
          $ship_fees = $this->My_model->getlist('ship_fee', array(
              'is_active' => 1,
              'is_delete' => 0,
              'id_location' => md6_decode($md6_id),
          ));
          if (!$ship_fees) {
              $ship_fees = $this->My_model->getlist('ship_fee', array(
                  'is_active' => 1,
                  'is_delete' => 0,
                  'id_location' => 4614,
              ));
          }

          if ($ship_fees) {
            foreach ($ship_fees as $key => $fee) {
                if ($fee['type']) {
                    if ($fee['type'] == 'price') {
                        $to_compare = $total;
                    } elseif ($fee['type'] == 'weight') {
                        $to_compare = $total_weight;
                    }

                    if ($fee['max'] == 0) {
                        if ($to_compare < $fee['min']) {
                            unset($ship_fees[$key]);
                        }
                    } else {
                        if ($to_compare < $fee['min'] || $to_compare > $fee['max']) {
                            unset($ship_fees[$key]);
                        }
                    }
                }
            }

            foreach ($ship_fees as $key => $fee) {
                if ($fee['fee'] == 0) {
                    $parent_fee = $this->My_model->getbyid('ship_fee', $fee['id_parent']);
                    if ($parent_fee) $ship_fees[$key] = $parent_fee;
                }
            }
          }

          $data = array(
              'ship_fees' => $ship_fees
          );
    
          $this->load->view($this->_base_view_path . 'cart/ajax_loadShipFee', $data);
        }
    }

    function getTotalWeight() {
        $total_weight = 0;
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $key => $item) {
                $total_weight += $item['options']['weight'] * $item['qty'];
            }
        }
        return $total_weight;
    }

    function ajax_reloadTotal() {
        if (__IS_AJAX__) {
            $id_ship_fee = $_POST['id_ship_fee'];
            $coupon_code = $_POST['coupon_code'];

            $where = array(
                'fee' => array(
                    'is_active'=>1,
                    'is_delete'=>0,
                    'id'=>md6_decode($id_ship_fee)
                ),
                'coupon_code' => array(
                    'code'=>$coupon_code,
                    'is_delete'=>0,
                    'is_active'=>1
                ),
            );

            $fee = $this->My_model->getdetail_by_any('ship_fee', $where['fee']);

            $data = array(
                'total' => $this->getTotalCart(),
                'fee' => $fee ? $fee['fee'] : 0,
                'coupon' => ''
            );

            $detailCoupon = $this->My_model->getdetail_by_any('coupon', $where['coupon_code']);

            if($detailCoupon==null){
            }else if($detailCoupon['time_start'] > time() && $detailCoupon['time_start'] != 0){
            }else if($detailCoupon['time_end']+86399 < time() && $detailCoupon['time_end'] != 0){
            }else{
                if ($detailCoupon['type'] == 'gift') {
                    $data['coupon'] = $detailCoupon['title'];
                } else {
                    $data['coupon'] = $this->getTotalCart() - $this->getTotalAmount(md6($detailCoupon['id']));
                }
            }

            $this->load->view($this->_base_view_path . 'cart/ajax_reloadTotal', $data);
        }
    }

    function action(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('fullname','email','address');
            $rules['valid_email'] = array('email');
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit' || $typeAction=='checkVTC'){
                $data_return['info'] = $this->actionSuccess($typeAction);
                $data_return['status'] = 'success';
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    /**
     * [actionSaveOrder description]
     * @return [type] [description]
     */
     
    function actionSuccess($typeAction){
        $data_return['status_action'] = 'fail';
        if($this->cart->total_items()>0){
            $cartList = $this->cart->contents();
            $orderDetailData = array();
            $orderData = $this->postvalue(array('note'));
            $orderData['total_amount'] = 0;
            if($cartList != null){
                foreach($cartList as $item){
                    $orderDetailData[] = array(
                        'id_product'=>$item['idProduct'],
                        'quantity'=>$item['qty'],
                        'price'=>$item['options']['price'],
                        'price_sale'=>$item['price'],
                        'total'=>$item['price']*$item['qty'],
                        // 'sale' => $item['options']['sale'],
                    );
                    $orderData['total_amount'] += $item['options']['price']*$item['qty'];
                }
            }
    
            $dataCustomer = $this->postvalue(array('fullname','email','phone','address','form'));
            
            // $orderData['city'] = md6_decode($_POST['city']);
            // $orderData['district'] = md6_decode($_POST['district']);
            // $orderData['note'] = $_POST['note'];
            $orderData['id_customer'] = $this->findCustomer($dataCustomer);
            $orderData['time'] = time();

            $coupon_code = isset($_POST['coupon_code'])?$_POST['coupon_code']:'';
            $detailCoupon = $this->My_model->getdetail_by_any('coupon', array(
                'code'=>$coupon_code,
                'is_delete'=>0,
                'is_active'=>1
            ));
            $orderData['id_coupon'] = $detailCoupon?$detailCoupon['id']:null;
            $orderData['total_amount_sale'] = $this->getTotalAmount($orderData['id_coupon'] ? md6($orderData['id_coupon']) : null);
            $orderData['total_price_promotion'] = $this->getTotalCart() - $orderData['total_amount_sale'];

            if ($_POST['id_ship_fee']) {
                $orderData['id_ship_fee'] = md6_decode($_POST['id_ship_fee']);
                $fee = $this->My_model->getdetail_by_any('ship_fee', array(
                    'is_active'=>1,
                    'is_delete'=>0,
                    'id'=>$orderData['id_ship_fee']
                ));
                $orderData['title_ship_fee'] = $fee['title'];
                $orderData['ship_fee'] = $fee['fee'];
            }

            $idOrder = $this->My_model->insert('order',$orderData);
    
            if($idOrder>0 && $orderDetailData!=null){
                foreach($orderDetailData as $key=>$item){
                    $item['id_order'] = $idOrder;
                    $this->My_model->insert('order_detail',$item);
                }
            }
    
            //$data_return['customer'] = $dataCustomer;
            //$data_return['order'] = $orderData;
            //$data_return['order_detail'] = $orderDetailData;
            $data_return['idOrder'] = md6($idOrder);
            $data_return['alert'] = isset($this->_template['config_website'][$this->_lang.'order_alert_success'])?$this->_template['config_website'][$this->_lang.'order_alert_success']:'';
            $data_return['status_action'] = 'success';
            $this->cart->destroy();

            // if ($typeAction == 'checkVTC') {
            //     $data_return['linkVTC'] = $this->processVTC($idOrder);
            // } else {
            //     $this->cart->destroy();
            // }
        }
        return $data_return;
    }

    function getTotalAmount($couponCode=null){
        $valuePromotion = 0;
        $totalAmount = $this->getTotalCart();
        if($couponCode){
            $couponId = md6_decode($couponCode);
            $detailCoupon = $this->My_model->getbyid('coupon',$couponId);
            if($detailCoupon){
                if($detailCoupon['value']>0){
                    if($detailCoupon['type']=='real_price'){
                        $valuePromotion = $detailCoupon['value'];
                    }else if($detailCoupon['type']=='percent_price'){
                        $valuePromotion = $totalAmount*$detailCoupon['value']/100;
                    }
                    $totalAmount = $totalAmount - $valuePromotion;
                    $totalAmount = $totalAmount<0?0:$totalAmount;
                }
            }
        }
        return round($totalAmount,-3);
    }

    function checkCoupon(){
        //$_POST['code'] = '#muangay';
        if(__IS_AJAX__ && isset($_POST['code'])){
            $data_return['status'] = 'fail';
            $code = trim($_POST['code']);
            $where = array(
                'code'=>$code,
                'is_delete'=>0,
                'is_active'=>1
            );
            $detailCoupon = $this->My_model->getdetail_by_any('coupon',$where);
            if($detailCoupon==null){
                $data_return['log'] = lang('coupon_not_found');
            }else if($detailCoupon['time_start'] > time() && $detailCoupon['time_start'] != 0){
                $data_return['log'] = lang('coupon_not_active');
            }else if($detailCoupon['time_end']+86399 < time() && $detailCoupon['time_end'] != 0){
                $data_return['log'] = lang('coupon_expired');
            }else{
                $data_return['status'] = 'success';
                $detailCoupon['id'] = md6($detailCoupon['id']);
                $detailCoupon['typeText'] = return_valueKey($this->_template['coupon'],'id',$detailCoupon['type'],'title');
                $detailCoupon['valueText'] = $detailCoupon['value'];
                if($detailCoupon['type']=='real_price'){
                    $detailCoupon['valueText'] = number_format((int)$detailCoupon['value'],0,'.','.') . ' đ';
                }else if($detailCoupon['type']=='percent_price'){
                    $detailCoupon['valueText'] = number_format((int)$detailCoupon['value'],0,'.','.') . '%';
                }
                $data_return['info'] = $detailCoupon;
            }
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }

    function done() {
        if($_GET){
            $dataBreadcrumb['title'] = 'Kết quả thanh toán';
            $dataBreadcrumb['alias'] = base_url() . 'ket-qua-thanh-toan';

            $data = array(
                'breadcrumb' => $this->getBreadcrumb($dataBreadcrumb, 'onepage'),
            );

            $dataSeo = array(
                'title' => 'Kết quả thanh toán',
                'desc' => 'Kết quả thanh toán',
                'keyword' => 'Kết quả thanh toán'
            );
            
            $this->set_seodata(null, null, $dataSeo);

            $orderid = $_GET["reference_number"];
            $order = $this->My_model->getbyid('order', $orderid);

            if ($order['info_paid'] == '') {
                $status = $_GET["status"];
                $websiteid = $_GET["website_id"];
                
                $amount = $_GET["amount"];
                $payment_type = $_GET["payment_type"];
                $message = $_GET["message"];
                $trans_ref_no = $_GET["trans_ref_no"];
                $sign = $_GET["signature"];
                $plaintext = $amount . "|" . $message . "|" . $payment_type . "|" . $orderid . "|" . $status . "|" . $trans_ref_no . "|" . $websiteid . "|" . $this->configVTC['txtSecret'];
                $mysign = strtoupper(hash('sha256', $plaintext));
    
                if ($mysign != $sign) {
                    $order['is_paid'] = -2;
                    $data['alert'] = 'Lỗi dữ liệu không hợp lệ.';
                }
                else {
                    switch ($status) {
                        case 1:
                            $order['is_active'] = 3;
                            $data['alert'] = 'Thanh toán thành công!';
                            $this->cart->destroy();
                            break;
                        case 2:
                            $data['alert'] = 'Thanh toán thành công! - đang chờ';
                            break;
                        case 0:
                            $data['alert'] = 'Thanh toán đang chờ.';
                            break;
                        case -1:
                            $data['alert'] = 'Thanh toán không thành công.';
                            break;
                        case -5:
                            $data['alert'] = 'Mã Hóa đơn không hợp lệ.';
                            break;
                        case -6:
                            $data['alert'] = 'Số dư tài khoản không đủ thanh toán.';
                            break;
                        default:
                            $data['alert'] = 'Thanh toán không thành công.';
                            break;
                    }

                }
    
                foreach ($_GET as $key => $value) {
                    $order['info_paid'][$key] = $value;
                }
                $order['info_paid'] = json_encode($order['info_paid']);
                $order['is_paid'] = $status;
                $this->My_model->update('order', $order);

                if ($amount != $order['total_amount_sale']) {
                    $dataMail = array(
                          'amountVTC' => $amount,
                          'order' => $order,
                      );

                      $mailContent = $this->load->view($this->_base_view_path . 'include/mail/unmatchedVTC', $dataMail, true);

                      $where = array(
                          'is_active' => 1,
                          'is_delete' => 0,
                          'id' => 1
                      );
                      $userList = $this->My_model->getlist('user', $where);
                      $mailList = array();
                      if ($userList) {
                        foreach ($userList as $user) {
                          $mailList[] = $user['email'];
                        }
                      }
                      if ($mailList) {
                        //$mailList[] = 'hotienloc.92@gmail.com';
                        $mailList = implode($mailList, ',');
                        $sentMail = array('email' => $mailList,
                            'subject' => 'Giao dịch VTC trả về Giá trị đơn hàng không trùng khớp',
                            'data' => array('message' => $mailContent),
                            'form' => 'forgotpwd');
                        $statusSentmail = $this->lazi_mailer->send($sentMail);
                      }
                }
            } else {
                $data['alert'] = 'Đơn hàng đã được xử lý!';
            }

            $this->load_view('cart/done', $data);

            // fwrite($fh,sprintf("Data = %s\t#\t sign=%s\t",$data,$sign));
            // fclose($fh);

            // $handle = fopen("data". DIRECTORY_SEPARATOR  ."data.txt", "r");
            // $contents = fread($handle, filesize("data". DIRECTORY_SEPARATOR ."data.txt") + 1);
            // fclose($handle);
            // echo $contents;
        }
    }

    function processVTC($idOrder){
        $order = $this->My_model->getbyid('order', $idOrder);
        //new version
        $plaintext = 
            $this->configVTC["txtWebsiteID"] . "-" . 
            $this->configVTC["txtCurency"] . "-" . 
            $idOrder . "-" . 
            $order['total_amount_sale'] . "-" . 
            $this->configVTC["txtReceiveAccount"] . "-" . 
            $this->configVTC["txtParamExt"] . "-" . 
            $this->configVTC["txtSecret"]. "-" . 
            $this->configVTC["txtUrlReturn"];
        
        $sign = strtoupper(hash('sha256', $plaintext));
        
        $data = 
            "?website_id=" . $this->configVTC["txtWebsiteID"] . 
            "&payment_method=" . $this->configVTC["txtCurency"] . 
            "&order_code=" . $idOrder . 
            "&amount=" . $order['total_amount_sale'] . 
            "&receiver_acc=" .  $this->configVTC["txtReceiveAccount"]. 
            "&urlreturn=" .  $this->configVTC["txtUrlReturn"];
        
        $customer_first_name = htmlentities($_POST["fullname"]);
        // $customer_last_name = htmlentities($this->configVTC["txtCustomerLastName"]);
        $customer_last_name = '';
        $bill_to_address_line1 = htmlentities($_POST["address"]);
        // $bill_to_address_line2 = htmlentities($this->configVTC["txtBillAddress2"]);
        $bill_to_address_line2 = '';
        // $city_name = htmlentities($this->configVTC["txtCity"]);
        $city_name = '';
        // $address_country = htmlentities($this->configVTC["txtCountry"]);
        $address_country = '';
        $customer_email = htmlentities($_POST["email"]);
        $order_des = htmlentities($this->configVTC["txtDescription"]);
        
        $data = $data . 
            "&customer_first_name=" . $customer_first_name. 
            "&customer_last_name=" . $customer_last_name. 
            "&customer_mobile=" . $_POST["phone"]. 
            "&bill_to_address_line1=" . $bill_to_address_line1. 
            "&bill_to_address_line2=" . $bill_to_address_line2. 
            "&city_name=" . $city_name. 
            "&address_country=" . $address_country. 
            "&customer_email=" . $customer_email . 
            "&order_des=" . $order_des . 
            "&param_extend=" . $this->configVTC["txtParamExt"] . 
            "&sign=" . $sign;

        return ($this->configVTC["destinationUrl"] . $data);
    }
}
?>