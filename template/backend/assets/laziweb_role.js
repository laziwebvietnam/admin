var list_id = [];
$(document).ready(function(){
    jstre_data('.jstree_role');
});


function jstre_data(className){
    $(className).jstree({
    	"core" : {
    		"check_callback" : true,
            "html_titles" : true
    	},
        "plugins" : ["types", "json_data", "checkbox"]
    });
    
    $(className).bind("ready.jstree", function (event, data) {
    });
    $(className).bind("changed.jstree", function (event, data) {
        var parentName = event.currentTarget.id;
        parentName = event.currentTarget.id;
        jstree_get_selected(parentName,data.selected,false);
        
    });
    
    $(className).bind("deselect_node.jstree", function (event, data) {
        if(data.selected.length>0){
            var parentName = data.node.parent;
            if(parentName=='#'){
                parentName = data.selected[0];
            }
            jstree_get_selected(parentName,data.selected,true);
        }
        
    });
}
var id_selected = {}; /** list id_role selected */
function jstree_get_selected(parentName,dataSelected,typeRemove){
    var firstKey = true;
    id_selected[parentName] = [];

    for(key in dataSelected){
        if(dataSelected[key]!=parentName && key!='remove'){
            if($.inArray(dataSelected[key],id_selected)<0){
                if(typeRemove==false){
                    id_selected[parentName].push(dataSelected[key]);
                }
            }else{
                if(typeRemove==true){
                    id_selected[parentName].remove(dataSelected[key]);
                }
            }
        }
    }
    var role_action = '';
    for(key in id_selected){
        if(id_selected[key].length>0){
            for(role in id_selected[key]){
                if(role!='remove'){
                    role_action += id_selected[key][role]+',';
                }
            }
        }
    }
    role_action = role_action==''?role_action:role_action.substr(0,role_action.length-1);
    $('#form-submit').find('input[name="actions"]').val(role_action);
}

$('select[name="id_role_select"]').change(function(){
    if($(this).val()!=null){
        var table_executed = $('#table_executed').val();
        window.location.href = table_executed+'/edit/'+$(this).val();
    }
});
