<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class User extends admin_basic_controller
{
    var $_table = 'user';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;
        parent::__construct();
        /** Config */        
        /** Load model */
        $this->load->model('M_user');
        $this->load->model('M_notification');
        
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
                'list'=>$this->listPage_data('search')
            );  
        }else if($view=='create'){
            $data = array(
                'role'=>$this->My_model->getlist('user_role',array('id <>'=>1,'is_active'=>1),0,999,'id asc')
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_user->detail_Backend($variable['id']),
                'role'=>$this->My_model->getlist('user_role',array('id <>'=>1,'is_active'=>1),0,999,'id asc'),
                'noti'=>$this->M_notification->get_all(array('tb.id_user'=>$variable['id']),0,10)
            );  
            if($data['detail']==null){
                $this->load_message('404');
                return;
            }else{
                $dataCheckIdUser = $this->checkIdForAction($data['detail'],true);
                if($dataCheckIdUser['status']!='success'){
                    $this->load_message('403');
                    return;
                }
            }
            $view = 'create';
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function listPage_data($type='list'){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array('tb.is_delete'=>0,'tb.id <>'=>1);
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
        $total_row = $this->M_user->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        
        $list = $this->M_user->get_all($where,$start,$limit,$order_by);
        
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
            array('name'=>'phone','title'=>'Điện thoại','linkDetail'=>true,'hidden'=>true),
            array('name'=>'r_title','title'=>'Thuộc quyền'),
            array('name'=>'time_login','title'=>'Lần đăng nhập cuối','type'=>'time'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    /** quickAction when select id */
    function listPage_quickAction(){
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Khóa tài khoản','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Mở tài khoản','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true)
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
                if($data['password']!=''){
                    $data['password'] = md5($data['password']);
                }else{
                    unset($data['password']);
                }
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
        if($_POST['type_action']=='create'){
            $rules['required'] = 
                array('email','id_role','password','username','fullname');
        }else{
            $rules['required'] = 
                array('email','id_role','username','fullname');
        }
        
        $rules['valid_email'] = 
            array('email');
        $rules['max_length[30]'] = 
            array('password','username');
        $rules['min_length[6]'] = 
            array('password','username');
        $rules['callback_check_unique[username]'] = 
            array('username');
        $rules['callback_check_unique[email]'] = 
            array('email');
        $rules['callback_check_unique[phone]'] = 
            array('phone');
        
                
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }    
    /** END ACTION */
    
    /** DELETE ACTION */
    function delete_action($id=null){
        if(__IS_AJAX__){
            $data['status'] = 'fail';
            if($id!=null){
                $id = (int)$id;
                $findUser = $this->My_model->getbyid($this->_table,$id);
                $dataCheckIdUser = $this->checkIdForAction($findUser);
                if($dataCheckIdUser['status']=='success'){
                    $this->My_model->update_delete($this->_table,'delete',array('id'=>$id));
                    $data['status'] = 'success';
                    $data['reload'] = true;
                }else{
                    $data['log'] = isset($dataCheckIdUser['log'])?$dataCheckIdUser['log']:'fail';
                }               
            }else if($_POST != null){
                $where_in = explode(',',$_POST['id_executed']);
                if($where_in!=null){
                    foreach($where_in as $id){
                        $findUser = $this->My_model->getbyid($this->_table,$id);
                        $dataCheckIdUser = $this->checkIdForAction($findUser);
                        if($dataCheckIdUser['status']=='success'){
                            $this->My_model->update_delete($this->_table,'delete',array('id'=>$id));
                            $data['status'] = 'success';
                            $data['reload'] = true;
                        }else{
                            $data['log'] = isset($dataCheckIdUser['log'])?$dataCheckIdUser['log']:'fail';
                            $data['reload'] = false;
                            echo json_encode($data);
                            return;
                        }
                    }
                }
            }else{
                $data['log'] = 'Empty $_POST';
            }
            echo json_encode($data);     
        }
    }
    
    function checkIdForAction($userDetail=array(),$editPage=false){

        $data['status'] = 'fail';
        if($userDetail==null){
            $data['log'] = 'Không tìm thấy thông tin - Quản trị viên';
        }else{
            if($userDetail['id_role']==1 && $this->data['user']['id']!=1){
                $data['log'] = 'Không thể xóa - Quản trị viên có Mã bằng '.$userDetail['id'];
            }else if($userDetail['id_role']==$this->data['user']['id_role'] && $this->data['user']['id']!=1 && $userDetail['id']!=$this->data['user']['id']){
                $data['log'] = 'Không thể xóa - Quản trị viên có cùng phân quyền';
            }
            else if($userDetail['id']==$this->data['user']['id'] && $editPage == false){
                $data['log'] = 'Không thể xóa chính bạn';
            }
            else if($userDetail['id_role'] < $this->data['user']['id_role']){
                $data['log'] = 'Không thể xóa - Quản trị viên cao quyền hơn';
            }
            else{
                $data['status'] = 'success';
            }
        }
        return $data;
    }

/** ACTION MASTER PAGE */
    function user_changeInfo(){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $rules['required'] = array('fullname','email');
                $rules['valid_email'] = array('email');
                $rules['callback_check_unique[email]'] = array('email');
                $rules['callback_check_unique[phone]'] = array('phone');
                $rules_result = $this->rules_array($rules);
                
                $check_validation = $this->set_validation(false,$rules_result);
                
                if($check_validation!=null){
                    $data_return['info'] = $check_validation;
                }else{
                    unset($_POST['type_action']);
                    $data = $_POST;
                    $data['time_update'] = time();
                    $this->My_model->update($this->_table,$data);
                    $data_return['status'] = 'success';
                }
                echo json_encode($data_return);
            }
        }else{
            $this->load_message('404');
        }
    }
    /** change Pass*/
    function user_changePass(){
        if($_POST){
            $data_return['status'] = 'fail';
            $rules['required'] = array('password_old','password_new','password_confirm');
            $rules['matches[password_new]'] = array('password_confirm');
            $rules_result = $this->rules_array($rules);
            
            $check_validation = $this->set_validation(false,$rules_result);
            
            if($check_validation!=null){
                $data_return['info'] = $check_validation;
            }else{
                if($this->data['user']['password']!=md5($_POST['password_old'])){
                    $data_return['info']['password_old'] = array(
                        'rules'=>'matches',
                        'alert'=>lang('password_old').' không đúng'
                    );
                }else{
                    $data = $_POST;
                    unset($data['type_action'],$data['password_old'],$data['password_new'],$data['password_confirm']);
                    $data['id'] = $this->data['user']['id'];
                    $data['time_update'] = time();
                    $data['password'] = md5($_POST['password_new']);
                    $this->My_model->update($this->_table,$data);
                    $data_return['status'] = 'success';
                }
            }
            echo json_encode($data_return);
        }
    }
    
    /**  Action set passcode and sentmail */
    function user_ActionResetPass($userDetail=array(),$returnResult=false){
        $checkUpdate = false;
        $userDetail =  $userDetail==null?$this->data['user']:$userDetail;
        $data_return['status'] = 'fail';
        if($userDetail!=null){
            $dataUpdate = array(
                'id'=>$userDetail['id'],
                'resetpasscode'=>md5(time()+(int)$userDetail['id']),
                'time_update'=>time()
            );
            $checkUpdate = $this->My_model->update($this->_table,$dataUpdate);
            if($checkUpdate==true){
                    $dataSentmail = array(
                    'userDetail'=>$userDetail,
                    'dataUpdate'=>$dataUpdate
                );
                $message = $this->load->view($this->_base_view_path.'view/user/include/mailResetPass',$dataSentmail,true);
                
                $sentMail = array('email'=>$userDetail['email'],
                                  'subject'=>'[LAZIWEB] Thông báo khôi phục mật khẩu thành công',
                                  'data'=>array('message'=>$message),
                                  'form'=>'forgotpwd');
                $statusSentmail = true;
                $this->lazi_mailer->send($sentMail);
                if($statusSentmail==true){
                    $data_return['status'] = 'success';
                    $data_return['log'] = 'Vui lòng kiểm tra hộp mail để kích hoạt và hoàn tất khôi phục mật khẩu.';
                }else{
                    $data_return['log'] = 'Gửi mail thất bại. Vui lòng thông báo với bộ phận thiết kế website.';
                }
            }else{
                $data_return['log'] = 'Cập nhật passcode thất bại. Vui lòng thông báo với bộ phận thiết kế website.';
            }
        }
        if($returnResult==true){
            return $data_return;
        }else{
            echo json_encode($data_return);
        }
        
    }
    
    /** action check and reset default pass*/
    function user_ActiveResetPass($resetPassCode=''){
        $checkUpdate = false;
        $data_return['status'] = false;
        if($resetPassCode!=''){
            $where = array('resetpasscode'=>$resetPassCode);
            $findUser = $this->My_model->getdetail_by_any($this->_table,$where);
            if($findUser!=null){
                $data_return['status'] = true;
                $data['userDetail'] = $findUser;
                $this->load->view($this->_base_view_path.'view/user/configNewPass',$data);
                return;
            }else{
                $data_return['log'] = 'Không tìm thấy thông tin User';
            }
        }
        redirect('admin');
    }
    
    function login(){
        if($this->data['user']==null){
            $this->load->view($this->_base_view_path.'view/user/login');
        }else{
            redirect('admin');   
        }        
    }
    
    function login_action(){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $rules['required'] = array('email','password');
                //$rules['valid_email'] = array('email');
                $rules_result = $this->rules_array($rules);
                
                $check_validation = $this->set_validation(false,$rules_result);
                
                if($check_validation!=null){
                    $data_return['info'] = $check_validation;
                }else{
                    $where = array(
                        'email'=>$_POST['email'],
                        'password'=>md5($_POST['password']),
                        'is_delete'=>0
                    );
                    $where_or = array(
                        'username'=>$_POST['email'],
                        'password'=>md5($_POST['password']),
                        'is_delete'=>0
                    );

                    $findUser = $this->My_model->getdetail_by_any($this->_table,$where);
                    $findUser = $findUser==null?$this->My_model->getdetail_by_any($this->_table,$where_or):$findUser;

                    if($findUser!=null){
                        if($findUser['is_active']==0){
                            $data_return['log'] = 'Tài khoản đang bị khóa';
                        }else{
                            $setLogin = array(
                                'loged_in'=>true,
                                'id_user'=>md6($findUser['id']),
                            );
                            $this->session->set_userdata('adminLogin',$setLogin);
                            $_SESSION['adminLogin'] = $setLogin;
                            $data_update = array(
                                'id'=>$findUser['id'],
                                'time_login'=>time()
                            );
                            $this->My_model->update('user',$data_update);
                            $data_return['status'] = 'success';
                        }  
                    }else{
                        $data_return['log'] = 'Tài khoản và mật khẩu không đúng';
                    }
                     
                }
                echo json_encode($data_return);
            }
        }else{
            redirect('admin/home');
        }
    }
    
    function forgotpass_action(){
        if($_POST){
            $data_return['status'] = 'fail';
            $rules['required'] = array('email');
            $rules['valid_email'] = array('email');
            $rules_result = $this->rules_array($rules);
            
            $check_validation = $this->set_validation(false,$rules_result);
            
            if($check_validation!=null){
                $data_return['info'] = $check_validation;
            }else{
                $where = array(
                    'email'=>$_POST['email'],
                    'is_delete'=>0
                );
                
                $findUser = $this->My_model->getdetail_by_any($this->_table,$where);
                if($findUser!=null){
                    if($findUser['is_active']==0){
                        $data_return['log'] = 'Tài khoản đang bị khóa';
                    }else{
                        $checkActionReset = $this->user_ActionResetPass($findUser,true);
                        if($checkActionReset['status']=='success'){
                            $data_return['status'] = 'success';
                            $data_return['log'] = isset($checkActionReset['log'])?$checkActionReset['log']:'';
                        }else{
                            $data_return['log'] = isset($checkActionReset['log'])?$checkActionReset['log']:'';
                        }
                    }  
                }else{
                    $data_return['log'] = 'Email không đúng';
                }
                 
            }
            echo json_encode($data_return);
        }
    }
    
    function configNewpass_action(){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $rules['required'] = array('password','password_confirm','id');
                $rules['min_length[6]'] = array('password','password_confirm');
                $rules['matches[password]'] = array('password_confirm');
                $rules_result = $this->rules_array($rules);
                
                $check_validation = $this->set_validation(false,$rules_result);
                
                if($check_validation!=null){
                    $data_return['info'] = $check_validation;
                }else{
                    $where = array(
                        'id'=>md6_decode($_POST['id'])
                    );
                    
                    $findUser = $this->My_model->getdetail_by_any($this->_table,$where);
                    if($findUser!=null){
                        if($findUser['is_active']==0){
                            $data_return['log'] = 'Tài khoản đang bị khóa';
                        }else{
                            $setLogin = array(
                                'loged_in'=>true,
                                'id_user'=>md6($findUser['id']),
                            );
                            $this->session->set_userdata('adminLogin',$setLogin);
                            $_SESSION['adminLogin'] = $setLogin;
                            $data_update = array(
                                'id'=>$findUser['id'],
                                'time_login'=>time(),
                                'password'=>md5($_POST['password'])
                            );
                            $this->My_model->update('user',$data_update);
                            $data_return['status'] = 'success';
                        }  
                    }else{
                        $data_return['log'] = 'Tài khoản và mật khẩu không đúng';
                    }
                }
                echo json_encode($data_return);
            }
        }else{
            redirect('admin/home');
        }
    }
    
    function logout(){
        $setLogin = array(
            'loged_in'=>false
        );
        $this->session->set_userdata('adminLogin',null);
        session_destroy();
        redirect('admin');
    }
    
    function popup_info(){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                $data_return['html'] = $this->load_view('view/user/include/popup_info',null,true);
                echo json_encode($data_return);   
            }else{
                $data_return['checkRole'] = false;
                echo json_encode($data_return); 
            }
        }else{
            $this->load_message('404');
        }    	
    }
    
    function popup_changepass(){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                $data_return['html'] = $this->load_view('view/user/include/popup_changepass',null,true);
                echo json_encode($data_return); 
            }else{
                $data_return['checkRole'] = false;
                echo json_encode($data_return); 
            }
        }else{
            $this->load_message('404');
        }
    }
    
    function popup_resetpass(){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                $data_return['html'] = $this->load_view('view/user/include/popup_resetpass',null,true);
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