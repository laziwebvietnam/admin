<?php
if(!function_exists('filter_getorder'))
{
    function filter_getorder($segments=array(),$sufix='order_',$fields_reg=array()){
        $request_order='';
        $link='';
        $values=array();
        $dot='';
        foreach($segments as $val)
        {
            if(preg_match("/^$sufix/",$val))
            {
                $val=str_replace($sufix,'',$val);
                $px=explode('__',$val);
                if(count($px)===2)
                {
                    if(in_array($px[0],$fields_reg)&&in_array($px[1],array('asc','desc')))
                    {
                        $request_order.=$dot.'`'.$px[0].'` '.$px[1];
                        $dot=',';
                        $link.=$val.'/';
                        $values[$px[0]]=$px[1];
                    }
                }
            }
        }
        return array('orders'=>$request_order,'link'=>$link,'values'=>$values);
    }
}
if(!function_exists('filter_getwhere'))
{
    //field__??__val
    //ex:: is_active__isnot__1
    //ex:: general_date__from__12-12-12
    //ex:: general_date__to__13-12-12
    function filter_getwhere($segments=array(),$sufix='where_',$fields_reg=array()){
        $request_where=array();
        $values=array();
        $link='';
        foreach($segments as $val)
        {
            if(preg_match("/^$sufix/",$val))
            {
                $val=str_replace($sufix,'',$val);
                $px=explode('__',$val);
                if(count($px)==3&&$px[2]!==''&&in_array($px[0],$fields_reg))
                {
                    //dieu kien cho trich loc ngay
                    //fromdate
                    if($px[1]=='isnot')
                    {
                        $request_where[$px[0].' <>']=$px[2];
                    }
                    elseif($px[1]=='is')
                    {
                        $request_where[$px[0]]=$px[2];
                    }
                    elseif($px[1]=='from')
                    {
                        $request_where[$px[0].' >=']=$px[2];
                    }
                    elseif($px[1]=='to')
                    {
                        $request_where[$px[0].' <=']=$px[2];
                    }
                    $link.=$val.'/';
                    if(isset($values[$px[0]]))
                    {
                        $values[$px[0].'__2']=$px[2];
                    }
                    else
                        $values[$px[0]]=$px[2];
                }
                
            }
        }
        return array('wheres'=>$request_where,'link'=>$link,'values'=>$values);
    }
}
?>