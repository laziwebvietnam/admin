<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class admin_action_controller extends admin_template_controller
{
    public function __construct()
    {
        parent::__construct();
        
    }        
    
    function exportByPrint()
    {
        // $_POST = '{"field":["id","image","title","c_title","price","is_active"],"list":[["1","http:\/\/laziweb.com\/public\/uploads\/images\/mau-thiet-ke\/doanh-nghiep\/thumb-homedecor.JPG","ten san pham","","1,000,000","is_active_1"],["2","http:\/\/laziweb.com\/public\/uploads\/images\/mau-thiet-ke\/doanh-nghiep\/thumb-homedecor.JPG","ten san pham","","1,000,000","is_active_1"],["3","http:\/\/laziweb.com\/public\/uploads\/images\/mau-thiet-ke\/doanh-nghiep\/thumb-homedecor.JPG","ten san pham","","1,000,000","is_active_1"]]}';
        // $_POST = json_decode($_POST,true);
        if(__IS_AJAX__){
            $data_return = array();
            if($this->_checkRole==true){
                if($_POST){
                    if(isset($_POST['field']) && isset($_POST['list'])){
                        $this->listPage_tableField();
                        $data = array(
                            'title'=>$this->_table,
                            'field'=>$_POST['field'],
                            'list'=>$_POST['list'],
                            'type_field'=>$this->data_view['tableField']
                        );
                        $data_return['html'] = $this->load_view('view/include/export/print',$data,true);
                        echo json_encode($data_return);
                    }
                }  
            }else{
                $data_return['checkRole'] = false;
                echo json_encode($data_return);
            }    
        }else{
            $this->load_message('404'); 
        }                              
    }
    
    function pdf(){
        if($this->_checkRole==true){    
            //echo json_encode($_POST); exit;
            //$_POST = '{"field":["id","image","title","c_title","price","views","is_active"],"list":[["95","http:\/\/localhost\/admin\/public\/uploads\/images\/Koala.jpg","1231231","","2","0","\u0110ang \u1ea9n"],["94","http:\/\/localhost\/admin\/public\/uploads\/images\/Koala.jpg","1231231","","2","0","\u0110ang hi\u1ec7n"],["93","http:\/\/localhost\/admin\/public\/uploads\/images\/Koala.jpg","1231231","","2","0","\u0110ang hi\u1ec7n"],["92","http:\/\/localhost\/admin\/public\/uploads\/images\/Koala.jpg","1231231","","2","0","\u0110ang hi\u1ec7n"],["91","http:\/\/localhost\/admin\/public\/uploads\/images\/Lighthouse.jpg","12312312","","2","0","\u0110ang hi\u1ec7n"],["90","http:\/\/localhost\/admin\/public\/uploads\/images\/no-image.gif","123","","2","0","\u0110ang hi\u1ec7n"],["89","http:\/\/localhost\/admin\/public\/uploads\/images\/Lighthouse.jpg","12312312","","123","0","\u0110ang hi\u1ec7n"],["88","http:\/\/localhost\/admin\/public\/uploads\/images\/Lighthouse.jpg","12312312","","123","0","\u0110ang hi\u1ec7n"],["87","http:\/\/localhost\/admin\/public\/uploads\/images\/Lighthouse.jpg","12312312","","123","0","\u0110ang hi\u1ec7n"],["86","http:\/\/localhost\/admin\/public\/uploads\/images\/Lighthouse.jpg","12312312","","123","0","\u0110ang hi\u1ec7n"]]}';
            //$_POST = json_decode($_POST,true);
            $data_return = array();
            if($_POST){
                if(isset($_POST['field']) && isset($_POST['list'])){
                    $data_row_field = array();
                    $data_row_list_temp = array();
                    $this->listPage_tableField();
                    if($_POST['field'] != null){
                        
                        foreach($_POST['field'] as $row){
                            $data_row_field[] = array(
                                'style'=>'tableHeader',
                                'text'=>lang($row)
                            ); 
                        }
                    }
                    
                    if($_POST['list'] != null){
                        foreach($_POST['list'] as $key=>$row){
                            $data_row_list = array();
                            foreach($row as $key_item=>$item){
                                $temp = array_find_value_by_key($this->data_view['tableField'],'name',$_POST['field'][$key_item]);
                                $type = isset($temp['type'])?$temp['type']:'';
                                
                                $html = $item;
                                $temp_ = array();
                                $temp_['style'] = $key%2==0?'tableBodyOdd':'tableBodyEven';
                                if($type=='image'){
                                    // alternatively specify an URL, if PHP settings allow
                                    //$temp_['image'] = $item;
                                    $temp_['text'] = $item;
                                }else{
                                    $temp_['text'] = $item;
                                }

                                $data_row_list[] = $temp_;
                            }
                            $data_row_list = array($data_row_list);
                            $data_row_list_temp = array_merge($data_row_list_temp,$data_row_list);
                        }
                    }
                }
                $data_return['html'] = array_merge(array($data_row_field),$data_row_list_temp);
                echo json_encode($data_return);
            }
            
            /*
            $data_th = array(
                array('style'=>'tableHeader','text'=>'Field name 1'),
                array('style'=>'tableHeader','text'=>'Field name 2'),
                array('style'=>'tableHeader','text'=>'Field name 3'),
                array('style'=>'tableHeader','text'=>'Field name 4'),
                array('style'=>'tableHeader','text'=>'Field name 5'),
                array('style'=>'tableHeader','text'=>'Field name 6'),
                array('style'=>'tableHeader','text'=>'Field name 7')
            );
            
            $data_th_2 = array(
                array('style'=>'tableBodyOdd','text'=>'Content'),
                array('style'=>'tableBodyOdd','text'=>'Content'),
                array('style'=>'tableBodyOdd','text'=>'Content'),
                array('style'=>'tableBodyOdd','text'=>'Content'),
                array('style'=>'tableBodyOdd','text'=>'Content'),
                array('style'=>'tableBodyOdd','text'=>'Content'),
                array('style'=>'tableBodyOdd','text'=>'Content'),
            );
            */
        }else{
            $data_return['checkRole'] = false;
            echo json_encode($data_return);
        }
        
    }
    
    function exportByCsv(){
        $data_return = array();
        if($this->_checkRole==true){
            if($_POST){
                if(isset($_POST['field']) && isset($_POST['list'])){
                    $data_row_field = array();
                    $data_row_list_temp = array();
                    if($_POST['field'] != null){
                        
                        foreach($_POST['field'] as $row){
                            $data_row_field[] = lang($row);
                        }
                    }
                    
                    if($_POST['list'] != null){
                        foreach($_POST['list'] as $row){
                            $data_row_list = array();
                            foreach($row as $key=>$item){
                                $data_row_list[] =$item;
                            }
                            $data_row_list = array($data_row_list);
                            $data_row_list_temp = array_merge($data_row_list_temp,$data_row_list);
                        }
                    }
                }
            }
            $data_return['html'] = array_merge(array($data_row_field),$data_row_list_temp);
            echo json_encode($data_return);
        }else{
            $data_return['checkRole'] = false;
            echo json_encode($data_return);
        }
    }
    
    function check_seodata(){
        print_r($_POST);
        
        $_POST = array(
            'str_check'=>'Thu mua máy lạnh cũ',
            'title'=>'Thu Mua Máy Lạnh Cũ Giá Cao HCM',
            'title_seo'=>'Thu Mua Máy Lạnh Cũ Giá Cao HCM - Mua 70 - 80% giá gốc‎',
            'desc_seo'=>'Thu mua máy lạnh quận 1, quận 2, quận 4, quận 5, quận 7, quận 8, quận phú nhuận. quận bình tân, quận bình thạnh, quận tân bình, quận tân phú......Chuyên',
            'keyword_seo'=>'máy lạnh, thu mua',
            'alias'=>'thu-mua-may-lanh-cu',
            'long_detail'=>''
        );
    }
    
    
    /** set limit session of table page */
    function setLimitDatatable(){
        $data['status'] = 'fail';
        if(isset($_POST['table']) && isset($_POST['limit'])){
            $this->session->set_userdata($_POST['table'].'_limit',$_POST['limit']);
            $data['status'] = 'success';
        }
        echo json_encode($data);
    }
    
    /** set sortby of table page */
    function setSortbyDatatable(){
        $data['status'] = 'fail';
        if(isset($_POST['table']) && isset($_POST['val']) && isset($_POST['name'])){
            $temp['name'] = $_POST['name'];
            $temp['val'] = $_POST['val'];
            $val = json_encode($temp);
            $this->session->set_userdata($_POST['table'].'_sort',$val);
            $data['status'] = 'success';
        }
        echo json_encode($data);
    }
    
    /** return session limit of table */
    function getSortbyDatatable(){
        $session_sort = $this->session->userdata($this->_table.'_sort');
        $session_sort = json_decode($session_sort,true);
        $session_sort['name'] = isset($session_sort['name'])?$session_sort['name']:'id';
        $session_sort['status'] = isset($session_sort['val'])?$session_sort['val']:'desc';
        
        return $session_sort;
    }
    
    /** kiểm tra biến & return giá trị đúng */
    function return_real_value($array=array(),$type='text',$field_in,$field_out)
    {
        $array_field_out = array();
        if($array)
        {
            if(isset($array[$field_in]))
            {
                $value_field_in = $this->get_real_value($array[$field_in],$type);    
                
                if($value_field_in=='wrong' && $type=='number')
                {
                    return array();
                }
                
                $array_field_out[$field_out] = $value_field_in;
            }
        }
        return $array_field_out;
    }
    
    function get_real_value($value_field_in=null,$type='text',$default_value=null)
    {
        if($type=='text')
        {
            $value_field_in = $value_field_in==''?$default_value:$value_field_in;
        }
        else if($type=='number')
        {
            $value_field_in = (int)$value_field_in?$value_field_in:$default_value;
            $value_field_in = $value_field_in==0?'wrong':$value_field_in;
        }
        else if($type=='time')
        {
            $value_field_in = $value_field_in==''?$default_value:strtotime($value_field_in)+86399;
        }
        else if($type=='array')
        {
            $value_field_in = $value_field_in!=null?explode('||',$value_field_in):$default_value;
        }
        else if($type=='bool')
        {
            $value_field_in = $value_field_in==0?0:1;
        }else if($type=='select'){
            $value_field_in = $value_field_in==-1?$default_value:$value_field_in;   
        }else if($type=='tag'){
            $value_field_in = return_tag_byString($value_field_in);
            $value_field_in = $value_field_in!=null?$value_field_in:$default_value;
        }
        return $value_field_in;
    }
    
    
    /** set field type int/bool */
    function set_status($name,$val,$id=null){
        
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                $data_return['status'] = 'fail';
                if($_POST != null && $id==null){
                    
                    if($name!=null && $val!=null){
                        $where_in = explode(',',$_POST['id_executed']);
                        $data_update[$name] = $val;
                        $this->My_model->update($_POST['table'],$data_update,null,$where_in);
                        $data_return['status'] = 'success';
                        $data_return['reload'] = true;
                    }else{
                        $data_return['log'] = 'Empty $name';
                    }
                }else if($_POST != null && $id!=null){
                    if($name!=null && $val!=null && (int)$id>0){
                        $data_update[$name] = $val;
                        $where['id'] = $id;
                        $this->My_model->update($_POST['table'],$data_update,$where);
                        $data_return['status'] = 'success';
                        $data_return['reload'] = true;
                    }
                }else{
                    $data_return['log'] = 'Empty $_POST';
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
    
    /** set field by $_GET */
    function set_statusByGET($table=null,$name=null,$val=null,$id=null){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                $data_return['status'] = 'fail';
                if($id!=null){
                    if($name!=null && $val!=null && $table!=null && (int)$id>0){
                        
                        $data_update[$name] = $val;
                        $where['id'] = $id;
                        $this->My_model->update($table,$data_update,$where);
                        $data_return['status'] = 'success';
                        $data_return['reload'] = true;
                    }
                }else{
                    $data_return['log'] = 'Empty $_POST';
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
    
/** View + action delete popup */
    function delete_popup(){
        if(__IS_AJAX__){
            $data_return = array();
            if($this->_checkRole==true){
                if(isset($_POST['table']) && isset($_POST['id_executed'])){
                    $count = count(explode(',',$_POST['id_executed']));
                    if($count>0 && $count<10){
                        $count = '0'.$count;
                    }
                    $data = array(
                        'count'=>$count,
                        'table'=>$this->_table
                    );
                    $data_return['html'] = $this->load_view('view/include/popup/delete',$data,true); 
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
    
    function delete_once_popup($id=null){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                if(isset($this->_table) && $id!=null){
                    $data = array(
                        'count'=>1,
                        'table'=>$this->_table,
                        'id'=>(int)$id
                    );
                    $data_return['html'] = $this->load_view('view/include/popup/delete',$data,true); 
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
    function delete_action($id=null){
        if(__IS_AJAX__){
            $data['status'] = 'fail';
            if($id!=null){
                $id = (int)$id;
                $this->My_model->update_delete($this->_table,'delete',array('id'=>$id));
                $data['status'] = 'success';
                $data['reload'] = true;
            }else if($_POST != null){
                $where_in = explode(',',$_POST['id_executed']);
                $this->My_model->update_delete($_POST['table'],'delete',null,$where_in);
                
                $data['status'] = 'success';
                $data['reload'] = true;
            }else{
                $data['log'] = 'Empty $_POST';
            }
            echo json_encode($data);     
        }else{
            $this->load_message('404');
        }
    }
/** End view + action delete popup */
    
/** View + action create/edit popup */
    function tag_popup($type_action='create'){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                if(isset($_POST['table']) && isset($_POST['id_executed'])){
                    $count = count(explode(',',$_POST['id_executed']));
                    if($count>0 && $count<10){
                        $count = '0'.$count;
                    }
                    $data = array(
                        'count'=>$count,
                        'id_executed'=>$_POST['id_executed'],
                        'table'=>$_POST['table'],
                        'type_action'=>$type_action,
                        'tag_complete'=>$this->My_model->getlist('tags',array('is_delete'=>0)),
                        'tag_suggest'=>$this->My_model->getlist('tags',array('is_delete'=>0),0,5)
                    );
                    $data_return['html'] = $this->load_view('view/include/popup/tag',$data,true);
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
    
    function tag_action(){
        if(__IS_AJAX__){
            $data['status'] = 'fail';
            $data['reload'] = false;
            if(isset($_POST)){
                if(isset($_POST['id_tag'])){
                    $table_tag = $_POST['table'].'_tags';
                    $id_executed = explode(',',$_POST['id_executed']);
                    $id_tag = return_tag_byString($_POST['id_tag']);
                    if($_POST['type_action']=='delete'){
                        $this->tag_remove_multyData($id_executed,$id_tag,$_POST['table']);
                    }else if($_POST['type_action']=='create'){
                        $this->tag_insert_multyData($id_executed,$id_tag,$_POST['table']);
                    }
                    $data['status'] = 'success';         
                                   
                }else{
                    $data['log'] = 'Dữ liệu rỗng';
                }                    
            }else{
                $data['status'] = 'success';
                $data['log'] = 'Dữ liệu rỗng';
            }
            echo json_encode($data);
        }
    }
    
    /** check & insert multyData */
    function tag_insert_multyData($id_executed=array(),$id_tag=array(),$table=''){
        $this->db->flush_cache();
        $data_tag_temp = array();
        if($id_executed != null){
            $data_tag_temp = $this->tag_find_mutilTag($id_tag,$table);
            $this->tag_update_tag_join_with_table($id_executed,$data_tag_temp,$table);
        }
    }
    
    /** check & remove multyData */
    function tag_remove_multyData($id_executed=array(),$id_tag=array(),$table=''){
        $this->db->flush_cache();
        if($id_executed != null){
            $data_tag_temp = $this->tag_find_mutilTag($id_tag,$table,'delete');
            $this->tag_update_tag_join_with_table($id_executed,$data_tag_temp,$table,'delete');
        }
    }
    
    /** update tag with a table: product/article */
    function tag_update_tag_join_with_table($id_executed=array(),$id_tag=array(),$table='',$type_action='create'){
        if($id_executed!=null && $id_tag!=null){
            foreach($id_executed as $pro){
                foreach($id_tag as $key=>$tag){
                    $data_find = array(
                        'id_'.$table=>$pro,
                        'id_tag'=>$tag
                    );
                    $find_tag_detail = $this->My_model->getdetail_by_any($table.'_tags',$data_find);
                    if($find_tag_detail == null && $type_action == 'create'){
                        $this->My_model->insert($table.'_tags',$data_find);
                    }else if($find_tag_detail != null && $type_action == 'delete'){
                        $this->My_model->delete($table.'_tags',array('id'=>$find_tag_detail['id']));
                    }
                }
            }
        }
    }        
    
    /** find mutil tag; create & return list tag id */
    function tag_find_mutilTag($data_tag=array(),$table='',$type_action='create'){
        $data_tag_temp = array();
        if($data_tag != null){
            foreach($data_tag as $tag){
                $this->db->flush_cache();
                $tag = trim($tag);
                $alias = stripUnicode_alias($tag);
                $where = array(
                    'alias'=>$alias
                );
                $find_tag = $this->My_model->getdetail_by_any('tags',$where);
                /** Case 1: find=null & action=create => insert => get id_insert */
                if($find_tag == null && $type_action == 'create'){
                    
                    $data_alias = array(
                        'title'=>$tag,
                        'type'=>'create',
                        'table'=>'tags'
                    );
                    
                    $tag_insert = array(
                        'title'=>$tag,
                        'alias'=>$this->set_alias(null,$data_alias,true),
                        'en_title'=>$tag,
                        'en_alias'=>$this->set_alias('en',$data_alias,true),
                        'time'=>time(),
                        'time_update'=>time(),
                        'is_active'=>1,
                        'id_user'=>$this->data['user']['id']
                    ); 
                    $id_insert = $this->My_model->insert('tags',$tag_insert);
                    $data_tag_temp[$tag] = $id_insert;
                }
                /** Case 2: find==null & action */
                else if($find_tag==null && $type_action=='delete'){
                    unset($data_tag_temp[$tag]);
                }else{
                    $data_tag_temp[$tag] = $find_tag['id'];
                }
            }
        } 
        return $data_tag_temp;
    }
    
/** End view + action create/edit popup */

/** View + action create/edit category */
    function cate_popup($type_action="create"){
        if(__IS_AJAX__){
            if($this->_checkRole==true){
                if(isset($_POST['table']) && isset($_POST['id_executed'])){
                    $count = count(explode(',',$_POST['id_executed']));
                    if($count>0 && $count<10){
                        $count = '0'.$count;
                    }
                    $data = array(
                        'count'=>$count,
                        'id_executed'=>$_POST['id_executed'],
                        'table'=>$_POST['table'],
                        'type_action'=>$type_action
                    );
                    $data_return['html'] = $this->load_view('view/include/popup/cate',$data,true); 
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
    
    function cate_action(){
        if(__IS_AJAX__){
            $data['status'] = 'fail';
            if($_POST != null){
                $where_in = explode(',',$_POST['id_executed']);
                $data_update = array();
                $value = $_POST['type_action']=='create'?1:0;
                if($this->data_view['cate_popup']['status']!=null){
                    foreach($this->data_view['cate_popup']['status'] as $row){
                        if(isset($_POST[$row])){
                            $data_update[$row] = $value;
                        }
                    }
                }
                $this->My_model->update($_POST['table'],$data_update,null,$where_in);
                $data['status'] = 'success';
            }else{
                $data['log'] = 'Dữ liệu rỗng';
            }
            echo json_encode($data);     
        }
    }
    
    function sentMail(){
        return false;
    }
/** End view + action create/edit category */

/** check alias */
    /** return alias with title */
    function set_alias($lang=null,$data=array(),$return=false){
        /*$_POST = array(
            'title'=>'Lazi Team - Đội ngũ thiết kế website chuyên nghiệp',
            'table'=>'product',
            'type'=>'create',
            'id'=>null
        );*/
        $data = $data!=null?$data:$_POST;
        $data_return = array();
        if($data != null)
        {
            $data['id'] = isset($data['id'])?$data['id']:null;
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
    /** check unique & return new alias */
    public function check_alias($alias='',$table,$lang=null,$type,$id=null)
    {
        $bool = false;
        $bool = $this->My_model->check_alias_exists($table,$alias,$lang,$type,$id);
        
        
        if($bool == false)
        {
            $check_alias = false;
            $alias_final = '';
            $i = 1;
            while($check_alias == false)
            {
                $alias_final = $alias.'-0'.$i;
                $check_alias = $this->My_model->check_alias_exists($table,$alias_final,$lang,$type,$id);
                $i++;
            }
            $alias = $alias_final;
        }
        return $alias;
    }
/** End check alias */
    
/** Show alert */
    function show_alert($strong_text,$normal_text,$typeAlert='basic',$typeValue='warning'){
        $alert_type = array(
            'success'=>'alert-success',
            'warning'=>'alert-warning',
            'danger'=>'alert-danger',
            'dismissable'=>'alert-dismissable'
        );
        
        $data = array(
            'strong_text'=>$strong_text,
            'normal_text'=>$normal_text,
            'type_value'=>$typeValue,
            'type_alert'=>$alert_type
        );
        
        $html = $this->load->view($this->_base_view_path.'view/include/alert/'.$typeAlert,$data,true);
        return $html;
    }
    
    function show_alert_popup(){
        if($_POST){
            $alert_type = array(
                'success'=>'alert-success',
                'warning'=>'alert-warning',
                'danger'=>'alert-danger',
                'dismissable'=>'alert-dismissable'
            );
            $data = array(
                'strong_text'=>isset($_POST['strong_text'])?$_POST['strong_text']:'',
                'normal_text'=>isset($_POST['normal_text'])?$_POST['normal_text']:'',
                'type_value'=>isset($_POST['typeValue'])?$_POST['typeValue']:'',
                'type_alert'=>$alert_type
            );
            
            $html = $this->load->view($this->_base_view_path.'view/include/alert/popup',$data,true);
            echo $html;
        }
        
    }
/** End show alert */

/** Search on Data Table / List page */
    /** return array search listPage */
    function get_where($where=array())
    {
        if($_GET)
        {                
            $field_search = $this->set_field_for_ajax_search();
            if($field_search != null){
                foreach($field_search as $key=>$row){
                    if(isset($row['field_search'])){
                        $type = isset($row['type'])?$row['type']:'text';
                        $field_search_output = isset($row['field_search'])?$row['field_search']:$row['name'];                    
                        $field_detail_val = $this->return_real_value($_GET,$type,$row['name'],$field_search_output);
                           
                        if(isset($field_detail_val[$field_search_output])){
                            $where = array_merge($where,$field_detail_val);
                        }                        
                    }
                }
            }
        }
        return $where;
    }  
/** End search on Data Table / List page */


/** Function about create / edit table */
    function setSeoItem(&$data_insert=array(),&$data_seo=array()){
        if(isset($data_insert['seo'])){
            $data_seo = $data_insert['seo'];
            $data_seo['image'] = isset($data_insert['image'])?$data_insert['image']:'';
            $data_seo['image'] = isset($data_insert['seo']['image'])?$data_insert['seo']['image']:$data_seo['image'];
            $data_seo['data_table'] = $this->_table;
            
            if(isset($data_insert['id'])){
                if($data_insert['id']!=0){
                    $find_seo = $this->My_model->getdetail_by_any('seo',array('data_table'=>$this->_table,'data_id'=>$data_insert['id']));
                    if($find_seo!=null){
                        $data_seo['id'] = $find_seo['id'];
                    }
                }
            }
            
            unset($data_insert['seo']);
        }
    }
    
    /** check & update by id */
    function tag_update_byID($id_data=0,$id_tag=array(),$table=''){
        $this->db->flush_cache();
        $id_tag = $id_tag==null?(isset($_POST['id_tag'])?$_POST['id_tag']:array()):$id_tag;
        if($id_data >0){
            $table = $table==''?$this->_table:$table;
            $id_executed = array($id_data); /** $id_executed = array() */
            $id_tag = return_tag_byString($id_tag);
            $data_tag_temp = $this->tag_find_mutilTag($id_tag,$table,'create');
            $this->My_model->delete($this->_table.'_tags',array('id_'.$this->_table=>$id_data));
            $this->tag_update_tag_join_with_table($id_executed,$data_tag_temp,$table,'create');
        }
    }   
    
    /** insert & update into database */
    function insert($data,$seo=false,$tag=false,$type=''){

        if($data==null){
            return null;
        }
        /** unset key = null */
        foreach($data as $key=>$field){
            if($field==''){
                $data[$key] = null;
            }
        }
        
        /** update status: is_active, is_special, ... */
        if($this->data_view['cate_popup']['status']!=null){
            foreach($this->data_view['cate_popup']['status'] as $status){
                if(!isset($data[$status])){
                    $data[$status] = 0;
                }
            }
        }            
        
        /** default value */
        $data['time_update'] = time();
        $data['id_user_update'] = $this->data['user']['id'];
        
        if($type=='savedraft'){
            $data['is_draft'] = 1;
        }
        if($seo==true){
            $this->setSeoItem($data,$data_seo);
        }
        
        if($tag==true){
            unset($data['id_tag']);
        }
        if($data['id']!=0){
            $rs = $this->My_model->update($this->_table,$data);
            $data_id = $data['id'];
            if($seo==true){
                $data_seo['data_id'] = $data_id;
                $findSeoData = $this->My_model->getdetail_by_any('seo',array('data_id'=>$data_id,'data_table'=>$this->_table));
                if($findSeoData!=null){
                    $this->My_model->update('seo',$data_seo);
                }else{
                    $this->My_model->insert('seo',$data_seo);
                }                    
            }
        }
        else{
            $data['time'] = time();
            $data['id_user'] = $this->data['user']['id'];  
            $data_id = $this->My_model->insert($this->_table,$data);
            if($seo==true){
                $data_seo['data_id'] = $data_id;
                $this->My_model->insert('seo',$data_seo);
            }
        }
        
                    
        if($tag==true){
            $this->tag_update_byID($data_id);
        }
        return $data_id;
    }
    
    
    /** return rules array */
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
    
    function check_equal_less($second_field,$first_field)
    {
        if ((double)$second_field != 0 && (double)$second_field > (double)$first_field)
        {
            $first_field = number_format($first_field,0,'.','.');
            $this->form_validation->set_message('check_equal_less', "%s chỉ được nhỏ hơn $first_field.");
            return false;       
        }
        else
        {
            return true;
        }
    }

    function check_equal_greate($second_field,$first_field)
    {
        if ((double)$second_field < (double)$first_field)
        {
            $first_field = number_format($first_field,0,'.','.');
            $this->form_validation->set_message('check_equal_greate', "%s chỉ được lớn hơn $first_field.");
            return false;       
        }
        else
        {
            return true;
        }
    }
    
    function check_unique($value,$field_name)
    {
        if($field_name!=null){
            if($_POST['type_action']=='edit'){
                $find_unique = $this->My_model->getdetail_by_any($this->_table,array($field_name=>$_POST[$field_name],'id <>'=>$_POST['id']));
                if($find_unique!=null){
                    $this->form_validation->set_message('check_unique', '%s đã tồn tại.');
                    return false;    
                }
                //
            }else if($_POST['type_action']=='create'){
                $find_unique = $this->My_model->getdetail_by_any($this->_table,array($field_name=>$_POST[$field_name]));
                if($find_unique!=null){
                    $this->form_validation->set_message('check_unique', '%s đã tồn tại.');
                    return false;    
                }
            }
        }
        return true;
    }

    function check_nomatches($second_field,$first_field)
    {
        if ($second_field == $first_field)
        {
            $this->form_validation->set_message('check_nomatches', '%s không được trùng.');
            return false;       
        }
        else
        {
            return true;
        }
    }

    /** load View Popup when checkRole = false */
    function loadPopupViewRoleFalse(){
        if(__IS_AJAX__){
            $data_return['html'] = $this->load_message('403',null,true);
            echo json_encode($data_return);
        }else{
            $this->load_message('404');
        }
    }
    
    
/** End function about create / edit table */
}
    
?>