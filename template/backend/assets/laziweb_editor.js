var mybase='../template/backend/assets/global/plugins/ckeditor/';
var editorObject = {};

function BrowseServer( startupPath, inputname ){
    var finder = new CKFinder();
    finder.basePath = '../template/backend/assets/global/plugins/ckeditor/ckfinder/'; //Đường path nơi đặt ckfinder
   	finder.startupPath = 'upload/images/'.startupPath; //Đường path hiện sẵn cho user chọn file
   	//finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionFunction = function( fileUrl, data ) {
    	$('input:[name="'+inputname+'"]').val(fileUrl);
    	// Using CKFinderAPI to show simple dialog.
    	//this.openMsgDialog( '', 'Additional data: ' + data['selectActionData'] );
    	//document.getElementById( data['selectActionData'] ).innerHTML = fileUrl;
    }
    //finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
   	//finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn	
    finder.popup(); // Bật cửa sổ CKFinder
}
function BrowseServerbyid( startupPath, id ){
    var finder = new CKFinder();
    finder.basePath = '../template/backend/assets/global/plugins/ckeditor/ckfinder/'; //Đường path nơi đặt ckfinder
   	finder.startupPath = 'upload/images/'.startupPath; //Đường path hiện sẵn cho user chọn file
   	//finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionFunction = function( fileUrl, data ) {
    	$('input#'+id).val(fileUrl);
    	// Using CKFinderAPI to show simple dialog.
    	//this.openMsgDialog( '', 'Additional data: ' + data['selectActionData'] );
    	//document.getElementById( data['selectActionData'] ).innerHTML = fileUrl;
    }
    //finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
   	//finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn	
    finder.popup(); // Bật cửa sổ CKFinder
}

function editor_replace(name){
   	var conf = {
        uiColor : '#F2F2F2',
        language:'vi',
		height:200,
		filebrowserImageBrowseUrl : mybase+'ckfinder/ckfinder.html?Type=Images',
		filebrowserFlashBrowseUrl : mybase+'ckfinder/ckfinder.html?Type=Flash',
		filebrowserImageUploadUrl : mybase+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : mybase+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
	 	
        toolbar:[
            ['Source','-','RemoveFormat','Bold','Italic','Underline','NumberedList','BulletedList','-','Outdent','Indent'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Link','Unlink','Anchor','HorizontalRule','Maximize'],
            ['Image','Flash','Youtube','Video','Table','Font','FontSize','TextColor','BGColor','Blockquote']
        ],
        allowedContent: true,
		extraPlugins:'youtube,video,onchange'
    };	
	
	editor = CKEDITOR.replace( name,conf);
  editorObject[name] = editor;
}	

function reload_editor(){
    $('textarea.editor').each(function(){
        var name=$(this).attr('name');
        var class_ = $(this).parent().find('div[id="cke_'+name+'"]').attr('class');
        if(typeof class_=='undefined'){
            editor_replace(name);
        }
        
   }); 
   $('input.multy-img').each(function(){
        var ismulty=$(this).is('.true-multy');
        $(this).plugimg({ismulty:ismulty});
   });
}

reload_editor();