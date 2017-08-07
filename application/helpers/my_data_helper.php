<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



function structure($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
}

 function create_random_string($num) {
    //Tao du lieu cho hinh ngau nhien
    $chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', 
                    '1', '2', '3', '4', '5', '6', '7', '8', '9','~','!','@','#','$','%','&','?');
    $max_chars = count($chars) - 1;
    for($i = 0; $i < $num; $i++) {
      $code = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $code . $chars[rand(0, $max_chars)];
    }
    return $code;
  }