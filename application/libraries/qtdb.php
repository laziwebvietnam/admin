<?php
class qtdb{
    var $CI='';
    var $table='';
    var $cols=array();
    var $config=array();
    var $where=array();
    function __construct($params=array()){
        $this->CI=& get_instance();
        //$this->table='configs';
        //$this->cols=array('id','title','keyname','value','rules','default');
        $this->ini($params);
    }
    function ini($params=array()){
        foreach($params as $k=>$v)
        {
            if(isset($this->$k))
                $this->$k=$v;
        } 
        if(!is_array($this->cols))
            $this->cols=explode(',',$this->cols);
        if(!in_array('id',$this->cols))
            $this->cols[]='id';
    }
    function index(){
        $this->CI->load_view('qtdb/dblist');
    }
    function getjsdb(){
        //echo '<pre>';
        //print_r($this->output());
        echo json_encode($this->output());
    }
    protected function output(){
        $this->CI->load->model('mqtdb');
        //order 
        $orderby=$this->_setorder();
        //where
        $where=$this->CI->filter_where();
        $where=$this->_setsearch($where);
        $where=array_merge($where,$this->where);
        //pagination $_GET['iDisplayStart'] $_GET['iDisplayStart']
        $this->_setlimit($limit,$start);
        //get result
        $cols=(isset($this->config['set_modify'])&&$this->config['set_modify'])?array_merge($this->cols,array('modify')):$this->cols;
        $data=$this->CI->mqtdb->qtdb_getlist($this->table,$where,$start,$limit,$orderby,$cols);
        $data=$this->_processrows($data);
        //print_r($data);return;
        $output = array(
    		"sEcho" => intval(isset($_GET['sEcho'])?$_GET['sEcho']:''),
    		"iTotalRecords" => $this->CI->My_model->dcount($this->table),
    		"iTotalDisplayRecords" => $this->CI->My_model->dcount($this->table,$where),
    		"aaData" => $data
    	);
        return $output;
    }
    protected function _processrows($data=array()){
        //echo '<pre>';
        //print_r($data);exit();
        $output=array();
        foreach($data as $row){
            if(!isset($this->config['edit_btn'])||$this->config['edit_btn']==false)
                $img_detail_open='';
            else
                $img_detail_open='<a href="admin/'.$this->CI->selected_controller.'/update/'.$row['id'].'"><i class="splashy-pencil"></i></a>';
            if($this->config['delete_btn'])
            {
                if($this->config['set_modify']&&$row['modify']==0)
                    $img_detail_open.='
                        
                    ';
                else
                    $img_detail_open.='
                        <a href="admin/'.$this->CI->selected_controller.'/delete/'.$row['id'].'"><i class="splashy-remove_outline"></i></a>
                    ';
            }            
            $new=array($img_detail_open);
            foreach($row as $k=>$v)
            {   
                if($k=='modify') continue;
                switch($k){
                    case 'avatar':;
                    case 'image':$v="<img src='$v' width='120px'/>";break;
                    case 'images':
                        $v=explode('||',$v);
                        $v=$v[0];
                        $v="<img src='$v' width='120px'/>";
                        break;
                    case 'date':;
                    case 'date_delivery_true':$v=date('d-m-Y',$v);break;
                    case 'generated_date':
                        $v=date('H:i:s d-m-Y',$v);break;
                    case 'price':$v=number_format($v,0,'.',',');break;
                    case 'is_active':$v=tfimg2($v,$this->table,$k,$row['id']);break;
                    default:
                        break;
                }
                if(is_numeric($v))
                    $v=number_format($v,0,'.',',');
                $new[]=$v;
            }
            $output[]=$new;
        }
        return $output;
    }
    protected function _setlimit(&$limit=0,&$start=10)
    {
        $limit=(int)$this->CI->input->get('iDisplayLength');
        if($limit>0)
        {
            $this->CI->session->set_userdata('qtdb_limit',$limit);
        }
        elseif($limit=$this->CI->session->userdata('qtdb_limit'))
        {
            
        }
        elseif(isset($this->_template['config']['per_page'])&&$this->_template['config']['per_page']>0)
        {
            $limit=$this->_template['config']['per_page'];
        }
        else
            $limit=10;
        
        $start=(int)$this->CI->input->get('iDisplayStart');
        $start=$start>0?$start:0;        
    }
    protected function _setorder(){
        $aColumns=$this->cols;
        $sOrder = "";
    	if ( isset( $_GET['iSortCol_0'],$_GET['iSortingCols']) )
    	{
    		$sOrder = "";
            $dot='';
    		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
    		{
    			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
    			{
                    try{
    				    $sOrder .=$dot.$aColumns[ intval( $_GET['iSortCol_'.$i] )-1 ]
                        .' '.mysql_real_escape_string( $_GET['sSortDir_'.$i]);
                        $dot=',';
                        $this->search_col=$aColumns[ intval( $_GET['iSortCol_'.$i] )-1 ];
                    }catch(Exception $e){}
    			}
    		}
    	}
		if ( $sOrder == "" )
		{
            $this->search_col='id';
			$sOrder = "id desc";
		}
        return $sOrder;
    }
    protected function _setsearch($where=array()){
        if(isset($this->search_col,$_GET['sSearch'])&&trim($_GET['sSearch'])!='')
            $where[$this->search_col.' like']='%'.str_replace(' ','%',$_GET['sSearch']).'%';
        return $where;
    }
}
?>