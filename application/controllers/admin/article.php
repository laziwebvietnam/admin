<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Article extends admin_basic_controller
{
    var $_table = 'article';
    public function __construct()
    {
        parent::__construct();
        /** Config */
        $this->data_view['cate_popup']['status'] = array('is_active','is_special');
        $this->_createSeoData = true;
        $this->_createTagData = true;
        /** Load model */
        $this->load->model('M_article');
        $this->load->model('M_tags');
        $this->load->model('M_comment');
        
    }

    function search(){
        $this->_Index('search');
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
                'category'=>$this->My_model->getlist('category',array('type'=>'article'),0,999,'position asc'),
                'tag_complete'=>$this->M_tags->getListByType('article',array('ts.is_active'=>1)),
                'user'=>$this->My_model->getlist('user',array(),0,99,'id asc')
            );  
        }else if($view=='create'){
            $data = array(
                'category'=>$this->My_model->getlist('category',array('type'=>'article'),0,999,'position asc'),
                'tag_complete'=>$this->My_model->getlist('tags'),
                'tag_suggest'=>$this->M_tags->getListByType('article',array('ts.is_active'=>1),0,5),
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_article->detail_Backend($variable['id']),
                'seo'=>$this->My_model->getdetail_by_any('seo',array('data_id'=>$variable['id'],'data_table'=>$this->_table)),
                'category'=>$this->My_model->getlist('category',array('type'=>'article'),0,999,'position asc'),
                'tag_complete'=>$this->M_tags->getListByType($this->_table),
                'tag_selected'=>$this->M_tags->getListByType($this->_table,array('t.id_'.$this->_table=>$variable['id'])),
                'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
                
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
        $total_row = $this->M_article->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_article->get_all($where,$start,$limit,$order_by);
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
            array('name'=>'desc','title'=>'Mô tả','hidden'=>true),
            array('name'=>'c_title','title'=>'Loại'),
            array('name'=>'views','title'=>'Lượt xem','type'=>'number'),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }
    
    /** array all field */
    public function set_field_for_ajax_search()
    {
        /** type: text, select, tag, checked */
        $array = array(
            array('type'=>'text','name'=>'title','field_search'=>'tb.title'),   
            array('type'=>'select','name'=>'id_user','field_search'=>'tb.id_user'),   
            array('type'=>'select','name'=>'id_category','field_search'=>'id_category'),
            array('type'=>'time','name'=>'dayTo','field_search'=>'tb.time >='),   
            array('type'=>'time','name'=>'dayEnd','field_search'=>'tb.time <='),     
            array('type'=>'checked','name'=>'is_active','field_search'=>'tb.is_active'),   
            array('type'=>'checked','name'=>'is_special','field_search'=>'is_special'),
            array('type'=>'tag','name'=>'id_tag','field_search'=>'tag'),          
        );
        
        return $array;
    }
    
    function set_rules(){
        $rules['required'] = 
            array('title','alias','en_title','en_alias','id_category');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
}
?>