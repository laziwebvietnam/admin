$(document).ready(function(){
    var maxWidth=$('body').width();
    var maxHeight=$(document).height();
    $('body  .page-right').animate({'opacity':0},0);
    $('body .main').animate({'width':maxWidth},function(){        
        var right_col_width=maxWidth-$('.page-left').width()-22;
        $('body .page-left').animate({'height':maxHeight},300,function(){
            $('body  .page-right').animate({'width':right_col_width},0,function(){
                $(this).animate({'opacity':1})
            });
        });
    });    
    $('.show-hidden-park').click(function(){
        $(this).parent().find('.hidden-park').slideToggle();
    });
    
    //tbl select row
    var selectAll=0;
    $('.tblview .checkAll').change(function(){
        if($(this).is(':checked'))
        {
            selectAll=1;
        }
        else
            selectAll=0;
        checkall(selectAll);
    });
    $('.tblview #select').each(function(){  
            
            $(this).click(function(){
                if($(this).is(':checked'))
                {
                    addClass_td_selected(this,1);
                }
                else
                {      
                    addClass_td_selected(this,0);
                }
            });
    });
    $('.list-font li').each(function(){
        $(this).hover(function(){
            font=$(this).text();
            $('#value-font').val(font);
            $('body').attr('style','');
            $('body').css({'font-family':font+''});
        });
    });
    $('#value-font').focus(function(){
        $('.fonts .list-font').show();
    });
    $('#value-font').blur(function(){
        $('.fonts .list-font').hide();
        url='ajax.php?ctr=font&act=setfont&id='+$(this).val();
        $.post(url);
    });
});
function addClass_td_selected(checkbox,isCheck)
{
    if(isCheck==true)
    {
       $(checkbox).parent().parents('tr:eq(0)').addClass('selected');
    }
    else
    {
        $(checkbox).parent().parents('tr:eq(0)').removeClass('selected');
    }
}
function checkall(val)
{
    if(val==1)
    {
        $('.tblview #select').each(function(){
            $(this).attr('checked',true);
            addClass_td_selected(this,true);
        });
    }
    else
    {
        $('.tblview #select').each(function(){
            $(this).attr('checked',false);
            addClass_td_selected(this,false);
        });
    }
}