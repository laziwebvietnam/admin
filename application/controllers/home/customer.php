<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class customer extends Public_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_customer');
    }
    

    function formSubscrible(){
        $this->set_seodata();
        $this->load_view('customer/demo/formSubscrible');
    }

    function actionFormSubscribe(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('email','form');
            $rules['valid_email'] = array('email');
            $rules['callback_check_unique[email]'] = array('email');
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $dataCustomer = $this->postvalue(array('email','form'));
                $data_return['info']['id_customer'] = $this->findCustomer($dataCustomer);

                $data_return['alert'] = 'Đăng ký thành công!';
                $data_return['status'] = 'success';
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function getCustomerByMail(){
        if(__IS_AJAX__ && isset($_POST['email'])){
            $data_return['status'] = 'fail';
            $email = trim($_POST['email']);
            $findCustomer = $this->M_customer->getInfoForSuggest('email',$email);
            if($findCustomer != null){
                $data_return['status'] = 'success';
                $data_return['info'] = $findCustomer;
            }
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }
}
?>