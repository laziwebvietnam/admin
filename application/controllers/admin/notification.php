<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Notification extends admin_basic_controller
{
    var $_table = 'notification';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;  
        parent::__construct();
        /** Config */   
        $this->data_view['btnCreate'] = false;
        
        /** Load model */
        $this->load->model('M_notification');
        $this->lang->load('admin_notification');  
    }
    
    function index($view='index'){      
        $this->_index($view);
        
    }
    function search(){ 
        $this->_index('search');
    }
    
    function edit($id=0){
        $this->load_message('404');
    }

    function create(){
        $this->load_message('404');
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
                'list'=>$this->listPage_data()
            );   
        }else if($view=='search'){
            $data = array(
                'list'=>$this->listPage_data('search'),
                'user'=>$this->My_model->getlist('user',array(),0,999,'id asc'),
                'customer'=>$this->My_model->getlist('customer',array(),0,999,'id asc'),
                'type'=>array(
                    array('title'=>lang('notification_admin'),'id'=>'admin'),
                    array('title'=>lang('notification_user'),'id'=>'user'),
                )
            );  
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function listPage_data($type='list'){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array();
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
        $total_row = $this->M_notification->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_notification->get_all($where,$start,$limit,$order_by);
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
            array('name'=>'user_fullname','title'=>'Tên'),
            array('name'=>'alert','title'=>'Thao tác'),
            array('name'=>'time','title'=>'Thời gian'),
            array('name'=>'type','title'=>'Loại'),
        );
    }
    
    /** quickAction when select id */
    function listPage_quickAction(){
        $this->data_view['dataTable']['quickAction'] = array(
        );
        
    }
    
    /** array all field */
    public function set_field_for_ajax_search()
    {
        /** type: text, select, tag, checked */
        $array = array(
            array('type'=>'select','name'=>'id_user','field_search'=>'tb.id_user'),   
            array('type'=>'select','name'=>'id_customer','field_search'=>'id_customer'),   
            array('type'=>'time','name'=>'dayTo','field_search'=>'tb.time >='),   
            array('type'=>'time','name'=>'dayEnd','field_search'=>'tb.time <='),
            array('type'=>'select','name'=>'type','field_search'=>'tb.type')  
        );
        
        return $array;
    }
    
    /** ACTION */
    function set_validation($return_bool=false){
        if($_POST){
            $rules = $this->set_rules();
            print_r($rules);exit;
            $this->form_validation->set_rules($rules);            
            $error = array();
            if($this->form_validation->run()==false){
    			foreach($rules as $row){
    				if(form_error($row['field']))
    				{
    					$error[$row['field']] = array(
                            'rules'=>$row['rules'],
                            'alert'=>form_error($row['field'],' ',' ')
                        );
    				}
    			}
            }else{
                if($return_bool==true){
                    return true;
                }
            }
            /** when not ajax */
            echo json_encode($error);
        }
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
                $data['time_update'] = time();
                $data['id_user_update'] = $this->data['user']['id'];
                $data['images'] = isset($data['images'])?(is_array($data['images'])==true?$data['images']:array($data['images'])):array();
                $data['images'] = implode($data['images'],'||');
                /** end set default value */
                       
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
            array('title','alias','desc','content','image','images',
                  'en_title','en_alias','en_desc','en_content');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
}
?>