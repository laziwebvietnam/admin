<? 
    class M_tags extends My_model
    {        
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'tags';
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
							   u.fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
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
			$where=array('tb.id'=>$id,'tb.is_delete'=>0);
			$this->db->select('tb.*,u.fullname as u_fullname, u_update.fullname as u_update_fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
					 ->where($where);
			$rs=$this->db->get();
			return $rs->row_array();
        }

        /** Get list by type: article, product */
        function getListByType($type='article',$where=array(),$start=0,$limit=999,$order_by='id desc',$count=false){
            $this->db->flush_cache();
            
            $this->db->select('ts.*')
                     ->from($type.'_tags t')
                     ->join('tags ts','t.id_tag = ts.id')
                     ->join('user u','ts.id_user = u.id','left')
                     ->group_by('t.id_tag')                     
                     ->limit($limit,$start)
                     ->where('ts.is_delete',0)
                     ->where($where)
                     ->order_by($order_by);
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
        
    }
?>