<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Slide extends admin_basic_controller
{
    var $_table = 'slide';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;
        parent::__construct();     
        $this->data_view['dataCreate']['alias'] = false;
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','image','en_title');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
}
?>