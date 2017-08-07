<? 
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */ 
    class M_product extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'product';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('tb.title');
            $id_category = isset($where['id_category'])?$where['id_category']:null;
            unset($where['id_category']);
            $where_in = $this->find_category_child($id_category);
            
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
                     
            if($where_in != null)
            {
                $this->db->where_in('id_category',$where_in);
            }
            
            if($tags != null)
            {
                $this->db->join('product_tags pt','pt.id_product = tb.id','left');
                $this->db->join('tags t','t.id = pt.id_tag','left');
                $this->db->where_in('t.alias',$tags);
                $this->db->group_by('pt.id_product');
            }
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
        
		/**
         * [find child category]
         * @param  integer $id_category [id category]
         * @return [array]               [array id category child]
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
         * [get detail product by id]
         * @param  [integer] $id [id product]
         * @return [row array]     []
         */
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

        function getProperty_detail($idProduct=0){
            $this->db->flush_cache();
            $where = array(
                'id_product'=>$idProduct
            );
            $this->db->select('*')
                     ->from('product_property')
                     ->where($where)
                     ->order_by('id','asc');
            $rs_query=$this->db->get();
            $rs_query=$rs_query->result_array();
            $rs = array();
            $price = array();

            if($rs_query){
                foreach($rs_query as $item){
                    $price[] = $item['price'];
                    $priceKey = array_search($item['price'], $price);
                    $key = $priceKey==false?0:$priceKey;
                    $rs[$key][] = array(  
                        'id_size'=>$item['id_size'],
                        'price'=>$item['price']
                    );


                }
            }
            return $rs;
        }

        function updatePropertyInfo($idProduct=0){
            if($this->_property==true){
                if(isset($_POST['pro_size']) || isset($_POST['price_size'])){
                    $sizeInfo['size'] = isset($_POST['pro_size'])?$_POST['pro_size']:null;
                    $sizeInfo['price'] = isset($_POST['price_size'])?$_POST['price_size']:null;
                }

                $dataInsert = array();
                $sizeList = $this->My_model->getlist('product_size');       

                if(isset($sizeInfo['size'])){           
                    if($sizeInfo['size']){
                        foreach($sizeInfo['size'] as $key=>$size){
                            /**
                             * convert from ["5"] to 5 
                             */ 
                            $size = str_replace('"', '', $size);
                            $size = str_replace('[', '', $size);
                            $size = str_replace(']', '', $size);

                            $sizeArray = isset($sizeInfo['size'])?explode(',',$size):null;

                            $price = isset($sizeInfo['price'][$key])?$sizeInfo['price'][$key]:0;
                            
                            if($sizeArray){
                                foreach($sizeArray as $item){
                                    $item = strtolower($item);
                                    if($item){
                                        $statusExist = $this->checkExistSize($item,$sizeList,$sizeId);
                                        $dataInsert[$sizeId] = array(
                                            'id_product'=>$idProduct,
                                            'id_size'=>$sizeId,
                                            'price'=>$price,
                                            'time'=>time(),
                                            'id_user'=>$this->data['user']['id']
                                        );


                                        /** nếu không tồn tại size => insert => phải get lại list mới */
                                        if($statusExist==false){
                                            $sizeList = $this->My_model->getlist('product_size');
                                        }
                                    }
                                    
                                }
                            }
                        }
                    }

                    $proPropertyList = $this->My_model->getlist('product_property',array('id_product'=>$idProduct));
                    
                    /** check for insert - remove - update */
                    $this->checkUpdateProperty($dataInsert,$proPropertyList);

                }else{
                    $this->My_model->delete('product_property',array('id_product'=>$idProduct));
                }
            }
        }

        function checkUpdateProperty(&$dataInsert,$proPropertyList){
            if($this->_property==true){
                if($dataInsert){
                    /** Bước 1: check trong db, size nào không có thì remove */
                    if($proPropertyList){
                        foreach($proPropertyList as $key=>$row){
                            $detailProperty = search_array($dataInsert,'id_size',$row['id_size']);
                            if(!$detailProperty){
                                $this->My_model->delete('product_property',array('id'=>$row['id']));
                            }
                        }
                    }

                    /** Bước 2: check có tồn tại thì update */
                    foreach($dataInsert as $key=>$row){
                        $detailProperty = search_array($proPropertyList,'id_size',$row['id_size']);
                        /** if exist in database => update & unset id for not insert new row */
                        if(isset($detailProperty[0])){
                            /** if price not match => update */
                            if($detailProperty[0]['price'] != $row['price']){
                                $dataUpdate = array(
                                    'id'=>$detailProperty[0]['id'],
                                    'price'=>$row['price'],
                                    'time_update'=>time(),
                                    'id_user_update'=>$this->data['user']['id']
                                );
                                $this->My_model->update('product_property',$dataUpdate);
                            }

                            unset($dataInsert[$key]);
                        }
                    }

                    /** Bước 3: check danh sách dataInsert còn lại */
                    if($dataInsert){
                        $this->db->insert_batch('product_property', $dataInsert);
                    }
                }else{
                    $this->My_model->delete('product_property',array('id_product'=>$idProduct));
                }
            }
        }


        function checkExistSize($size,$sizeList,&$sizeId){
            $sizeInfoDetail = search_array($sizeList,'alias',$size);

            /** size exist in db */
            if(isset($sizeInfoDetail[0])){
                $sizeId = $sizeInfoDetail[0]['id'];
                return true;
            }
            /** size not exist in db => insert in db */
            else{
                $dataSizeInsert = array(
                    'title'=>$size,
                    'en_title'=>$size,
                    'alias'=>stripUnicode_alias(trim($size)),
                    'en_alias'=>stripUnicode_alias(trim($size)),
                    'time'=>time(),
                    'is_active'=>1,
                    'is_delete'=>0,
                    'id_user'=>$this->data['user']['id']
                );
                $sizeId = $this->My_model->insert('product_size',$dataSizeInsert);
                return false;
            }
        }

        

        /**
         * [get list product]
         * @param  array   $where    [where]
         * @param  integer $start    [start]
         * @param  integer $limit    [limit]
         * @param  string  $order_by [order by]
         * @param  boolean $count    [true: return number, false: return array]
         * @return [array]           [product list]
         */
        function frontend_getList($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false){
            $this->db->flush_cache();
            $where_like_item = array('tb.title','tb.en_title');
            $where['tb.is_active'] = 1;
            $where['tb.is_delete'] = 0;
            $id_category = isset($where['id_category'])?$where['id_category']:null;
            unset($where['id_category']);
            $where_in = $this->find_category_child($id_category);
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
                $this->db->join('product_tags pt','pt.id_product = tb.id','left');
                $this->db->join('tags t','t.id = pt.id_tag','left');
                $this->db->where_in('t.id',$tags);
                $this->db->group_by('pt.id_product');
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
                    $this->getInfoPrice($rs);
                    return $rs;
                }
                else
                {
                    return array();
                }
            }
        }
        /**
         * find real price and promotion
         * @param  array  $dataList [product list]
         * @return [array]          [product list result]
         */
        function getInfoPrice(&$dataList=array(),$is_return_row_array=false){
            if($dataList){
                foreach($dataList as $key=>$item){
                    $this->getInfoPriceOneData($dataList[$key]);
                }
            }
        }

        function getInfoPriceOneData(&$dataDetail=array()){
            if($dataDetail){
                $dataDetail['price_result'] = 0;
                $dataDetail['is_sale_off'] = false;
                $dataDetail['sale_title'] = 'N/A';
                
                if(isset($dataDetail['price'])){
                    $dataDetail['price_result'] = $dataDetail['price'];
                }

                if(isset($dataDetail['price_promotion'])){
                    if($dataDetail['price_promotion']>0 && $dataDetail['price_promotion']<$dataDetail['price_result']){
                        $dataDetail['price_result'] = $dataDetail['price_promotion'];
                        $dataDetail['promotion'] = 100 - round($dataDetail['price_result']/$dataDetail['price']*100);
                        $dataDetail['is_sale_off'] = true;
                    }
                }

                if ($dataDetail['id_sale'] != 0) {
                    $sale = $this->My_model->getdetail_by_any('sale', array(
                        'is_active' => 1,
                        'is_delete' => 0,
                        'id' => $dataDetail['id_sale']
                    ));

                    if($sale==null){
                    }else if($sale['time_start'] > time() && $sale['time_start'] != 0){
                    }else if($sale['time_end']+86399 < time() && $sale['time_end'] != 0){
                    }else{
                        switch ($sale['type']) {
                            case 'percent_price':
                                $dataDetail['price_result'] = round($dataDetail['price'] - ($dataDetail['price'] * $sale['value']) / 100, -3);
                                $dataDetail['promotion'] = $sale['value'];
                                break;
                            case 'real_price':
                                $dataDetail['price_result'] = $dataDetail['price'] - $sale['value'];
                                $dataDetail['promotion'] = 100 - round($dataDetail['price_result'] / $dataDetail['price'] * 100);
                                break;
                        }

                        $dataDetail['sale_title'] = $sale[$this->_lang . 'title'];
                        $dataDetail['is_sale_off'] = true;
                    }
                }
            }
        }

        function getDetailByField($field,$value,$countView=true){
            if($value==''){
                return array();
            }
            $where = array(
                'tb.is_active'=>1,
                'tb.is_delete'=>0,
                $field=>$value
            );
            $this->db->flush_cache();

            $this->db->select()
                     ->from($this->_table.' tb')
                     ->where($where);
            $rs = $this->db->get();
            $rs = $rs->row_array();
            if(isset($rs['views']) && $countView == false){
                $dataUpdate['views'] = $rs['views']+1;
                $whereUpdate = array('id'=>$rs['id']);
                $this->db->flush_cache();
                $this->db->where($whereUpdate)
                         ->update($this->_table,$dataUpdate);
            }
            $this->getInfoPriceOneData($rs);
            return $rs;
        }
        
    }
?>

