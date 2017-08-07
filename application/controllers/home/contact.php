<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class contact extends Public_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_contact');
        $this->load->model('M_category');
    }

    function index(){
        $this->set_seodata();
        $this->load_view('contact/demo/index');
    }

    function action(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('fullname','email','phone','address','title','content');
            $rules['valid_email'] = array('email');
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $data_return['info'] = $this->actionSuccess();
                $data_return['status'] = 'success';
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function actionSuccess(){

        $dataCustomer = $this->postvalue(array('fullname','email','phone','address','form'));
        
        $contactData = $this->postvalue(array('title','content'));
        $contactData['id_customer'] = $this->findCustomer($dataCustomer);
        $contactData['time'] = time();
        $idcontact = $this->My_model->insert('contact',$contactData);

        $data_return['customer'] = $dataCustomer;
        $data_return['contact'] = $contactData;
        $data_return['alert'] = isset($this->_template['config_website'][$this->_lang.'contact_alert_success'])?$this->_template['config_website'][$this->_lang.'contact_alert_success']:'';
        $data_return['idContact'] = md6($idcontact);
        
        return $data_return;
    }

    function sentMail($idContact=0){
        if(__IS_AJAX__){
            $idContact = md6_decode($idContact);
            $data_return['status'] = 'fail';
            $detailContact = $this->M_contact->getDetailByField('tb.id',$idContact);
            if($detailContact!=null){
                if($detailContact['is_sentmailAdmin']==1){
                    $data_return['log'] = 'This order send mail before';
                }else{
                    $data_return['status'] = 'success';
                    $data['status_sentmail'] = $this->sentContactToAdmin($detailContact);
                }
            }else{
                $data_return['log'] = 'Not found order';
            }
            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }

    function sentContactToAdmin($contactDetail=array()){
        $data = array(
            'detailContact'=>$contactDetail
        );
        $statusSentmail = false;
        $mailContent = $this->load->view($this->_base_view_path.'include/mail/contactAdmin',$data,true);
        $mailTitle = $this->_template['seo_data']['site_name'].': Thông báo có liên hệ mới';
        if($contactDetail['title']){
            $mailTitle  = $this->_template['seo_data']['site_name'].' - ';
            if($contactDetail['cus_fullname']){
                $mailTitle .= $contactDetail['cus_fullname'];
            }else if($contactDetail['cus_phone']){
                $mailTitle .= $contactDetail['cus_phone'];
            }else if($contactDetail['cus_email']){
                $mailTitle .= $contactDetail['cus_email'];
            }
            $mailTitle.= ': "'.$contactDetail['title'].'"';
        }
        $where = array(
            'is_active'=>1,
            'is_delete'=>0,
            'id_role >'=>2
        );
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
                $this->db->where('id',$contactDetail['id']);
                $this->db->update('contact',$dataUpdate);
            }
        }
        
        return $statusSentmail;    
    }
}
?>