<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Ship_fee extends admin_basic_controller
{
    var $_table = 'ship_fee';
    public function __construct()
    {
        parent::__construct();     
        $this->_createSeoData = true;

        $this->load->model('M_ship_fee');
    }
    
    function set_rules(){
        $rules['required'] = 
            array('id_location');
        // $rules['numeric'] = 
        //     array('fee');
        // $rules['greater_than[0]'] = 
        //     array('fee');
        // $rules['callback_check_unique[id_location]'] = 
        //     array('id_location');
        
        $rules_result = $this->rules_array($rules);
        return $rules_result;
    }
    /** END ACTION */

    // function default_fee() {
    //     $this->_index('default_fee');
    // }

    function edit($id=0, $id_ship_fee=0){
        $data = array(
            'id' => (int)$id,
            'id_ship_fee' => (int)$id_ship_fee,
        );
        $this->_index('edit', $data);
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
        }else if($view=='default_fee'){
            // $data = array(
            //     'detail'=>$this->M_ship_fee->detail_Backend(0),
            // );

            // $view = 'create';
        }else if($view=='create'){
            $data = array(
                //'tag_complete'=>$this->My_model->getlist('tags',array('is_active'=>1,'is_delete'=>0)),
                // 'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
                'location'=>$this->My_model->getlist('location',array('is_active'=>1,'level'=>0),0,999,'position asc')
            );  
        }else if($view=='edit'){
            $data = array(
                'id_location'=>$variable['id'],
                'id_ship_fee'=>$variable['id_ship_fee'],
                // 'seo'=>$this->My_model->getdetail_by_any('seo',array('data_id'=>$variable['id'],'data_table'=>$this->_table)),
                // 'tag_complete'=>$this->M_tags->getListByType($this->_table),
                // 'tag_selected'=>$this->M_tags->getListByType($this->_table,array('t.id_'.$this->_table=>$variable['id'])),
                // 'tag_suggest'=>$this->M_tags->getListByType($this->_table,array('ts.is_active'=>1),0,5),
                'location'=>$this->My_model->getlist('location',array('is_active'=>1,'level'=>0),0,999,'position asc'),
            );
        }        
        $this->load_view('view/'.$this->_table.'/'.$view,$data);
    }

    function listPage_tableField(){
        $this->data_view['tableField'] = array(
            array('name'=>'id','title'=>'Mã'),
            array('name'=>'title','title'=>'Khu vực','linkDetail'=>true),
            array('name'=>'ship_fees','title'=>'Phương thức'),
            // array('name'=>'fee','title'=>'Chi phí','type'=>'number'),
            // array('name'=>'is_active','title'=>'Trạng thái','type'=>'status'),
        );
    }

    function listPage_quickAction(){
        /**
            action: link / action when executed
            title: text for show
            popup (true/false): if true => config by link view popup
        */
        $this->data_view['dataTable']['quickAction'] = array(
            // array('action'=>$this->_table.'/set_status/is_active/0','title'=>'Ẩn','popup'=>false),
            // array('action'=>$this->_table.'/set_status/is_active/1','title'=>'Hiện','popup'=>false),
            array('action'=>$this->_table.'/delete_popup/1','title'=>'Xóa','popup'=>true)
        );
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
                if ($where_in) {
                    foreach ($where_in as $key => $id_location) {
                        $location = $this->My_model->getbyid('location', $id_location);
                        $location['has_ship'] = 0;
                        $this->My_model->update('location', $location);

                        $where_in_2 = array();
                        $ship_fees = $this->My_model->getlist('ship_fee', array(
                            'is_delete' => 0,
                            'id_location' => $id_location
                        ));

                        if ($ship_fees) {
                            foreach ($ship_fees as $k => $fee) {
                                $where_in_2[] = $fee['id'];
                                $children = $this->My_model->getlist('ship_fee', array(
                                    'is_delete' => 0,
                                    'id_parent' => $fee['id']
                                ));

                                if ($children) {
                                    foreach ($children as $kk => $child) {
                                        $where_in_2[] = $child['id'];
                                    }
                                }
                            }
                        }

                        if ($where_in_2) {
                            $this->My_model->update_delete('ship_fee', 'delete', null, $where_in_2);
                        }
                    }
                }
                
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

    function listPage_data($type='list'){
        if($type=='search' && $_GET==null){
            return array();
        }
        $where = array('tb.is_delete'=>0,'c.level'=>0);
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
        $total_row = $this->M_ship_fee->get_all_cityHasShip($where,0,999999,$order_by,true);
    
        /** Page list */
        $pageList = $this->create_pageList($total_row,$baseUrl,$limit,$start);       
        $list = $this->M_ship_fee->get_all_cityHasShip($where,$start,$limit,$order_by);
        $data_return = array(
            'data'=>$list,
            'pageList'=>$pageList,
            'start'=>count($list)==0?0:$start+1,
            'limit'=>count($list)==0?0:$start+count($list),
            'order_by'=>$order_by
        );
        
        return $data_return;
    }

    function loadFees($id, $id_ship_fee) {
        if (__IS_AJAX__) {
            $this->load->view($this->_base_view_path . 'view/ship_fee/ajax_loadFees', array(
                'id_ship_fee' => $id_ship_fee,
                'fees' => $this->M_ship_fee->get_all(array(
                    'id_location' => $id,
                    'tb.is_active' => 1,
                    'tb.is_delete' => 0,
                ))
            ));
        }
    }

    function openModalFee($id_location, $action, $id=0) {
        if (__IS_AJAX__) {
            if ($action == 'edit') {
                $where = array(
                    'tb.is_active' => 1,
                    'tb.id_parent' => $id_location,
                    'sf.id_parent' => $id
                );

                $data = array(
                    'locations' => $this->M_ship_fee->queryLocations($where, 0, 999, 'position asc'),
                    'fee' => $this->M_ship_fee->detail_Backend($id),
                    'id_location' => $id_location
                );

                $this->load->view($this->_base_view_path . 'view/ship_fee/ajax_modalEditFee', $data);
            } elseif ($action == 'add') {
                $data = array(
                    'locations' => $this->My_model->getlist('location', array(
                        'is_active' => 1,
                        'id_parent' => $id_location
                    ), 0, 999, 'position asc'),
                    'id_location' => $id_location
                );

                $this->load->view($this->_base_view_path . 'view/ship_fee/ajax_modalAddFee', $data);
            } else {
                $data = array(
                    'fee' => $this->M_ship_fee->detail_Backend($id),
                );

                $this->load->view($this->_base_view_path . 'view/ship_fee/ajax_modalRemoveFee', $data);
            }
        }
    }

    function ajax_addFee() {
        if (__IS_AJAX__) {
            $dataFee = array(
                'time' => time(),
                'id_user' => $this->data['user']['id'],
                'title' => $_POST['title'],
                'min' => $_POST['min'],
                'max' => $_POST['max'],
                'type' => $_POST['type'],
                'id_location' => $_POST['id_location'],
                'fee' => $_POST['fee'],
                'id_parent' => 0
            );
            $idFee = $this->My_model->insert('ship_fee', $dataFee);

            if ($idFee) {
                $location = $this->My_model->getbyid('location', $_POST['id_location']);
                $location['has_ship'] = 1;
                $this->My_model->update('location', $location);

                if (isset($_POST['id_district']) && isset($_POST['fee_location'])) {
                    if ($_POST['fee_location']) {
                        foreach ($_POST['fee_location'] as $key => $fee) {
                            $dataFee['id_location'] = $_POST['id_district'][$key];
                            $dataFee['fee'] = $fee ? $fee : 0;
                            $dataFee['id_parent'] = $idFee;
                            $this->My_model->insert('ship_fee', $dataFee);
                        }
                    }
                }
                echo 'Success';
            } else {
                return false;
            }
        }
    }

    function ajax_editFee() {
        if (__IS_AJAX__) {
            $is_update = false;
            $dataFee = $this->My_model->getbyid('ship_fee', $_POST['id']);
            if ($dataFee['title'] != $_POST['title']) {
                $dataFee['title'] = $_POST['title'];
                $is_update = true;
            }
            if ($dataFee['min'] != (float)$_POST['min']) {
                $dataFee['min'] = (float)$_POST['min'];
                $is_update = true;
            }
            if ($dataFee['max'] != (float)$_POST['max']) {
                $dataFee['max'] = (float)$_POST['max'];
                $is_update = true;
            }
            if ($dataFee['type'] != $_POST['type']) {
                $dataFee['type'] = $_POST['type'];
                $is_update = true;
            }
            if ($dataFee['fee'] != $_POST['fee']) {
                $dataFee['fee'] = $_POST['fee'];
                $is_update = true;
            }
            if ($is_update) {
                $dataFee['id_user_update'] = $this->data['user']['id'];
                $dataFee['time_update'] = time();
                $this->My_model->update('ship_fee', $dataFee);
            }

            if (isset($_POST['fee_id']) && isset($_POST['fee_location'])) {
                if ($_POST['fee_id']) {
                    foreach ($_POST['fee_id'] as $key => $id) {
                        $is_update = false;
                        $dataFee = $this->My_model->getbyid('ship_fee', $id);
                        if ($dataFee['title'] != $_POST['title']) {
                            $dataFee['title'] = $_POST['title'];
                            $is_update = true;
                        }
                        if ($dataFee['min'] != (float)$_POST['min']) {
                            $dataFee['min'] = (float)$_POST['min'];
                            $is_update = true;
                        }
                        if ($dataFee['max'] != (float)$_POST['max']) {
                            $dataFee['max'] = (float)$_POST['max'];
                            $is_update = true;
                        }
                        if ($dataFee['type'] != $_POST['type']) {
                            $dataFee['type'] = $_POST['type'];
                            $is_update = true;
                        }
                        if ($dataFee['fee'] != (float)$_POST['fee_location'][$key]) {
                            $dataFee['fee'] = (float)$_POST['fee_location'][$key];
                            $is_update = true;
                        }
                        if ($is_update) {
                            $dataFee['id_user_update'] = $this->data['user']['id'];
                            $dataFee['time_update'] = time();
                            $this->My_model->update('ship_fee', $dataFee);
                        }
                    }
                }
            }
            echo 'Success';
        }
    }

    function ajax_removeFee() {
        if (__IS_AJAX__) {
            $where_in = array($_POST['id']);

            $ship_fee = $this->My_model->getbyid('ship_fee', $_POST['id']);

            $children = $this->My_model->getlist('ship_fee', array(
                'id_parent' => $_POST['id']
            ));

            if ($children) {
                foreach ($children as $key => $fee) {
                    $where_in[] = $fee['id'];
                }
            }

            if ($where_in) {
                $this->My_model->update_delete('ship_fee', 'delete', null, $where_in);
            }

            $fees = $this->My_model->getlist('ship_fee', array(
                'id_location' => $ship_fee['id_location'],
                'is_active' => 1,
                'is_delete' => 0,
                'id_parent' => 0
            ));
            if (!$fees) {
                $location = $this->My_model->getbyid('location', $ship_fee['id_location']);
                $location['has_ship'] = 0;
                $this->My_model->update('location', $location);
            }

            echo 'Success';
        }
    }
}
?>