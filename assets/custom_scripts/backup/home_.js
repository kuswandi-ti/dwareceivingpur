$(document).ready(function() {
	$("#div_complaint_open, #div_complaint_on_progress, #div_complaint_close").on("click",function(){
         var myURL = 'complaint_list';
         window.open(myURL, '_self');
		 return false;
     });
});