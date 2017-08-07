<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Coupon extends admin_basic_controller
{
    var $_table = 'coupon';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = 'code';
        parent::__construct();     
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','code','value','type');
        $rules['is_numeric'] = 
            array('value');
        $rules['callback_check_unique[code]'] = 
            array('code');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */

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
            array('name'=>'code','title'=>'Mã code','linkDetail'=>true),
            array('name'=>'title','title'=>'Tên chương trình','linkDetail'=>true),
            array('name'=>'type','title'=>'Loại'),
            array('name'=>'value','title'=>'Giá trị'),
            array('name'=>'time_start','title'=>'Ngày áp dụng','type'=>'time'),
            array('name'=>'time_end','title'=>'Ngày hết hạn','type'=>'time'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }

    /** form submit action: create, edit */
    function action($type=''){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $check_validation = $this->set_validation(true);
                if($check_validation==false){
                    $data_return['info'] = 'validation fail';
                }else{
                    $type_action = $_POST['type_action'];
                    unset($_POST['type_action'],$_POST['set_alias']);
                     $data = $_POST;
                    /**
                     * set default value
                     * example: $data['images'] = implode($data['images'],'||');
                     */
                    $data['time_start'] = strtotime($data['time_start']);
                    $data['time_end'] = strtotime($data['time_end']);

                    /** end set default value */

                    if($type_action=='create'){
                        /** Code when create here */
                    }else if($type_action=='edit'){
                        /** Code when edit here */           
                    }
                   
                    /**
                        Function for insert to table
                            Variable #1: array data
                            Variable #2: seo data, true/false
                            Variable #3: tag data, true/false
                            Variable #4: type: preview, savedraft, default
                    */
                    $data_id = $this->insert($data,$this->_createSeoData,$this->_createTagData,$type);
                    
                    if($data_id > 0){
                        $data_return['status'] = 'success';
                        $data_return['id_insert'] = $data_id;    
                    }
                }
                echo json_encode($data_return);
            }
        }else{
           $this->load_message('404');
        }
    }
}
?>