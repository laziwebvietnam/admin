<?php
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
if(!function_exists('is_ajaxloader'))
{
    function is_ajaxloader(){
        if(isset($_POST['ajax'])&&$_POST['ajax']==='ajax')
            return true;
        return false;
    }
}
if(!function_exists('ajax_input'))
{
    function ajax_input($fieldname='',$table='',$id=0,$value='',$class='')
    {
        ?>
        <div class="<?=$class?>" >
            <input class="min-input ajax-update-input" value="<?=$value?>" name="order_number" class="ajax_update" />
            <input type="hidden" value="<?=$fieldname?>" name="field" class="field" />
            <input type="hidden" value="<?=$table?>" name="table" class="table" />
            <input type="hidden" value="<?=$id?>" name="id" class="id" />
        </div>
        <?php
    }
}
?>