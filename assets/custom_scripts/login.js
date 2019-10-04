$(document).ready(function() { 

	$('#nik').focus(); 

	$('#form_login').submit(function(e){
		e.preventDefault();
		$("#btn_login").html('Processing...');
		$("#btn_login").prop("disabled", true);
		$.ajax({
			type 		: 'POST',
			url 		: 'login/do_login',
			dataType	: 'json',
			data 		: $('#form_login').serialize(),
			success 	: function(response) {
				if(response.error) {
					$.toast({
			        	heading				: 'Error',
			            text				: response.error,
			            showHideTransition	: 'slide',
			            position			: 'top-center',
			            loaderBg			: '#ff6849',
			            icon				: 'error',
			            hideAfter			: 5000            
			    	});
			    	$("#btn_login").html('Submit');
					$("#btn_login").prop("disabled", false);
				} else {
					$.toast({
			        	heading				: 'Success',
			            text				: response.success,
			            showHideTransition	: 'slide',
			            position			: 'top-center',
			            loaderBg			: '#ff6849',
			            icon				: 'success',
			            hideAfter			: 2000,
			            afterHidden: function () {
        					window.location.href = 'home';
    					}
			    	});					
				}
			},
     		error: function(xhr, status, error){
         		var errorMessage = xhr.status + ': ' + xhr.statusText
         		$.toast({
		        	heading				: 'Error',
		            text				: errorMessage,
		            showHideTransition	: 'slide',
		            position			: 'top-center',
		            loaderBg			: '#ff6849',
		            icon				: 'error',
		            hideAfter			: 5000
		    	});
		    	$("#btn_login").html('Submit');
				$("#btn_login").prop("disabled", false);
     		}
		});
	});

});