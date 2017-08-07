var jstree_category_html = '';

$(document).ready(function(){
    
    /*var jstree_category_time = setInterval(function(){
        add_html_action_into_jstree();
        if(jstree_category_html!=''){
            clearInterval(jstree_category_time);
        }
    },1000);*/
});

function jstree_category_delete(data){
    var id = [$(data).closest('li').attr('id')];
    $('#id_executed').val(id);
    create_popup('category/popup_delete');
}

function jstree_category_change_position(data){
    console.log(data);
    console.log(data.position);
    console.log(data.old_position);
    console.log(data.parent);
}


function add_html_action_into_jstree(){
    jstree_category_html = $('#hml1').html();
    $('#html1').each(function(){
        $(this).find('a').append("<div class=\"modify\"><a onclick=\"change_position(this,'up')\">Up</a><a onclick=\"change_position(this,'down')\">Down</a><a onclick=\"category_edit(this)\">Edit</a><a onclick=\"jstree_category_delete(this);return false;\">Delete</a></div>");
        $(this).find('li.jstree-last').removeClass('jstree-last');
        $(this).find('ul[role="group"]').append('<li class="jstree-node jstree-closed jstree-last category-create"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" onclick="category_create(this)"><i class="jstree-icon jstree-themeicon" role="presentation"></i>Thêm mới</a></li>');
        //$(this).find('a.jstree-anchor').parent().find('li.category-create');
        //var test = $(this).find('a.jstree-anchor').html();
        //console.log(test);
        
    })
}

function remove_html_action_into_jstree(){
    $('#html1').each(function(){
        $(this).find('div.modify').remove();
        $(this).find('li.category-create').remove();
    })
}

function change_position(id,type){
   
    var ajax = $.post('category/change_position/'+id+'/'+type);
    
    ajax.success(function(data_log){
        data_log = jQuery.parseJSON(data_log);
        if(data_log.checkRole==false){
            create_popup('home/loadPopupViewRoleFalse');
            return;
        }
        if(data_log.status=='success'){
            jsTree_data();
        }else{
            console.log('fail');
        }
    });
}

function category_edit(id){
    if(id!=null){
        window.location.href = 'category/edit/'+id;
    }
}

function category_create(this_button){
    /** Find id_category Position Prev - with same id_category */
    var idCate_parent = parseInt($(this_button).closest('ul[role="group"]').parent().attr('id'));
    idCate_parent = idCate_parent>0?idCate_parent:0;
    window.location.href = 'category/create/'+idCate_parent;
}
var prevBtnTemp = [];
var BtnTemp = []
var createRole = [];
function jsTree_data(){
    var type_ = $('#category_type').val();
        data = {
            type:type_ 
        };
    var ajax_data_html = $.post('category/ajax_nodes',data);
    
    ajax_data_html.success(function(data_html){
        // console.log(data_html);return;
        var data_json = jQuery.parseJSON(data_html);
        if(data_json.html==null){
            $('#tree').html('<a href="category/create/0">Thêm mới</a>');
            return;
        }
        var ajax_data_type = $.post('category/ajax_nodes/getType',data);
        ajax_data_type.success(function(data_type){
            data_type = jQuery.parseJSON(data_type);
            createRole = data_type.createRole;
            $('#tree').jstree("destroy");
            $('#tree').jstree({
                'core': {
                    'check_callback': true,
                    'themes': {
                        'dots': true,
                        'responsive': true
                    },
                    'data' : data_json.html
                },
                "types": data_type.types,
                "plugins": ["types"]
            })
            .bind("move_node.jstree", function (e, data) {
                var data_id = data.node.id;
                var type = data.old_position>data.position?'up':'down';
                change_position(data_id,type);
            })
            .bind("open_node.jstree", function(e, data){
                jsTreeRemoveBtn();
            })
            .bind("close_node.jstree", function(e, data){
                jsTreeRemoveBtn();
            });
            
            jsTreeRemoveBtn();
        })
        
        
    })
}

function jsTreeRemoveBtn(){
    
    $('#tree').find('li.category-create').map(function(idx,e) {
        var thisBtn = $(e);
        var id_ = $(e).attr('id');
        var prevLi = $(e).prev().attr('data-jstree'); /** level2_parent4_id6 */
        var test = $(e).prev();
        var prevLi_undefined = false;
        if(typeof prevLi == 'undefined'){
            prevLi = $(e).parents('li[role="treeitem"]').attr('data-jstree');
            prevLi_undefined = true;
            test = $(e).parents('li[role="treeitem"]');
        }
        
        if(typeof prevLi != 'undefined'){

            prevLi = '{"data_jstree":'+prevLi+'}';
            prevLi = jQuery.parseJSON(prevLi);
            
            checkLock = false;
            var level = parseInt(prevLi.data_jstree.type.substring(prevLi.data_jstree.type.indexOf("_"),prevLi.data_jstree.type.indexOf("_")-1)); /** get level */
            
            level += prevLi_undefined==true?1:0;
            //console.log(level+'-'+id_);return;
            var parent = prevLi.data_jstree.type.substring(prevLi.data_jstree.type.lastIndexOf("_"),prevLi.data_jstree.type.lastIndexOf("_")-1); /** get parent */
            var type = prevLi.data_jstree.data_type;
            var id = prevLi.data_jstree.id;
            var id_check = parent==0?id:parent;
            id_check = prevLi_undefined==true?id:id_check;
            id_check = id_check.toString();
            
            if("level_"+level in createRole){
                var checkLock = createRole["level_"+level].lock; /** return true / false */
                /** check type (product,article) */
                //alert(createRole["level_"+level].type);
                
                if("type" in createRole["level_"+level]){
                    if(createRole["level_"+level].type.length > 0){
                        if($.inArray(type,createRole["level_"+level].type)>=0){
                            checkLock = true;
                        }
                    }
                }
                //alert(id_check);
                /** if check == false, check id */
                if(checkLock==false){
                    if("id" in createRole["level_"+level]){
                        if(createRole["level_"+level].id.length > 0){
                            if($.inArray(id_check,createRole["level_"+level].id)>=0){
                                
                                checkLock = true;
                            }
                        }
                        
                    }
                }
                
                /** if check == true , check i <> */
                if(checkLock==true){

                    if("non_id" in createRole["level_"+level]){
                        if(createRole["level_"+level].non_id.length > 0){
                            console.log(id_check+' '+createRole["level_"+level].non_id);
                            if($.inArray(id_check,createRole["level_"+level].non_id)>=0){
                                checkLock = false;console.log(id_check);
                            }
                        }
                    }
                }
            }
        }else{
            checkLock = false;
        }
        //console.log(level+'-'+parent+'-'+checkLock);
        if(checkLock==false){
            thisBtn.remove();
        }
    });
    
    //console.log(createRole);
    
    //console.log(prevBtnTemp);
    //console.log(BtnTemp);
}
