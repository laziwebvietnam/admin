<? 
    class M_customer extends My_model
    {
    	function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'customer';
        }
		function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
		{
			$this->db->flush_cache();
            $where_like_item = array('tb.fullname','tb.phone','tb.email','tb.address');
            
			$this->db->select('tb.*,
							   u.fullname as admin_fullname')
					 ->from($this->_table.' tb')
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

        function getInfoForSuggest($field,$value){
        	$this->db->flush_cache();
        	$where=array(
    			'tb.is_delete'=>0,
    			$field=>$value);
			$this->db->select('tb.fullname,tb.phone,tb.email,tb.address')
					 ->from($this->_table.' tb')
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

	        $this->db->select()
	                 ->from($this->_table.' tb')
	                 ->where($where);
	        $rs = $this->db->get();
	        $rs = $rs->row_array();
	        return $rs;
	    }

      function checkUser($data = array(), $api) {
          // lấy ra customer có oauth_provider và oauth_uid tương ứng
          $this->db->select();
          $this->db->from($this->_table);
          $this->db->where(array(
              $api . '_oauth_provider' => $data[$api . '_oauth_provider'],
              $api . '_oauth_uid' => $data[$api . '_oauth_uid']
          ));
          $prevQuery = $this->db->get();
          $prevCheck = $prevQuery->num_rows();
          
          if ($prevCheck > 0) {
              // nếu tồn tại customer đó:
              // lấy ra facebook_info, cập nhật lại
              // trả về id của customer đó
              $prevResult = $prevQuery->row_array();
              $api_info = json_decode($prevResult[$api . '_info'], true);

              unset($data[$api . '_oauth_provider'], $data[$api . '_oauth_uid']);
              $data['created'] = $api_info['created'];
              $data['modified'] = time();

              // if (!$prevResult['image']) {
              //   $prevResult['image'] = $data['picture_url'];
              // }
              
              $prevResult[$api . '_info'] = json_encode($data);

              $this->My_model->update('customer', $prevResult);

              $userID = $prevResult['id'];
          } else {
              // nếu không tìm thấy customer, tiếp tục tìm theo email
              $this->db->flush_cache();
              $this->db->select()
                       ->from($this->_table.' tb')
                       ->where('email', $data['email']);
              $prevQuery = $this->db->get();
              $prevCheck = $prevQuery->num_rows();

              if ($prevCheck > 0) {
                  // nếu tồn tại customer có email thỏa:
                  // cập nhật lại dữ liệu API của họ
                  // trả về id của customer đó
                  $prevResult = $prevQuery->row_array();
                  $prevResult[$api . '_oauth_provider'] = $data[$api . '_oauth_provider'];
                  $prevResult[$api . '_oauth_uid'] = $data[$api . '_oauth_uid'];

                  // if (!$prevResult['image']) {
                  //   $prevResult['image'] = $data['picture_url'];
                  // }

                  unset($data[$api . '_oauth_provider'], $data[$api . '_oauth_uid']);
                  $data['created'] = time();
                  $data['modified'] = time();
                  $prevResult[$api . '_info'] = json_encode($data);

                  $this->My_model->update('customer', $prevResult);

                  $userID = $prevResult['id'];
              } else {
                  // nếu chưa tồn tại thông tin nào của customer:
                  // thêm mới 1 customer
                  // trả về id của customer đó
                  $dataInsert = array(
                    'email' => $data['email'],
                    $api . '_oauth_provider' => $data[$api . '_oauth_provider'],
                    $api . '_oauth_uid' => $data[$api . '_oauth_uid'],
                    'is_active' => 1,
                    'time' => time(),
                    'time_update' => time(),
                    'fullname' => $data['name'],
                    'image' => $data['picture_url']
                  );

                  unset($data[$api . '_oauth_provider'], $data[$api . '_oauth_uid']);
                  $data['created'] = time();
                  $data['modified'] = time();
                  $dataInsert[$api . '_info'] = json_encode($data);
                  
                  $userID = $this->My_model->insert('customer', $dataInsert);
              }
          }

          return $userID ? $userID : FALSE;
      }
    }
?>