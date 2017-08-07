<?php
class My_accessright{
    public $actions=array(
       // 'users'=>array(
//            'users/viewlist' =>'Xem DS',
//            'users/update'   =>'Cập nhật'
//        )//exp
        
    );
    public $is_superadmin=false;
    public $user_actions=array();
    
    var $_CI='';
    
    function __construct($config=array()){ 
        $this->_CI =& get_instance();
        //$this->actions=$this->_CI->load_table_role();
        
        $iduser=$config['iduser'];
        $_find=$this->_CI->My_model->getdetail_by_any('user',array('id'=>$iduser,'id_role'=>1));
        
        if($_find)
        {
            $this->is_superadmin=true;
        }

        $this->user_actions=$this->setUserAtion($iduser);
    }
    function index()
    {
        $this->isAllowAction();
    }
    function isAllowAction()
    {

        if($this->is_superadmin)
            return true;
            
        $current_action=CI_Router::$current_action?CI_Router::$current_action:'index';
        
        $action=CI_Router::$current_class.'/'.$current_action;
        //echo $action; exit;
        $publiccontrol=array('home','ajax','order_cart');
        if(in_array(CI_Router::$current_class,$publiccontrol))
            return true;
        foreach($this->user_actions as $key=>$item)
        {
            if($action==$item)
            {
                return true;
            }
        }  
        return false;
    }
    
    protected function setUserAtion($idUser){
        
        $this->_CI->load->model('M_user_role');
        
        return $this->_CI->M_user_role->getUserActions($idUser);
    }
}
?>