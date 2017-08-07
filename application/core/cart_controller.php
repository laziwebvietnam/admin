<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Cart_controller extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_order');
        $this->load->model('M_product_buy_together');
    }        

    /**
     * [add description]
     * @param integer $id  [description]
     * @param integer $qty [description]
     */
    function add($id=0,$qty=1)
    {
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            if($this->SessionExcute('check')==false){
                $data_return['log'] = 'Spam';
                echo json_encode($data_return);
                return;
            }
            $qty = (float)$qty;
            $qty = $qty>0?$qty:1;
            $qty = $qty>0?($qty>50?50:$qty):1;
            $id = md6_decode($id);
            
            $product = $this->M_product->getDetailByField('tb.id',$id,false);
            $dataBuyTogether = isset($_POST['productBuyTogether'])?$_POST['productBuyTogether']:array();

            if($product){
                /** find id product exist in cart */
                $itemRowId = $this->findItemByIdProduct($id,$cartList);

                $checkAddNewCart = false;

                if($itemRowId==null){
                    $checkAddNewCart = true;
                }else if(isset($cartList[$itemRowId]['idProductMain'])){
                    $checkAddNewCart = true;
                }

                if($checkAddNewCart==true){
                    /** if not - add to cart with qty = 1 */
                    $alias = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
                    $alias = base_url().$alias.$product[$this->_lang.'alias'];
                    $cartItem = array(
                        'id'=>count($cartList)+1,
                        'idProduct'=>$id,
                        'qty'=>$qty,
                        'price'=>$product['price_result'] == 0 ? 1 : $product['price_result'],
                        'name'=>$product[$this->_lang.'title'],
                        'options'=>array(
                            'promotion'=>$product['promotion'],
                            'price'=>$product['price'] ? $product['price'] : 0,
                            'image'=>$product['image'],
                            'alias'=>$alias,
                            // 'sale' => $product['sale_title']
                        )
                    );
                    $this->cart->insert($cartItem);
                    $this->addItemFree($id);
                    $this->addItemTogether($id,$dataBuyTogether);
                    $data_return['status'] = 'success';
                    $data_return['id'] = $id;
                    $this->SessionExcute('set');

                    $var = array(
                        'product' => $product,
                        'qty' => $qty,
                    );
                    $data_return['viewAlert'] = $this->load->view($this->_base_view_path . 'include/masterpage/addItemAlert', $var, true);
                }else{
                    /** if exist - update with qty++ */
                    $itemDetail = $cartList[$itemRowId];
                    $itemDetail['qty'] += $qty;
                    $this->update(md6($id),$itemDetail['qty'],$itemRowId,$qty);
                    $this->addItemTogether($id,$dataBuyTogether);
                    return;
                }
            }else{
                $data_return['log'] = 'Not found data';
            }
            
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }

    /**
     * [update description]
     * @param  integer $id  [description]
     * @param  integer $qty [description]
     * @return [type]       [description]
     */
    function update($id=0,$qty=1,$key='',$qtyAdded=0){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            if($this->SessionExcute('check')==false){
                $data_return['log'] = 'Spam';
                echo json_encode($data_return);
                return;
            }

            $qty = (float)$qty;
            $qty = $qty>0?($qty>50?50:$qty):1;
            //$id = md6_decode($id);
            //$itemRowId = $this->findItemByIdProduct($id,$cartList);
            $cartList = $this->cart->contents();
            if(isset($cartList[$key])){
                $product = $this->M_product->getDetailByField('tb.id',md6_decode($id),false);

                if ($qtyAdded != 0) {
                    $var = array(
                        'product' => $product,
                        'qty' => $qtyAdded,
                    );
                    $data_return['viewAlert'] = $this->load->view($this->_base_view_path . 'include/masterpage/addItemAlert', $var, true);
                }
                
                $itemDetail = $cartList[$key];
                $itemDetail['qty'] = $qty;
                $this->cart->update($itemDetail);
                $data_return['status'] = 'success';
                $data_return['info'] = $id;
                $this->SessionExcute('set');
            }else{
                $data_return['status'] = 'fail';
                $data_return['log'] = 'Not found item in cart';
            }
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }

    /**
     * [findItemByIdProduct description]
     * @param  integer $id        [description]
     * @param  [type]  &$cartList [description]
     * @return [type]             [description]
     */
    function findItemByIdProduct($id=0,&$cartList,$checkProductMain=false){
        $cartList = $this->cart->contents();
        if($cartList){
            $id = (int)$id;
            foreach($cartList as $key=>$item){
                if($item['idProduct']==$id && !isset($item['idProductMain'])){
                    return $key;
                }
            }
        }
        return null;
    }

    /**
     * [remove description]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    function remove($key=''){
        if(__IS_AJAX__ && $key){
            $data_return['status'] = 'fail';
            if($this->SessionExcute('check')==false){
                $data_return['log'] = 'Spam';
                echo json_encode($data_return);
                return;
            }
            
            //$itemRowId = $this->findItemByIdProduct($key,$cartList);
            $cartList = $this->cart->contents();
            if(isset($cartList[$key])){
                if(count($cartList)>1){
                    $itemDetail = $cartList[$key];
                    $itemDetail['qty'] = 0;
                    $this->cart->update($itemDetail);
                    $this->removeProTogether($cartList[$key]['idProduct'],$cartList);
                }else{
                    $this->cart->destroy();
                }

                // if ($this->cart->contents() != null) {
                //   $data_return['empty'] = false;
                // } else {
                //   $data_return['empty'] = true;
                // }
                
                $data_return['status'] = 'success';
                $data_return['info'] = $key;
                $this->SessionExcute('set');
            }else{
                $data_return['log'] = 'Not found item in cart';
            }
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }

    /**
     * [destory description]
     * @return [type] [description]
     */
    function destroy(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            if($this->SessionExcute('check')==false){
                $data_return['log'] = 'Spam';
                echo json_encode($data_return);
                return;
            }
            $this->cart->destroy();
            $data_return['status'] = 'success';
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }

    

    /**
     * [SessionExcute description]
     * @param string $type [description]
     */
    function SessionExcute($type="set"){
        if($type=="set"){
            $this->session->set_userdata('cartActionExcuted',time());
        }else if($type=="check"){
            $time = $this->session->userdata('cartActionExcuted');
            $time = (int)$time;
            $setTimeOut = 0;
            if($time!=null && $setTimeOut!=0){
                if((time()-$time) <= $setTimeOut){
                    return false;
                }
            }
            return true;
        }
    }
    
    function sentMail($idOrder=0,$type='admin'){
        $idOrder = md6_decode($idOrder);
        $data_return['status'] = 'fail';
        $detailOrder = $this->M_order->getDetailByField('tb.id',$idOrder,false);
        if($detailOrder!=null){
            if($type=='admin' && $detailOrder['is_sentmailAdmin']==1){
                $data_return['log'] = 'This order send mail before';
            }else{
                $data_return['status'] = 'success';
                $data['status_sentmail'] = $this->sentOrderToAdmin($idOrder,$detailOrder);
            }
        }else{
            $data_return['log'] = 'Not found order';
        }
        echo json_encode($data_return);
    }

    function sentOrderToAdmin($idOrder=0,$detailOrder=array()){
        $statusSentmail = false;
        $listProductOrder = $this->M_order->getOrderDetail($idOrder);
        $data = array(
            'detailOrder'=>$detailOrder,
            'listProductOrder'=>$listProductOrder
        );
        $mailContent = $this->load->view($this->_base_view_path.'include/mail/orderAdmin',$data,true);
        $mailTitle = $this->_template['seo_data']['site_name'].': Thông báo có đơn hàng mới';

        $where = array(
            'is_active'=>1,
            'is_delete'=>0
        );

        if($this->config->item('site_public')==FALSE){
            $where['id_role <='] = 2;
        }else{
            $where['id_role'] = 6;
        }


        $userList = $this->My_model->getlist('user',$where);
        $mailList = array();
        if($userList){
            foreach($userList as $user){
                $mailList[] = $user['email'];
            }
        }
        if($mailList){
            $mailList = implode($mailList,',');
            $sentMail = array('email'=>$mailList,
                              'subject'=>$mailTitle,
                              'data'=>array('message'=>$mailContent),
                              'form'=>'forgotpwd');
            $statusSentmail = $this->lazi_mailer->send($sentMail);
            if($statusSentmail==true){
                $dataUpdate['is_sentmailAdmin'] = 1;
                $this->db->flush_cache();
                $this->db->where('id',$idOrder);
                $this->db->update('order',$dataUpdate);
            }
        }
        
        return $statusSentmail;        
    }

    function sentOrderToCustomer(){

    }

    function addItemTogether($idProductMain,$dataTogether=array()){
        if($idProductMain && $dataTogether){
            foreach($dataTogether as $proId){
                $proId = md6_decode($proId);
                $proDetail = $this->M_product_buy_together->frontend_checkExistProrelative($idProductMain,$proId);
                if($proDetail){
                    $alias = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
                    $alias = base_url().$alias.$proDetail[$this->_lang.'alias'];
                    $cartList = $this->cart->contents();
                    $idCart = count($cartList)+1;
                    $cartItem = array(  
                        'id'=>$idCart,
                        'idProduct'=>$proDetail['id'],
                        'idProductMain'=>$idProductMain,
                        'qty'=>1,
                        'price'=>$proDetail['price_sale'],
                        'name'=>$proDetail[$this->_lang.'title'],
                        'options'=>array(
                            'promotion'=>$proDetail['promotion'],
                            'price'=>$proDetail['price'],
                            'image'=>$proDetail['image'],
                            'alias'=>$alias 
                        )
                    );

                    $this->cart->insert($cartItem);
                }
                
            }
            
        }
    }

    function addItemFree($idProductMain){
        if($idProductMain){            
            $proFreeList = $this->M_product_buy_together->frontend_getListByIdpro($idProductMain,true);
            if($proFreeList){
                $slug = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
                $cartList = $this->cart->contents();
                $idCart = count($cartList)+1;
                foreach($proFreeList as $item){
                    $alias = base_url().$slug.$item[$this->_lang.'alias'];
                    $cartItem = array(  
                        'id'=>$idCart,
                        'idProduct'=>$item['id'],
                        'idProductMain'=>$idProductMain
,                        'qty'=>1,
                        'price'=>1,
                        'name'=>$item[$this->_lang.'title'],
                        'options'=>array(
                            'promotion'=>$item['promotion'],
                            'price'=>$item['price'],
                            'image'=>$item['image'],
                            'alias'=>$alias 
                        )
                    );

                    $this->cart->insert($cartItem);
                    $idCart++;
                }
            }
        }
    }

    function removeProTogether($idProductMain=0,$cartList=array()){
        if($cartList){
            $n = count($cartList);
            foreach($cartList as $key=>$item){
                if(isset($item['idProductMain'])){
                    if($item['idProductMain']==$idProductMain){
                        $n--;
                        if($n>1){
                            $cartList[$key]['qty'] = 0;                        
                            $this->cart->update($cartList[$key]);  
                                             
                        }else{
                            $this->cart->destroy();
                        }
                    }
                }
            }
        }
    }

    function getTotalCart(){
        $cartList = $this->cart->contents();
        $total = 0;
        if($cartList){
            foreach ($cartList as $key=>$item) {
                if($item['price']>1){
                    $total += $item['price']*$item['qty'];
                }
            }
        }
        return round($total,-3);
    }

    function getTotalAmount($couponCodeId=null){
        $valuePromotion = 0;
        $totalAmount = $this->getTotalCart();
        if($couponCodeId){
            $couponId = md6_decode($couponCodeId);
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
                }else if($detailCoupon['type']=='gift'){
                    $detailCoupon['valueText'] = $detailCoupon[$this->_lang.'value'];
                }
                $data_return['info'] = $detailCoupon;
            }
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }
}
    
?>