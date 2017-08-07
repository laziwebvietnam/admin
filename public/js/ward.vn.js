/**
 * My_Model
 * 
 * @package   
 * @author lvtu.quicktips.vn
 * @copyright congdongnhadat
 * @version 2013
 * @access public
 */
 $(document).ready(function(){
    getwards();
    $('select#id_city').change(function(){
           getwards();
    });
    
 });
 function getwards()
 {
    
    var val=$('select#id_city').val(),
            url='ward',
        currentward=$('select#id_ward').attr('current');
    var ward=$('select#id_ward');
    ward.fadeTo(300,0.3);
    var xlsx=$.post(url,{idprovince:val,ajaxkey:'ajax',currentward:currentward},function(resp){
        ward.empty()
        .append(resp)
        .removeAttr('disabled')
        .val(currentward)
        .fadeTo(300,1);
    })
 }