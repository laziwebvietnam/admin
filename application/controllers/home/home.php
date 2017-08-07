<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class home extends Public_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_product');
        $this->load->model('M_category');
        $this->load->model('M_article');
    }

    function index()
    {
        $where = array(
            'slide'=>array(
                'is_active' => 1,
                'is_delete' => 0,
            ),
        );

        $data = array(
            // 'menuActive' => 1,
            // 'slide'=>$this->My_model->getlist('slide',$where['slide'],0,999),
        );

        $this->set_seodata('category',1);
        $this->load_view('home/demo/index',$data);
    }

    function test(){
    }
}
?>