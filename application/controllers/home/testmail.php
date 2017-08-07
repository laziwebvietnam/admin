<?php
/** 
 * @package   
 * @author hotienloc.92@gmail.com
 * @version 2015
 * @access public
 */
if ( ! defined('BASEPATH')) 
    exit('Access define.');
class testmail extends Public_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('lazi_mailer');
    }
    function index()
    {
        $data=array(
           'email'      =>'matthewbui171193@gmail.com',
           'subject'    =>'Test mail123',
           'data'       =>array('message'=>'TEst mail'),
           'form'       =>'testmail'
         );

        $this->lazi_mailer->send($data);
    }
    
    //function index(){
//        $mail=$this->config->item('mail');
//         $config = array(
//                'protocol' => 'smtp',
//                'useragent'=>'quicktips.vn',
//                'mailtype'  =>'html',
//                'charset'   => 'utf-8',
//                'smtp_host' => $mail['smtp_host'],
//                'smtp_port' => $mail['smtp_port'],
//                'smtp_user' => $mail['smtp_user'],
//                'smtp_pass' => $mail['smtp_pass']
//        );
//        
//        $this->load->library('email');
//        //$this->load->model('Mconfig');
//        $this->email->initialize($config);
//        $this->email->set_newline("\r\n");
//        $time=date('H:i:s d/m/Y');
//        $this->email->from($mail['mail_send'], 'test TS\'s--support');
//        $this->email->to($mail['mail_receive']);    
//        $this->email->subject('Thông báo: có thư liên hệ từ khách hàng'.'--'.$time);
//        $this->email->message('test');
//        $this->email->send();
//        $this->email->print_debugger();
//    }
}
?>