<?php
/**
 * model user library 
 * gom cac chuc nang:
 * 1. lay thong tin user
 * 2. xac dinh nhom quyen user
 * 
 */
 /**
  * Muser_lib
  * 
  * @package   
  * @author lvtu.quicktips.vn
  * @copyright quicktips.vn
  * @version 2013
  * @access public
  */
 class Muser_lib extends CI_Model{
    /**
     * Muser_lib::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * lay thong tin cua user
     */
    /**
     * Muser_lib::get_UserInfor_by_id()
     * 
     * @param string $id
     * @return
     */
    public function get_UserInfor_by_id($id='')
    {
        if(!is_numeric($id)||$id<1)
            return $this->_create();
        $query=$this->db->get_where('user',array('id'=>$id));
        if($query->num_rows()==0)
        {
            return $this->_create();
        }        
        return $query->row_array();
    }
    /**
     * Muser_lib::check_Login()
     * 
     * @param mixed $user
     * @param mixed $pass
     * @return
     */
    public function check_Login($user,$pass){
        //$this->newadmin();
        
        //echo $user.'<br>'.$pass; exit;
        $pass=md5($pass);
        //$this->db->query("update `users` set `password_admin`='$pass' where `email`='$user' ");
        $rs=$this->db->query("select * from `users` where `email`='$user' and `password_admin`='$pass'");
        if($rs->num_rows()===1)
        {
            return $rs->first_row('array');           
        }
        return false;
    }
    /**
     * Muser_lib::check_old_pass()
     * 
     * @param integer $id
     * @param mixed $old
     * @return
     */
    function check_old_pass($id=0,$old)
    {
        $old=md5($old);
        $query=$this->db->get_where('users',array('id'=>$id,'password_admin'=>$old));
        if($query->num_rows()==0)
            return false;
        return $query->first_row('array');
    }
    /**
     * Muser_lib::changepassword()
     * 
     * @param mixed $id
     * @param mixed $pass
     * @return
     */
    function changepassword($id,$pass){
        $pass=md5($pass);        
        $this->db->update('users',array('password_admin'=>$pass),array('id'=>$id));
        return true;
    }
    /**
     * Muser_lib::newadmin()
     * 
     * @param mixed $data
     * @return
     */
    function newadmin($data=array())
    {
        $data=array(
            'email'=>'quicktips.vn',
            'password_admin'=>md5('baohoai!@'),
            'password'=>md5('baohoai!@')
        );
        $this->db->insert('users',$data);
    }
    /**
     * Muser_lib::_create()
     * 
     * @return
     */
    protected function _create(){
        $data=array(
                'id'=>0,
                'name'=>'',
                'email'=>''
                );
        return $data;
    }
 }
?>