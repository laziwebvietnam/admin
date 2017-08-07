<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email {
    var $CI='';
    var $eConfig=array();
    var $_data=array(
           'email'      =>'',
           'subject'    =>'',
           'contents'       =>'',
           'form'       =>''
         );
     var $_mail;
     
     function __construct(){
        $CI =& get_instance(); 
       // $this->CI->load->library('email');
        $this->CI->_config['is_mail_editor']=false;
     }
     
     function config($data){
        $this->_mail=array(
                            "from_sender"       => "saigon21.com@gmail.com",
                            "name_sender"       => "MMC-2.0",
                            "subject_sender"    => "Active acount Manager Member with CodeIgniter 2.0",
                         );

        
        $this->_mail['to_receiver'] = $data['to_receiver'];               
        $this->_mail['message'] = $data['message'];
     }
     
     function sendmail(){
        
            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'ssl://smtp.gmail.com';
            $config['smtp_port']    = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user']    = '...'; // địa chỉ gmail
            $config['smtp_pass']    = '...'; // pass gmail
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not      
            $this->initialize($config);
        
        
            $this->from($this->_mail['from_sender'], $this->_mail['name_sender']);
            $this->to($this->_mail['to_receiver']); 
        
            $this->subject($this->_mail['subject_sender']);
            $this->message($this->_mail['message']);
        
            $this->send();
     }
}
