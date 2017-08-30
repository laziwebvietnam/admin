<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Public_Controller extends My_controller{
    var $_current_selected_menu='home';
    var $_base_view_path='FRONTEND/';
    var $_base_view_path_sub='';
    var $_BASE_URL='';
    var $_template=array();
    var $_config=array();

    function __construct()
    {
        parent::__construct();
        if($this->config->item('site_open')===FALSE)
        {
            show_error('Sorry the site is shut down for now');
        }
        $this->_base_view_path=$this->config->item('my_base_view_path_frontend');
        
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper(array('form','url','default'));
        $this->getConfigList();
        
        $this->setLoginCustomer();
    } 

    function setLoginCustomer(){
        $sessionCustomerLogin = $this->session->userdata('customerLogin');

        


        $this->data['customer'] = null;
        if($sessionCustomerLogin!=null){
            if(isset($sessionCustomerLogin['loged_in']) && isset($sessionCustomerLogin['id_customer'])){
                if($sessionCustomerLogin==true){
                    $idcustomer = md6_decode($sessionCustomerLogin['id_customer']);
                    $findcustomer = $this->My_model->getbyid('customer',$idcustomer);
                    if($findcustomer!=null){
                        if($findcustomer['is_active']==1 && $findcustomer['is_delete']==0){
                            $this->data['customer'] = $findcustomer;
                        }
                    }
                }
            }
        }
    }

    /**
     * Public_Controller::load_default_data()
     * 
     * @return
     */
    function load_default_data(){
        /** Config Where */
        $where = array(
            'menu'=>array('is_active'=>1,'is_delete'=>0,'level'=>0)
        );

        $this->_template['menu'] = $this->My_model->getlist('category',$where['menu'],0,999,'position asc');
        
        return array();
    }

    /**
     * [set_seodata description]
     * @param [type] $dataTable [description]
     * @param [type] $dataId    [description]
     */
    function set_seodata($dataTable=null,$dataId=null,$dataSeo=array())
    {
        if($dataSeo==null && $dataTable!=null && $dataId!=null){
            $where = array(
                'data_id'=>$dataId,
                'data_table'=>$dataTable
            );
            $data = $this->My_model->getdetail_by_any('seo',$where);
        }else{
            $data = $dataSeo;
        }

        $this->_template['seo_data']['title_seo']   =isset($data[$this->_lang.'title'])?$data[$this->_lang.'title']:$this->_template['config_website'][$this->_lang.'seo_title'];
        $this->_template['seo_data']['title_seo'] .= isset($this->_template['config_website'][$this->_lang.'seo_title_tail'])?$this->_template['config_website'][$this->_lang.'seo_title_tail']:'';
        $this->_template['seo_data']['desc_seo']    =isset($data[$this->_lang.'desc'])?$data[$this->_lang.'desc']:$this->_template['config_website'][$this->_lang.'seo_desc'];
        $this->_template['seo_data']['keyword_seo'] =isset($data[$this->_lang.'keyword'])?$data[$this->_lang.'keyword']:$this->_template['config_website'][$this->_lang.'seo_keyword'];
        $this->_template['seo_data']['title_seo_facebook'] = isset($data[$this->_lang.'title_facebook'])?($data[$this->_lang.'title_facebook']!=''?$data[$this->_lang.'title_facebook']:$this->_template['seo_data']['title_seo']):$this->_template['seo_data']['title_seo'];
        $this->_template['seo_data']['desc_seo_facebook'] = isset($data[$this->_lang.'desc_facebook'])?($data[$this->_lang.'desc_facebook']!=''?$data[$this->_lang.'desc_facebook']:$this->_template['seo_data']['desc_seo']):$this->_template['seo_data']['desc_seo'];
        $this->_template['seo_data']['image']=isset($data['image'])?$data['image']:$this->_template['config_website']['logo'];
        $this->_template['seo_data']['logo_icon'] = isset($this->_template['config_website']['logo_icon'])?$this->_template['config_website']['logo_icon']:'';
    }
    
    /** count view */
    function countViews(){
        $counter_name = "template/backend/counter.txt";
        $time = date('Y-m-d');
        //$time = '19-03-2016';
        $typeTest = false;
        // Check if a text file exists. If not create one and initialize it to zero.
        if (!file_exists($counter_name)) {
            $content = '';
            if($typeTest==true){
                $content = '';
                for($i=0;$i<=60;$i++){
                    $time = date('Y-m-d',time()-86400*$i);
                    $content .= $time.' '.rand(0,1000)."\n";
                }   
            }else{
                $content = $time." 0\n";
            }
            $f = fopen($counter_name, "w");
            fwrite($f,$content);
            fclose($f);
        }
        $lines = file($counter_name);
        $content = '';
        $found = false;
        foreach($lines as $key=>$line)
        {
            if(strpos($line, $time) !== false)
            {
                $num = (int)substr($line,11);
                $num = $num+1;
                $lines[$key] = $time.' '.$num."\n";
                $found = true;
            }
            $content .= $lines[$key];
        }
        if($found==false){
            $content = $time." 1\n".$content;
        }
        $th=fopen($counter_name, 'w');
        fwrite($th, $content);
        fclose($th);
    }

    /** get config list on Config Table */
    function getConfigList(){
        $fileName = "template/backend/config.txt";
        if (file_exists($fileName)) {
            $f = fopen($fileName, "r");
            $content = fread($f,filesize($fileName));
            
            if (!is_int($content) && !is_float($content)) {
                $configTemp = json_decode($content,true);

                if($configTemp){
                    foreach($configTemp as $item){
                        $this->_template['config_website'][$item['key']] = $item['value'];
                    }
                }
            }
            fclose($f);
        }



        // $list = $this->My_model->getlist('config');
        // if($list!=null){
        //     foreach($list as $item){
        //         $this->_template['config_website'][$item['key']] = $item['value'];
        //     }
        // }
    }

    public function load_message($type='404',$data=array(),$isPopup=true)
    {
        $dataSEO = array(
            'title'=>'Không tìm thấy nội dung',
            'desc'=>'Không tìm thấy nội dung',
            'keyword'=>'Không tìm thấy nội dung',
            'en_title'=>'Page is not found',
            'en_desc'=>'Page is not found',
            'en_keyword'=>'Page is not found',
        );
        $this->set_seodata(null,null,$dataSEO);
        $this->load_view('include/error/'.$type,$data);
    }

    /**
     * [create_pageList description]
     * @param  [type] $total_row [description]
     * @param  [type] $baseurl   [description]
     * @param  [type] &$limit    [description]
     * @param  [type] &$start    [description]
     * @return [type]            [description]
     */
    function create_pageList($total_row,$baseurl,&$limit,&$start)
    {
        $baseurl=$baseurl?$baseurl:current_url();
        $this->load->library('pagination','','Pager');
        //cau hinh phan trang
        //$limit=$this->_template['config']['per_page'];
        $limit=is_numeric($limit)?$limit:18;
        $start=$this->input->get('page');
        $start=str_replace('/','',$start);
        $start=is_numeric($start)?$start:0;
        //xu ly link
        $hget=$_GET;
        //print_r($hget);
        if(isset($hget['page']))
        {
            unset($hget['page']);
        }
        if(!empty($hget))
        {
            $baseurl.='?'.http_build_query($hget);
        }
        else
        {
            $baseurl.='?';
        }
        $pageConfig=array(
            'base_url'      =>   $baseurl,
            'total_rows'    =>   $total_row,
            'cur_page'      =>   $start,
            'query_string_segment'=>'page',
            'cur_tag_open'  =>   '<li class="active">', //trạng thái active
            'cur_tag_close' =>   '</li>',
            'num_tag_open'  =>   '<li>',
            'num_tag_close' =>   '</li>',
            'first_tag_open' =>  '<li>',
            'first_tag_close'=>  '</li>',
            'next_tag_open' =>   '<li>',
            'next_tag_close'=>   '</li>',
            'prev_tag_open' =>   '<li>',
            'prev_tag_close'=>   '</li>',
            'last_tag_open' =>   '<li>',
            'last_tag_close'=>   '</li>',
            'per_page'      =>   $limit,
            'first_link'    =>   'First',
            'last_link'     =>   'Last',
            'next_link'     =>   'Next',
            'prev_link'     =>   'Prev',
            'num_links'     =>   5,
            'full_tag_open' =>   '<ul>',
            'full_tag_close'=>   '</ul>',
            'page_query_string'=>TRUE
        );
        $this->Pager->initialize($pageConfig);
        return $this->Pager->create_links();
    }

    /**
     * [set_validation description]
     * @param boolean $return_bool [description]
     * @param array   $rules_temp  [description]
     */
    function set_validation($return_bool=false,$rules_temp=array()){
        if(__IS_AJAX__) {
            $rules = $rules_temp!=null?$rules_temp:$this->set_rules();
            $this->form_validation->set_rules($rules);  

            $error = array();
            if($this->form_validation->run()==false && $rules){
                if($return_bool==true){
                    return false;
                }
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
            if($return_bool==false && $rules_temp!=null){
                return $error;
            }else{
                /** when not ajax */
                echo json_encode($error);
            }
        }else{
            $this->load_message();
        }
    }

    /**
     * [getBreadcrumb description]
     * @param  array  $detailPage [description]
     * @param  string $typePage   [description]
     * @param  string $slug       [description]
     * @return [type]             [description]
     */
    function getBreadcrumb($detailPage=array(),$typePage='onepage',$slug=''){
        $breadcrumb = array();
        $slug = $slug!=''?$slug:'';
        $breadcrumb[] = array(
            'title'=>lang('homepage'),
            'alias'=>$this->_BASE_URL
        );
        $breadcrumbTemp = array();
        if($typePage=='onepage'){
            $breadcrumb[] = array(
                'title'=>$detailPage[$this->_lang.'title'],
                'alias'=>base_url().$slug.$detailPage[$this->_lang.'alias']
            );
        }else if($typePage=='category'){
            if(isset($detailPage['id'])){
                $this->M_category->getListByIdParent($detailPage['id'],$breadcrumbTemp);
            }

        }else if($typePage=='detailProduct'){
            $aliasDetail = return_valueKey($this->_template['typeCategory'],'id','product','alias'); 
            $breadcrumbTemp[] = array(
                'title'=>$detailPage[$this->_lang.'title'],
                'alias'=>$aliasDetail.$detailPage[$this->_lang.'alias']);
            if(isset($detailPage['id_category'])){
                $this->M_category->getListByIdParent($detailPage['id_category'],$breadcrumbTemp);
            }
        }else if($typePage=='detailArticle'){
            $aliasDetail = return_valueKey($this->_template['typeCategory'],'id','article','alias'); 
            $breadcrumbTemp[] = array(
                'title'=>$detailPage[$this->_lang.'title'],
                'alias'=>$aliasDetail.$detailPage[$this->_lang.'alias']);
            if(isset($detailPage['id_category'])){
                $this->M_category->getListByIdParent($detailPage['id_category'],$breadcrumbTemp);
            }
        }
        
        $breadcrumb = array_merge($breadcrumb,$breadcrumbTemp);
        
        return $breadcrumb;
    }

    /**
     * [rules_array description]
     * @param  array  $rules [description]
     * @return [type]        [description]
     */
    function rules_array($rules=array()){
        $result = array();
        foreach($rules as $rules_name=>$rules_list){
            foreach($rules_list as $key){
                $rules_name_detail = array_find_value_by_key($result,'field',$key,true);
                if((int)$rules_name_detail>=0){
                    $result[$rules_name_detail]['rules'] .= '|'.$rules_name;
                }else{
                    $result[] = array(
                        'field'=>$key,
                        'label'=>lang($key),
                        'rules'=>$rules_name
                    );
                }
            }
        }
        return $result;
    }

    function findCustomer($dataPost=array()){
        $dataCus = $dataPost;
        if(isset($dataPost['email'])){
            $where['email'] = trim($dataPost['email']);
            $where['is_delete'] = 0;
        }else if(isset($dataPost['phone'])){
          $where = array(
              'phone'=>trim($dataCus['phone']),
              'is_delete'=>0
            );
        }
        
        if(isset($dataCus)){
            if(isset($where)){
                $findCustomer = $this->My_model->getdetail_by_any('customer',$where);
                $dataCheckDifferent = array('fullname','phone','address');
            
                if($findCustomer!=null){
                    $dataUpdate = array();
                    foreach($dataCheckDifferent as $key){
                        if(isset($dataPost[$key])){
                            if($dataPost[$key] != $findCustomer[$key]){
                                $dataUpdate[$key] = $dataPost[$key];
                            }
                        }
                    }
                    if($dataUpdate!=null){
                        $this->db->flush_cache();
                        $dataUpdate['time_update'] = time();
                        $this->db->where('id',$findCustomer['id'])
                                 ->update('customer',$dataUpdate);
                    }
                    return $findCustomer['id'];
                }
            }    
            if(!isset($dataCus['time'])){
                $dataCus['time'] = time();
            }      
            $dataCus['is_active'] = 1;
            $customerId = $this->My_model->insert('customer',$dataCus);
            return $customerId>0?$customerId:-1;
        }
        return -1;
    }

    
    /**
     * [saveContact description]
     * @return [type] [description]
     */
    function actionSubmit(){
        if(__IS_AJAX__){
            $data_return['status'] = 'fail';
            $rules = $this->set_rules();
            $check_validation = $this->set_validation(false,$rules);
            if($check_validation!=null){
                $data_return['validation'] = $check_validation;
            }else{
                $data_return['info'] = $this->actionSuccess();
                $data_return['status'] = 'success';
            }
            echo json_encode($data_return);
        }else{
           $this->load_message();
        }
    }

    function check_unique($value,$field_name)
    {
        if($field_name!=null){
            $find_unique = $this->My_model->getdetail_by_any('customer',array($field_name=>$_POST[$field_name]));
            if($find_unique!=null){
                $this->form_validation->set_message('check_unique', '%s đã tồn tại.');
                return false;    
            }
        }
        return true;
    }

    

    function loadConfigWebsite($key){
        if(isset($this->_template['config_website'][$key])){
            return $this->_template['config_website'][$key];
        }
        return null;
    }
}
?>