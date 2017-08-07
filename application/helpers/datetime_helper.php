<?php
if(!function_exists('datetime_compare'))
{
    
    /**
     * datetime_compare()
     * 
     * @param datetimestring $firstdat
     * @param datetimestring $datecompare
     * @return if($firstdate>$datecompare) retrun 1
     * @return if($firstdate==$datecompare) retrun 2
     * @return if($firstdate<$datecompare) retrun 0
     */
    function datetime_compare($firstdate,$datecompare)
    {
        $d1=new DateTime($firstdate);
        $d2=new DateTime($datecompare);
        if($d1>$d2)
            return 1;
        if($d1==$d2)
            return 2;
        return0;
    }
}
if(!function_exists('in_time'))
{
    function in_time($d1,$d2){
        $d1=new DateTime($d1);
        $d2=new DateTime($d2);
        $d3=new DateTime();
        if($d1<=$d3 && $d2>=$d3)
            return true;
        return false;
    }
}
?>