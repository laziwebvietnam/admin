<script>
var mybase='../plugin/';
function BrowseServer( startupPath, functionData ){
    var finder = new CKFinder();
    finder.basePath = '../plugin/ckfinder/'; //Đường path nơi đặt ckfinder
   	finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
   	finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
   	//finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn	
    finder.popup(); // Bật cửa sổ CKFinder
}
</script>
<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../plugin/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
function editor_replace(name){
   		var editor = CKEDITOR.replace( name,{
        uiColor : '#9AB8F3',
        language:'vi',
		height:200,
        skin:'v2',
		filebrowserImageBrowseUrl : mybase+'ckfinder/ckfinder.html?Type=Images',
		filebrowserFlashBrowseUrl : mybase+'ckfinder/ckfinder.html?Type=Flash',
		filebrowserImageUploadUrl : mybase+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : mybase+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
	 	
        toolbar:[
        ['Source','Save','Preview','Find','Replace','-','SelectAll','RemoveFormat',        
        'Bold','Italic','Underline','NumberedList','BulletedList','-','Outdent','Indent'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Link','Unlink','HorizontalRule','Smiley','Maximize'],
        ['Image','Flash','Table','Styles','Format','Font','FontSize','TextColor','BGColor']
        ]
    });	
}	
</script>