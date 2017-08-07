<? 
    class M_user extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'user';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('tb.title');
            
			$this->db->select('tb.*,
                               r.title as r_title')
					 ->from($this->_table.' tb')
                     ->join('user_role r','tb.id_role = r.id')
					 ->where($where)
					 ->limit($limit,$start)
					 ->order_by($order_by);
                     
            if($where!=null){
                foreach($where as $key=>$item){
                    if(in_array($key,$where_like_item)==true){
                        $this->db->like($key,$item);
                    }
                }
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