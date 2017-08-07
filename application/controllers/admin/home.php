<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Home extends admin_action_controller
{
    public function __construct()
    {
        parent::__construct();
        /** Config */
        $this->_table = 'dashboard';
        $this->load_dataView_dataAction();
        $this->load->model('M_order');
        $this->load->model('M_notification');
        $this->load->model('M_contact');
        
        if($this->data['user']==null){
            redirect('admin/user/login');
        }
    }
    
    function index($view='index'){
        $this->_index($view);
    }
    
    function _index($view='index',$variable=array()){
        /** default */
        #title page
        $this->data_view['pageTitle'] = $this->_table.'/'.$view;
        $this->load_breadcrumb($this->_table.'/'.$view); 
        $data['view'] = $this->data_view['pageTitle'];
        $this->insertViews();
        $data['info'] = $this->loadDefaultInfo(); 
        
        /** end default */
        
        $this->load_view('view/dashboard/index',$data);
    }
    
    function loadDefaultInfo(){
        $data_return = array();
        
        $data_return['order'] = $this->My_model->dcount('order',array('is_delete'=>0));
        $data_return['contact'] = $this->My_model->dcount('contact',array('is_delete'=>0,'is_reply'=>0));
        $data_return['product'] = $this->My_model->dcount('product',array('is_delete'=>0));
        $data_return['article'] = $this->My_model->dcount('article',array('is_delete'=>0));
        $data_return['contact_noread'] = $this->M_contact->get_all(array('tb.is_read'=>0,'tb.is_delete'=>0));
        $data_return['contact_noreply'] = $this->M_contact->get_all(array('tb.is_reply'=>0,'tb.is_delete'=>0));
        return $data_return;   
    }
    
/** get traffic */
    function insertViews(){
        $counter_name = "template/backend/counter.txt";
        if (file_exists($counter_name)){
            $lines = file($counter_name);
            if($lines!=null){
                foreach($lines as $row=>$info){
                    $time = substr($info,0,10);
                    $views = (int)substr($info,10);
                    $where['time'] = $time;
                    $findExist = $this->My_model->getdetail_by_any('views',$where);
                    if($findExist!=null){
                        $findExist['views'] += $views;
                        $this->My_model->update('views',$findExist);
                    }else{
                        $dataViews = array(
                            'time'=>$time,
                            'views'=>$views
                        );
                        $this->My_model->insert('views',$dataViews);
                    }
                }
            }
            unlink($counter_name);
        }
    }

    function groupViews($timeTo='',$timeEnd='',$dayGroup='default'){
        $where = array('time >='=>date('Y-m-d',$timeTo),'time <='=>date('Y-m-d',$timeEnd));
        $viewsList = $this->My_model->getlist('views',$where,0,365,'time asc'); 
        $viewFullList = array();
        if($viewsList!=null){    
            $time = 0;
            $first = true;
            foreach($viewsList as $key=>$row){
                if($first==false){
                    $timeNow = strtotime($row['time']);
                    $timePrev = strtotime($viewsList[$key-1]['time']);
                    /** find and insert a day dont have data 
                     *  ex: find date from 01 to 10, but date 4 5 are NULL. So set 4 5 = 0.
                     */
                    if(($timeNow-$timePrev)/86400 > 1){
                        for($i=1;$i<($timeNow-$timePrev)/86400;$i++){
                            $view = array(
                                'time'=>date('Y-m-d',$timePrev+86400*$i),
                                'views'=>0
                            );
                            $viewFullList[] = $view;
                            //$this->My_model->insert('views',$view);
                        }
                    }
                }
                
                if($first==true){
                    $first=false;
                }
                
                if(isset($timeNow) && isset($timePrev)){
                    if(date('Y-m-d',$timeNow)==date('Y-m-d',$timePrev)){
                        $viewFullList[count($viewFullList)-1]['views'] += $row['views'];
                        continue;
                    }
                }
                
                $viewFullList[] = $row;
            }
            
            /** timeLast in array */
            $timeLast = strtotime($viewsList[count($viewsList)-1]['time']);
            /** check date' not exist. 
             * Ex: find date from 01 to 10, but date 8 9 0 are NULL. So set 8 9 0 = 0.
             */ 
            if(($timeEnd-$timeLast)/86400 > 1){
                for($i=($timeEnd-$timeLast)/86400-1;$i>=0;$i--){
                    $view = array(
                        'time'=>date('Y-m-d',$timeEnd-86400*$i),
                        'views'=>0
                    );
                    $viewFullList[] = $view;
                    //$this->My_model->insert('views',$view);
                }
            }
        }
        
        /** Group day */
        $viewResult = array();
        if($dayGroup=='default'){
            $dayGroup = count($viewFullList)/7;
        }else{
            $dayGroup = (int)$dayGroup;
        }
        
        if($viewFullList != null){
            if($dayGroup>1){
                $time = '';
                $keyInsert = -1;
                foreach($viewFullList as $key=>$row){
                    if($key%$dayGroup==0){
                        $time = $row['time'];
                        $keyInsert++;
                    }
                    if(isset($viewResult[$keyInsert])){
                        $viewResult[$keyInsert]['views'] += $row['views'];
                    }else{
                        $viewResult[$keyInsert] = array(
                            'time'=>$time,
                            'views'=>$row['views']
                        );
                    }
                }
            }else{
                $viewResult = $viewFullList;
            }
        }        
        
        return $viewResult;
    }
    
    function getChartTraffic(){        
        $timeTo = 0;
        $timeEnd = 0;
        $data_result = array();
        if($_POST){
            $timeTo = strtotime($_POST['dateTo']);
            $timeEnd = strtotime($_POST['dateEnd']);
        }else{
            /** count views, default 7 days */
            $timeEnd = strtotime(date('Y-m-d',time()));
            $timeTo = $timeEnd - 7*86400;
        } 
        
        if($timeTo < $timeEnd){            
            $data_views = $this->groupViews($timeTo,$timeEnd);
            if($data_views != null){
                foreach($data_views as $item){
                    $day = date('d-m',strtotime($item['time']));
                    $data_result[] = array($day,$item['views']);
                }
            }
        }
        
        echo json_encode($data_result);
    }
/** end get traffic */

/** get order */
    function getChartOrder(){        
        $timeTo = 0;
        $timeEnd = 0;
        $data_result['chart'] = array();
        $data_result['total_amount'] = 0;
        $data_result['qty'] = 0;
        if($_POST){
            $timeTo = strtotime($_POST['dateTo']);
            $timeEnd = strtotime($_POST['dateEnd']);
        }else{
            /** count order, default 7 days */
            $timeEnd = strtotime(date('Y-m-d',time()));
            $timeTo = $timeEnd - 7*86400;
        } 
        if($timeTo < $timeEnd){            
            $dataOrder = $this->groupOrders($timeTo,$timeEnd);
            $dataOrderChartList = array(); 
            
            if($dataOrder['list'] != null){
                foreach($dataOrder['list'] as $item){                
                    $day = date('d-m',$item['time']);
                    $dataOrderChartList[] = array($day,$item['total_amount']);
                }
            }   
            
            $data_result['chart'] = $dataOrderChartList;
            $data_result['total_amount'] = number_format($dataOrder['total'],0,'.','.').' đ';
            $data_result['qty'] = $dataOrder['qty'];
        }
        
        echo json_encode($data_result);
        
        for($i=0;$i<=1;$i++){
            
            $time = strtotime(date('Y-m-d',time()-86400*$i));
            $data = array(
                'time'=>$time,
                'total_amount'=>rand(100000,5000000)
            );
            //$this->My_model->insert('order',$data);
        } 
    }
    
    function groupOrders($timeTo='',$timeEnd='',$dayGroup='default'){
        $where = array('time >='=>$timeTo,'time <='=>$timeEnd);
        $orderList = $this->My_model->getlist('order',$where,0,9999,'time asc'); 
        $orderFullList = array();
        if($orderList!=null){    
            $time = 0;
            $first = true;
            foreach($orderList as $key=>$row){
                if($first==false){
                    $timeNow = $row['time'];
                    $timePrev = $orderList[$key-1]['time'];
                    
                    /** find and insert a day dont have data */
                    if(($timeNow-$timePrev)/86400 > 1){
                        //echo $key;
                        //exit;
                        for($i=1;$i<($timeNow-$timePrev)/86400;$i++){
                            $order = array(
                                'time'=>$timePrev+86400*$i,
                                'total_amount'=>0
                            );
                            $orderFullList[] = $order;
                        }
                    }
                }
                
                if($first==true){
                    $first=false;
                }
                if(isset($timeNow) && isset($timePrev)){
                    if(date('Y-m-d',$timeNow)==date('Y-m-d',$timePrev)){
                        $orderFullList[count($orderFullList)-1]['total_amount'] += $row['total_amount'];
                        continue;
                    }
                }
                
                $orderFullList[] = $row;
            }
            
            /** timeLast in array */
            $timeLast = $orderList[count($orderList)-1]['time'];
            /** check date' not exist. 
             * Ex: find date from 01 to 10, but date 8 9 0 are NULL. So set 8 9 0 = 0.
             */ 
            if(($timeEnd-$timeLast)/86400 > 1){
                for($i=($timeEnd-$timeLast)/86400-1;$i>=0;$i--){
                    $view = array(
                        'time'=>$timeEnd-86400*$i,
                        'total_amount'=>0
                    );
                    $orderFullList[] = $view;
                    //$this->My_model->insert('views',$view);
                }
            }
            
            
        }
        
        /** Group day */
        $orderResult = array();
        $orderTotalamount = 0;
        if($dayGroup=='default'){
            $dayGroup = count($orderFullList)/7;
            $dayGroup = $dayGroup<1?1:$dayGroup;
        }else{
            $dayGroup = (int)$dayGroup;
        }
        
        if($orderFullList != null){
            // if($dayGroup>1){
                $time = '';
                $keyInsert = -1;
                foreach($orderFullList as $key=>$row){
                    if($key%$dayGroup==0){
                        $time = $row['time'];
                        $keyInsert++;
                    }
                    if(isset($orderResult[$keyInsert])){
                        $orderResult[$keyInsert]['total_amount'] += $row['total_amount'];
                    }else{
                        $orderResult[$keyInsert] = array(
                            'time'=>$time,
                            'total_amount'=>$row['total_amount']
                        );
                    }
                    $orderTotalamount += $row['total_amount'];
                }
            // }else{
            //     $orderResult = $orderFullList;
            // }
        }      
        
        $orderResult['list'] = $orderResult;
        $orderResult['qty'] = count($orderList);  
        $orderResult['total'] = $orderTotalamount;
        return $orderResult;
    }
/** end get order */

/** get notification */
    function getNotification(){
        $where = array();
        if($_POST){
            $where['type'] = $_POST['type'];
        }
        $data['list'] = $this->M_notification->get_all($where,0,8);
        echo $this->load->view($this->_base_view_path.'view/dashboard/include/ajax/loadNotification',$data,true);
    }
/** end get notification */

    function error(){
        $this->load_message();
    }
}
?>