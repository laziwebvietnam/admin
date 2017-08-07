<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Product extends admin_basic_controller
{
    var $data_view = array();
    var $_table = 'product';
    var $_property = true;
    public function __construct()
    {
        parent::__construct();
        /** Config */
        
        $this->data_view['cate_popup']['status'] = array('is_special','is_new','is_promotion','is_stock','is_draft','is_active');
        $this->data_view['dataCreate']['alias'] = true;
        $this->data_action['preview'] = true;
        $this->data_action['savedraft'] = true;
        $this->_createSeoData = true;
        $this->_createTagData = true;
        
        /** Load model */
        $this->load->model('M_product');
        $this->load->model('M_tags');
        $this->load->model('M_comment');
        $this->load->model('M_product_buy_together');
        $this->load->model('M_product_property');
    }
    
    function search(){
        $this->index('search');
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
                'tag_complete'=>$this->M_tags->getListByType('product',array('ts.is_active'=>1)),
                'category'=>$this->My_model->getlist('category',array('type'=>'product'),0,999,'position asc')
            );  
        }else if($view=='create'){
            $data = array(
                'category'=>$this->My_model->getlist('category',array('type'=>'product'),0,999,'position asc'),
                'tag_complete'=>$this->My_model->getlist('tags',array('is_active'=>1,'is_delete'=>0)),
                'tag_suggest'=>$this->M_tags->getListByType('product',array('ts.is_active'=>1),0,5),
                'pro_color'=>$this->My_model->getlist('product_color',array('is_active'=>1,'is_delete'=>0)),
                'pro_size'=>$this->My_model->getlist('product_size',array('is_active'=>1,'is_delete'=>0)),
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_product->detail_Backend($variable['id']),
                'seo'=>$this->My_model->getdetail_by_any('seo',array('data_id'=>$variable['id'],'data_table'=>$this->_table)),
                'tag_complete'=>$this->M_tags->getListByType($this->_table),
                'tag_selected'=>$this->M_tags->getListByType($this->_table,array('t.id_'.$this->_table=>$variable['id'])),
                'category'=>$this->My_model->getlist('category',array('type'=>'product'),0,999,'position asc'),
                'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
                'product_buy_together'=>$this->M_product_buy_together->getListByIdpro($variable['id']),
                'pro_color'=>$this->My_model->getlist('product_color',array('is_active'=>1,'is_delete'=>0)),
                'pro_size'=>$this->My_model->getlist('product_size',array('is_active'=>1,'is_delete'=>0)),
                'pro_property'=>$this->M_product_property->getProperty_detail($variable['id'])
            );  
            // echo '<pre>';
            // print_r($data['pro_property']);exit;

            if($data['detail']==null){
                $this->load_message('404');
                return;
            }
            $view = 'create';
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
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
        $total_row = $this->M_product->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_product->get_all($where,$start,$limit,$order_by);
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
            array('name'=>'image','title'=>'Hình','type'=>'image','linkDetail'=>true),
            array('name'=>'title','title'=>'Tên','linkDetail'=>true),
            array('name'=>'c_title','title'=>'Loại'),
            array('name'=>'price','title'=>'Giá','type'=>'number'),
            array('name'=>'price_promotion','title'=>'Giá giảm','type'=>'number','hidden'=>true),
            array('name'=>'views','title'=>'Lượt xem','type'=>'number'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status'),
            array('name'=>'is_stock','title'=>'Còn hàng','type'=>'status','hidden'=>true),
            array('name'=>'is_special','title'=>'Nổi bật','type'=>'status','hidden'=>true)
        );
    }
    
    /** quickAction when select id */
    function listPage_quickAction(){
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Ẩn','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Hiện','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true),
            array('action'=>$this->_table.'/tag_popup/create','title'=>'Thêm tag','popup'=>true),
            array('action'=>$this->_table.'/tag_popup/delete','title'=>'Xóa tag','popup'=>true),
            array('action'=>$this->_table.'/cate_popup/create','title'=>'Thêm vào danh mục','popup'=>true),
            array('action'=>$this->_table.'/cate_popup/delete','title'=>'Xóa khỏi danh mục','popup'=>true),
        );
    }
    
    /** array all field */
    public function set_field_for_ajax_search()
    {
        /** type: text, select, tag, checked */
        $array = array(
            array('type'=>'text','name'=>'title','field_search'=>'tb.title'),                
            array('type'=>'number','name'=>'price','field_search'=>'price >='),       
            array('type'=>'number','name'=>'min_price','field_search'=>'price >='),  
            array('type'=>'number','name'=>'max_price','field_search'=>'price <='), 
            array('type'=>'select','name'=>'id_category','field_search'=>'id_category'),         
            array('type'=>'checked','name'=>'is_special','field_search'=>'is_special'),      
            array('type'=>'checked','name'=>'is_new','field_search'=>'is_new'),      
            array('type'=>'checked','name'=>'is_promotion','field_search'=>'is_promotion'),      
            array('type'=>'checked','name'=>'is_stock','field_search'=>'is_stock'),      
            array('type'=>'checked','name'=>'is_active','field_search'=>'tb.is_active'),   
            array('type'=>'tag','name'=>'id_tag','field_search'=>'tag'),          
        );
        
        return $array;
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','alias',
                  'en_title','en_alias','id_category');
        $rules['numeric'] = 
            array('price','price_promotion','quantity');
        $rules['greater_than[0]'] = 
            array('price');
        $rules['callback_check_equal_less['.$this->input->post('price').']'] = 
            array('price_promotion');
        $rules['callback_check_equal_greate['.$this->input->post('price_promotion').']'] =
            array('price');

        if($this->_property==true){
            $rules['numeric'][] = 'price_size[]';
        }
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }

    function getPriceByPro($idPro=null){
        $data_return = array();
        $data_return['status'] = 'fail';

        $detailPro = $this->M_product->getDetailByField('id',$idPro);
        
        if($detailPro){
            $data_return['price'] = $detailPro['price_result'];
            $data_return['price_text'] = number_format($detailPro['price_result'],0,'.','.').'đ';
            $data_return['status'] = 'success';
        }else{
            $data_return['log'] = 'Product is not found';
        }
        echo json_encode($data_return);
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
                    
                    $data = $_POST;
                    unset($data['type_action'],$data['set_alias'],$data['pro_size'],$data['price_size']);
                    /**
                     * set default value
                     * example: $data['images'] = implode($data['images'],'||');
                     */
                    if(isset($data['images'])){
                        $data['images'] = is_array($data['images'])==true?$data['images']:array($data['images']);
                        $data['images'] = implode($data['images'],'||');
                    }

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
                    $this->M_product->updatePropertyInfo($data_id);

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

    function addProperty($proSizeId){
        if(__IS_AJAX__){
            $data['pro_size_id'] = $proSizeId;
            $data['pro_size'] = $this->My_model->getlist('product_size',array('is_active'=>1,'is_delete'=>0));
            $data_return = array();

            // if($data['pro_size']){
                $data_return['html'] = $this->load->view($this->_base_view_path.'view/product/load/ajax_addProperty',$data,true);
                $data_return['status'] = 'success';
            // }        

            echo json_encode($data_return);
        }else{
            $this->load_message();
        }
    }


}
?>