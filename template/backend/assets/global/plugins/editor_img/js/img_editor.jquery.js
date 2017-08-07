(function($){
    $.fn.extend({
        //plugin name - 
        plugimg: function(options) {
            //Settings list and the default values
            var defaults = {
                imgwidth:'120px',
                imgheight:'auto',
                ismulty:false,
                startupPath:'',
                name:''
            };
            var options = $.extend(defaults, options);
            var _obj={
                i:0,
                imgframe:$('<div/>',{
                    class:'img-frame'
                }),
                inputName:'image',
                inputframe:$('<div/>',{class:'input-frame'}),
                _construct:function(cobj){
                     var multyimg=$('<div/>',{class:'multy-img'});
                     var btnAddNew=$('<div/>',{class:'btn-addnew img-box'});
                     $(btnAddNew).append('Click here to add new photo').click(function(){
                        _obj.newImg();
                     });
                     _obj.imgframe.append(btnAddNew);
                     multyimg.append(_obj.imgframe);
                     multyimg.append(_obj.inputframe);
                     if(options.name=='')
                     {
                        _obj.inputName=cobj.attr('name');
                     }
                     else
                        _obj.inputName=options.name;
                     var imgresults=cobj.val();
                     var imgs=imgresults.split('||');
                     var i=imgs.length;
                     if(!options.ismulty)
                     {
                        if(imgs[0]!='')
                            _obj.addImg(imgs[0]);
                     }
                     else
                     {
                        for(j=0;j<i;j++) 
                         {
                            if(imgs[j]=='')
                                continue;
                            _obj.addImg(imgs[j]);
                         }
                     }
                     cobj.after(multyimg);
                     cobj.remove();
                },
                newImg:function(){
                    var finder = new CKFinder();
                    finder.basePath = 'public/plugin/ckeditor/ckfinder/';
                    finder.selectActionFunction = function( fileUrl, data ){
                        _obj.addImg(fileUrl);
                    };
                    finder.popup();
                },
                addImg:function(fileUrl){
                    _obj.i++;
                    fileUrl=fileUrl.replace('/../','');
                    var cl='img-item-'+_obj.i;
                    var input=$('<input/>',{type:'hidden',value:fileUrl,class:cl,name:_obj.inputName}),
                        imgbox=$('<div/>',{class:'img-box item '+cl}),
                        btndel=$('<span/>',{class:'btn del'}),
                        toolbox=$('<div/>',{class:'toolbox'});
                    //fix tool box    
                    $(btndel).click(function(e){
                        e.stopPropagation();
                        _obj.removeImg(cl);
                    }).appendTo(toolbox); 
                    $(imgbox).click(function(){
                        _obj.editImg(cl);
                    });
                    $(imgbox).append(toolbox);
                    $(imgbox).css({'background-image':'url('+fileUrl+')'});
                    //add img
                    if(_obj.imgframe.find('.btn-addnew').length>0){
                        _obj.imgframe.children('.btn-addnew').before(imgbox);
                    }
                    else{
                        _obj.imgframe.append(imgbox);
                    }
					
					
					//console.log(inputArray);
                    _obj.inputframe.append(input);
                    _obj.checkMultySelect();              

					var inputArray = _obj.inputframe[0].childNodes;
					for(i=0;i<inputArray.length;i++){
						var imageDetail = inputArray[i];
						if(!imageDetail.value){
							console.log('remove');
							imageDetail.remove();
						}
					}								
                    /*if(typeof finder_complete == 'function'){
                        finder_complete(_obj.inputName);
                    }*/
                },
                editImg:function(cl){
                    var finder = new CKFinder();
                    finder.basePath = 'public/plugin/ckeditor/ckfinder/';
                    finder.selectActionFunction = function( fileUrl, data ){
                        _obj.imgframe.find('.'+cl).css({'background-image':'url('+fileUrl+')'});
                        _obj.inputframe.find('.'+cl).val(fileUrl);
                    };
                    finder.popup();
                },
                removeImg:function(cl){
                    _obj.imgframe.find('.'+cl).remove();
					if(_obj.inputframe[0].childNodes.length>1){
						_obj.inputframe.find('.'+cl).remove();
					}else{
						_obj.inputframe.find('.'+cl).val(null);
					}
                    
                    /** update: 06/06/2016 */
                    
                    _obj.checkMultySelect();
                },
                checkMultySelect:function(){
                    if(options.ismulty)
                    {
                        return;
                    }
                    var i=_obj.imgframe.children('.img-box.item').length;
                    if(i>0)
                    {
                        _obj.imgframe.children('.btn-addnew').hide();
                    }
                    else
                        _obj.imgframe.children('.btn-addnew').fadeIn();
                }
            };
            return this.each(function() {
                _obj._construct($(this));
            });
        }
    });
})(jQuery);