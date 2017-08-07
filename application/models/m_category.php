<? 
    class M_category extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'category';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('tb.title');
            
			$this->db->select('tb.*,
							   u.fullname')
					 ->from($this->_table.' tb')
					 ->join('user u','tb.id_user = u.id','left')
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

        /**
         * [find_category_child description]
         * @param  integer $id_category [description]
         * @return [type]               [description]
         */
        function find_category_child($id_category=0)
        {
            if($id_category==0) {
                return array();
            }
            $where=array('id_parent'=>$id_category);
            $rs=$this->My_model->getlist('category',$where);
            $where_in = array($id_category);
            
            $test = 0;
            $n = count($rs);
            $rs_temp = array();
            while($rs!=null)
            {
                foreach($rs as $key=>$row)
                {
                    $where_in[] = $row['id'];
                    
                    $where_child = array('id_parent'=>$row['id']);
                    $child = $this->My_model->getlist('category',$where_child);
                    foreach($child as $row_child)
                    {
                        $rs[$n] = $row_child;     
                        $n++;                   
                    }
                    unset($rs[$key]);
                }
            }
            return $where_in;
        }
        
        /**
         * [findLastParentByIdCategory description]
         * @return [type] [description]
         */
        function findBiggestParentByIdCategory($idCategory){
        	$idParentResult = -1;
        	$detailCate = $this->My_model->getbyid('category',$idCategory);
    		while($detailCate['level']>0){
        		$detailCate = $this->My_model->getbyid('category',$detailCate['id_parent']);
        	}
        	return $detailCate;
        }

        function getListByIdParent($idCategory,&$cateList=array()){
            $idParentResult = -1;
            $detailCate = $this->My_model->getbyid('category',$idCategory);
            $detailCateBiggest = $this->findBiggestParentByIdCategory($idCategory);
            
            
            while($detailCate!=null){
                $slug = '';
                if($detailCateBiggest!=null){
                    if($detailCateBiggest['id']!=$detailCate['id']){
                        $slug = $detailCateBiggest[$this->_lang.'alias'].'/';
                    }
                }
                $cateList[] = array(
                    'title'=>$detailCate[$this->_lang.'title'],
                    'alias'=>$slug.$detailCate[$this->_lang.'alias']
                );
                $detailCate = $this->My_model->getbyid('category',$detailCate['id_parent']);
            }
            $cateList = array_reverse($cateList);
            
        }

        function getCategory($alias='',$segment=1){
        	if($alias==''){
        		$segment = (int)$segment;
		        $alias = $this->uri->segment($segment);
		        if($alias=='vi' || $alias=='en'){
		            $alias = $this->alias->segment($segment+1);
		        }
        	}
        	$where = array(
        		'is_active'=>1,
        		'is_delete'=>0,
        		$this->_lang.'alias'=>$alias
    		);
        	$cateDetail = $this->My_model->getdetail_by_any('category',$where);
        	return $cateDetail;
        }
    }
?>