
<?php

    include_once("plugin/ckeditor/ckeditor.php");
    
    $CKEditor = new CKEditor();
     
    $CKEditor->basePath = base_url().'plugin/ckeditor/';
     
    $CKEditor->config['width'] = 600;
     
    $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
     
    $initialValue = '<p>This is some <strong>sample text</strong>. You are using <a href="http://ckeditor.com/">CKEditor</a>.</p>';
     if(isset($admin)&&$admin==true)
     {
        include_once('plugin/ckfinder/ckfinder.php');
        CKFinder::SetupCKEditor( $CKEditor, 'plugin/ckfinder/') ;
     }
function editor_frontend($name=''){
    global $CKEditor;
    
    $code = $CKEditor->editor($name, $initialValue);     
    echo $code;
}
function editor_admin($name=''){     
    global $CKEditor;
    include_once('plugin/ckfinder/ckfinder.php');
     CKFinder::SetupCKEditor( $CKEditor, 'plugin/ckfinder/') ;
}
?>