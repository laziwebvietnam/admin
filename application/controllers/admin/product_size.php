<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Product_size extends admin_basic_controller
{
    var $_table = 'product_size';
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

    /** load thead on table */
    function listPage_tableField(){
        /**
         * name: field on query
         * title: text for show on thead
         * type: type of text
         *     image: show image with <img />
         *     number: show with number_format
         *     status: show with true / false
         * linkDetail: (true/false)
         *     true: show a link detail with: table/edit/{id}
         *     false: not show link 
         * hidden: (true/false)
         *     true: hidden
         *     false or null: for show
         */
            
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'title','title'=>'Tên','linkDetail'=>true),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
}
?>