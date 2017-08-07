<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class user extends Public_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_customer');
    }
    
    function signUp(){
        if($this->data['customer']){
            print_r($this->data['customer']);
            $this->set_seodata();
            $this->load_view('user/demo/signUp');
        }else{
            $this->signUp();
        }
    }

    function signIn(){
        if($this->data['customer']){
            print_r($this->data['customer']);
            $this->set_seodata();
            $this->load_view('user/demo/signIn');
        }else{
            $this->set_seodata();
            $this->load_view('user/demo/signIn');
        }
    }

    function signOut(){
        $this->session->set_userdata('customerLogin',null);
        echo 'thanh cong';  
    }

    function testAPI() {
        $this->load->view($this->_base_view_path . 'user/demo/testAPI');
    }

    function logoutAPI() {
        $this->session->set_userdata('customerLogin',null);
        redirect('user/testAPI');
    }

    function loginFacebook() {
        // Include the facebook api php libraries
        include_once APPPATH."libraries/Facebook/facebook.php";
        
        // Facebook API Configuration
        $appId = '1455247697849399';
        $appSecret = '9eac3054b8f3ad6fcbe6d3c39e97e648';
        $redirectUrl = base_url() . 'user/loginFacebook';
        $fbPermissions = 'email';
        
        //Call Facebook API
        $facebook = new Facebook(array(
          'appId'  => $appId,
          'secret' => $appSecret
        ));
        $fbuser = $facebook->getUser();
        
        if ($fbuser) {
            $userProfile = $facebook->api('/me?fields=id,name,email,picture');
            // Preparing data for database insertion
            $userData['facebook_oauth_provider'] = 'facebook';
            $userData['facebook_oauth_uid'] = $userProfile['id'];
            $userData['name'] = $userProfile['name'];
            $userData['email'] = $userProfile['email'];
            $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
            $userData['picture_url'] = 'https://graph.facebook.com/' . $userProfile['id'] . '/picture?width=300&height=300';
            // $userData['picture_url'] = $userProfile['picture']['data']['url'];
            // Insert or update user data
            $userID = $this->M_customer->checkUser($userData, 'facebook');
            
            $setLogin = array(
                'loged_in'=>true,
                'id_customer'=>md6($userID)
            );
            $this->session->set_userdata('customerLogin',$setLogin);

            $data_return = array(
                'is_auth' => true,
                'userID' => $userID
            );
        } else {
            $fbuser = '';
            
            $data_return = array(
                'is_auth' => false,
                'link' => $facebook->getLoginUrl(array(
                    'redirect_uri' => $redirectUrl,
                    'scope' => $fbPermissions
                ))
            );
        }
        
        if (__IS_AJAX__) {
            echo json_encode($data_return);
        } else {
            redirect('user/testAPI');
        }
    }

    function loginGoogle() {
        // Include the facebook api php libraries
        include_once APPPATH."libraries/Google/Google_Client.php";
        include_once APPPATH."libraries/Google/contrib/Google_Oauth2Service.php";
        
        // Facebook API Configuration
        $clientId = '674708839999-mk8r1h00spdb6qticpjumb4a973jdgb1.apps.googleusercontent.com';
        $clientSecret = 'gnVjZopxo5Hc0M9DtD_rv1ak';
        $redirectUrl = base_url() . 'user/loginGoogle';

        $gClient = new Google_Client();
        $gClient->setApplicationName('Test Connect API');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }
        
        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
            $userData['google_oauth_provider'] = 'google';
            $userData['google_oauth_uid'] = $userProfile['id'];
            $userData['name'] = $userProfile['name'];
            $userData['email'] = $userProfile['email'];
            $userData['profile_url'] = $userProfile['link'];
            $userData['picture_url'] = $userProfile['picture'];
            // $userData['picture_url'] = $userProfile['picture']['data']['url'];
            // Insert or update user data
            $userID = $this->M_customer->checkUser($userData, 'google');
            
            $setLogin = array(
                'loged_in'=>true,
                'id_customer'=>md6($userID)
            );
            $this->session->set_userdata('customerLogin',$setLogin);

            $data_return = array(
                'is_auth' => true,
                'userID' => $userID
            );
        } else {
            $data_return = array(
                'is_auth' => false,
                'link' => $gClient->createAuthUrl()
            );
        }
        
        if (__IS_AJAX__) {
            echo json_encode($data_return);
        } else {
            $this->session->unset_userdata('token');
            redirect('user/testAPI');
        }
    }

    function changeInfo(){
        if($this->data['customer']){
            $this->set_seodata();
            $this->load_view('user/demo/changeInfo');
        }else{
            $this->set_seodata();
            $this->load_view('user/demo/signIn');
        }
    }

    function changePass(){
        if($this->data['customer']){
            $this->set_seodata();
            $this->load_view('user/demo/changePass');
        }else{
            $this->set_seodata();
            $this->load_view('user/demo/signIn');
        }
    }

    function forgotPass(){
        if(!$this->data['customer']){
            $this->set_seodata();
            $this->load_view('user/demo/forgotPass');
        }else{
            echo 'You can not visit this page when signed in. Click for <a href="'.base_url().'user/signOut">sign out</a>';
            $this->set_seodata();            
        }
    }

    function actionSignUp(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('fullname','email','form','password','password_confirm','address','phone');
            $rules['valid_email'] = array('email');
            //$rules['callback_check_unique[email]'] = array('email');
            $rules['matches[password]'] = array('password_confirm');
            $rules['min_length[6]'] = array('password','password_confirm');
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $dataCustomer = $this->postvalue(array('fullname','email','form','password','address','phone'));
                $findCustomer = $this->M_customer->getDetailByField('email',$dataCustomer['email']);
                if($findCustomer && strlen($findCustomer['password'])>0){
                    $data_return['error'] = 'Email is exists';
                }else{
                    $dataCustomer['is_active'] = 1;
                    $dataCustomer['time'] = time();
                    $dataCustomer['password'] = md5($dataCustomer['password']);
                    $data_return['info']['id_customer'] = $this->findCustomer($dataCustomer);

                    $setLogin = array(
                        'loged_in'=>true,
                        'id_customer'=>md6($data_return['info']['id_customer'])
                    );
                    $this->session->set_userdata('customerLogin',$setLogin);

                    $data_return['status'] = 'success';
                }
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function actionSignIn(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('email','password');
            $rules['valid_email'] = array('email');
            $rules['min_length[6]'] = array('password');
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $email = trim($_POST['email']);
                $findCustomer = $this->M_customer->getDetailByField('email',$email);

                if($findCustomer==null){
                    $data_return['error'] = 'Not found user by email';
                }else if($findCustomer['password']!=md5($_POST['password'])){
                    $data_return['error'] = 'Wrong password';
                }else if($findCustomer['is_active']==0){
                    $data_return['error'] = 'Your account is log';
                }else{
                    $setLogin = array(
                        'loged_in'=>true,
                        'id_customer'=>md6($findCustomer['id'])
                    );
                    $this->session->set_userdata('customerLogin',$setLogin);

                    $data_return['status'] = 'success';
                }
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function actionChangeInfo(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('fullname','phone','address','id');
            if(isset($_POST['password']) && isset($_POST['password_confirm'])){
                if($_POST['password'] || $_POST['password_confirm']){
                    $rules['min_length[6]'] = array('password','password_confirm');
                    $rules['matches[password]'] = array('password_confirm');
                    $rules['required'][] = 'password';
                    $rules['required'][] = 'password_confirm';
                }
            }
            
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $dataCustomer = $this->postvalue(array('fullname','address','phone','id'));
                $id = md6_decode($dataCustomer['id']);

                $findCustomer = $this->M_customer->getDetailByField('id',$id);
                
                if($findCustomer==null){
                    $data_return['error'] = "Not found user by id = $id";
                }else if($findCustomer['is_active']==0){
                    $data_return['error'] = 'Your account is log';
                }else{
                    $dataUpdate = $dataCustomer;
                    $dataUpdate['time_update'] = time();
                    unset($dataUpdate['id']);

                    if(isset($_POST['password'])){
                        if(strlen($_POST['password'])>=6){
                            $dataUpdate['password'] = md5($_POST['password']);
                        }
                    }

                    $where['id'] = $id;
                    $statusUpdate = $this->My_model->update('customer',$dataUpdate,$where);

                    $data_return['status'] = $statusUpdate==true?'success':'fail';
                }
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function actionChangePass(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('password','new_password','new_password_confirm','id');
            $rules['min_length[6]'] = array('new_password','new_password_confirm');
            $rules['matches[new_password]'] = array('new_password_confirm');

            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $dataCustomer = $this->postvalue(array('password','new_password','id'));
                $id = md6_decode($dataCustomer['id']);
                $findCustomer = $this->M_customer->getDetailByField('id',$id);
                
                if($findCustomer==null){
                    $data_return['error'] = "Not found user by id = $id";
                }else if($this->data['customer']['id'] != $findCustomer['id']){
                    $data_return['error'] = "Not same user";
                }else if($findCustomer['is_active']==0){
                    $data_return['error'] = 'Your account is log';
                }else if($findCustomer['password']!=md5($dataCustomer['password'])){
                    $data_return['error'] = 'Old password is not correct';
                }else if($findCustomer['password']==md5($dataCustomer['new_password'])){
                    $data_return['error'] = 'New password is not same Old password';
                }
                else{
                    $dataUpdate['password'] = md5($dataCustomer['new_password']);
                    $dataUpdate['time_update'] = time();
                    unset($dataUpdate['id']);

                    $where['id'] = $id;
                    $statusUpdate = $this->My_model->update('customer',$dataUpdate,$where);

                    $data_return['status'] = $statusUpdate==true?'success':'fail';
                }
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function actionForgotPass(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('email');
            $rules['valid_email'] = array('email');

            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $email = trim($_POST['email']);
                $findCustomer = $this->M_customer->getDetailByField('email',$email);

                if($findCustomer==null){
                    $data_return['error'] = "Not found user by id = $id";
                }else if($findCustomer['is_active']==0){
                    $data_return['error'] = 'Your account is log';
                }else{
                    $data_return['info'] = $this->user_ActionResetPass($findCustomer);

                    if($data_return['info']['status']=='success'){
                        $data_return['alert'] = 'Please check your email for verify account.';
                        $data_return['status'] = 'success';
                    }else{
                        $data_return['error'] = $data_return['info']['error'];
                    }
                    
                }
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function user_ActionResetPass($userDetail=array()){
        // $userDetail = $this->My_model->getbyid('customer','1');
        $checkUpdate = false;
        $userDetail =  $userDetail==null?$this->data['customer']:$userDetail;
        $data_return['status'] = 'fail';
        $data_return['error'] = '';
        if($userDetail!=null){
            $dataUpdate = array(
                'id'=>$userDetail['id'],
                'resetpasscode'=>md5(time()+(int)$userDetail['id']),
                'time_update'=>time()
            );
            $checkUpdate = $this->My_model->update('customer',$dataUpdate);
            if($checkUpdate==true){
                $dataSentmail = array(
                    'userDetail'=>$userDetail,
                    'dataUpdate'=>$dataUpdate
                );
                $message = $this->load->view($this->_base_view_path.'include/mail/resetPass',$dataSentmail,true);
                
                $sentMail = array('email'=>$userDetail['email'],
                                  'subject'=>'[LAZIWEB] Thông báo khôi phục mật khẩu thành công',
                                  'data'=>array('message'=>$message),
                                  'form'=>'forgotpwd');
                $statusSentmail = true;
                $this->lazi_mailer->send($sentMail);
                if($statusSentmail==true){
                    $data_return['status'] = 'success';
                }else{
                    $data_return['error'] = 'Sentmail is fail.';
                }
            }else{
                $data_return['error'] = 'Update passcode is fail.';
            }
        }
        return $data_return;
    }

    function user_ActiveResetPass($resetPassCode=''){
        $checkUpdate = false;
        $data_return['status'] = false;
        if($resetPassCode!=''){
            $where = array('resetpasscode'=>$resetPassCode);
            $findCustomer = $this->My_model->getdetail_by_any('customer',$where);

            if($findCustomer==null){
                $data_return['error'] = "Not found user";
            }else if($findCustomer['is_active']==0){
                $data_return['error'] = 'Your account is log';
            }else{
                $data_return['status'] = true;
                $data['userDetail'] = $findCustomer;

                $this->set_seodata();
                $this->load_view('user/demo/createNewPass',$data);
                return;
            }
        }else{
            $data_return['error'] = 'Passcode is null';
        }
        $data['message'] = $data_return['error'];
        $this->load_message('403',$data);
    }

    function actionSetNewPass(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            /** SET RULES */
            $rules['required'] = array('password','password_confirm');
            $rules['matches[password]'] = array('password_confirm');
            $rules['min_length[6]'] = array('password','password_confirm');
            $rules = $this->rules_array($rules);

            $typeAction = isset($_POST['typeAction'])?$_POST['typeAction']:'submit';

            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else if($typeAction=='submit'){
                $dataCustomer = $this->postvalue(array('password','id','passcode'));

                $where = array(
                        'id'=>md6_decode($dataCustomer['id']),
                        'resetpasscode'=>$dataCustomer['passcode']
                    );
                $findCustomer = $this->My_model->getdetail_by_any('customer',$where);

                if($findCustomer==null){
                    $data_return['error'] = "Not found user";
                }else if($findCustomer['is_active']==0){
                    $data_return['error'] = 'Your account is log';
                }else{
                    $dataUpdate = array(
                            'password'=>md5($dataCustomer['password']),
                            'resetpasscode'=>null
                        );
                    $this->My_model->update('customer',$dataUpdate,array('id'=>$findCustomer['id']));
                    $setLogin = array(
                        'loged_in'=>true,
                        'id_customer'=>md6($findCustomer['id'])
                    );
                    $this->session->set_userdata('customerLogin',$setLogin);
                    $data_return['status'] = true;
                }

                $data_return['status'] = 'success';
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }
}
?>