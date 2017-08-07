<?php 
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
function create_input($name,$title,$val=null,$required=false,$maxlength=null,$ques_title=null,$col=2,$readOnly=false){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    $class .= $maxlength!=null?" maxlength_placement":"";
    
    $id = "field_$name";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $readOnly = $readOnly==true?'readonly="true"':'';
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"input-icon right\">
                    <i class=\"fa tooltips show_error\" data-original-title=\"\"></i>
                    <input id=\"$id\" type=\"text\" class=\"$class\" data-maxlength=\"$maxlength\" name=\"$name\" value=\"$val\" $readOnly/> 
                    <span class=\"help-block help-block-error\"></span>
                </div>
                
            </div>
        </div>
    ";
    
}

function create_input_password($name,$title,$val=null,$required=false,$maxlength=null,$ques_title=null,$col=2,$readOnly=false){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    $class .= $maxlength!=null?" maxlength_placement":"";
    
    $id = "field_$name";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $readOnly = $readOnly==true?'readonly="true"':'';
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"input-icon right\">
                    <i class=\"fa tooltips show_error\" data-original-title=\"\"></i>
                    <input id=\"$id\" type=\"password\" class=\"$class\" data-maxlength=\"$maxlength\" name=\"$name\" value=\"$val\" $readOnly/> 
                    <span class=\"help-block help-block-error\"></span>
                </div>
                
            </div>
        </div>
    ";
    
}

function create_input_image($name,$title,$val=null,$required=false,$ques_title=null,$col=2){
    $col_after = 12 - $col;
    $id = "field_$name";
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"fileinput fileinput-new\" data-provides=\"fileinput\">
                    <div class=\"fileinput-preview thumbnail\" data-trigger=\"fileinput\" style=\"width: 200px; height: 150px;\"> </div>
                    <div>
                        <span class=\"btn red btn-outline btn-file\">
                            <span class=\"fileinput-new\"> Chọn ảnh </span>
                            <span class=\"fileinput-exists\"> Chọn lại </span>
                            <input type=\"file\" name=\"$name\" value=\"http://localhost/admin/template/backend/assets/image/logo-admin.png\"> 
                        </span>
                        <a href=\"javascript:;\" class=\"btn red fileinput-exists\" data-dismiss=\"fileinput\"> Bỏ </a>
                    </div>
                </div>
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>

    ";
    
}

function create_input_search($name,$title,$val=null,$placeholder=null,$col=2){
    $id = 'field-'.$name;
    echo "
        <div class=\"col-md-$col\" field-id=\"$name\">
            <div class=\"form-group\">
                <label for=\"$id\">$title</label>
                <input type=\"text\" name=\"$name\" class=\"form-control\" id=\"$id\" placeholder=\"$placeholder\" value=\"$val\" />  
            </div>
        </div>
    ";
}

function create_input_addon($name,$title,$link,$val=null,$required=false,$maxlength=null,$ques_title=null,$col=2,$readOnly=false){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    $class .= $maxlength!=null?" maxlength_placement":"";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    
    $id = "field_$name";
    $readOnly = $readOnly==true?'readonly="true"':'';
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"input-group\">
                    <span class=\"input-group-addon\">
                        $link
                    </span>
                    <div class=\"input-icon right\">
                        <i class=\"fa tooltips show_error\" data-original-title=\"\"></i>
                        <input type=\"text\" name=\"$name\" class=\"$class\" data-maxlength=\"$maxlength\" id=\"$id\" value=\"$val\" $readOnly/>  
                        
                    </div>
                    
                </div>
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
    
}

function create_input_multy($title,$input_array=array(),$required=false,$ques_title=null,$col_=2){
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $input_text = '';
    if($input_array != null){
        foreach($input_array as $row){
            $col = isset($row['col'])?$row['col']:5;
            $name = $row['name'];
            $title_ = lang($row['title']);
            $val = isset($row['val'])?$row['val']:null;
            $id = isset($row['id'])?$row['id']:"field_$name";
            $class = "form-control";
            $class .= isset($row['maxlength'])?" maxlength_placement":"";
            
            $input_text .= "
                <div class=\"col-md-$col\" field-id=\"$name\">
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\">
                            <label for=\"$id\">
                                $title_
                            </label>
                        </span>
                        <div class=\"input-icon right\">
                            <i class=\"fa tooltips show_error\" data-original-title=\"\"></i>
                            <input type=\"text\" name=\"$name\" class=\"$class\" id=\"$id\" value=\"$val\"/>  
                            
                        </div>
                    </div>
                    <span class=\"help-block help-block-error\"></span>
                </div>
            ";
        }
    }
    
    $id = $id==null?"field_$name":'';
    
    echo "
        <div class=\"form-group\">
            <label class=\"control-label col-md-$col_\">$title
                $required_text
            </label>
            $input_text
        </div>
    ";
}

function create_textarea($name,$title,$val=null,$required=false,$maxlength=null,$ques_title=null,$col=2){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    $class .= $maxlength!=null?" maxlength_placement":"";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $id = "field_$name";
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"input-icon right\">
                    <i class=\"fa tooltips show_error\" data-original-title=\"\"></i>
                    <textarea name=\"$name\" id=\"$id\" rows=\"3\" class=\"$class\" data-maxlength=\"$maxlength\">$val</textarea>
                    <span class=\"help-block help-block-error\"></span>
                </div>
                 
            </div>
        </div>
    ";
}

function create_seo_review($keyword,$title){
    
}

function create_editor($name,$title,$val=null,$required=false,$ques_title=null,$col=2){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $id = "field_$name";
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <textarea class=\"editor form-control\" name=\"$name\">$val</textarea>
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
}

function create_image($name,$title,$val=null,$required=false,$multy=false,$ques_title=null,$col=2){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "multy-img";
    $class .= $multy!=null?" true-multy":"";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $id = "field_$name";
    echo "
        <div class=\"form-group\" id=\"$id\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <input id=\"$id\" type=\"text\" class=\"$class\" value=\"$val\" name=\"$name\"/>
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
    
}

function create_tab($title,$collapse=true,$tab=array(),$active=true){
    
    $tool = "";
    $nav = "";
    $class = $active==true?"collapse":"expand";
    if($collapse==true){
        $tool = "
            <div class=\"tools\">
                <a href=\"javascript:;\" class=\"$class\"> </a>
            </div>
        ";
    }
    
    if($tab!=null){
        $nav .= "<ul class=\"nav nav-tabs\">";
        $class = "active";
        foreach($tab as $item){
            $tab_id = $item['id'];
            $tab_title = $item['title'];
            $nav .= "
                <li class=\"$class\">
                    <a href=\"#portlet_tab_$tab_id\" data-toggle=\"tab\"> $tab_title </a>
                </li>
            ";
            $class = '';
        }
        $nav .= "</ul>";
    }
    
    echo "
        <div class=\"portlet-title tabbable-line\">
            <div class=\"caption\">
                <span class=\"caption-subject font-green sbold uppercase\">$title</span>
            </div>
            $tool
            $nav
            
        </div>
    ";
}

function create_select_($name,$title,$val=null,$required=false,$select=array(),$field='title',$ques_title=null,$col=2,$disable=false){
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $col_after = 12 - $col;
    $id = "field_$name";
    $field = $field==null?'title':$field;
    $label = $title==null?"":"
        <label class=\"control-label col-md-$col\" for=\"$id\">
            $question
            $title
            $required_text
        </label>
    ";
    $disable = $disable==true?'disabled':'';
    
    $option = "<option value=\"\">Mời chọn ".strtolower(lang($name))."...</option>";
    if($select!=null){
        foreach($select as $item){
            $value_ = $item['id'];
            $title_ = $item[$field];
            $checked = $value_==$val?"selected=\"\"":"";
            $option .= "<option value=\"$value_\" $checked>$title_</option>";
        }
    }
    
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            $label
            <div class=\"col-md-$col_after\">
            
                <select id=\"$id\" name=\"$name\" class=\"form-control bs-select\" data-live-search=\"true\" $disable>
                    $option
                </select>
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
}

function create_select($name,$title,$val=null,$required=false,$select=array(),$ques_title=null,$col=2){
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $col_after = 12 - $col;
    
    $label = $title==null?"":"
        <label class=\"control-label col-md-$col\" for=\"field_$name\">
            $question
            $title
            $required_text
        </label>
    ";
    
    $option = "<option value=\"\">Mời chọn ".mb_strtolower(lang($name),"UTF-8")."...</option>";
    $select = mutil_menu($select,0,$result);
    if($result!=null){
        foreach($result as $item){
            $value_ = $item['id'];
            $title_ = $item['title'];
            $title_temp = "";
            $level = $item['level'];
            // for($i=0;$i<$item['level'];$i++){
            //     $title_temp .= "&nbsp;&nbsp;&nbsp;&nbsp;";
            // }
            $title_ = $title_temp.$title_;
            $checked = $value_==$val?"selected=\"\"":"";
            $option .= "<option class=\"lz-level-$level\" value=\"$value_\" $checked>$title_</option>";
        }
    }
    
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            $label
            <div class=\"col-md-$col_after\">
                <select name=\"$name\" class=\"form-control bs-select\" data-live-search=\"true\">
                    $option
                </select>
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
}

function create_select_search($name,$title,$val=null,$select=array(),$col=2,$field='title'){
    $id = 'field-'.$name;
    $option = "<option value=\"-1\">Mời chọn...</option>";
    $select = mutil_menu($select,0,$result);
    
    if($result!=null){
        foreach($result as $item){
            $value_ = $item['id'];
            $title_ = $item['title'];
            $title_temp = "";
            if(isset($item['level'])){
                for($i=0;$i<$item['level'];$i++){
                    $title_temp .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            
            $title_ = $title_temp.$title_;
            $checked = $value_==$val?"selected=\"\"":"";
            $option .= "<option value=\"$value_\" $checked>$title_</option>";
        }
    }
    echo "
        <div class=\"col-md-$col\" field-id=\"$name\">
            <div class=\"form-group\">
                <label for=\"$id\">$title</label>
                <select id=\"$id\" name=\"$name\" class=\"form-control bs-select\" data-live-search=\"true\">
                    $option
                </select>
            </div>
        </div>
    ";
}

function create_select_search_basic($name,$title,$val=null,$select=array(),$field='title',$col=2){
    $id = 'field-'.$name;
    $option = "<option value=\"-1\">Mời chọn...</option>";
    if($select!=null){
        foreach($select as $item){
            $value_ = $item['id'];
            $title_ = $item[$field];
            $checked = $value_==$val?"selected=\"\"":"";
            $option .= "<option value=\"$value_\" $checked>$title_</option>";
        }
    }
    echo "
        <div class=\"col-md-$col\" field-id=\"$name\">
            <div class=\"form-group\">
                <label for=\"$id\">$title</label>
                <select id=\"$id\" name=\"$name\" class=\"form-control bs-select\" data-live-search=\"true\">
                    $option
                </select>
            </div>
        </div>
    ";
}

function create_checkbox($name,$title,$val=null,$checked=false,$required=false,$ques_title=null,$col=2){
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $id = "field_$name";
    $checked = $checked==true?"checked=\"checked\"":"";
    echo "
        <div class=\"form-group lzCheckbox\" field-id=\"$name\">
            <div class=\"col-md-12\">
                <input id=\"$id\" type=\"checkbox\" class=\"checkboxes\" name=\"$name\" value=\"1\" $checked/> 
                <label for=\"$id\">$title</label>
                $required_text
                $question
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
}

function create_datetimepicker_range($title,$dayTo=array(),$dayEnd=array(),$required=false,$ques_title=null,$col=2){

    //($name,$title,$val=null,$required=false,$maxlength=null,$ques_title=null,$col=2,$readOnly=false){
    $dayTo_name = $dayTo['name'];
    $dayTo_val = (int)$dayTo['val']>0?date('m/d/Y',$dayTo['val']):null;
    $dayEnd_name = $dayEnd['name'];
    $dayEnd_val = (int)$dayEnd['val']>0?date('m/d/Y',$dayEnd['val']):null;
    $col = $col<2?2:$col;

    /*******************/
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    echo "
        <div class=\"form-group\">
            <label class=\"control-label col-md-$col\" >
                $question
                $title
                $required_text
            </label>
            <div class=\"input-group col-md-$col_after date-picker input-daterange\" data-date-format=\"mm/dd/yyyy\">
                <div class=\"col-md-6\" field-id=\"$dayTo_name\">
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\">
                            <label for=\"$dayTo_name\">
                                Từ ngày
                            </label>
                        </span>
                        <div class=\"input-icon right\">
                            <i class=\"fa tooltips show_error\"></i>
                            <input type=\"text\" class=\"form-control\" name=\"$dayTo_name\" value=\"$dayTo_val\">
                        </div>
                    </div>
                </div>
                <div class=\"col-md-6\" field-id=\"$dayEnd_name\">
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\">
                            <label for=\"$dayEnd_name\">
                                Đến ngày
                            </label>
                        </span>
                        <div class=\"input-icon right\">
                            <i class=\"fa tooltips show_error\"></i>
                            <input type=\"text\" class=\"form-control\" name=\"$dayEnd_name\" value=\"$dayEnd_val\">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    ";
}

function create_datetimepicker_range_search($title,$dayTo=array(),$dayEnd=array(),$col=4){
    $dayTo_name = $dayTo['name'];
    $dayTo_val = $dayTo['val'];
    $dayEnd_name = $dayEnd['name'];
    $dayEnd_val = $dayEnd['val'];
    $col = $col<4?4:$col;
    echo "
    <div class=\"col-md-$col\">
        <div class=\"form-group\">
            <label>$title</label>
            <div class=\"input-group input-large date-picker input-daterange\" data-date-format=\"mm/dd/yyyy\">
                <input type=\"text\" class=\"form-control\" name=\"$dayTo_name\" value=\"$dayTo_val\">
                <span class=\"input-group-addon\"> đến </span>
                <input type=\"text\" class=\"form-control\" name=\"$dayEnd_name\" value=\"$dayEnd_val\"> 
            </div>
        </div>
    </div>
    ";
}

function create_radio($name,$title,$val=null,$checked=0,$required=false,$ques_title=null,$col=3){
    $col_after = 12 - $col;   
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $id = "field_$name";
    $checked = $checked==1?"checked":"";
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $label = "
        <label class=\"control-label col-md-$col\" for=\"$id\">
            $question
            $title
            $required_text
        </label>
    ";
    if($col==0){
        $label = '';
    }
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            $label
            <div class=\"col-md-$col_after\">
                <input type=\"checkbox\" class=\"make-switch\" value=\"$val\" name=\"$name\" $checked data-on-color=\"primary\" data-off-color=\"info\">
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
    
}

function create_checkbox_search_multy($title,$check_list,$col=2){
    
    $input = '';
    
    if($check_list != null){
        foreach($check_list as $row){
            $id_ = 'field-'.$row['name'];
            $name_ = $row['name'];
            $title_ = lang($row['title']);
            $value_ = $row['value'];
            $checked_ = isset($row['checked'])?($row['checked']==true?'checked="checked"':''):'';
            $input .= "
                <input id=\"$id_\" type=\"checkbox\" class=\"form-control\" name=\"$name_\" value=\"$value_\" $checked_/> 
                <label for=\"$id_\">$title_</label>
            ";
        }
    }
    echo "
        <div class=\"col-md-$col\" field-id=\"\">
            <div class=\"form-group\">
                <label>$title</label>
                <br />
                $input
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div>
    ";
}


function create_input_tag($name,$title,$data,$col=2){
    $id = 'field-'.$name;
    
    $label = "<label class=\"control-label col-md-$col\">$title</label>";
    if($col==0){ $label = ''; }
    
    $col_after = 12 - $col;
    $data['dataComplete'] = isset($data['dataComplete'])?$data['dataComplete']:array();
    $autocomplete = json_encode($data['dataComplete']);
    
    echo "
        <div class=\"form-group\" field-id=\"$name\">
            $label
            <div class=\"col-md-$col_after\">
                <input id=\"$name\" type=\"text\" name=\"$name\" 
                       class=\"form-control tag_autocomplete\" data-value='$autocomplete' /> 
                <span class=\"help-block help-block-error\"></span>
            </div>
        </div> 
    ";
    
    
    
    if(isset($data['dataAdd'])){
        if($data['dataAdd']){
            $addTag = '';
            $label = "<label class=\"control-label col-md-$col\">Chọn các tags đã sử dụng</label>";
            if($col==0){ $label = ''; }
            foreach($data['dataAdd'] as $row){
                $data_value = json_encode($row);
                $data_name = $row['name'];
                $addTag .= "<a href=\"javascript:;\" onclick=\"add_tag(this)\" 
                                data-tag=\"$name\" data-value='$data_value' class=\"btn blue btnTag\">$data_name</a>&nbsp;";
            }
            echo "
                <div class=\"form-group\">
                    $label
                    <div class=\"col-md-$col_after\">
                        $addTag
                    </div>
                </div>
            ";
        }
    }
}

function create_input_tag_search($name,$title,$data,$col=2){
    $id = 'field-'.$name;
    
    $data['dataComplete'] = isset($data['dataComplete'])?$data['dataComplete']:array();
    $autocomplete = json_encode($data['dataComplete']);
    
    echo "
        <div class=\"col-md-$col\" field-id=\"$name\">
            <div class=\"form-group\">
                <label for=\"$id\">$title</label>
                <input type=\"text\" name=\"$name\" class=\"form-control tag_autocomplete\" 
                        id=\"$id\" 
                        data-value='$autocomplete'>
            </div>
        </div> 
    ";
    
    
    if($col==0){ $label = ''; }
    if(isset($data['dataAdd'])){
        if($data['dataAdd']){
            $addTag = '';
            $label = "<label class=\"control-label col-md-$col\">Chọn các tags đã sử dụng</label>";
            foreach($data['dataAdd'] as $row){
                $data_value = json_encode($row);
                $data_name = $row['name'];
                $addTag .= "<a href=\"javascript:;\" onclick=\"add_tag(this)\" 
                                data-tag=\"$name\" data-value='$data_value' class=\"btn blue\">$data_name</a>&nbsp;";
            }
            echo "
                <div class=\"form-group\">
                    $label
                    <div class=\"col-md-$col_after\">
                        $addTag
                    </div>
                </div>
            ";
        }
    }
}

function create_input_tag_search_multy($name,$id,$title,$data,$col=2){
    
    $data['dataComplete'] = isset($data['dataComplete'])?$data['dataComplete']:array();
    $autocomplete = json_encode($data['dataComplete']);
    $name = $name.'[]';
    echo "
        <div class=\"col-md-$col\" field-id=\"$id\">
            <div class=\"form-group\">
                <label for=\"$id\">$title</label>
                <input type=\"text\" name=\"$name\" class=\"form-control tag_autocomplete\" 
                        id=\"$id\" 
                        data-value='$autocomplete'>
            </div>
        </div> 
    ";
}


function loadDatabyField($type='text',$name,$dataValue,$array_loadDatabyField=array()){
    $data_return = array(
        'html'=>'',//HTML for show on list
        'export'=>null//Content for export
    );
    if($array_loadDatabyField['linkDetail']==true){
        $link = $array_loadDatabyField['table'].'/edit/'.$array_loadDatabyField['detail']['id'];
        $data_return['html'] .= "<a href=\"$link\">";
    }
    
    
    if($type=='text'){
        $data_return['html'] .= $dataValue[$name];
        $data_return['export'] = strip_tags($dataValue[$name]);
    }else if($type=='image'){
        $data_return['html'] .= "<img src=\"$dataValue[$name]\" width=\"70\" />";
        //$data_return['export'] = isset($dataValue[$name.'_base64'])?'data:image/png;base64,'.$dataValue[$name.'_base64']:$dataValue[$name];
        //$data_return['export'] = 'data:image/png;base64,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';//$dataValue[$name];
        $data_return['export'] = strip_tags($dataValue[$name]);;//isset($dataValue[$name.'_base64'])?'data:image/png;base64,'.$dataValue[$name.'_base64']:$dataValue[$name];
    }else if($type=='number'){
        $data_return['html'] .= number_format($dataValue[$name],0,'.','.');
        $data_return['export'] = number_format($dataValue[$name],0,'.','.');
    }else if($type=='time'){
        $typeParse = 'd-m-Y';
        $data_return['html'] .= $dataValue[$name]>0?date('d-m-Y G:i',$dataValue[$name]):null;
        $data_return['export'] = $dataValue[$name]>0?date('d-m-Y G:i',$dataValue[$name]):null;
    }
    else if($type=='status'){
        $default = array(
            '0'=>'label label-sm label-warning',
            '1'=>'label label-sm label-success'
        );
        $class = isset($array_loadDatabyField[$type][$name][$dataValue[$name]])?$array_loadDatabyField[$type][$name][$dataValue[$name]]:'undefined';
        $class = $class=='undefined'?(isset($default[$dataValue[$name]])?$default[$dataValue[$name]]:$default[0]):$class;
        $data_return['html'] .= 
            "<span class=\"$class\">
                ".lang($name.'_'.$dataValue[$name])."  
            </span>";
        $data_return['export'] = lang($name.'_'.$dataValue[$name]);
    }else if($type=='desc'){
        $data_return['html'] .= sub_text(strip_tags($dataValue[$name]),100);
        $data_return['export'] = $dataValue[$name];
    }
    
    if($array_loadDatabyField['linkDetail']==true){
        $data_return['html'] .= "</a>";
    }
    
    return $data_return;
}


function create_input_date($name,$title,$val=null,$required=false,$ques_title=null,$col=2){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    
    $id = "field_$name";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $timeToday = $val==null?date('d-m-Y',time()):date('d-m-Y',$val);
    $val = $val==null?null:date('d-m-Y',$val);
    echo "

        <div class=\"form-group\" field-id=\"$name\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"input-group input-medium date date-picker\" data-date=\"$timeToday\" data-date-format=\"dd-mm-yyyy\" data-date-viewmode=\"years\">
                    <input type=\"text\" class=\"$class\" readonly id=\"$id\" name=\"$name\" value=\"$val\">
                    <span class=\"input-group-btn\">
                        <button class=\"btn default\" type=\"button\">
                            <i class=\"fa fa-calendar\"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </div>
        </div>
    ";
    
}

function create_input_datetime($name,$title,$val=null,$required=false,$ques_title=null,$col=2){
    $col_after = 12 - $col;
    
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    
    $class = "form-control";
    
    $id = "field_$name";
    
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $timeToday = $val==null?date('d-m-Y H:i',time()):date('d-m-Y H:i',$val);
    $val = $val==null?null:date('d-m-Y H:i',$val);
    echo "

        <div class=\"form-group\">
            <label class=\"control-label col-md-$col\" for=\"$id\">
                $question
                $title
                $required_text
            </label>
            <div class=\"col-md-$col_after\">
                <div class=\"input-group date form_datetime input-large\" data-date=\"$timeToday\" >
                    <input type=\"text\" class=\"$class\" size=\"16\" readonly id=\"$id\" name=\"$name\" value=\"$val\">
                    <span class=\"input-group-btn\">
                        <button class=\"btn default date-set\" type=\"button\">
                            <i class=\"fa fa-calendar\"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    ";
    
}

function create_select_div10($name,$title,$val=null,$required=false,$select=array(),$field='title',$ques_title=null,$col=2,$disable=false){
    $required_text = $required==true?"<span class=\"required\"> * </span>":"";
    $question = $ques_title!=null?"<i class=\"fa fa-question-circle tooltips\" data-original-title=\"$ques_title\"></i>":'';
    $col_after = 12 - $col;
    $id = "field_$name";
    $field = $field==null?'title':$field;
    $label = $title==null?"":"
        <label class=\"control-label col-md-$col\" for=\"$id\">
            $question
            $title
            $required_text
        </label>
    ";
    $disable = $disable==true?'disabled':'';
    
    $option = "<option value=\"\">Mời chọn ".mb_strtolower(lang($name),"UTF-8")."...</option>";
    if($select!=null){
        foreach($select as $item){
            $value_ = md6($item['id']);
            $title_ = $item[$field];
            $checked = $value_==$val?"selected=\"\"":"";
            $option .= "<option value=\"$value_\" $checked>$title_</option>";
        }
    }
    
    echo "
            <div class=\"col-md-$col_after\">
            
                <select id=\"$id\" name=\"$name\" class=\"form-control bs-select\" data-live-search=\"true\" $disable>
                    $option
                </select>
                <span class=\"help-block help-block-error\"></span>
            </div>
    ";
}

?>


