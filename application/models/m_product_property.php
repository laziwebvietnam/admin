<? 
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */ 
    class M_product_property extends My_model
    {
        function __construct(){
            parent::__construct();
            $this->_table = isset($this->_table)?$this->_table:'product_property';
        }

        function getProperty_detail($idProduct=0){
            $this->db->flush_cache();
            $where = array(
                'id_product'=>$idProduct
            );
            $this->db->select('*')
                     ->from($this->_table)
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
        
    }
?>

