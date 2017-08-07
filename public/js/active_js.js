$(document).ready(function(){
    //colection
    if($('.colection').length)
   {
        var table=$('.colection').attr('tblname');
        $('.colection-item').each(function(){
            $(this).click(function(){
                var id=$(this).val();
                if($(this).is(':checked'))
                    var url='admin/colection/add_item';
                else
                    var url='admin/colection/remove_item';
                url=url+'/'+table+'/'+id;
                $.post(url,{ajax:'ajax'},function(html){
                    $('.colection-selected')
                    .children('.num')
                    .empty().append(html);
                })
            });
        });
   }
    
   try{
        $('.ajax-update-input').each(function(){
            $(this).blur(function(){
                var obj=$(this);
               var val=$(this).val(),
                    id=$(this).next().next().next().val(),
                    field=$(this).next().val(),
                    table=$(this).next().next().val();
                var url='admin/ajax/update';
                var xlsx=$.post(url
                ,{id:id,value:val,table:table,field:field,ajax:'ajax'}
                ,function(html){
                    obj.fadeTo(300,0.4,function(){
                        obj.fadeTo(100,1);
                    })
                });
            });
        });
   }
   catch(e){};
});
function showdialog(){
    $('#frmDialog').fadeIn(function(){
       $(this).click(function(e){
            e.stopPropagation();
       });
        $(document).bind('click',function(){
             $('#frmDialog').fadeOut(function(){
                $(document).unbind('click');
             });
        });
    });
}
function call_active_image(vobj){
    var tbl=$(vobj).attr('table'),
        key=$(vobj).attr('key'),
        id=$(vobj).attr('id'),
        img=$(vobj).attr('src'),
        ajaxKey='ajax',
        obj=$(vobj);
        p=$.post(
            'admin/ajax/active'
            ,{ajax:ajaxKey,table:tbl,field:key,id:id}
            ,function(data){
                if(data=='1')
                {
                    obj.fadeOut(0)
                    .delay(300)
                    .attr('src',img.replace('false','true'))
                    .delay(300)
                    .fadeIn();
                }
                else if(data=='0')
                {
                    obj.fadeOut()
                    .delay(300)
                    .attr('src',img.replace('true','false'))
                    .delay(300)
                    .fadeIn();
                }
                if(typeof(active_callback) != "undefined")
                {
                    active_callback(data,obj);
                }
            }
        ); 
    p.error(function(){alert('error')}); 
}