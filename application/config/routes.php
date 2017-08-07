<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$route['admin_folder']='admin';
$route['fontend_folder'] = 'home';
$route['default_controller'] =$route['fontend_folder'].'/home';
$route['admin/dang-nhap'] = $route['admin_folder'].'/home/login';
$route['admin/dang-xuat'] = $route['admin_folder'].'/home/logout';
$route['admin'] = $route['admin_folder'].'/home';
$route['admin/(.*)']=$route['admin_folder'].'/$1';
$route['sitemap'] = $route['fontend_folder'].'/home/sitemap';



$lang=array('vi','en');
foreach($lang as $l)
{
    foreach($route as $key=>$val)
    {
        $route[$l.'/'.$key]=$val;
    }
    $route[$l.'/(.*)?'] = $route['fontend_folder'] . '/$1';
   $route[$l]= $route['fontend_folder'] . '/home';
}
unset($lang,$k,$key,$val,$l);
$route['(.*)'] = $route['fontend_folder'].'/$1';
$route['(.*)?'] = $route['fontend_folder'] . '/$1';
$route['scaffolding_trigger'] = "";
$route['404_override'] = 'error/er404';