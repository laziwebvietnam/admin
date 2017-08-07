<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Customer extends admin_basic_controller
{
    var $_table = 'customer';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = 'fullname';
        parent::__construct();
        $this->data_view['formname'] = array(array('id'=>'contact','title'=>'Form liên hệ'),
                                             array('id'=>'subscrible','title'=>'Form nhận bản tin'),
                                             array('id'=>'order','title'=>'Form đặt hàng'));
        $this->load->model('M_customer');

    }

    function search(){
        $this->index('search');
    }

    /** get list data of table */
    function listPage_data($type='list'){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array('tb.is_delete'=>0);
        $where = $this->get_where($where);
    
        /** Set limit */
        $limit = $this->data_view['dataTable']['limit_val'];
        if($this->session->userdata($this->_table.'_limit')!=null){
            $limit = $this->session->userdata($this->_table.'_limit');
            $limit = (int)$limit;
        }
        /** Set order by */
        $session_sort = $this->getSortbyDatatable();
        $order_by = $session_sort['name'].' '.$session_sort['status'];
        $baseUrl = current_url();
        $total_row = $this->M_customer->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_customer->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }
    
    /** thead & column show/hide */
    function listPage_tableField(){
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'fullname','title'=>'Tên','linkDetail'=>true),
            array('name'=>'email','title'=>'Email','linkDetail'=>true),
            array('name'=>'phone','title'=>'Số điện thoại'),
            array('name'=>'address','title'=>'Địa chỉ','hidden'=>true),
            array('name'=>'time','title'=>'Thời gian đăng ký','type'=>'time'),
            array('name'=>'form','title'=>'Từ nguồn'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    /** type: null or save draft*/
    function action($type=''){
        if($_POST){
            $data_return['status'] = 'fail';
            $check_validation = $this->set_validation(true);
            if($check_validation==false){
                $data_return['info'] = 'validation fail';
            }else{
                $type_action = $_POST['type_action'];
                unset($_POST['type_action'],$_POST['set_alias']);
                $data = $_POST;
                
                /** set default value */
                $image_default = '../template/backend/assets/pages/media/users/avatar80_1.jpg';
                $data['image'] = isset($data['image'])?($data['image']!=''?$data['image']:$image_default):$image_default;
                /** end set default value */
                                
                if($type_action=='create'){
                    /** Code when create here */
                }else if($type_action=='edit'){
                    /** Code when edit here */           
                }
                /* $this->insert(data,$seo_status=false/true,$tag_status=false/true,$type='') */
                $data_id = $this->insert($data,false,false,$type);
                
                if($data_id>0){
                    $data_return['status'] = 'success';
                    $data_return['id_insert'] = $data_id;    
                }
            }
            echo json_encode($data_return);
        }
    }
    
    function set_rules(){
        $rules['required'] = 
            array('fullname','phone','email');
        $rules['valid_email'] = 
            array('email');
        $rules['callback_check_unique[email]'] = 
            array('email');
        $rules['callback_check_unique[phone]'] = 
            array('phone');
            
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */

    /** set all field for search */
    public function set_field_for_ajax_search()
    {
        /**
         * type: type of field
         *     text
         *     number
         *     select: use for selectbox - RETURN value selected
         *     checked: use for checkbox - RETURN variable
         *     tag: return array
         *     time: return (int)
         * name: name of field
         * field_search: field get where on sql
         */
        
        $array = array(
            array('type'=>'text','name'=>'fullname','field_search'=>'tb.fullname'), 
            array('type'=>'text','name'=>'email','field_search'=>'tb.email'),
            array('type'=>'text','name'=>'phone','field_search'=>'tb.phone'),
            array('type'=>'text','name'=>'address','field_search'=>'tb.address'),               
            array('type'=>'select','name'=>'form','field_search'=>'tb.form'),
            array('type'=>'time','name'=>'dayTo','field_search'=>'tb.time >='),   
            array('type'=>'time','name'=>'dayEnd','field_search'=>'tb.time <='),  
            array('type'=>'checked','name'=>'is_active','field_search'=>'tb.is_active')
        );
        
        return $array;
    }
}
?>