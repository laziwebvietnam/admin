<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class category extends admin_basic_controller
{
    var $_table = 'category';
    public function __construct()
    {
        parent::__construct();
        /** Config */
        
        $this->lang->load('admin_category');  
        $this->load_dataView_dataAction();  
        $this->data_view['cate_popup']['status'] = array('is_active');
        $this->data_view['dataCreate']['alias'] = true;
        $this->data_view['btnCreate'] = false;
        
        $this->data_view['unLockCreate'] = array(
            'level_0'=>array(
                'lock'=>true
            ),
            'level_1'=>array(
                'lock'=>false,
                'type'=>array('product','article'),
                'id'=>array(),
                'non_id'=>array()
            ),
            'level_2'=>array(
                'lock'=>false,
                'type'=>array('product'),
                'id'=>array(),
                'non_id'=>array()
            )
        );
        /** Load model */
        $this->load->model('M_category');
        
    }
    
    function index($view='index'){
        $this->_index($view);
    }
    
    function product($view='index'){
        /** Load model */
        $variable = array(
            'type'=>'product'
        );
        $this->_index($view,$variable);
    }
    
    function article($view='index'){
        $variable = array(
            'type'=>'article'
        );
        $this->_index($view,$variable);
    }
    
    function search(){
        $this->load_message('404');
        $this->index('search');
    }
    
    function create($id_parent=0){
        $id_parent = (int)$id_parent; 
        $data['id_parent'] = $id_parent;
        $this->_index('create',$data);
    }   
    
    function edit($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('edit',$data);
    } 

    function configTypePage($type=''){
        if($type==''){
            return;
        }else{
            $this->data_view['unLockCreate']['level_0']['lock'] = false;
            if($type=='car'){
                $this->data_view['unLockCreate'] = array(
                    'level_0'=>array(
                        'lock'=>false
                    ),
                    'level_1'=>array(
                        'lock'=>false,
                        'type'=>array('car'),
                        'id'=>array(),
                        'non_id'=>array()
                    ),
                    'level_2'=>array(
                        'lock'=>false,
                        'type'=>array('car'),
                        'id'=>array(),
                        'non_id'=>array()
                    ),
                    'level_3'=>array(
                        'lock'=>false,
                        'type'=>array('car'),
                        'id'=>array(),
                        'non_id'=>array()
                    ),
                );
            }
        }
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
                'type'=>isset($variable['type'])?$variable['type']:''
            );   
        }else if($view=='create'){
            $data = array(
                'info'=>$this->findInfoByIdCategory($variable['id_parent'])
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_category->detail_Backend($variable['id']),
                'seo'=>$this->My_model->getdetail_by_any('seo',array('data_id'=>$variable['id'],'data_table'=>$this->_table)),
            );  
            
            if($data['detail']==null){
                $this->load_message();
                return;
            }
            $data['info'] = $this->findInfoByIdCategory($data['detail']['id_parent']);
            $view = 'create';
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function quick_create($type=''){
        $where = array();
        if($type=='product'){
            $where['type'] = 1;
        }else if($type=='article'){
            $where['type'] = 2;
        }
        $data = array(
            'cate'=>$this->My_model->getlist('category',$where,0,999,'position asc')
        );
        echo $this->load->view($this->_base_view_path.'view/category/include/pop_create',$data,true);   
    }
        
    /** ACTION */
    /** type: null or save draft*/
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
                    /* $this->insert(data,$seo_status=false/true,$tag_status=false/true,$type='') */
                    $data_id = $this->insert($data,true,false,$type);
                    
                    if($data_id>0){
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
        /** when edit action */
        if(isset($_POST['type'])){
            /** if home type */
            if($_POST['type']=='home'){
                $rules['required'] = 
                    array('title','en_title','type');
            }
            /** other type */
            else{
                $rules['required'] = 
                    array('title','alias','en_title','en_alias','type');
            }
        }else{
            $rules['required'] = 
                array('title','alias','en_title','en_alias');
        }
        
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */
    
    /** find info: position, level, type, ... for create category */
    function findInfoByIdCategory($id_parent=0){
        $id_parent = (int)$id_parent;
        $findCate_parent = $this->My_model->getbyid($this->_table,$id_parent);
        
        $data_return = array(
            'id_parent'=>0,
            'level'=>0,
            'type'=>null
        );
        
        if($findCate_parent!=null){
            $data_return['id_parent'] = $findCate_parent['id'];
            $data_return['level'] = $findCate_parent['level']+1;
            $data_return['type'] = $findCate_parent['type'];
            
            /** get category same id_parent and position highest */
            $where = array('id_parent'=>$data_return['id_parent']);
            $findCateSameParent = $this->My_model->getdetail_by_any($this->_table,$where,'position desc');
            $data_return['position'] = $findCateSameParent!=null?$findCateSameParent['position']+1:0;
        }else if($id_parent==0){
            /** get category same id_parent and position highest */
            $where = array('id_parent'=>0);
            $findCateSameParent = $this->My_model->getdetail_by_any($this->_table,$where,'position desc');
            $data_return['position'] = $findCateSameParent!=null?$findCateSameParent['position']+1:0;
        }
        
        return $data_return;
    }
    
    function ajax_nodes($type="getList"){
        if(__IS_AJAX__){
            $where['tb.is_delete'] = 0;
            if(isset($_POST['type'])){
                if($_POST['type']!=''){
                    $where['type'] = $_POST['type'];
                }
            }
            $category = $this->M_category->get_all($where,0,9999,'position asc');
            mutil_menu_return_key_id($category,0,$result,$result_key_id);
            $new_array['data'] = array();
            $new_array['types'] = array();
            $data_parent = array();
            $i=1;
            if($result != null){
                $level = 0;
                foreach($result as $row){
                    $type_title = '#';
                    if($row['level']>0){
                        $data_id_parent = $result_key_id[$row['id_parent']]; /** return data id = id_parnt */
                        if(in_array($data_id_parent['id'],$data_parent)==false){
                            $data_parent[] = $data_id_parent['id'];
                        }
                        $type_title = 'level'.$data_id_parent['level'].'_parent'.$data_id_parent['id_parent'].'_id'.$data_id_parent['id'];
                    } 
                    $type_content = 'level'.$row['level'].'_parent'.$row['id_parent'].'_id'.$row['id'];
                    $new_array['data'][] = array(
                        'id'=>$row['id'],
                        'parent'=>$row['id_parent']==0?'#':$row['id_parent'],
                        'level'=>$row['level'],
                        'type'=>$type_content,
                        'title'=>$row['title'],
                        'data_type'=>$row['type']
                    );
                    
                    $new_array['types'][$type_title]["valid_children"][] = $type_content;
                }
                
                foreach($result as $row){
                    if(in_array($row['id'],$data_parent)==false){
                        $type_title = 'level'.$row['level'].'_parent'.$row['id_parent'].'_id'.$row['id'];
                        $new_array['types'][$type_title]["valid_children"] = array();
                    }
                }

                if($type=="getList"){
                    $data_return['html'] = $this->load->view($this->_base_view_path.'view/category/ajax_nodes',$new_array,true);
                    echo json_encode($data_return);
                }else if($type=="getType"){
                    $this->configTypePage($_POST['type']);
                    $new_array['createRole'] = $this->data_view['unLockCreate'];
                    echo json_encode($new_array);
                }
            }else{
                $data_return['html'] = null;
                echo json_encode($data_return);
            }
        }else{
            $this->load_message('404');
        }
    }
    
    function change_position($id=null,$type=null){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                $data_return['status'] = 'fail';
                if($id!=null && $type!=null){
                    $findThisCate = $this->My_model->getbyid($this->_table,$id);
                    if($type=='up'){
                        $order_by = 'position desc';
                        $where['id_parent'] = $findThisCate['id_parent'];
                        $where['position <'] = $findThisCate['position'];
                        $where['is_delete'] = 0;
                    }else{
                        $order_by = 'position asc';
                        $where['id_parent'] = $findThisCate['id_parent'];
                        $where['position >'] = $findThisCate['position'];
                        $where['is_delete'] = 0;
                    }

                    $findNewCate = $this->My_model->getdetail_by_any($this->_table,$where,$order_by);
                    if($findNewCate!=null){
                        $this->My_model->update($this->_table,array('id'=>$id,'position'=>$findNewCate['position']));
                        $this->My_model->update($this->_table,array('id'=>$findNewCate['id'],'position'=>$findThisCate['position']));
                        $data_return['status'] = 'success';
                    }
                }
                echo json_encode($data_return);
            }else{
                $data_return['checkRole'] = false;
                echo json_encode($data_return);
            }
        }else{
            $this->load_message('404');
        }    
    }
    
    function set_alias($lang=null,$data=array(),$return=false){
        $data = $data!=null?$data:$_POST;
        $data_return = array();
        if($data != null)
        {
            $data['id'] = isset($data['id'])?$data['id']:null;
            if($data['id']!=null){
                $findDetail = $this->My_model->getbyid($this->_table,$data['id']);
                if($findDetail!=null){
                    if($findDetail['level']==0 && $this->data['user']['id_role']!=1){
                        $data_return['status'] = 'fail';
                        echo json_encode($data_return);
                        return;
                    }
                }
            }
            $title = trim($data['title']);
            if($title==''){
                $data_return['status'] = 'fail';
            }else{
                $alias = stripUnicode_alias($title);
                $alias = $this->check_alias($alias,$data['table'],$lang,$data['type'],$data['id']);
                
                if($return==true){
                    return $alias;
                }else{
                    $data_return['status'] = 'success';
                    $data_return['alias'] = $alias;
                }            
            }
            echo json_encode($data_return);
        }
    }
}
?>