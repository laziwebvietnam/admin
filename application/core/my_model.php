<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class My_Model extends CI_Model
{
    /**
     * My_Model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    /**
     * My_Model::insert()
     * 
     * @param mixed $table
     * @param mixed $data
     * @return
     */
    public function insert($table,$data,$type_notifiaction=false)
    {
        $this->db->flush_cache();
        $this->db->insert($table,$data,'id');
        
        $id_insert = $this->db->insert_id();
        if($id_insert>0 && $type_notifiaction==false){
            $this->addToNotification($table,$id_insert,'create');
        }
        return $id_insert;
    }
	 function dcount($table,$where=array(),$al=' p ')
    {
        $this->db->flush_cache();
        $this->db->select('count(id) as total')
                 ->from($table.' as '.$al)
                 ->where($where);
        $rs=$this->db->get();
        $rs=$rs->first_row();
        return $rs->total;
    }
    /**
     * My_Model::counter()
     * 
     * @param mixed $sql
     * @return
     */
    function counter($sql)
    {
        $this->db->flush_cache();
        $query=$this->db->query($sql);
        if($query->num_rows()==0)
            return 0;
        $rs=$query->first_row('array');
        return $rs['num'];
    }
    /**
     * My_Model::update()
     * 
     * @param mixed $table
     * @param mixed $data
     * @param mixed $where
     * @return
     */
    public function update($table,$data,$where=array(),$where_in=array(),$field='id')
    {
        $this->db->flush_cache();
        
        
        if(count($where_in)>0)
        {
            foreach($where_in as $key){                
                $this->db->where($field,$key);
                $this->db->update($table,$data);
                if($this->db->affected_rows() > 0){
                    $this->addToNotification($table,$key,'edit');
                }
            }
            return true;
        }else{
            $data_id = 0;
            if($where==''||count($where)==0)
            {
                if(isset($data['id']))
                {
                    if(is_numeric($data['id'])){
                        $data_id = $data['id'];
                        $where=array('id'=>$data['id']);
                    }                        
                    else
                        $where=array();
                }
            }
            
            if(count($where)>0)
            {
                foreach($where as $key=>$val)
                {
                    $this->db->where($key,$val);
                }
            }
            
            $this->db->update($table,$data);
            if($this->db->affected_rows() > 0)
            {
                $this->addToNotification($table,$data_id,'edit');
                return true;
            }
            return false;
        }
        
        
    }
    
    public function update_delete($table,$type="delete",$where=array(),$where_in=array(),$field='id')
    {
        /**
         * $type = delete => is_delete = 1
         * $type = restore => is_delete = 0
         */ 
        $this->db->flush_cache();
        $data['is_delete'] = $type=='delete'?1:0;
        if(count($where_in)>0)
        {
            foreach($where_in as $key){                
                $this->db->where($field,$key);
                $this->db->update($table,$data);
                if($this->db->affected_rows() > 0){
                    $this->addToNotification($table,$key,'delete');
                }
            }
            return true;
            
        }else{
            
            $key_ = null;
            if(count($where)>0)
            {
                foreach($where as $key=>$val)
                {
                    if($key=='id'){
                        $key_ = $val;
                    }                    
                    $this->db->where($key,$val);
                }
            }
            $this->db->update($table,$data);
            $this->addToNotification($table,$key_,'delete');
            if($this->db->affected_rows() > 0)
                return true;
            return false;   
        }
             
    }
    /**
     * My_Model::delete()
     * 
     * @param mixed $table
     * @param mixed $where
     * @return
     */
    public function delete($table,$where=array(),$where_in=array(),$field='id')
    {
        $this->db->flush_cache();
        if(count($where_in)>0)
        {
            foreach($where_in as $key){
                $this->db->where($field,$key);
                $this->db->delete($table);
                $this->addToNotification($table,'delete');
            }
            return true;
        }
        else
        {
            if(count($where)>0)
            {
                foreach($where as $key=>$val)
                {
                    $this->db->where($key,$val);
                }
                $this->db->delete($table);
                
                return true;
            }
            else
            return false;
        }
        
    }
    
    #delete mutil
    public function delete_multi($table,$field,$array_id=array())
    {
        $this->db->flush_cache();
        if(count($where)>0)
        {
            $this->db->where_in($field,$array_id);
            $this->db->delete($table);
            return true;
        }
        else
        return false;
    }
    
    //thuc thi cau lenh sql
    /**
     * My_Model::sql_excutequery()
     * 
     * @param mixed $sql
     * @return
     */
    public function sql_excutequery($sql){
        $this->db->flush_cache();
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0)
            return array();
        return $rs->result_array();
    }
    /**
     * My_Model::getbyid()
     * 
     * @param string $table
     * @param integer $id
     * @return
     */
    public function getbyid($table,$id=0)
    {
        $this->db->flush_cache();
		$query=$this->db->get_where($table,array('id'=>$id));
        if($query->num_rows()==0)
            return false;
		$rs=$query->first_row('array');
		return $rs;
    }
    /**
     * My_Model::get_where_item()
     * 
     * @param string $table
     * @param mixed $where
     * @return
     */
    public function get_where_item($table,$where=array())
    {
        $query=$this->db->get_where($table,$where);	
        $this->db->flush_cache();
        if($query->num_rows()==0)
            return false;
		$rs=$query->first_row('array');
		return $rs;
    } 
	public function checkfield($table,$field,$data)
     {
        $this->db->flush_cache();
		$query=$this->db->get_where($table,array($field=>$data));
        if($query->num_rows()==0)
            return false;
		return true;
     }
    /**
     * My_Model::getlist()
     * 
     * @param mixed $table
     * @param mixed $where
     * @param integer $start
     * @param integer $limit
     * @param string $order
     * @return
     */
    public function getlist($table,$where=array(),$start=0,$limit=999,$order='id desc')
    { 
        $this->db->flush_cache();
        if($order!='')
        {
            $this->db->order_by($order);
        }
        $query=$this->db->get_where($table,$where,$limit,$start);
        return $query->result('array');
    }   
    /**
     * My_Model::dcount()
     * 
     * @param mixed $table
     * @param mixed $where
     * @param string $as
     * @return
     */
    /**
     * My_Model::fix_where()
     * 
     * @param mixed $wheres
     * @return
     */
    function fix_where($wheres=array())
    {
        $wherecondition='';
        if($wheres==''||empty($wheres))
            return '';
        else
        {
            $dot='';
            foreach($wheres as $key=>$val)
            {
                if(preg_match('/(>|<|>=|<=|not in|in)/',$key))
                {
                    $wherecondition.=$dot." $key $val";
                }
                elseif(preg_match('/(like|not like)/',$key))
                {
                    $wherecondition.=$dot." $key '$val'";
                }
                elseif(preg_match('/\./',$key))
                {
                    $wherecondition.=$dot.$key."='$val'";
                }
                else
                {
                    $val=mysql_escape_string($val);
                    $wherecondition.=$dot." `$key`='$val'";
                }
                $dot=' and ';
            }
        }
        $wherecondition=($wherecondition=='')?'':' where '.$wherecondition;
        return $wherecondition;
    }
    /**
     * My_Model::dlookup()
     * 
     * @param string $table
     * @param mixed $where
     * @param bool $getfirstRow
     * @return
     */
    function dlookup($table='',$where=array(),$getfirstRow=true){
        $rs=$this->db->get_where($table,$where);
        $this->db->flush_cache();
        if($rs->num_rows()==0)
            return false;
        if($getfirstRow)
            return $rs->first_row('array');
        return $rs->result('array');
    }
    /**
     * My_Model::updatefieldbyid()
     * 
     * @param mixed $table
     * @param mixed $field
     * @param mixed $value
     * @param mixed $id
     * @return
     */
    function updatefieldbyid($table,$field,$value,$id)
    {
        $this->db->flush_cache();
        $this->db->update($table,array($field=>$value),array('id'=>$id));
        $this->db->flush_cache();
        return;
    }
    /**
     * My_Model::getselection()
     * 
     * @param mixed $table
     * @param mixed $field
     * @param mixed $where
     * @param string $orderb
     * @return
     */
    function getselection($table,$field='*',$where=array(),$orderb='id asc')
    {
        $this->db->flush_cache();
        $this->db->select($field)
                 ->from($table)
                 ->where($where)
                 ->order_by($orderb);
        $query=$this->db->get();
        $rs=$query->result('array');
        $_v='Moi chon';
        $selections=array(''=>$_v?$_v:'Please, select');
        $field=explode(',',$field);
        foreach($rs as $r)
        {
            $selections[$r[$field[0]]]=$r[$field[1]];
        }
        return $selections;
    }
    /**
     * My_Model::truncate_table()
     * 
     * @param mixed $table
     * @param mixed $where
     * @return
     */
    function truncate_table($table,$where=array())
    {
        if(!is_array($where)||count($where)<1)
        {
            return false;
        }
        $this->db->delete($table,$where);
        return true;
    }
    public function getdetail_by_any($table,$where = array(),$order_by='id desc')
    {
        $this->db->flush_cache();
        $this->db->from($table)
                 ->where($where)
                 ->order_by($order_by);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        return false;
    }
    
    public function create_historyuser($table='',$info=array(),$type='other',$action='')
    {
        if(isset($info['id']))
        {
            $type_array = array(
                'create'=>'Thêm mới thành công '.lang($table).':',
                'update'=>'Chỉnh sửa thành công '.lang($table).':',
                'delete'=>'Xóa thành công '.lang($table).':',
                'sentmail'=>'Gửi bản tin '.lang($table).':',
                'other'=>null
            );
            
            $title = isset($info['title'])?$info['title']:'link';
            
            $action = $type_array[$type];
            
            if($type=='create' || $type=='update')
            {
                $action .= " <b><a target=\"_blank\" href=\"admin/$table/update/$info[id]\">$title</a></b>";
            }
            else if($type=='delete')
            {
                $action .= " <b>$title</b>";
            }
            
            $data = array(
                'table'=>$table,
                'id_excute'=>$info['id'],
                'action'=>$action,
                'id_user'=>$this->data['user']['id'],
                'time'=>time()
            );
            
            $this->insert('history',$data);
        }
        
    }
    
    public function check_alias_exists($table='',$alias='',$lang=null,$type='update',$id=0)
    {
        $this->db->flush_cache();
        $lang = $lang==null?'':'en_';
        if($type=='create')
        {
            $where=array($lang.'alias'=>$alias);
        }
        else
        {
            $where=array($lang.'alias'=>$alias,
                         'id <>'=>$id);
        }
        $this->db->select()
                 ->from($table)
                 ->where($where);
        $rs=$this->db->get();
        $rs=$rs->result_array();
        if(count($rs) > 0)
            return false;
        return true;
    }

    function getDetailByField($field,$value,$countView=false){
        if($value==''){
            return array();
        }
        $where = array(
            'tb.is_active'=>1,
            'tb.is_delete'=>0,
            $field=>$value
        );
        $this->db->flush_cache();

        $this->db->select('tb.*,
                            u.fullname as author')
                 ->from($this->_table.' tb')
                 ->join('user u','tb.id_user = u.id','left')
                 ->where($where);
        $rs = $this->db->get();
        $rs = $rs->row_array();
        if(isset($rs['views']) && $countView == true){
            $dataUpdate['views'] = $rs['views']+1;
            $whereUpdate = array('id'=>$rs['id']);
            $this->db->flush_cache();
            $this->db->where($whereUpdate)
                     ->update($this->_table,$dataUpdate);
        }
        return $rs;
    }

    function getArticleOneByField($field,$value,$countView=false){
        if($value==''){
            return array();
        }
        $where = array(
            'tb.is_active'=>1,
            'tb.is_delete'=>0,
            $field=>$value
        );
        $this->db->flush_cache();

        $this->db->select('tb.*,
                            u.fullname as author')
                 ->from('article_one tb')
                 ->join('user u','tb.id_user = u.id','left')
                 ->where($where);
        $rs = $this->db->get();
        $rs = $rs->row_array();
        if(isset($rs['views']) && $countView == true){
            $dataUpdate['views'] = $rs['views']+1;
            $whereUpdate = array('id'=>$rs['id']);
            $this->db->flush_cache();
            $this->db->where($whereUpdate)
                     ->update('article_one',$dataUpdate);
        }
        return $rs;
    }
    
    /** add to notification / history */
    function addToNotification($table='',$id=0,$action=''){
        $table = $table==''?$this->_table:$table;
        $table_not_insert = explode(',','seo,product_tags,views,order_detail,product_tags,article_tags');
        if(in_array($table,$table_not_insert)==false){
            if($table!='' && $id!=0 && $action!=''){
                $alert = lang($action)." ".strtolower(lang($table));
                $data_table = $this->getbyid($table,$id);
                
                if($data_table!=null){
                    $alert .= " <a href=\"$table/edit/$id\">";
                    if(isset($data_table['title'])){
                        $alert .= $data_table['title'];
                    }else if(isset($data_table['fullname'])){
                        $alert .= $data_table['fullname'];
                    }else{
                        $alert .= "có mã là $id";
                    }
                    $alert .= "</a>";
                    
                    $data = array(
                        'data_id'=>$id,
                        'data_table'=>$table,
                        'id_user'=>isset($this->data['user']['id'])?$this->data['user']['id']:-1,
                        'action'=>$action,
                        'alert'=>$alert,
                        'time'=>time(),
                        'type'=>isset($this->data['user']['id'])?'admin':'user'
                    );
                    $this->insert('notification',$data,true);
                }            
            }
        }
    }
}
?>