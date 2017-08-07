<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class user_role extends admin_basic_controller
{
    var $_table = 'user_role';
    public function __construct()
    {
        parent::__construct();
        /** Config */
        $this->data_view['cate_popup']['status'] = array('is_active');
        $this->data_view['dataCreate']['alias'] = false;
        /** Load model */
        $this->load->model('M_user_role');
        
    }
    
    function index($view='index'){
        $this->_index($view);
    }
    
    function search(){
        $this->index('search');
    }
    
    function create(){
        //$this->load_message('404');return;
        $this->_index('create');
    }   
    
    function editInfo($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('editInfo',$data);
    }

    function edit($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('edit',$data);
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
                'list' => null,
                'user_role' => $this->My_model->getlist($this->_table,array('id <>'=>1,'is_delete'=>0),0,10,'id asc'),
                'detail' => null
            );   
        }else if($view=='edit'){
            $data = array(
                'list' => $this->loadList(),
                'user_role' => $this->My_model->getlist($this->_table,array('id <>'=>1,'is_delete'=>0),0,10,'id asc'),
                'detail' => $this->M_user_role->detail_Backend($variable['id'])
            );   
            if($data['detail']==null){
                $this->load_message();
            }
            $view='index';
        }
        else if($view=='editInfo'){
            $data = array(
                'list' => $this->loadList(),
                'user_role' => $this->My_model->getlist($this->_table,array('id <>'=>1,'is_delete'=>0),0,10,'id asc'),
                'detail' => $this->M_user_role->detail_Backend($variable['id'])
            );   
            if($data['detail']==null){
                $this->load_message();
            }
            $view='create';
        }
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function loadList(){
        $data_return = array(
            'default' => array(
                    'user/popup_info' => 'Thông tin tài khoản',
                    'user/popup_changepass' => 'Đổi mật khẩu',
                ),
            'notification' => array(
                    'notification/index' => 'Danh sách',
                    'notification/exportByPrint' => 'In',
                    'notification/exportByCsv' => 'Xuất file CSV'
                ),
            'order' => array(
                    'order/index' => 'Danh sách',
                    'order/inbox' => 'Mới',
                    'order/confirmed' => 'Đã xác nhận',
                    'order/nopayment' => 'Chưa thanh toán',
                    'order/noship' => 'Chưa gửi hàng',
                    'order/finish' => 'Đã hoàn tất',
                    'order/returns' => 'Bị hoàn trả',
                    'order/cancel' => 'Bị hủy',
                    'order/edit' => 'Sửa',
                    'order/delete_popup' => 'Xóa',
                    'order/set_status' => 'Cập nhật trạng thái',
                    'order/set_statusByGET' => 'Cập nhật trạng thái',
                    'order/search' => 'Tìm kiếm',
                    'order/exportByPrint' => 'In',
                    'order/exportByCsv' => 'Xuất file CSV',
                    'order/restore' => 'Khôi phục dữ liệu'
                ),
            'category' => array(
                    'category/index' => 'Danh sách',
                    'category/product' => 'Danh mục sản phẩm',
                    'category/article' => 'Danh mục bài viết',
                    'category/create' => 'Thêm',
                    'category/edit' => 'Sửa',
                    'category/delete_once_popup' => 'Xóa',
                    'category/change_position' => 'Cập nhật vị trí',
                    'category/restore' => 'Khôi phục dữ liệu'
                ),
            'product' => array(
                    'product/index' => 'Danh sách',
                    'product/create' => 'Thêm',
                    'product/edit' => 'Sửa',
                    'product/delete_popup' => 'Xóa',
                    'product/search' => 'Trang tìm kiếm',
                    'product/exportByPrint' => 'In',
                    'product/exportByCsv' => 'Xuất file CSV',
                    'product/set_status' => 'Cập nhật nhanh trạng thái',
                    'product/tag_popup' => 'Cập nhật tag',
                    'product/cate_popup' => 'Cập nhật danh mục',
                    'product/restore' => 'Khôi phục dữ liệu'
                ),
            'product_color' => array(
                    'product_color/index' => 'Danh sách',
                    'product_color/create' => 'Thêm',
                    'product_color/edit' => 'Sửa',
                    'product_color/delete_popup' => 'Xóa',
                    'product_color/search' => 'Trang tìm kiếm',
                    'product_color/exportByPrint' => 'In',
                    'product_color/exportByCsv' => 'Xuất file CSV',
                    'product_color/set_status' => 'Cập nhật nhanh trạng thái',
                    'product_color/tag_popup' => 'Cập nhật tag',
                    'product_color/restore' => 'Khôi phục dữ liệu'
                ),
            'product_size' => array(
                    'product_size/index' => 'Danh sách',
                    'product_size/create' => 'Thêm',
                    'product_size/edit' => 'Sửa',
                    'product_size/delete_popup' => 'Xóa',
                    'product_size/search' => 'Trang tìm kiếm',
                    'product_size/exportByPrint' => 'In',
                    'product_size/exportByCsv' => 'Xuất file CSV',
                    'product_size/set_status' => 'Cập nhật nhanh trạng thái',
                    'product_size/tag_popup' => 'Cập nhật tag',
                    'product_size/restore' => 'Khôi phục dữ liệu'
                ),
            'coupon' => array(
                    'coupon/index' => 'Danh sách',
                    'coupon/create' => 'Thêm',
                    'coupon/edit' => 'Sửa',
                    'coupon/delete_popup' => 'Xóa',
                    'coupon/search' => 'Trang tìm kiếm',
                    'coupon/exportByPrint' => 'In',
                    'coupon/exportByCsv' => 'Xuất file CSV',
                    'coupon/set_status' => 'Cập nhật nhanh trạng thái',
                    'coupon/restore' => 'Khôi phục dữ liệu'
                ),
            'sale' => array(
                    'sale/index' => 'Danh sách',
                    'sale/create' => 'Thêm',
                    'sale/edit' => 'Sửa',
                    'sale/delete_popup' => 'Xóa',
                    'sale/search' => 'Trang tìm kiếm',
                    'sale/exportByPrint' => 'In',
                    'sale/exportByCsv' => 'Xuất file CSV',
                    'sale/set_status' => 'Cập nhật nhanh trạng thái',
                    'sale/restore' => 'Khôi phục dữ liệu'
                ),
            'ship_fee' => array(
                    'ship_fee/default_fee' => 'Phí Mặc định',
                    'ship_fee/index' => 'Danh sách',
                    'ship_fee/create' => 'Thêm',
                    'ship_fee/edit' => 'Sửa',
                    'ship_fee/delete_popup' => 'Xóa',
                    'ship_fee/search' => 'Trang tìm kiếm',
                    'ship_fee/exportByPrint' => 'In',
                    'ship_fee/exportByCsv' => 'Xuất file CSV',
                    'ship_fee/set_status' => 'Cập nhật nhanh trạng thái',
                    'ship_fee/restore' => 'Khôi phục dữ liệu'
                ),
            'customer' => array(
                    'customer/index' => 'Danh sách',
                    'customer/create' => 'Thêm',
                    'customer/edit' => 'Sửa',
                    'customer/delete_popup' => 'Xóa',
                    'customer/search' => 'Trang tìm kiếm',
                    'customer/exportByPrint' => 'In',
                    'customer/exportByCsv' => 'Xuất file CSV',
                    'customer/set_status' => 'Cập nhật nhanh trạng thái',
                    'customer/restore' => 'Khôi phục dữ liệu'
                ),
            'article' => array(
                    'article/index' => 'Danh sách',
                    'article/create' => 'Thêm',
                    'article/edit' => 'Sửa',
                    'article/delete_popup' => 'Xóa',
                    'article/search' => 'Trang tìm kiếm',
                    'article/exportByPrint' => 'In',
                    'article/exportByCsv' => 'Xuất file CSV',
                    'article/set_status' => 'Cập nhật nhanh trạng thái',
                    'article/tag_popup' => 'Cập nhật tag',
                    'article/cate_popup' => 'Cập nhật danh mục',
                    'article/restore' => 'Khôi phục dữ liệu'
                ),
            'article_one' => array(
                    'article_one/index' => 'Danh sách',
                    'article_one/create' => 'Thêm',
                    'article_one/edit' => 'Sửa',
                    'article_one/delete_popup' => 'Xóa',
                    'article_one/search' => 'Trang tìm kiếm',
                    'article_one/exportByPrint' => 'In',
                    'article_one/exportByCsv' => 'Xuất file CSV',
                    'article_one/set_status' => 'Cập nhật nhanh trạng thái',
                    'article_one/tag_popup' => 'Cập nhật tag',
                    'article_one/cate_popup' => 'Cập nhật danh mục',
                    'article_one/restore' => 'Khôi phục dữ liệu'
                ),
            'comment' => array(
                    'comment/index' => 'Xem tất cả',
                    'comment/inbox' => 'Bình luận mới',
                    'comment/noreply' => 'Chưa phản hồi',
                    'comment/product' => 'Thuộc sản phẩm',
                    'comment/article' => 'Thuộc bài viết',
                    'comment/delete' => 'Đã xóa',
                    'comment/reply' => 'Đã phản hồi',
                    'comment/popup_detail' => 'Chi tiết (popup)',
                    'comment/popup_reply' => 'Phản hồi (popup)',
                    // 'comment/create' => 'Thêm',
                    // 'comment/edit' => 'Sửa',
                    'comment/delete_popup' => 'Xóa',
                    // 'comment/search' => 'Trang tìm kiếm',
                    'comment/exportByPrint' => 'In',
                    'comment/exportByCsv' => 'Xuất file CSV',
                    'comment/set_status' => 'Cập nhật nhanh trạng thái',
                    'comment/restore' => 'Khôi phục dữ liệu'
                ),
            'contact' => array(
                    'contact/index' => 'Xem tất cả',
                    'contact/inbox' => 'Liên hệ mới',
                    'contact/noreply' => 'Chưa phản hồi',
                    'contact/delete' => 'Đã xóa',
                    'contact/reply' => 'Đã phản hồi',
                    'contact/readContact' => 'Xem chi tiết',
                    'contact/replyContact' => 'Phản hồi',
                    // 'contact/create' => 'Thêm',
                    // 'contact/edit' => 'Sửa',
                    'contact/delete_once_popup' => 'Xóa',
                    'contact/delete_popup' => 'Xóa',
                    // 'contact/search' => 'Trang tìm kiếm',
                    'contact/exportByPrint' => 'In',
                    'contact/exportByCsv' => 'Xuất file CSV',
                    'contact/set_status' => 'Cập nhật nhanh trạng thái',
                    'contact/set_statusByGET' => 'Cập nhật trạng thái trang chi tiết',
                    'contact/restore' => 'Khôi phục dữ liệu'
                ),
            'slide' => array(
                    'slide/index' => 'Danh sách',
                    'slide/create' => 'Thêm',
                    'slide/edit' => 'Sửa',
                    'slide/delete_popup' => 'Xóa',
                    'slide/search' => 'Trang tìm kiếm',
                    'slide/exportByPrint' => 'In',
                    'slide/exportByCsv' => 'Xuất file CSV',
                    'slide/set_status' => 'Cập nhật nhanh trạng thái',
                    'slide/restore' => 'Khôi phục dữ liệu'
                ),
            'config' => array(
                    'config/index' => 'Cập nhật',
                ),
            'user' => array(
                    'user/index' => 'Danh sách',
                    'user/create' => 'Thêm',
                    'user/edit' => 'Sửa',
                    'user/delete_popup' => 'Xóa',
                    'user/exportByPrint' => 'In',
                    'user/exportByCsv' => 'Xuất file CSV',
                    'user/set_status' => 'Cập nhật nhanh trạng thái',
                    'user/restore' => 'Khôi phục dữ liệu'
                ),
            'user_role' => array(
                    'user_role/index' => 'Danh sách',
                    'user_role/create' => 'Thêm',
                    'user_role/edit' => 'Sửa',
                    'user_role/editInfo' => 'Sửa info',
                    'user_role/delete_once_popup' => 'Xóa',
                    'user_role/exportByPrint' => 'In'
                )           
        );
        
        return $data_return;
    }
    
    function action($type=''){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $check_validation = $this->set_validation(true);
                if($check_validation==false){
                    $data_return['info'] = 'validation fail';
                }else{
                    $type_action = $_POST['type_action'];
                    unset($_POST['type_action'],$_POST['set_alias'],$_POST['id_role_select']);
                     $data = $_POST;
                    /**
                     * set default value
                     * example: $data['images'] = implode($data['images'],'||');
                     */

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
    
    function set_rules(){
        $rules = array();
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
}
?>