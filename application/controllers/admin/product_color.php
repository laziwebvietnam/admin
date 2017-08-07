<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Product_color extends admin_basic_controller
{
    var $_table = 'product_color';
    public function __construct()
    {
        parent::__construct();     
        $this->_createSeoData = true;
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','en_title');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
}
?>