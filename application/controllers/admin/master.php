<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Master extends admin_action_controller
{
    public function __construct()
    {
        parent::__construct();  
    }
    
    function loadNewContact(){
        if(__IS_AJAX__){
            $data_return = array();
            $where = array(
                'tb.is_read'=>0,
                'tb.is_delete'=>0
            );
            $data['list'] = $this->M_contact->get_all($where,0,10);
            $data_return['html'] = $this->load->view($this->_base_view_path.'master/include/top/ajaxContact',$data,true);
            $data_return['total'] = count($data['list']);
            echo json_encode($data_return);
        }
    }
    
/** ACTION USER */
    
    
/** END ACTION USER */
}
?>