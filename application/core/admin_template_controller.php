<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class admin_template_controller extends My_controller
{
    
    var $_base_view_path = 'backend/';
    var $_template = array();
    var $_base_url;
    var $_table = '';
    var $data_view =  array();
    var $_master_info = array();
    var $_checkRole = true;
    var $_adminPage = true;
    #biến để load các file html: css, js
    var $_base_url_template_admin; 
    
    #folder chứa các view admin trong folder: backend
    var $_view_folder = 'view/';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_base_url = base_url().'admin/';
        $this->_base_url_template_admin = '../template/backend';

        $this->setLoginAdmin();     
        $this->setRole();
        $this->_view_folder = $this->_base_view_path.$this->_view_folder;
        $this->load->helper(array('admin','default','array'));
        $this->load_default_data();
    }
    
    /** check and add Info admin */
    function setLoginAdmin(){
        $sessionUserLogin = $this->session->userdata('adminLogin');
        
        $this->data['user'] = null;
        if($sessionUserLogin!=null){
            if(isset($sessionUserLogin['loged_in']) && isset($sessionUserLogin['id_user'])){
                if($sessionUserLogin==true){
                    $idUser = md6_decode($sessionUserLogin['id_user']);
                    $findUser = $this->My_model->getbyid('user',$idUser);
                    if($findUser!=null){
                        if($findUser['is_active']==1 && $findUser['is_delete']==0){
                            $this->data['user'] = $findUser;
                        }
                    }
                }
            }
        }
    }
    
    /** check Role */
    function setRole(){
        $this->load->library('My_accessright',array('iduser'=>$this->data['user']['id']),'My_accessright');
        $classIgnore = array('home');
        $actionIgnore = array('login','user_ActiveResetPass','login_action','forgotpass_action','configNewpass_action');
        
        if($this->My_accessright->isAllowAction()==false
            &&in_array(CI_Router::$current_class,$classIgnore)==false
            &&in_array(CI_Router::$current_action,$actionIgnore)==false)
        {
            /** set _checkRole = false and load another view,
                view detail on load_view() */
            $this->_checkRole = false;
            if($this->data['user']==null){
                redirect('admin/home');
            }
        }
    }
    
    function load_default_data(){
        $this->lang->load('admin_default'); 
        $this->_master_info['menuleft'] = $this->menuLeft();      
    }
    
    function load_dataView_dataAction(){
        /** load default value */
        $this->data_view['script'] = true;                      /* table/include/script */
        $this->data_view['css'] = true;                         /* table/include/css */
        $this->data_view['page_js'] = true;                     /* table/include/page_js */
        $this->data_view['btnCreate'] = true;                   /* button create */
        $this->data_action['preview'] = false;                  /* action preview */
        $this->data_action['savedraft'] = false;                /* action savedraft */
        $this->data_view['cate_popup']['status'] = array();     /* table/include/script */
        $this->data_view['dataTable']['otherInfo']['table'] = $this->_table;
        
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Ẩn','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Hiện','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true)
        );
        
        
    }
    
    function dataTable_loaddefault(){
        $this->data_view['dataTable']['field_search'] = isset($this->data_view['dataTable']['field_search'])?$this->data_view['dataTable']['field_search']:'title';
        $this->data_view['dataTable']['limit'] = array(10,20,50,100);
        $limit = $this->session->userdata($this->_table.'_limit')==null?10:$this->session->userdata($this->_table.'_limit');
        $this->data_view['dataTable']['limit_val'] = $limit;
        
        $session_sort = $this->getSortbyDatatable();
        $this->data_view['dataTable']['field_sort']['name'] = $session_sort['name'];
        $this->data_view['dataTable']['field_sort']['status'] = $session_sort['status'];
        $this->data_view['dataTable']['export'] = array('print'=>true,'pdf'=>true,'csv'=>true);
        $this->data_view['dataTable']['column_html'] = $this->load->view($this->_base_view_path.'view/include/pageList/column',null,true);
        $this->data_view['dataTable']['export_html'] = $this->load->view($this->_base_view_path.'view/include/pageList/export',null,true);
        $this->data_view['dataTable']['limit_html'] = $this->load->view($this->_base_view_path.'view/include/pageList/limit',null,true);
        $this->data_view['dataTable']['thead_html'] = $this->load->view($this->_base_view_path.'view/include/pageList/thead',null,true);
        
    }
    
    /** Load breadcrumb */
    function load_breadcrumb($breadcrumb=null){
        $data['breadcrumb'] = array(
            array('title'=>lang('home/index'),'alias'=>''),
            array('title'=>lang($this->_table),'alias'=>$this->_table)
        );
        if($breadcrumb){
            $data['breadcrumb'][] = array('title'=>lang($breadcrumb),'alias'=>$breadcrumb);   
        }
        $this->data_view['breadcrumb'] = $this->load->view($this->_base_view_path.'view/include/pageList/breadcrumb',$data,true);
    }
    
    /** page list */
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
            'cur_tag_open'  =>   '<li class="active"><a href="javascript:;">', //trạng thái active
            'cur_tag_close' =>   '</a></li>',
            'num_tag_open'  =>   '<li>',
            'num_tag_close' =>   '</li>',
            'first_tag_open' =>  '<li>',
            'first_tag_close'=>  '</li>',
            'next_tag_open' =>   '<li class="next">',
            'next_tag_close'=>   '</li>',
            'prev_tag_open' =>   '<li class="prev">',
            'prev_tag_close'=>   '</li>',
            'last_tag_open' =>   '<li>',
            'last_tag_close'=>   '</li>',
            'per_page'      =>   $limit,
            'first_link'    =>   '<i class="fa fa-angle-double-left"></i>',
            'last_link'     =>   '<i class="fa fa-angle-double-right"></i>',
            'next_link'     =>   '<i class="fa fa-angle-right"></i>',
            'prev_link'     =>   '<i class="fa fa-angle-left"></i>',
            'num_links'     =>   5,
            'full_tag_open' =>   '<div class="dataTables_paginate paging_bootstrap_full_number"><ul class="pagination">',
            'full_tag_close'=>   '</ul></div>',
            'page_query_string'=>TRUE
        );
        $this->Pager->initialize($pageConfig);
        return $this->Pager->create_links();
    }
    
    /** Menu left */
    function menuLeft(){
        $result = array(
            ''=>array('title'=>'Bảng điều khiển','icon'=>'icon-home','show'=>true),
            'order'=>array('title'=>'Đơn hàng','icon'=>'icon-basket','show'=>true),
            'product'=>array('title'=>'Sản phẩm','icon'=>'icon-note','show'=>true),
            'product_buy_together'=>array('title'=>'Sản phẩm mua kèm','icon'=>'icon-note','show'=>true),
            'product_color'=>array('title'=>'Màu sắc','icon'=>'icon-note','show'=>true),
            'product_size'=>array('title'=>'Kích thước','icon'=>'icon-note','show'=>true),
            'coupon'=>array('title'=>'Mã giảm giá','icon'=>'icon-note','show'=>true),
            'sale'=>array('title'=>'Chương trình giảm giá','icon'=>'icon-note','show'=>true),
            'ship_fee'=>array('title'=>'Phí Giao hàng','icon'=>'icon-refresh','show'=>true),
            'category/product'=>array('title'=>'Danh mục sản phẩm','icon'=>'icon-folder-alt','show'=>true),
            'customer'=>array('title'=>'Khách hàng','icon'=>'icon-users','show'=>true),
            'article'=>array('title'=>'Bài viết','icon'=>'icon-note','show'=>true),
            'article_one'=>array('title'=>'Bài viết tĩnh','icon'=>'icon-note','show'=>true),
            'category/article'=>array('title'=>'Danh mục bài viết','icon'=>'icon-folder-alt','show'=>true),
            'comment'=>array('title'=>'Bình luận','icon'=>'icon-bubbles','show'=>true),
            'contact'=>array('title'=>'Liên hệ','icon'=>'icon-envelope-open','show'=>true),
            'slide'=>array('title'=>'Trình chiếu','icon'=>'icon-refresh','show'=>true),
            'category'=>array('title'=>'Menu','icon'=>'icon-folder-alt','show'=>true),
            'config'=>array('title'=>'Cấu hình','icon'=>'icon-settings ','show'=>true),
            'user'=>array('title'=>'Quản trị viên','icon'=>'icon-user','show'=>true)
        );
        
        $result['order']['child'] = array(
            'inbox'=>array('title'=>'Mới','icon'=>'icon-puzzle'),
            'confirmed'=>array('title'=>'Đã xác nhận','icon'=>'icon-puzzle'),
            'nopayment'=>array('title'=>'Chưa thanh toán','icon'=>'icon-puzzle'),
            'noship'=>array('title'=>'Đã thanh toán chưa gửi hàng','icon'=>'icon-puzzle'),
            'finish'=>array('title'=>'Bị hoàn tất','icon'=>'icon-puzzle'),
            'returns'=>array('title'=>'Bị hoàn trả','icon'=>'icon-puzzle'),
            'cancel'=>array('title'=>'Bị hủy','icon'=>'icon-puzzle'),
            'finish'=>array('title'=>'Đã hoàn tất','icon'=>'icon-puzzle'),
            ''=>array('title'=>'Tất cả','icon'=>'icon-puzzle'),
            'search'=>array('title'=>'Tìm kiếm','icon'=>'icon-puzzle'),
        );
        
        $result['product']['child'] = array(
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle'),
            'index'=>array('title'=>'Danh sách','icon'=>'icon-puzzle'),
            //'#'=>array('title'=>'Khuyến mãi/giảm giá','icon'=>'icon-puzzle'),
            '/comment/product'=>array('title'=>'Bình luận','icon'=>'icon-puzzle'),
            'search'=>array('title'=>'Tìm kiếm','icon'=>'icon-puzzle')
        );

        $result['coupon']['child'] = array(
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle'),
            'index'=>array('title'=>'Danh sách','icon'=>'icon-puzzle')
        );

        $result['ship_fee']['child'] = array(
            'create'=>array('title'=>'Thêm Khu vực','icon'=>'icon-puzzle'),
            'index'=>array('title'=>'Danh sách','icon'=>'icon-puzzle')
        );

        $result['sale']['child'] = array(
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle'),
            'index'=>array('title'=>'Danh sách','icon'=>'icon-puzzle')
        );
        
        $result['customer']['child'] = array(
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle'),
            'index'=>array('title'=>'Danh sách','icon'=>'icon-puzzle'),
            'search'=>array('title'=>'Tìm kiếm','icon'=>'icon-puzzle')
        );
        
        $result['article']['child'] = array(
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle'),
            'index'=>array('title'=>'Danh sách','icon'=>'icon-puzzle'),
            '/comment/article'=>array('title'=>'Bình luận','icon'=>'icon-puzzle'),
            'search'=>array('title'=>'Tìm kiếm','icon'=>'icon-puzzle')
        );
        
        $result['comment']['child'] = array(
            'inbox'=>array('title'=>'Mới','icon'=>'icon-puzzle'),
            'noreply'=>array('title'=>'Chưa phản hồi','icon'=>'icon-puzzle'),
            'product'=>array('title'=>'Thuộc sản phẩm','icon'=>'icon-puzzle'),
            'article'=>array('title'=>'Thuộc bài viết','icon'=>'icon-puzzle'),
            ''=>array('title'=>'Tất cả','icon'=>'icon-puzzle')
        );
        
        $result['contact']['child'] = array(
            'inbox'=>array('title'=>'Mới','icon'=>'icon-puzzle'),
            'noreply'=>array('title'=>'Chưa phản hồi','icon'=>'icon-puzzle'),
            ''=>array('title'=>'Tất cả','icon'=>'icon-puzzle')
        );
        
        $result['slide']['child'] = array(
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle'),
            ''=>array('title'=>'Danh sách','icon'=>'icon-puzzle')
        );
        
        $result['slide']['config'] = array(
            '#'=>array('title'=>'Cấu hình chung','icon'=>'icon-puzzle'),
            '#'=>array('title'=>'Thông tin liên hệ','icon'=>'icon-puzzle'),
            '#'=>array('title'=>'SEO','icon'=>'icon-puzzle'),
            '#'=>array('title'=>'Thông báo','icon'=>'icon-puzzle')
        );
        
        $result['user']['child'] = array(
            ''=>array('title'=>'Danh sách','icon'=>'icon-puzzle'),
            'create'=>array('title'=>'Thêm mới','icon'=>'icon-puzzle')
        );
        
        return $result;
    }
    
}
?>