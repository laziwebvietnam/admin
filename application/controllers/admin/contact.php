<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Contact extends admin_basic_controller
{
    var $_table = 'contact';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;
        parent::__construct();
        /** Config */
        $this->data_view['btnCreate'] = false;
        /** Load model */
        $this->load->model('M_contact');
    }
    
    function index($view='index'){
        $variable['tb.is_delete'] = 0;
        $this->_index('index',$variable);
    }

    function edit($id=0){
        $this->readContact($id);
    }
    
    function inbox()
    {
        $variable['tb.is_reply'] = 0;
        $variable['tb.is_delete'] = 0;
        $this->_index('index',$variable);
    }
    
    function noreply(){
        $variable['tb.is_delete'] = 0;
        $variable['tb.is_reply'] = 0;
        $variable['tb.is_spam'] = 0;
        $variable['tb.is_read'] = 1;
        $this->_index('index',$variable);
    } 
    
    function reply(){
        $variable['tb.is_delete'] = 0;
        $variable['tb.is_reply'] = 1;
        $this->_index('index',$variable);
    }
    
    function delete()
    {
        $variable['tb.is_delete'] = 1;
        $this->_index('index',$variable);
    }
    
    function readContact($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->My_model->update($this->_table,array('id'=>$id,'is_read'=>1));
        $this->_index('read',$data);
    } 
    
    function replyContact($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('reply',$data);
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
        }else if($view=='read'){
            $data = array(
                'detail'=>$this->M_contact->detail_Backend($variable['id']),
                'count'=>$this->loadCountDefault()
            );
            if($data['detail']==null){
                $this->load_message();
                return;
            }
        }else if($view=='reply'){
            $data = array(
                'detail'=>$this->M_contact->detail_Backend($variable['id']),
                'count'=>$this->loadCountDefault()
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
        $total_row = $this->M_contact->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_contact->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }
    
    /** load count contact default */
    function loadCountDefault(){
        $data_return = array();
        
        
        $where = array(
            'inbox'=>array('tb.is_reply <>'=>1,'tb.is_delete'=>0),
            'noreply'=>array('tb.is_reply'=>0,'tb.is_delete'=>0,'tb.is_spam'=>0,'is_read'=>1),
            'delete'=>array('tb.is_delete'=>1),
            'reply'=>array('tb.is_reply'=>1)
        );
        
        $data_return = array(
            'inbox'=>$this->M_contact->get_all($where['inbox'],0,999,'id desc',true),
            'noreply'=>$this->M_contact->get_all($where['noreply'],0,999,'id desc',true),
            'delete'=>$this->M_contact->get_all($where['delete'],0,999,'id desc',true),
            'reply'=>$this->M_contact->get_all($where['reply'],0,999,'id desc',true)
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
            #array('action'=>$this->_table.'/set_status/is_spam/0','title'=>'Không Spam','popup'=>false),
            #array('action'=>$this->_table.'/set_status/is_spam/1','title'=>'Spam','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_reply/0','title'=>'Chưa phản hồi','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_reply/1','title'=>'Đã phản hồi','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true)
        );
    }
    
    /**
     * action reply & sentmail
     * @return [type] [description]
     */
    function action_sentmail(){
        // $_POST = '{"id":"7","email":"hotienloc.92@gmail.com","title_reply":"da nhan mail","content_reply":"<p>noi dung mai</p>\r\n"}';
        // $_POST = json_decode($_POST,true);
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $data_return['reload'] = true;
                $rules['required'] = array('content_reply','title_reply');
                $rules_result = $this->rules_array($rules);
                
                $check_validation = $this->set_validation(false,$rules_result);
                
                if($check_validation!=null){
                    $data_return['info'] = json_encode($check_validation);
                }else{
                    $emailSent = $_POST['email'];unset($_POST['email']);
                    $data = $_POST;
                    $data['is_reply'] = 1;
                    $this->My_model->update($this->_table,$data);
                    /** Sent mail here */
                    $sentMail = array('email'=>$emailSent,
                                      'subject'=>$data['title_reply'],
                                      'data'=>array('message'=>$data['content_reply']),
                                      'form'=>'forgotpwd');
                    $this->lazi_mailer->send($sentMail);
                    /** Add sent mail here */
                    $data_return['status'] = 'success';
                }
                echo json_encode($data_return);
            }
        }else{
            $this->load_message('404');
        }
    }
    
    function set_rules(){
        $rules['required'] = 
            array('content_reply','title_reply');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
    
    function popup_detail($id=0){
        if($id!=0){
            $find_detail = $this->M_contact->detail_Backend($id);
            if($find_detail==null){
                $this->load_message();
            }else{
                $data['detail'] = $find_detail;
                $data_update['id'] = $find_detail['id'];
                $data_update['is_read'] = 1;
                $this->My_model->update($this->_table,$data_update);
                echo $this->load->view($this->_base_view_path.'view/contact/include/popup_detail',$data,true);
            }
        }
    }
    
    function popup_reply($id=0){
        if($id!=0){
            $find_detail = $this->M_contact->detail_Backend($id);
            if($find_detail==null){
                $this->load_message();
            }else{
                $data['detail'] = $find_detail;
                echo $this->load->view($this->_base_view_path.'view/contact/include/popup_reply',$data,true);
            }
        }
    }
}
?>