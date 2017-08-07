<?php
class lazi_mailer{
    var $CI='';
    var $eConfig=array();
    var $_data=array(
           'email'      =>'',
           'subject'    =>'',
           'contents'       =>'',
           'form'       =>''
         );
    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
        $this->CI->_config['is_mail_editor']=false;
    }
    /**
     * 
     * $data=array(
     *  'email'=>'',
     *  'subject'=>'',
     *  'contents'=>'',
     *  'form'=>''
     * );
     * 
     * **/
    function send($data=array(),$html='')
    {
        $configs=$this->CI->config->item('mail');
        if(!$html)
            $html=$this->get_data_content($data);
        //return;
        $configs['protocol'] = 'smtp';
        $configs['charset']   = 'utf-8';
        
        $this->CI->load->library('email',$configs);
        $this->CI->email=new CI_Email();
        $this->CI->email->initialize($configs);
        
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->set_mailtype('html');
        
        $time=date('H:i:s d/m/Y');
        $this->CI->email->from($configs['mail_send'],$configs['mail_receive'] );
        $this->CI->email->to($data['email']);
        $this->CI->email->subject($data['subject']);
        $this->CI->email->message($html);
        if(!$this->CI->email->send())
            //return false;
        echo $this->CI->email->print_debugger();
        return true;
    }
    protected function get_data_content($data)
    {
        return $this->CI->load->view('MAILS/template',$data,true);
    }
    function edit_mail($form_mail,$data)
    {
        $this->CI->load_view('mailbox',array('data'=>$data));
    }
}
?>