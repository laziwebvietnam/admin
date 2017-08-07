<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Tags extends admin_action_controller
{
    public function __construct()
    {
        parent::__construct();
        /** Config */
        $this->_table = 'tags';
        $this->lang->load('admin_tags');  
        $this->load_dataView_dataAction();    
        $this->listPage_tableField();
        $this->listPage_quickAction();
        $this->listPage_otherInfo(); 
        $this->dataTable_loaddefault();   
        $this->data_view['cate_popup']['status'] = array('is_active');
        $this->data_view['dataCreate']['alias'] = true;
        $this->data_view['btnCreate'] = false;
        
        /** Load model */
        $this->load->model('M_tags');
        
    }
    
    function index($view='index'){
        $this->_index($view);
    }
    
    function product(){
        $this->_index('byTypeProduct',array('type'=>'product'));
    }
    
    function article(){
        $this->_index('byTypeArticle',array('type'=>'article'));
    }
    
    function search(){
        $this->load_message();
        $this->index('search');
    }
    
    function create(){
        
        $this->_index('create');
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
                'list'=>$this->listPage_data()
            );   
        }else if($view=='byTypeProduct'){
            $byType = isset($variable['type'])?$variable['type']:'product';
            $data = array(
                'list'=>$this->listPageByType($byType)
            );
            $view = 'byType';
        }else if($view=='byTypeArticle'){
            $byType = isset($variable['type'])?$variable['type']:'product';
            $data = array(
                'list'=>$this->listPageByType($byType)
            );
            $view = 'byType';
        }
        else if($view=='search'){
            $data = array(
                'list'=>$this->listPage_data('search')
            );  
        }else if($view=='create'){
            $data = array(
            
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_tags->detail_Backend($variable['id']),
                'seo'=>$this->My_model->getdetail_by_any('seo',array('data_id'=>$variable['id'],'data_table'=>$this->_table))
            );  
            if($data['detail']==null){
                $this->load_message();
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
        $total_row = $this->M_tags->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_tags->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }
    
    /** List data by Type */
    function listPageByType($type='product'){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array('ts.is_delete'=>0);
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
        $total_row = $this->M_tags->getListByType($type,$where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_tags->getListByType($type,$where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list)-1,
            'order_by'=>$order_by
        );
        
        return $data_return;
    }
    
    /** note something for view list Datatable  */
    function listPage_otherInfo(){
        $this->data_view['dataTable']['otherInfo']['status'] = array(
            /*
            'is_active'=>array(
                '0'=>'label label-sm label-warning',
                '1'=>'label label-sm label-warning'
            )
            */
        );
    }
    
    /** thead & column show/hide */
    function listPage_tableField(){
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'title','title'=>'Tên','linkDetail'=>true),
            array('name'=>'alias','title'=>'Link'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    /** quickAction when select id */
    function listPage_quickAction(){
        /*
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Ẩn','popup'=>false),
            array('action'=>$this->_table.'/delete_popup','title'=>'Xóa','popup'=>true)
        );
        */
    }
    
    /** array all field */
    public function set_field_for_ajax_search()
    {
        /** type: text, select, tag, checked */
        $array = array(
            array('type'=>'text','name'=>'title','field_search'=>'title'),   
            array('type'=>'checked','name'=>'is_active','field_search'=>'tb.is_active') 
        );
        
        return $array;
    }
    
    /** ACTION */
    function set_validation($return_bool=false){
        if($_POST){
            $rules = $this->set_rules();
            $this->form_validation->set_rules($rules);            
            $error = array();
            if($this->form_validation->run()==false){
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
            /** when not ajax */
            echo json_encode($error);
        }
    }
    /** type: null or save draft*/
    function action($type=''){
        
        //$_POST = '{"type_action":"create","id":"","set_alias":"true","title":"title","alias":"title","desc":"desc","content":"\u003Cp\u003Econtent\u003C\/p\u003E\r\n","en_title":"en title","en_alias":"en-title","en_desc":"en desc","en_content":"\u003Cp\u003Een content\u003C\/p\u003E\r\n","price":"50000","price_promotion":"80000","image":"http:\/\/localhost\/admin\/public\/uploads\/images\/Koala.jpg","images":"http:\/\/localhost\/admin\/public\/uploads\/images\/Koala.jpg","seo":{"title":"title seo","desc":"desc seo","keyword":"keyword seo","en_title":"en title seo","en_desc":"en desc seo","en_keyword":"keyword seo"},"id_category":"1","is_special":"1","is_new":"1","is_promotion":"1","id_tag":"[\"va-chi-co-phu-map\",\"quan-khong-map\",\"phu-map\",\"linh-khong-map\",\"loc-dep-trai\"]"}';
        //$_POST = json_decode($_POST,true);
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
                //$data['images'] = isset($data['images'])?(is_array($data['images'])==true?$data['images']:array($data['images'])):array();
                //$data['images'] = implode($data['images'],'||');
                /** end set default value */
                                
                if($type_action=='create'){
                    /** set create value */                          
                }else if($type_action=='edit'){
                    /** set edit value */   
                }
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
        $rules['required'] = 
            array('title','alias','en_title','en_alias');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
}
?>