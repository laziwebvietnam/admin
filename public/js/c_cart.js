(function($){
   $.fn.extend({
    qt_edit_cart:function(options){
        var defaults={
          link_update:'cart/update',
          link_remove:'cart/remove',
          rowitem:'tr.row',
          qty:'.c_qty',
          subtotal:'.subtotal',
          total:'.total',
          cart:'.cart',
          price:'.c_price'
        };
        var options=$.extend(defaults,options);
        var _obj={  
            _construct:function(){
                  $(options.cart).find(options.rowitem).each(function(){
                        var input=$(this).find(options.qty),
                            btnremove=$('<a/>',{class:'c_btn',title:'Remove'});
                        _obj._create_qty_input(input);
                        
                        $(this).children('td:last').append($(btnremove));
                        _obj.remove(btnremove);
                  });
            },
            remove:function(obj){
                obj.click(function(){
                    var row=obj.parents(options.rowitem),
                        trid=row.attr('id');
                    $.post(options.link_remove+'/'+trid,{ajax:'ajax'},function(html){
                        if(html.trim()=='0')
                        {
                            row.fadeOut(400,function(){
                                $(this).remove();
                                $(options.cart).find('.btn_next').fadeOut();
                                _obj.totalcart();
                            });
                        }
                    });  
                });                
            },
            _create_qty_input:function(obj){
                var qty=obj.html().trim(),
                    newInput=$('<input/>',{type:'text',maxlength:2,name:'qty only_numeric',class:'qty',value:qty});
                $(newInput).change(function(){
                   var qty=$(this).val(),
                        row=$(this).parents('tr.row'),
                        trid=row.attr('id'),
                        link=options.link_update+'/'+trid;
                   //check quantity 
                    $.post(link,{ajax:'ajax',qty:qty},function(html){
                        try{
                            $(newInput).val(html);
                            html=Number(html);
                            var price =row.find(options.price).html();
                            price=price.replace(/\./gi,'');
                            price=html*Number(price);
                            price=_obj.addCommas(price);
                            row.children(options.subtotal).fadeTo(200,0,function(){
                                $(this).html(price).fadeTo(400,1);
                            });
                            _obj.totalcart();
                        }
                        catch(e){}                        
                    });
                });
                obj.empty().append(newInput);
            },
            addCommas:function(str) {
                var amount = new String(str);
                amount = amount.split("").reverse();
            
                var output = "";
                for ( var i = 0; i <= amount.length-1; i++ ){
                    output = amount[i] + output;
                    if ((i+1) % 3 == 0 && (amount.length-1) !== i)output = '.' + output;
                }
                return output;
            },
            totalcart:function(){
                var totalOrder=0,
                    cart=$(options.cart),
                    numpdt=0;
                
                 cart.find(options.subtotal).each(function(){ 
                    var val=$(this).html();
                    val=val.replace(/\./gi,'');
                    totalOrder+=Number(val); 
                    numpdt++;
                });
               cart.find(options.total).fadeOut(function(){
                    $(this).html(addCommas(totalOrder)).fadeIn();
               });           
            }
        };
        return this.each(function(){
           _obj._construct(); 
        });
    },
    qt_flytocard:function(options){
        var defaults={
            productItem:'li',
            productImg:'img',
            productTitle:'title',
            productPrice:'.price',
            subtotalcart:'.subtotal',
            btnadd:'.btn-add-cart',
            cart:'.cart-block',
            totalcart:'.amoun',
            qtyTotalTag:'.qty-total',
            cartItemTag:'.pdt-item',
            cartItem:''
                +'<li>'
                    +'<span class="title">'
                    +'</span>'
                    +'<span class="subtotal">'
                    +'</span>'
                +'</li>'
        }
        var op=$.extend(defaults,options);
        var _obj={
            _cartblock:$(op.cart),
            _construct:function(obj){
                obj.find(op.btnadd).each(function(){
                    _obj.addcart($(this));
                })
            },
            addcart:function(obj){
                obj.click(function(e){
                    e.preventDefault();
                    if($(this).is('.active'))
                        return;
                    else
                        $(this).addClass('active');
                        
                    _obj.tag_block($(this));
                    var pid=$(this).attr('pid');
                    _obj.set_selected($(this));
                    if($(op.cart+' '+op.cartItemTag+'[pid="'+pid+'"]').length>0){
                        return;
                    }   
                    var cur_obj=$(this),
                        url=cur_obj.attr('href'),
                        xls=$.post(url,{ajax:'ajax'});
                        
                    xls.complete(function(){
                        _obj.tag_unblock(cur_obj);
                    });
                    xls.success(function(html){
                        if(html!='')
                        {
                            //success
                            _obj.flytocart(cur_obj);
                        }
                    });
                });
            },
            flytocart:function(obj){
                var p=obj.parents(op.productItem+':eq(0)');
                if(typeof(p)=='undefined ')
                    return;
                var title=p.find(op.productTitle).html(),
                    oldImg=p.find(op.productImg),
                    img=oldImg.clone(),
                    imgOffset=oldImg.offset(),
                    price=p.find(op.productPrice).html(),
                    cartItem=$(op.cartItem),
                    toOffset=$(op.cart).find(op.totalcart).offset();
                    
                cartItem.children('.title').html(title);
                cartItem.attr('pid',obj.attr('pid'));
                cartItem.children('.subtotal').html(price);
                
                img.css({
                    'width':oldImg.width(),
                    'height':oldImg.height(),
                    'position':'absolute',
                    'top':imgOffset.top,
                    'left':imgOffset.left
                }).appendTo('body');
                img.animate(toOffset,300)
                   .animate({opacity:0,width:0,height:0},function(){
                        $(op.cart).find(op.totalcart).before(cartItem);
                        cartItem.slideUp(0,function(){
                            img.remove();
                            $(this).slideDown(function(){
                                _obj.totalcart();
                            });
                        })
                   }); 
                
            },
            addCommas:function(str) {
                var amount = new String(str);
                amount = amount.split("").reverse();
            
                var output = "";
                for ( var i = 0; i <= amount.length-1; i++ ){
                    output = amount[i] + output;
                    if ((i+1) % 3 == 0 && (amount.length-1) !== i)output = '.' + output;
                }
                return output;
            },
            totalcart:function(){
                var totalOrder=0,
                    cart=$(op.cart),
                    numpdt=0;
                
                 cart.find(op.subtotalcart).each(function(){ 
                    var val=$(this).html();
                    val=val.replace(/\./gi,'');
                    totalOrder+=Number(val); 
                    numpdt++;
                });
               cart.find(op.totalcart).find('.total').fadeOut(function(){
                    $(this).html(_obj.addCommas(totalOrder)).fadeIn();
               });           
            },
            tag_block:function(obj){
                var blk=$('<div/>',{class:'tag_block'});
                blk.height(obj.outerHeight());
                blk.width(obj.outerWidth())
                    .css({
                        'position':'absolute',
                        'background':'rgba(255,255,255,0.5)'
                    })
                    .appendTo($('body'));
                blk.animate(obj.offset(),0);
                var top=parseInt(obj.offset().top);
                blk.addClass('tag_block'+top);
                obj.attr('for','tag_block'+top);
            },
            tag_unblock:function(obj){
                var f=obj.attr('for');
                obj.removeAttr('for');
                $('body').find('.tag_block'+f).delay(300).fadeOut().remove();
            },
            set_selected:function(obj){
                obj.unbind('click').bind('click',function(e){
                    e.preventDefault();
                });
            }
            
        }
        return this.each(function(){
            _obj._construct($(this));
        });
    } 
   });
})(jQuery);