<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Sale extends admin_basic_controller
{
    var $_table = 'sale';
    public function __construct()
    {
        // $this->data_view['dataTable']['field_search'] = 'code';
        parent::__construct();

        $this->load->model('M_sale');
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','value','type');
        $rules['is_numeric'] = 
            array('value');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */

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
                //'tag_complete'=>$this->My_model->getlist('tags',array('is_active'=>1,'is_delete'=>0)),
                // 'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_sale->detail_Backend($variable['id']),
                'products' => $this->My_model->getlist('product', array(
                    'is_delete' => 0,
                    'id_sale' => $variable['id']
                ))
                // 'tag_complete'=>$this->M_tags->getListByType($this->_table),
                // 'tag_selected'=>$this->M_tags->getListByType($this->_table,array('t.id_'.$this->_table=>$variable['id'])),
                // 'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
            );  
            if($data['detail']==null){
                $this->load_message();
                return;
            }
            $view = 'create';
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }

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
            array('name'=>'title','title'=>'Tên chương trình','linkDetail'=>true),
            array('name'=>'type','title'=>'Loại'),
            array('name'=>'value','title'=>'Giá trị'),
            array('name'=>'time_start','title'=>'Ngày áp dụng','type'=>'time'),
            array('name'=>'time_end','title'=>'Ngày hết hạn','type'=>'time'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }

    function addProduct() {
        $where = array(
            'products' => array(
                'is_delete' => 0,
            ),
        );
        $data = array(
            'products'=>$this->My_model->getlist('product',$where['products']),
        );
        $this->load->view($this->_base_view_path . 'view/sale/load/ajax_addProduct',$data);
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
                    unset($_POST['type_action'],$_POST['set_alias']);
                     $data = $_POST;
                    /**
                     * set default value
                     * example: $data['images'] = implode($data['images'],'||');
                     */
                    $data['time_start'] = strtotime($data['time_start']);
                    $data['time_end'] = strtotime($data['time_end']);

                    if ($data['id']) {
                        $products_remove = $this->My_model->getlist('product', array(
                            'is_delete' => 0,
                            'id_sale' => $data['id']
                        ));

                        if ($products_remove) {
                            foreach ($products_remove as $key => $product) {
                                $product['id_sale'] = 0;
                                $this->My_model->update('product', $product);
                            }
                        }
                    }

                    $products = array();
                    if (isset($data['products'])) {
                        $products = $data['products'];
                        unset($data['products']);
                    }

                    /** end set default value */

                    if($type_action=='create'){
                        
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
                        if ($products) {
                            $products = array_unique(array_filter($products));

                            foreach ($products as $key => $md6_id) {
                                $product = $this->My_model->getdetail_by_any('product', array(
                                    'is_delete' => 0,
                                    'id' => md6_decode($md6_id)
                                ));

                                if ($product) {
                                    $product['id_sale'] = $data_id;
                                    $this->My_model->update('product', $product);
                                }
                            }
                        }

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
}
?>