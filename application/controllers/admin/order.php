<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Order extends admin_basic_controller
{
    var $_table = 'order';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;
        parent::__construct();
        /** Config */
        $this->data_view['btnCreate'] = false;
        /** Load model */
        $this->load->model('M_order');
        $this->lang->load('admin_order');  
    }
    
    function index($view='index'){
        $this->_index($view);
    }
    
    function inbox(){
        $variable['tb.is_active'] = 0;
        $this->_index('index',$variable);
    }
    function confirmed(){
        $variable['tb.is_active'] = 1;
        $this->_index('index',$variable);
    }
    
    function nopayment(){
        $variable['tb.is_active'] = 2;
        $this->_index('index',$variable);
    }
    
    function noship(){
        $variable['tb.is_active'] = 3;
        $this->_index('index',$variable);
    }
    
    function finish(){
        $variable['tb.is_active'] = 4;
        $this->_index('index',$variable);
    }
    
    function returns(){
        $variable['tb.is_active'] = 5;
        $this->_index('index',$variable);
    }
    
    function cancel(){
        $variable['tb.is_active'] = 6;
        $this->_index('index',$variable);
    }
    
    function edit($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('edit',$data);
    } 
    
    function search(){
        $this->_index('search');
    }
    
    function _index($view='index',$variable=array()){
        /** default */
        #title page
        $this->data_view['pageTitle'] = $this->_table.'/'.$view;
        $this->load_breadcrumb($this->_table.'/'.$view); 
        $data['view'] = $this->data_view['pageTitle']; 
        /** end default */
        
        if($view=='index'){
            $data = array(
                'list'=>$this->listPage_data($view,$variable),
                'result'=>$this->countInfoOrder($variable)
            );   
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_order->detail_Backend($variable['id']),
                'list_product'=>$this->M_order->getListProByIdOrder_Backend($variable['id'])
            );  
            if($data['detail']==null){
                $this->load_message();
                return;
            }
            $view = 'create';
        }else if($view=='search'){
            $data = array(
                'list'=>$this->listPage_data($view,$variable)
            ); 
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function listPage_data($type='list',$variable=array()){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array('tb.is_delete'=>0);
        $where = array_merge($where,$variable);
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
        $total_row = $this->M_order->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_order->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }
    
    /** note something for view list Datatable  */
    function listPage_otherInfo(){
        $this->data_view['dataTable']['otherInfo']['status'] = array(
            'is_active'=>array(
                '0'=>'label label-sm label-warning',
                '1'=>'label label-sm label-warning',
                '2'=>'label label-sm label-danger',
                '3'=>'label label-sm label-danger',
                '4'=>'label label-sm label-success',
                '5'=>'label label-sm label-default',
                '6'=>'label label-sm label-default'
            )
        );
    }
    
    /** thead & column show/hide */
    function listPage_tableField(){
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'cus_fullname','title'=>'Tên','linkDetail'=>true),
            array('name'=>'cus_phone','title'=>'Điện thoại','linkDetail'=>true),
            array('name'=>'cus_email','title'=>'Email','linkDetail'=>true),
            array('name'=>'total_amount_sale','title'=>'Tổng tiền','type'=>'number','linkDetail'=>true),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    /** quickAction when select id */
    function listPage_quickAction(){
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Mới','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Đã xác nhận','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/2','title'=>'Chưa thanh toán','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/3','title'=>'Đã thanh toán chưa gửi hàng','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/4','title'=>'Hoàn tất','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/5','title'=>'Bị hoàn trả','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/6','title'=>'Bị hủy','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true)
        );
        
    }
    
    /** array all field */
    public function set_field_for_ajax_search()
    {
        /** type: text, select, tag, checked */
        $array = array(
            array('type'=>'text','name'=>'fullname','field_search'=>'c.fullname'),   
            array('type'=>'text','name'=>'phone','field_search'=>'c.phone'),   
            array('type'=>'text','name'=>'address','field_search'=>'c.address'),   
            array('type'=>'time','name'=>'dayTo','field_search'=>'tb.time >='),   
            array('type'=>'time','name'=>'dayEnd','field_search'=>'tb.time <='),   
            array('type'=>'number','name'=>'min_price','field_search'=>'total_amount_sale >='),   
            array('type'=>'number','name'=>'max_price','field_search'=>'total_amount_sale <='),
            array('type'=>'checked','name'=>'is_active','field_search'=>'tb.is_active')
        );
        
        return $array;
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
                              
                /* $this->insert(data,$seo_status=false/true,$tag_status=false/true,$type='') */
                $data_id = $this->insert($data,true,false,$type);
                
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
            array('note_admin');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
    
    function countInfoOrder($where=array()){
        $where['tb.is_delete'] = 0;
        $result = $this->M_order->getTotalOrderInfo($where);
        if($result!=null){
            $result['total_average'] = $result['total_order']!=0?$result['total_amount']/$result['total_order']:0;
            $result['total_amount'] = round($result['total_amount']);
            $result['total_average'] = round($result['total_average']);
        }
        return $result;
    }

    function printBill($md6_id)
    {
        if(__IS_AJAX__){
            $data_return = array();
            if($this->_checkRole==true){
                $this->listPage_tableField();
                $data = array(
                    'detail'=>$this->M_order->detail_Backend(md6_decode($md6_id)),
                    'list_product'=>$this->M_order->getListProByIdOrder_Backend(md6_decode($md6_id))
                );

                $data_return['html'] = $this->load_view('view/order/printBill',$data,true);
                echo json_encode($data_return);
            }else{
                $data_return['checkRole'] = false;
                echo json_encode($data_return);
            }    
        }else{
            $this->load_message('404'); 
        }                              
    }
}
?>