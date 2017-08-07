<?

function mutil_menu($source = array(),$id_parent = 0,&$result)
{
    if(count($source) > 0)
    {
        foreach($source as $key=>$row)
        {
            /**
             * category menu
             */
            if(isset($row['id_parent']) && $id_parent>=0){
                if($row['id_parent']==$id_parent)
                {
                    $result[] = $row;
                    $id_parent_ = $row['id'];
                    unset($source[$key]);
                    mutil_menu($source,$id_parent_,$result);
                }
            }
            /**
             * normal menu, dont have id_parent, level
             */
            else{
                $result[] = $row;
                unset($source[$key]);
                mutil_menu($source,-1,$result);     
            }
        }
    }

}
/**
 * $result[$key] = array();
 * $result_key_id[$id] = array();
 */ 
function mutil_menu_return_key_id($source = array(),$id_parent = 0,&$result,&$result_key_id)
{
    if(count($source) > 0)
    {
        foreach($source as $key=>$row)
        {
            $result_key_id[$row['id']] = $row;
            if($row['id_parent']==$id_parent)
            {
                $result[] = $row;
                
                $id_parent_ = $row['id'];
                unset($source[$key]);
                mutil_menu($source,$id_parent_,$result,$result_key_id);
            }
        }
    }
}

/** find and return value by key */
function array_find_value_by_key($data=array(),$key='',$val='',$return_key=false){
    if($data != null){
        foreach($data as $k=>$row){
            if(isset($row[$key])){
                if($row[$key]==$val){
                    if($return_key==true){
                        return $k>=0?$k:-1;
                    }else{
                        return $row;
                    }
                    break;
                }        
            }
        }
    }
    if($return_key==true){
        return -1;
    }
    return null;
}

function return_tag_byString($tag_string){
    $new_tag = array();
    if($tag_string != null){
        $tag = substr($tag_string,1,strlen($tag_string)-2);
        if($tag){
            $tag = explode(',',$tag);
        }
        
        if($tag != null){
            foreach($tag as $item){
                $new_tag[] = str_replace('"','',$item);
            }
        }
    }
    return $new_tag;
}

/**
 * 
 * @param  [type] $array   [description]
 * @param  [type] $keyname [description]
 * @return [type]          [description]
 */
function return_arrayKey($array,$keyname){
    $result=array();
    if($array!=null){
        foreach($array as $row){
            if(isset($row[$keyname])){
                $result[]=$row[$keyname];
            }
        }
    }
    return $result;
}

/**
 * tìm giá trị trong mảng theo keyFind và trả về giá trị của 1 key khác trong mảng được tìm thấy
 * @param  [type] $array     [description]
 * @param  [type] $keyFind   [description]
 * @param  [type] $keyValue  [description]
 * @param  [type] $keyReturn [description]
 * @return [type]            [description]
 */
function return_valueKey($array,$keyFind,$keyValue,$keyReturn){
    $result=array();
    if($array!=null){
        foreach($array as $row){
            if(isset($row[$keyFind])){
                if($row[$keyFind]==$keyValue){
                    $result[]=$row[$keyReturn];
                }
            }
        }
    }
    if(count($result)<=1){
        return isset($result[0])?$result[0]:null;
    }else{
        return $result;
    }
}

function base64Decode($url='') {
    //$url = 'http://localhost/admin/public/uploads/images/123/Jellyfish.jpg';
    /*$curl_handle=curl_init();
    curl_setopt($curl_handle, CURLOPT_URL,$url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
    $query = curl_exec($curl_handle);
    curl_close($curl_handle);*/
    $base = base64_encode(file_get_contents($url));
    return $base;
    //echo "<img src=\"data:image/png;base64,$base\"/>";
     
}

function getParentStack($stack,$value,$key,$returnMap=false) {
    $arrayMap = array();
    foreach ($stack as $k => $v) {
        if (is_array($v)) {
            // If the current element of the array is an array, recurse it and capture the return
            $return = getParentStack($v,$value,$key);
            
            // If the return is an array, stack it and return it
            if (is_array($return)) {
                $arrayMap[] = $k;
                return array($k => $return);
            }
        } else {
            // Since we are not on an array, compare directly
            if ($v == $value && $k == $key) {
                // And if we match, stack it and return it
                return array($k => $value);
            }
        }
    }
    
    // Return false since there was nothing found
    return false;
}

function valueByKey($dataArray,$key,$returnKey=false){
    if(isset($dataArray[$key])){
        if($returnKey==true){
            return $dataArray[$key];
        }else{
            echo $dataArray[$key];return;
        }
    }
    if($returnKey==true){
        return null;
    }
    echo null;
}

?>