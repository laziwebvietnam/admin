$(document).ready(function(){
    var id=0;
    $('.multi_images').find('.addthis').click(function(){
        id++;
        var parent=$(this).parents('.multi_images').find('.group');
        var newobj=parent.children('.field:eq(0)').clone();
        
        newobj.find('.input')
                .val('')
                .attr('id','images'+id).attr('rel',id);
        var exp=$('<span/>',
                {class:'btn'}
            ).html('-')
            .bind('click',function(){
                $(this).parents('.field').remove();
            }).appendTo(newobj);
        newobj.find('a').bind('click',function(){
            var currentId=$(this).parent('.field').find('input').attr('id');
            
            BrowseServerbyid('images/products/',currentId);
        });
        parent.append(newobj);
    });
    $('.remove-items').click(function(){
        $(this).parent().remove();
    });
});