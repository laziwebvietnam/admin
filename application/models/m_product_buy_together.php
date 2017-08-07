<? 
    class M_product_buy_together extends My_model
    {
    	function __construct(){
    		$this->_table = 'product_buy_together';
    		$this->load->model('M_product');
            parent::__construct();
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('tb.title');
            
			$this->db->select('tb.*, p_main.title as pro_main_title, p_relav.title as pro_relative_title,
							   u.fullname as admin_fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
					 ->join('product p_main','p_main.id = tb.id_pro_main','left')
					 ->join('product p_relav','p_relav.id = tb.id_pro_relative','left')
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
			$this->db->select('tb.*,u.fullname as u_fullname, u_update.fullname as u_update_fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
					 ->where($where);
			$rs=$this->db->get();
			return $rs->row_array();
        }
        
        function getListByIdpro($idProMain=0){
        	$this->db->flush_cache();
        	$where = array(
        		'tb.id_pro_main'=>$idProMain,
        		'tb.is_delete'=>0,
        		'pro.is_delete'=>0
    		);
            $where_like_item = array('tb.title');
            
			$this->db->select('tb.*, p_relav.title as pro_relative_title, pro.price as price_nosale,
							   u.fullname as admin_fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
					 ->join('product p_relav','p_relav.id = tb.id_pro_relative','left')
					 ->join('product pro','p_relav.id = pro.id','left')
					 ->where($where)
					 ->order_by('tb.id','asc');
                     
                   
			$rs=$this->db->get();
			$total_row=$rs->num_rows();
			if($total_row > 0){
				return $rs->result_array();
			}else{
				return array();
			}
        }

        function frontend_getListByIdpro($idProMain=0,$getListFree=false){
        	$this->db->flush_cache();
        	$where = array(
        		'tb.id_pro_main'=>$idProMain,
        		'tb.is_active'=>1,
        		'tb.is_delete'=>0,
        		'p_relav.is_delete'=>0
    		);

			if($getListFree==true){
				$where['tb.price_sale'] = 0;
			}

			$this->db->select('p_relav.id, p_relav.alias, p_relav.en_alias, p_relav.title, p_relav.en_title, p_relav.price as price, tb.price_sale as price_sale, tb.promotion, p_relav.price as price, p_relav.price_promotion, p_relav.image')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
					 ->join('product p_relav','p_relav.id = tb.id_pro_relative','left')
					 ->where($where)
					 ->order_by('tb.id','asc');
                     
                   
			$rs=$this->db->get();
			$total_row=$rs->num_rows();
			if($total_row > 0){
				$rs = $rs->result_array();
                $this->M_product->getInfoPrice($rs);
                return $rs;
			}else{
				return array();
			}
        }

        function frontend_checkExistProrelative($idProMain,$idProRelative){
        	$this->db->flush_cache();
        	$where = array(
        		'tb.id_pro_main'=>$idProMain,
        		'tb.id_pro_relative'=>$idProRelative,
        		'tb.is_active'=>1,
        		'tb.is_delete'=>0,
        		'p_relav.is_delete'=>0
    		);
            
			$this->db->select('p_relav.id, p_relav.alias, p_relav.en_alias, p_relav.title, p_relav.en_title, p_relav.price as price, p_relav.image, tb.price_sale as price_sale, tb.promotion, p_relav.price as price, p_relav.price_promotion')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
					 ->join('product p_relav','p_relav.id = tb.id_pro_relative','left')
					 ->where($where)
					 ->order_by('tb.id','asc');
                     
                   
			$rs = $this->db->get();
			$rs = $rs->row_array();
			//$this->M_product->getInfoPriceOneData($rs);
			return $rs;
        }
    }
?>