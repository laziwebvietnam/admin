<? 
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */ 
    class M_ship_fee extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'ship_fee';
        }
        function get_all($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
        {
            $this->db->flush_cache();
            $where_like_item = array('tb.title');
            
            $this->db->select('tb.*,
                               c.title as c_title,
                               u.fullname')
                     ->from($this->_table.' tb')
                     ->join('location c','tb.id_location = c.id','left')
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

        function get_all_cityHasShip($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false)
        {
            $this->db->flush_cache();
            $where = array(
                'level' => 0,
                'has_ship' => 1
            );
            // $where_like_item = array('tb.title');
            
            $this->db->select()
                     ->from('location tb')
                     ->limit($limit,$start)
                     ->where($where)
                     ->order_by($order_by);
                     
            // if($where!=null){
            //     foreach($where as $key=>$item){
            //         if(in_array($key,$where_like_item)==true){
            //             $this->db->like($key,$item);
            //             unset($where[$key]);
            //         }
            //     }
            // }
                     
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
                    $temp = $rs->result_array();

                    foreach ($temp as $key => $location) {
                        $temp[$key]['ship_fees'] = '';

                        $this->db->flush_cache();
                        $ship_fees = $this->db->select()
                                             ->from('ship_fee')
                                             ->where(array(
                                                    'is_active' => 1,
                                                    'is_delete' => 0,
                                                    'id_location' => $location['id']
                                                ))
                                             ->get()->result_array();

                        if ($ship_fees) {
                            foreach ($ship_fees as $k => $fee) {
                                $temp[$key]['ship_fees'] .= '<a href="ship_fee/edit/' . $location['id'] . '/' . $fee['id'] . '">' . $fee['title'] . ' - ' . number_format($fee['fee'], 0, '.', ',') . '₫</a><br>';
                            }
                        }
                    }

                    return $temp;
                }
                else
                {
                    return array();
                }
            }
        }
        
        /**
         * [get detail ship_fee by id]
         * @param  [integer] $id [id ship_fee]
         * @return [row array]     []
         */
        function detail_Backend($id){
            $this->db->flush_cache();
            $where=array('tb.id'=>$id,'tb.is_delete'=>0);
            $this->db->select('tb.*,u.fullname as u_fullname, u_update.fullname as u_update_fullname,
                                l.title as location_title')
                     ->from($this->_table.' tb')
                     ->join('user u','tb.id_user = u.id','left')
                     ->join('user u_update','tb.id_user_update = u_update.id','left')
                     ->join('location l','tb.id_location = l.id','left')
                     ->where($where);
            $rs=$this->db->get();
            return $rs->row_array();
        }

        function queryLocations($where=array(),$start=0,$limit=999,$order_by='id desc',$count=false){
            $this->db->flush_cache();
            $this->db->select('tb.*,
                               sf.fee as fee_location, sf.id as fee_id')
                     ->from('location tb')
                     ->join('ship_fee sf','sf.id_location = tb.id','left')
                     ->limit($limit,$start)
                     ->order_by($order_by);
                     
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

