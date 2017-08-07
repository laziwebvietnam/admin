<? 
    class M_contact extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'contact';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            
            $title = '';
            if(isset($where['title']))
            {
                $title = $where['title'];
                unset($where['title']);
            }
			$this->db->select('tb.*,
                               c.fullname as "cus_fullname",c.email as "cus_email", c.phone as "cus_phone", c.image as "cus_image"')
					 ->from($this->_table.' tb')
                     ->join('customer c','tb.id_customer = c.id','left')
					 ->where($where)
					 ->limit($limit,$start)
					 ->order_by($order_by);
                     
            if($title != '')
            {
                $this->db->like('tb.title',$title);
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
			$where=array('tb.id'=>$id);
			$this->db->select('tb.*, u_update.fullname as u_update_fullname,
                               c.fullname as "cus_fullname", c.image as "cus_image", c.email as "cus_email", 
                               c.phone as "cus_phone", c.address as "cus_address"')
					 ->from($this->_table.' tb')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
                     ->join('customer c','tb.id_customer = c.id','left')
					 ->where($where);
			$rs=$this->db->get();
			return $rs->row_array();
        }
        
        function getDetailByField($field,$value){
	        if($value==''){
	            return array();
	        }
	        $where = array(
	            'tb.is_delete'=>0,
	            $field=>$value
	        );
	        $this->db->flush_cache();

	        $this->db->select('tb.*, c.email as cus_email, c.phone as cus_phone, c.fullname as cus_fullname, c.address as cus_address')
                     ->from($this->_table.' tb')
                     ->join('customer c','tb.id_customer = c.id','left')
	                 ->where($where);
	        $rs = $this->db->get();
	        $rs = $rs->row_array();
	        return $rs;
	    }
    }
?>