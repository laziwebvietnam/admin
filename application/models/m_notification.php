<? 
    class M_notification extends My_model
    {
    	var $tableNotShow =  array('views','user','user_role','article_tags','tags','product_tags','order_detail','seo');
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'notification';
        }
        
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            
            if(isset($where['type'])){
                $where_type = $where['type'];
                unset($where['type']);
            }
            
			$this->db->select('tb.*,
							   u.fullname as user_fullname, c.fullname as c_fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('customer c','tb.id_customer = c.id','left')
					 ->where($where)
					 ->limit($limit,$start)
					 ->order_by($order_by);
            
            if($this->tableNotShow != null){
                $this->db->where_not_in('tb.data_table',$this->tableNotShow);
            }
            
            if(isset($where_type)){
                $this->db->where_in('tb.type',$where_type);  
            }
                   
			$rs=$this->db->get();
			$total_row=$rs->num_rows();
			if($count==true)
			{
				return $total_row;
			}
			else
			{
				if($total_row > 0)
				{
					return $rs->result_array();
				}
				else
				{
					return array();
				}
			}
		}
        
        /** Backend get detail */
        function detail_Backend($id){
            $this->db->flush_cache();
			$where=array('tb.id'=>$id,'tb.is_delete'=>0);
			$this->db->select('tb.*,u.fullname as u_fullname, u_update.fullname as u_update_fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
					 ->where($where);
			$rs=$this->db->get();
			return $rs->row_array();
        }
        
    }
?>