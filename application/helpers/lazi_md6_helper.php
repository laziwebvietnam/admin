<?php
if(!function_exists('md6'))
{
    function md6($id=0){
        $id +=307843300;
        $id=dechex($id);
        $id = str_replace(1,'W',$id); 
        $id = str_replace(2,'I',$id); 
        $id = str_replace(3,'O',$id); 
        $id = str_replace(4,'U',$id); 
        $id = str_replace(5,'Z',$id); 
        return strtoupper($id);
    }
}
if(!function_exists('md6_decode'))
{
    function md6_decode($id=''){
        $id = str_replace('W',1,$id); 
        $id = str_replace('I',2,$id); 
        $id = str_replace('O',3,$id); 
        $id = str_replace('U',4,$id); 
        $id = str_replace('Z',5,$id); 
        return hexdec($id)-307843300;
        //return int($id);
    }
}
?>