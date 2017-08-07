<script type="text/javascript" src="public/plugin/date_picker/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="public/plugin/date_picker/jquery.ui.core.js"></script>
<link href="public/plugin/date_picker/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
	$(".datetimepicker").each(function(){
	   $(this).datepicker({
    		numberOfMonths: 1,  dateFormat: 'yy-mm-dd',
    		monthNames: ['Một','Hai','Ba','Tư','Năm','Sáu','Bảy','Tám','Chín', 
    		'Mười','Mười một','Mười hai'] ,
    		monthNamesShort: ['Tháng1','Tháng2','Tháng3','Tháng4','Tháng5',
    		'Tháng6','Tháng7','Tháng8','Tháng9','Tháng10','Tháng11','Tháng12'] ,
    		dayNames: ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm',
    		 'Thứ sáu', 'Thứ bảy'],
    		dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'] ,
    		showWeek: true , showOn: 'both',
    		changeMonth: true , changeYear: true,
    		currentText: 'Hôm nay', weekHeader: 'Tuần'
    	});
	});
});
</script>