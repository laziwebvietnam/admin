<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class My_controller extends CI_Controller{
    var $data = array(); /** data user */
    function __construct()
    {
        parent::__construct();                                                     
        $this->My_model=new My_Model();
        $this->_template=$this->config->item('template');
        $this->load->helper(array('language','noneunicode','lazi_md6'));
        $this->load->library('session');
        $this->load->library('lazi_mailer');
        
        $this->load->model('M_contact');
        $this->set_language();
    }
    
     
    /**
     * @param  string : view name
     * @param  array : data array
     * @param  boolean : check return to <!DOCTYPE html>
     <html>
     <head>
         <title></title>
     </head>
     <body>
     
     </body>
     </html>
     * @param  boolean : 
     * @param  boolean : check load view message (error) or not
     * @return [type]
     */
    function load_view($viewname='',$data=array(),$isReturn=false,$is_component=false,$is_loadMessage=false)
    {

        if(isset($this->_checkRole)){
            if($this->_checkRole==false && $is_loadMessage==false) {
                if(__IS_AJAX__){
                    $data_return['checkRole'] = false;
                    echo json_encode($data_return);
                }else{
                    $this->load_message('403');
                }            
                return;
            }
        }
        
        
        if(!$is_component){            
            if(isset($this->_base_view_path_sub)&&$this->_base_view_path_sub)
            {
                $viewname=$this->_base_view_path.$this->_base_view_path_sub.'/'.$viewname;
            }
            else
            {
                $viewname=$this->_base_view_path.$viewname;
            }
        }
        else
        {
            $viewname='COMPONENT/'.$viewname.'/'.$viewname.'_template';
        }
        $main_data['page'] = $this->load_default_data();
        $main_data['content'] = array('view'=>$viewname,
                                      'data'=>$data);
        /**
        * 
        * Trường hợp là Ajax
        * 
        * */
        if(__IS_AJAX__)
        {
            if($isReturn==true){
                return $this->load->view($viewname,array('data'=>$data),true);
            }
            $this->load->view($viewname,$main_data);
        }
        
        if($isReturn==true){
            return $this->load->view($this->_base_view_path.'template',$main_data,true);
        }
        if($viewname!='frontend/include/error/404' && !isset($this->_adminPage)){
            $this->countViews();
        }
        $this->load->view($this->_base_view_path.'template',$main_data);

    }
    
    function postvalue($fieldname=array(),$ignore=false,$stripTags=true)
    {
        if(!is_array($fieldname))
        {
            $fieldname=explode(',',$fieldname);
        }
        $data=array();
        if($ignore==false){
            foreach($fieldname as $f)
            {
                $data[$f]=$stripTags==false?$this->input->post($f):strip_tags($this->input->post($f));
            }
        }else{
            $data = $_POST;
            foreach($fieldname as $f){
                if(isset($data[$f])){
                    unset($data[$f]);
                }
            }
        }
        
        return $data;
    }
    public function load_message($type='404',$data=array(),$isPopup=true)
    {
        if(__IS_AJAX__){
            if($isPopup==true){
                return $this->load_view('view/include/error/'.$type,null,true,false,true);
            }
        }
        $this->load_view('view/include/error/'.$type,null,false,false,true);
    }

    /**
     * set language
     * set $this->_lang (null or en_)
     */
    function set_language()
    {
        $langs=$this->config->item('allow_langs');
        if(!($lang=$this->uri->segment(1))||!in_array($lang,$langs))        
        {
            if(!($lang=$this->session->userdata('language'))||!in_array($lang,$langs))
            {
                $lang=$this->config->item('language');
            }
        }
        $this->session->set_userdata('language',$lang);
        $this->_config['current_language']=$lang;
        if($lang=='en')
        {
            $this->_lang='en_';
            $this->_config['current_language']='en_';
            $lang='english';
        }
        else
        {
            $this->_config['current_language']='';
            $this->_lang='';
        }
        //$this->load->library('language');
        $this->config->set_item('language',$lang);
        $this->lang->load('default');
        $this->load->helper('language');
    }
}
?>