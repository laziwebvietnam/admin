<? 
    class M_order extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'order';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('c.fullname','c.phone','c.address','c.email');
            
			$this->db->select('tb.*,
                               c.fullname as cus_fullname, c.phone as cus_phone, c.address as cus_address, c.email as cus_email,
							   u.fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('customer c','tb.id_customer = c.id','left')
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
        function detail_Backend($id){
            $this->db->flush_cache();
            $where=array('tb.id'=>$id,'tb.is_delete'=>0);
            $this->db->select('tb.*,
                c.fullname as cus_fullname, c.email as cus_email, c.phone as cus_phone, c.address as cus_address, 
                u.fullname as u_fullname, u_update.fullname as u_update_fullname, 
                co.title as coupon_title, co.value as coupon_value, co.type as coupon_type, co.code as coupon_code, 
                d.title as district_title, ci.title as city_title')
                     ->from($this->_table.' tb')
                     ->join('user u','tb.id_user = u.id','left')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
                     ->join('customer c','tb.id_customer = c.id','left')
                     ->join('coupon co','co.id = tb.id_coupon','left')
                     ->join('location d','d.id = tb.district','left')
                     ->join('location ci','ci.id = tb.city','left')
                     ->where($where);
            $rs=$this->db->get();
            return $rs->row_array();
        }
        
        /** return total Order Info */
        function getTotalOrderInfo($where=array()){
            $this->db->flush_cache();
            
			$this->db->select('sum(tb.total_amount) as total_amount,count(tb.id) as total_order')
					 ->from($this->_table.' tb')
					 ->where($where);
                     
			$rs=$this->db->get();
			return $rs->row_array();
        }
        
        /** get list order by Id Order */
        function getListProByIdOrder_Backend($id_order=null){
            if($id_order!=null){
                $this->db->flush_cache();
                $where['id_order'] = $id_order;
                $this->db->select('od.*, p.title as product_title')
                         ->from('order_detail od')
                         ->where($where)
                         ->join('order o','od.id_order = o.id')
                         ->join('product p','p.id = od.id_product');
                $rs=$this->db->get();
                return $rs->result_array();
            }
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
    
            $this->db->select('tb.*, c.email as cus_email, c.phone as cus_phone, c.fullname as cus_fullname, c.address as cus_address, co.title as coupon_title, co.value as coupon_value, co.type as coupon_type, co.code as coupon_code, co.id as coupon_id')
                     ->from($this->_table.' tb')
                     ->join('customer c','tb.id_customer = c.id','left')
                     ->join('coupon co','co.id = tb.id_coupon','left')
                     ->where($where);
            $rs = $this->db->get();
            $rs = $rs->row_array();
            return $rs;
        }
        
        function getOrderDetail($idOrder=0){
            $this->db->flush_cache();
            
            $this->db->select('od.*,p.title as prod_title, p.alias as prod_alias')
                     ->from('order_detail od')
                     ->join('product p','od.id_product = p.id','left')                     
                     ->where('od.id_order',$idOrder);
            $rs = $this->db->get();
            $rs = $rs->result_array();
            return $rs;
        }
    }
?>