<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Comment extends admin_basic_controller
{
    var $_table = 'comment';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;
        parent::__construct();
        $this->data_view['btnCreate'] = false;
        /** Config */
        /** Load model */
        $this->load->model('M_comment');
    }
    
    function index($view='index'){
        $this->_index($view);
    }
    
    function inbox()
    {
        $variable['tb.is_reply <>'] = 1;
        $variable['tb.is_delete'] = 0;
        $this->_index('index',$variable);
    }
    
    function noreply(){
        $variable['tb.is_reply'] = 0;
        $variable['tb.is_delete'] = 0;
        $this->_index('index',$variable);
    } 
    
    function product(){
        $variable['tb.data_table'] = 'product';
        $variable['tb.is_delete'] = 0;
        $this->_index('index',$variable);
    }
    
    function article(){
        $variable['tb.data_table'] = 'article';
        $variable['tb.is_delete'] = 0;
        $this->_index('index',$variable);
    }
    
    function delete()
    {
        $variable['tb.is_delete'] = 1;
        $this->_index('index',$variable);
    }
    
    function reply()
    {
        $variable['tb.is_reply'] = 1;
        $this->_index('index',$variable);
    }
    function create(){
        $this->load_message('404');
        return;
        $this->_index('create');
    } 
    function search(){
        $this->load_message('404');
        $this->index('search');
    }  
    
    function detail($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('detail',$data);
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
                'count'=>$this->loadCountDefault()
            );   
        }else if($view=='detail'){
            $data = array(
                'detail'=>$this->M_comment->detail_Backend($variable['id'],$idParent),
                'parent'=>$this->M_comment->detail_Backend($idParent),
                'child'=>$this->M_comment->getListByIdParent($idParent)
            );

            if($data['detail']==null){
                $this->load_message();
                return;
            }
        }

        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function listPage_data($type='list',$variable=array()){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array();
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
        $total_row = $this->M_comment->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_comment->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }
    
    /** load count comment default */
    function loadCountDefault(){
        $data_return = array();
        
        
        $where = array(
            'inbox'=>array('tb.is_reply <>'=>1,'tb.is_delete'=>0),
            'noreply'=>array('tb.is_reply'=>0,'tb.is_delete'=>0),
            'delete'=>array('tb.is_delete'=>1),
            'reply'=>array('tb.is_reply'=>1,'tb.is_delete'=>0)
        );
        
        $data_return = array(
            'inbox'=>$this->M_comment->get_all($where['inbox'],0,999,'id desc',true),
            'noreply'=>$this->M_comment->get_all($where['noreply'],0,999,'id desc',true),
            'delete'=>$this->M_comment->get_all($where['delete'],0,999,'id desc',true),
            'reply'=>$this->M_comment->get_all($where['reply'],0,999,'id desc',true)
        );
        
        return $data_return;
    }
    
    /** note something for view list Datatable  */
    function listPage_otherInfo(){
        $this->data_view['dataTable']['otherInfo']['status'] = array(
            'is_active'=>array(
                '0'=>'label label-sm label-warning',
                '1'=>'label label-sm label-success'
            ),
            'is_read'=>array(
                '0'=>'label label-sm label-warning',
                '1'=>'label label-sm label-success'
            ),
            'is_spam'=>array(
                '0'=>'label label-sm label-default',
                '1'=>'label label-sm label-danger'
            ),
            'is_reply'=>array(
                '0'=>'label label-sm label-warning',
                '1'=>'label label-sm label-success'
            ),
            'is_delete'=>array(
                '0'=>'label label-sm label-default',
                '1'=>'label label-sm label-danger'
            )
        );
    }
    
    /** thead & column show/hide */
    function listPage_tableField(){
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'cus_fullname','title'=>'Tên','linkDetail'=>true),
            array('name'=>'cus_email','title'=>'Email','hidden'=>true),
            array('name'=>'cus_phone','title'=>'Phone','hidden'=>true),
            array('name'=>'content','title'=>'Nội dung','type'=>'desc','linkDetail'=>true),
            array('name'=>'time','title'=>'Thời gian','hidden'=>true),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    /** quickAction when select id */
    function listPage_quickAction(){
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_read/1','title'=>'Đã đọc','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Ẩn','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Hiện','popup'=>false),
            #array('action'=>$this->_table.'/set_status/is_spam/0','title'=>'Không Spam','popup'=>false),
            #array('action'=>$this->_table.'/set_status/is_spam/1','title'=>'Spam','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_reply/0','title'=>'Chưa phản hồi','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_reply/1','title'=>'Đã phản hồi','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true)
        );
    }
    
    function action_reply(){
        if($_POST){
            $data_return['status'] = 'fail';
            /**
             * $rules['required'] : set rule
             * $this->rules_array($rules) : return array rule for validation
             * $this->set_validation() : check validation 
             */
            $rules['required'] = array('content');

            $rules_result = $this->rules_array($rules);
            $check_validation = $this->set_validation(false,$rules_result);
            
            if($check_validation!=null){
                $data_return['info'] = json_encode($check_validation);
            }else{
                /** update */
                $data = $_POST;
                $data['time'] = time();
                $data['time_update'] = time();
                $data['id_user'] = $this->data['user']['id'];
                $data['is_admin'] = 1;

                $this->My_model->insert($this->_table,$data);

                $data_update = array(
                    'id'=>$data['id_parent'],
                    'id_user'=>$this->data['user']['id'],
                    'is_reply'=>1
                );
                $this->My_model->update($this->_table,$data_update);


                $data_return['status'] = 'success';
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
    
    function popup_detail($id=0){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                if($id!=0){
                    $find_detail = $this->M_comment->detail_Backend($id);
                    if($find_detail==null){
                        $this->load_message();
                    }else{
                        $data['detail'] = $find_detail;
                        $data_update['id'] = $find_detail['id'];
                        $data_update['is_read'] = 1;
                        $this->My_model->update($this->_table,$data_update);
                        $data_return['html'] = $this->load_view('view/comment/include/popup_detail',$data,true);
                        // echo $this->load->view($this->_base_view_path.'view/comment/include/popup_detail',$data,true);
                        echo json_encode($data_return);
                    }
                }
            }else{
                $data_return['checkRole'] = false;
                echo json_encode($data_return);
            }            
        }else{
            $this->load_message('404');
        }
    }
    
    function popup_reply($id=0){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                if($id!=0){
                    $find_detail = $this->M_comment->detail_Backend($id);
                    if($find_detail==null){
                        $this->load_message();
                    }else{
                        $data['detail'] = $find_detail;
                        $data_return['html'] = $this->load_view('view/comment/include/popup_reply',$data,true);
                        echo json_encode($data_return);
                    }
                }
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