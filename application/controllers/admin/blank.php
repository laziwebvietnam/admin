<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Blank extends admin_basic_controller
{
    var $_table = 'blank';
    public function __construct()
    {
        parent::__construct();     
        $this->_createSeoData = true;
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','alias','desc','content','image','images','en_title','en_alias','en_desc','en_content');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
}
?>