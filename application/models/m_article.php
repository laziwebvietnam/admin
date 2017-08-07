<?
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */ 
    class M_article extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'article';
            $this->load->model('M_category');
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('tb.title');
            $id_category = isset($where['id_category'])?$where['id_category']:null;
            unset($where['id_category']);
            $where_in = $this->M_category->find_category_child($id_category);
            
            $tags = array();
            if(isset($where['tag']))
            {
                $tags = $where['tag'];
                unset($where['tag']);
            }
            
			$this->db->select('tb.*,
							   c.alias as c_alias, c.title as c_title,
							   u.fullname')
					 ->from($this->_table.' tb')
					 ->join('category c','tb.id_category = c.id','left')
					 ->join('user u','tb.id_user = u.id','left')
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

            if($where_in != null)
            {
                $this->db->where_in('id_category',$where_in);
            }
            
            
            if($tags != null)
            {
                $this->db->join('article_tags pt','pt.id_article = tb.id','left');
                $this->db->join('tags t','t.id = pt.id_tag','left');
                $this->db->where_in('t.alias',$tags);
                $this->db->group_by('pt.id_article');
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
        

        /**
         * [get list article]
         * @param  array   $where    [where]
         * @param  integer $start    [start]
         * @param  integer $limit    [limit]
         * @param  string  $order_by [order by]
         * @param  boolean $count    [true: return number, false: return array]
         * @return [array]           [article list]
         */
        function frontend_getList($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false){
            $this->db->flush_cache();
            $where_like_item = array('tb.title','tb.en_title');
            $where['tb.is_active'] = 1;
            $where['tb.is_delete'] = 0;
            $id_category = isset($where['id_category'])?$where['id_category']:null;
            unset($where['id_category']);
            $where_in = $this->M_category->find_category_child($id_category);
            $tags = array();
            if(isset($where['tag']))
            {
                $tags = $where['tag'];
                unset($where['tag']);
            }
            
            $this->db->select('tb.*,
                               c.alias as c_alias, c.en_alias as en_c_alias, c.title as c_title, c.en_title as en_c_title')
                     ->from($this->_table.' tb')
                     ->join('category c','tb.id_category = c.id','left')
                     ->limit($limit,$start)
                     ->order_by($order_by);
                     
            if($where_in != null)
            {
                $this->db->where_in('id_category',$where_in);
            }
            
            if($tags != null)
            {
                $this->db->join('article_tags pt','pt.id_article = tb.id','left');
                $this->db->join('tags t','t.id = pt.id_tag','left');
                $this->db->where_in('t.id',$tags);
                $this->db->group_by('pt.id_article');
            }
            if($where!=null){
                foreach($where as $key=>$item){
                    if(in_array($key,$where_like_item)==true){
                        if($item!=''){
                            $this->db->like($key,$item);
                        }
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
                    $rs = $rs->result_array();
                    return $rs;
                }
                else
                {
                    return array();
                }
            }
        }
    }
?>