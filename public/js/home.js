$(function(){
    $('.togglearts').children('article').each(function(){
        
        $(this).children('section').slideUp(0);
        
        $(this).children('header').click(function(){
            if($(this).parent().is('.current'))
                return;
            $(this).parents('.togglearts')
                .children('.current').removeClass('current')
                .children('section').slideUp(300);
            $(this).next('section').slideDown(300)
                   .parent().addClass('current');
        });
    });
    $('.togglearts').children('article:first').addClass('current')
                    .children('section').slideDown();
                    
    $('.qty').click(function(){
        $(this).children('input').focus();
    });
});