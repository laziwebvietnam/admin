<?php
/** 
 * @package   
 * @author lvtu.quicktips.vn
 * @copyright sushivn
 * @version 2013
 * @access public
 */
if ( ! defined('BASEPATH')) 
    exit('Access define.');
class Maccessright extends My_Model
{
    function __construct()
    {
       parent::__construct(); 
    }
    function getUserActions($idUser=0)
    {
        $sql="
        SELECT a.actions FROM `r_user_action` u
        INNER JOIN `r_group_action` a 
        ON a.`id`=u.`id_group_action`
        WHERE u.`id_user`='$idUser'
        ";
        $result=$this->sql_excutequery($sql);
        $actions='';
        foreach($result as $item)
        {
            $actions.=$item['actions'].',';
        }
        $actions=explode(',',$actions);
        return $actions;
    }
    function getUsers_by_groupAction($idGroup)
    {
        $sql="
        SELECT u.id,u.email,u.fullname
        FROM `r_user_action` g 
        INNER JOIN user u
        ON u.id=g.`id_user`
        WHERE g.`id_group_action`='$idGroup'
        ";
        return $this->sql_excutequery($sql);
    }
    function getActions_by_groupAction($idGroup)
    {
        $sql="
        SELECT actions
        FROM `r_group_action`
        WHERE id='$idGroup'
        ";
        $result=$this->sql_excutequery($sql);
        $actions='';
        foreach($result as $item)
        {
            $actions.=$item['actions'].',';
        }
        $actions=explode(',',$actions);
        return $actions;
    }
    function delete_user($where){
        $this->db->delete('r_user_action',$where);
    }
    function deletegroup($id){
        $this->db->delete('r_user_action',array('id_group_action'=>$id));
        $this->db->flush_cache();
        $this->db->delete('r_group_action',array('id'=>$id));
    }
}
?>