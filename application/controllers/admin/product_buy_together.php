<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Product_buy_together extends admin_basic_controller
{
    var $_table = 'product_buy_together';
    public function __construct()
    {
        $this->data_view['dataTable']['field_search'] = false;
        parent::__construct();
        $this->load->model('M_product');
        $this->load->model('M_product_buy_together');

    }

    /** check and load view detail */
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
                //'tag_complete'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1)),
            );  
        }else if($view=='create'){
            $data = array(
                'product'=>$this->M_product->getlist('product',array('is_delete'=>0),0,999,'id asc')
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_product_buy_together->detail_Backend($variable['id']),
                'product'=>$this->M_product->getlist('product',array('is_delete'=>0),0,999,'id asc')
            );  
            if($data['detail']==null){
                $this->load_message();
                return;
            }
            $view = 'create';
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }

    /** get list data of table */
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
        $total_row = $this->M_product_buy_together->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_product_buy_together->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }

    /** load thead on table */
    function listPage_tableField(){
        /**
         * name: field on query
         * title: text for show on thead
         * type: type of text
         *     image: show image with <img />
         *     number: show with number_format
         *     status: show with true / false
         * linkDetail: (true/false)
         *     true: show a link detail with: table/edit/{id}
         *     false: not show link 
         * hidden: (true/false)
         *     true: hidden
         *     false or null: for show
         */
            
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'pro_main_title','title'=>'Sản phẩm chính','linkDetail'=>true),
            array('name'=>'pro_relative_title','title'=>'Sản phẩm mua kèm','linkDetail'=>true),
            array('name'=>'price_sale','title'=>'Giá bán','type'=>'number'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    function set_rules(){
        $rules['required'] = 
            array('id_pro_main','id_pro_relative','price_sale');
        $rules['callback_check_nomatches['.$this->input->post('id_pro_main').']'] = 
            array('id_pro_relative');
        $rules['callback_check_uniquePro['.$this->input->post('id_pro_main').']'] = 
            array('id_pro_relative');
        $rules['numeric'] = 
            array('price_sale','promotion');
        $rules['callback_check_equal_greate[0]'] = 
            array('price_sale','promotion');
        if(isset($_POST['price'])){
            if($_POST['price']){
                $rules['callback_check_price_less['.$_POST['price'].']'] = 
                    array('price_sale');
            }
        }
        
        $rules['callback_check_equal_less[100]'] = 
            array('promotion');
            
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }

    /** check unique between id_product_main and id_product_relative */
    function check_uniquePro($second_field,$first_field)
    {
        $second_field = (double)$second_field;
        $first_field = (double)$first_field;
        $where = array(
            'id_pro_main'=>$first_field,
            'id_pro_relative'=>$second_field,
            'is_delete'=>0
        );
        /** check if form is edit */
        if($_POST['type_action']=='edit'){
            $where['id <>'] = $_POST['id'];
        }
        $findProRelative = $this->My_model->getdetail_by_any($this->_table,$where);
        if($findProRelative){
            $linkDetail = 'product_buy_together/edit/'.$findProRelative['id'];
            $this->form_validation->set_message('check_uniquePro', "%s đã tồn tại, <a target=\"_blank\" href=\"$linkDetail\">xem chi tiết</a>.");
            return false;       
        }
        else
        {
            return true;
        }
    }

    /** form submit action: create, edit */
    function action($type=''){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $check_validation = $this->set_validation(true);
                if($check_validation==false){
                    $data_return['info'] = 'validation fail';
                }else{
                    $type_action = $_POST['type_action'];
                    unset($_POST['type_action'],$_POST['set_alias'],$_POST['price']);
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
    
    function check_price_less($second_field,$first_field)
    {
        if ((double)$second_field != 0 && (double)$second_field > (double)$first_field)
        {
            $first_field = number_format($first_field,0,'.','.');
            $this->form_validation->set_message('check_price_less', "%s phải nhỏ hơn giá bán hiện tại. Giá hiện tại: $first_field .");
            return false;       
        }
        else
        {
            return true;
        }
    }
}
?>