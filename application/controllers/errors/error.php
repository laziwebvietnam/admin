<?php
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
 
if ( ! defined('BASEPATH')) 
    exit('Access define.');
    
class error extends Public_controller{

	function __construct(){
		parent::__construct();
	}

	function er404()
	{
		$segment = $this->uri->segment(1);
		if($segment=='admin'){
			redirect('admin');
		}else{
			$this->_base_view_path = 'frontend/';
			$data['message'] = '404';
			$data['title'] = $data['desc'] = $data['keyword'] = 'Lỗi trang không tìm thấy';
			$this->_template['seo_data']['noindex'] = true;
			//$this->set_seodata(null,null,$data);
			//$this->load_view('include/error/404',$data);
			$this->load_message();
		}
    }
}
?>