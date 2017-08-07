<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class config extends admin_basic_controller
{
    var $_table = 'config';
    public function __construct()
    {
        parent::__construct();
        /** Config */
        $this->data_view['btnCreate'] = false;
        /** Load model */
        $this->load->model('M_config');
        $this->lang->load('admin_config');  
    }

    function create(){
        $this->load_message('404');
    }

    function edit(){
        $this->load_message('404');
    }

    function _index($view='index',$variable=array()){
        /** default */
        #title page
        $this->data_view['pageTitle'] = $this->_table.'/'.$view;
        $this->load_breadcrumb($this->_table.'/'.$view); 
        $data['view'] = $this->data_view['pageTitle']; 
        /** end default */
        
        if($view=='index'){
            //$config = $this->getListConfig();
            $fileName = "template/backend/config.txt";
            $config = array();
            if (file_exists($fileName)) {
                $f = fopen($fileName, "r");
                $content = fread($f,filesize($fileName));
                
                if (!is_int($content) && !is_float($content)) {
                    $configTemp = json_decode($content,true);

                    if($configTemp){
                        foreach($configTemp as $item){
                            $config[$item['key']] = $item['value'];
                        }
                    }
                }
                fclose($f);
            }
            $data = array(
                'config'=>$config
            );   
        }     
        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }
    
    function getListConfig(){
        $list = $this->My_model->getlist('config');
        $config = null;
        if($list != null){
            foreach($list as $item){
                $config[$item['key']] = $item['value'];
            }
        }
        return $config;
    }
    /** type: null or save draft*/
    function action($type=''){
        if(__IS_AJAX__){
            if($_POST){
                $data_return['status'] = 'fail';
                $check_validation = $this->set_validation(true);
                if($check_validation==false){
                    $data_return['info'] = 'validation fail';
                }else{
                    unset($_POST['type_action']);
                    //$config = $this->getListConfig();
                    $data = array();
                    foreach($_POST as $key=>$item){
                        $data[] = array(
                            'key'=>$key,
                            'value'=>$item
                        );
                        // if(isset($config[$key])){
                        //     $where['key'] = $key;
                        //     $this->My_model->update($this->_table,$data,$where);
                        // }else{
                        //     $data['time'] = time();
                        //     $this->My_model->insert($this->_table,$data);
                        // }
                    }
                    $this->saveFile($data);


                    $data_return['status'] = 'success';
                }
                echo json_encode($data_return);
            }
        }else{
            $this->load_message('404');
        }
    }
    
    function set_rules(){
        $rules['required'] = 
            array('logo','logo_icon','contact_address','contact_hotline','contact_email',
                  'seo_title','seo_desc','seo_keyword','googlemap_lat','googlemap_lng','contact_alert_success');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */

    function saveFile($data=array()){
        if(__IS_AJAX__ && $data){
            $fileName = "template/backend/config.txt";
            //$time = '19-03-2016';
            $dataConfigNew = json_encode($data);
            // Check if a text file exists. If not create one and initialize it to zero.
            $this->checkFieldChange($dataConfigNew);    
            $f = fopen($fileName, "w");
            fwrite($f,$dataConfigNew);
            fclose($f);        
        }else{
            $this->load_message('404');
        }
    }

    function checkFieldChange($dataContentChange=array()){
        $dataContentChange = json_decode($dataContentChange,true);
        $fileName = "template/backend/config.txt";
        $f = fopen($fileName, "r");
        $fileContent = fread($f,filesize($fileName));
        fclose($f);
        $dataContent = json_decode($fileContent,true);
        
        $dataInsertNotification = array();
        if($dataContentChange && $dataContent){
            foreach($dataContent as $item){
                $valueOld = return_valueKey($dataContentChange,'key',$item['key'],'value');
                if($item['value']!=$valueOld){
                    $dataInsertNotification[] = array(
                        'data_id'=>$item['key'],
                        'data_table'=>'config',
                        'id_user'=>$this->data['user']['id'],
                        'time'=>time(),
                        'type'=>'admin',
                        'alert'=>'Chỉnh sửa '.lang($item['key'])
                    );
                }
            }
        }

        if($dataInsertNotification){
            $this->db->flush_cache();
            $this->db->insert_batch('notification', $dataInsertNotification);
        }
        
    }
}
?>