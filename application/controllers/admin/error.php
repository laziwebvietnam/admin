<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class Error extends admin_action_controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    function er404()
	{
        exit('1');
    } 
}
?>