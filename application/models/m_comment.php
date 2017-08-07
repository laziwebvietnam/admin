<? 
    class M_comment extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'comment';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('c.fullname');

			$this->db->select('tb.*,
							   u.fullname,c.fullname as "cus_fullname",c.email as "cus_email", c.phone as "cus_phone", c.image as "cus_image"')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('customer c','tb.id_customer = c.id')
					 ->limit($limit,$start)
					 ->order_by($order_by);

			 if($where!=null){
                foreach($where as $key=>$item){
                    if(in_array($key,$where_like_item)==true){
                        $this->db->like($key,$item);
                        unset($where[$key]);
                    }
                }
            }  

            $this->db->where($where);
                        
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
        function detail_Backend($id,&$idParent=null){
            $this->db->flush_cache();
			$where=array('tb.id'=>$id/*,'tb.is_delete'=>0*/);
			$this->db->select('tb.*,u.fullname as u_fullname, u_update.fullname as u_update_fullname,
                               c.fullname as "cus_fullname", c.image as "cus_image", c.email as "cus_email", c.phone as "cus_phone",
                               p.title as "product_title", a.title as "article_title"')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
                     ->join('customer c','tb.id_customer = c.id','left')
                     ->join('product p','tb.data_id = p.id','left')
                     ->join('article a','tb.data_id = a.id','left')
					 ->where($where);
			$rs=$this->db->get();
			$rs=$rs->row_array();
			if($rs){
				$idParent = $rs['id_parent']==0?$id:$rs['id_parent'];
			}
			return $rs;
        }

        function getListByIdParent($id){
        	$this->db->flush_cache();
        	$where = array('tb.id_parent'=>$id,'tb.is_delete'=>0);
        	$this->db->select('tb.*,u.fullname as u_fullname, u_update.fullname as u_update_fullname,
                               c.fullname as cus_fullname, c.image as cus_image, c.email as cus_email, c.phone as cus_phone')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
					 ->join('user u_update','tb.id_user_update = u_update.id','left')
                     ->join('customer c','tb.id_customer = c.id','left')
					 ->where($where);
			$rs=$this->db->get();
			return $rs->result_array();
        }	
        
    }
?>