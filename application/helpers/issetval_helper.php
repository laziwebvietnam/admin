<?php
/**
 * issetValue width a string
 * if valid return that value, else return null
 */
 
 if(!function_exists('issetValue'))
 {
    function issetValue($keyName){
        return (isset($$keyName)?$$keyName:null);
    };
 }
?>