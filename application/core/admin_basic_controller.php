<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class admin_basic_controller extends admin_action_controller
{
    var $_createSeoData = false;
    var $_createTagData = false;
    /**
     * load default view
     *     $this->data_view['dataTable']['field_search'] (null/field_name): load field search default. Load in controller, before parent::__construct()
     *     $this->data_view['btnCreate'] (true/false) : config create button show or not show. Load in controller, after parent::__construct()
     *     $this->data_view['dataCreate']['alias'] (true/false) : config auto create alias (url). Load in controller, after parent::__construct()
     *     $this->data_action['savedraft'] : config for display action savedraft, need field: is_draft
     *     $this->data_action['preview'] : config for display action preview, need field: preview
     */
    public function __construct()
    {
        parent::__construct();
        /** Config */
        $this->lang->load('admin_'.$this->_table);  
        $this->load_dataView_dataAction();
        $this->listPage_tableField(); /** load thead on table */
        $this->listPage_quickAction(); /** quickAction when select id */
        $this->listPage_otherInfo(); /** note something for view list Datatable */
        $this->dataTable_loaddefault();

        $this->data_view['cate_popup']['status'] = array('is_active');
        $this->data_view['dataCreate']['alias'] = true; /** auto set alias */

        $this->load->model('M_basic');  
        $this->load->model('M_tags');
    }

    /** load view list page */
    function index($view='index'){        
        $this->_index($view);
    }
    
    /** load view create */
    function create(){
        $this->_index('create');
    }   
    
    /** load view edit page */
    function edit($id=0){
        $id = (int)$id;
        $data['id'] = $id;
        $this->_index('edit',$data);
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
                //'tag_complete'=>$this->My_model->getlist('tags',array('is_active'=>1,'is_delete'=>0)),
                // 'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
            );  
        }else if($view=='edit'){
            $data = array(
                'detail'=>$this->M_basic->detail_Backend($variable['id']),
                'seo'=>$this->My_model->getdetail_by_any('seo',array('data_id'=>$variable['id'],'data_table'=>$this->_table)),
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

    /** quickAction when select id */
    function listPage_quickAction(){
        /**
            action: link / action when executed
            title: text for show
            popup (true/false): if true => config by link view popup
        */
        $this->data_view['dataTable']['quickAction'] = array(
            array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Ẩn','popup'=>false),
            array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Hiện','popup'=>false),
            array('action'=>$this->_table.'/delete_popup/1','title'=>'Xóa','popup'=>true)
        );
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
            array('name'=>'image','title'=>'Hình','type'=>'image','linkDetail'=>true),
            array('name'=>'title','title'=>'Tên','linkDetail'=>true),
            array('name'=>'is_active','title'=>'Trạng thái','type'=>'status')
        );
    }

    /** set all field for search */
    public function set_field_for_ajax_search()
    {
        /**
         * type: type of field
         *     text
         *     number
         *     select: use for selectbox - RETURN value selected
         *     checked: use for checkbox - RETURN variable
         *     tag: return array
         *     time: return (int)
         * name: name of field
         * field_search: field get where on sql
         */
        
        $array = array(
            array('type'=>'text','name'=>'title','field_search'=>'tb.title'),                
            array('type'=>'checked','name'=>'is_active','field_search'=>'tb.is_active')
        );
        
        return $array;
    }

    /** note something for view list Datatable  */
    function listPage_otherInfo(){
        /**
         * example & default value if null
         * 'is_active'=>array(
                '0'=>'label label-sm label-warning',
                '1'=>'label label-sm label-warning'
            )            
         */
        $this->data_view['dataTable']['otherInfo']['status'] = array(

            );
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
        $total_row = $this->M_basic->get_all($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_basic->get_all($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }

    /**
     * check validation
     * @param boolean $return_bool [false: echo json, true: return true/false ]
     * @param array   $rules_temp  [if $rules_temp!=null then check validation with this array]
     */
    function set_validation($return_bool=false,$rules_temp=array()){
        if($_POST){
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
        }
    }

    /** set rule for validation */
    function set_rules(){
        /**
            callback_check_equal_less[$this->input->post('{field_for_compare}')] 
            callback_check_equal_greate[$this->input->post('{field_for_compare}')]
        */
        $rules['required'] = 
            array('title','image','alias','desc','content');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
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
    
    function restore($type='delete',$dataId=0){
        if(__IS_AJAX__){
            $data_return = array();
            if($this->_checkRole==true){
                $dataId = (int)$dataId;

                if($dataId > 0){
                    $data = array(
                        'table'=>$this->_table,
                        'id'=>$dataId
                    );
                    $data_return['html'] = $this->load_view('view/include/popup/restore',$data,true); 
                }else{
                    $strong_text = 'Không tìm thấy dữ liệu đang thao tác!';
                    $normal_text = 'Vui lòng thông báo quản trị viên.';
                    $message = $this->show_alert($strong_text,$normal_text,'popup');
                    $data_return['html'] = $message;
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

    function restore_action($type='delete',$dataId=0){
        if(__IS_AJAX__){
            $data_return = array();
            $data_return['status'] = 'fail';
            $dataId = (int)$dataId;
            $dataDetail = $this->My_model->getbyid($this->_table,$dataId);

            if($dataDetail){
                $dataUpdate = array(
                    'id'=>$dataDetail['id'],
                    'time_update'=>time(),
                    'is_delete'=>0
                );
                $this->My_model->update($this->_table,$dataUpdate);
                $data_return['status'] = 'success';
                $data_return['reload'] = true;
            }else{
                $data_return['log'] = 'Không tìm thấy dữ liệu đang thao tác! Vui lòng thông báo quản trị viên';
            }
            echo json_encode($data_return);  
        }else{
            $this->load_message('404');
        }
    }
}
?>