$(document).ready(function() {

	$('#browse_truk').click(function () {
		table_browse_truk.ajax.reload();
		$('#modal_truk').modal('show');
	});

	var table_browse_truk = $('#tbl_browse_truk').DataTable({
    	"processing"	: true,
        "serverSide"	: true,
        "order"			: [],
        "iDisplayLength": 10,
        "ajax"			: {
            "url"		: "loading/datatable_truk_list",
            "type"		: "POST"
        },
        "columnDefs"	: [
        	{ "className": "text-center", "targets": [1, 2, 3] },
        ],
    });

    $('body').on('click', '#select_vehicle', function (e) {    	
		var vehicle_num 	= $(this).data('vehicle-num');
		var armada_name 	= $(this).data('armada-name');

		$('#vehicle_num').val(vehicle_num);
		$('#armada_name').val(armada_name);

		$('#modal_truk').modal('hide');
    });

    $('#browse_supir').click(function () {
		$('#modal_supir').modal('show');
	});

    var table_browse_supir = $('#tbl_browse_supir').DataTable({
    	"processing"	: true,
        "serverSide"	: true,
        "order"			: [],
        "ajax"			: {
            "url"		: "loading/datatable_supir_list",
            "type"		: "POST"
        },
        "columnDefs"	: [
        	{ "className": "text-center", "targets": [1, 2, 3] },
        ],
    });

    $('body').on('click', '#select_driver', function (e) {    	
		var nik 			= $(this).data('nik');
		var driver_name 	= $(this).data('driver-name');

		$('#nik').val(nik);
		$('#driver_name').val(driver_name);

		$('#modal_supir').modal('hide');

		$('#dn_adm').val('');
		$('#dn_adm').focus();
    });

    function load_table_loading() {
	    var table_dn = $('#tbl_loading').DataTable({
	    	"processing"	: true,
	        "serverSide"	: true,
	        "order"			: [],
	        "ajax"			: {
	            "url"		: "loading/datatable_dn_list",
	            "type"		: "POST",
	            "data"		: {
	            	"sysid"		: $('#sysid').val()
	            }
	        },
	        "columnDefs"	: [
	        	{ "className": "text-center", "targets": [1, 2, 3] },
	        ],
	    });
	}

    $('#dn_adm').keypress(function(event) {	
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13') {
			$('#dn_adm_rep').val($('#dn_adm').val());
			$.ajax({
				type 		: 'POST',
				url 		: 'loading/scan_dn',
				dataType	: 'json',
				data 		: $('#form_loading').serialize(),
				beforeSend 	: function() {
					$("body").mLoading({
	  					text: "Loading...",
					});
				},
				complete 	: function() {
					$("body").mLoading('hide');
				},
				success 	: function(response) {
					if(response.dn_not_exist) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.dn_not_exist,
				            showHideTransition	: 'slide',
				            position			: 'top-center',
				            loaderBg			: '#ff6849',
				            icon				: 'error',
				            hideAfter			: 5000            
				    	});
						Swal.fire({
							type 		: 'error',
						  	title 		: '<strong>Error</strong>',
						    // html 		: '<u>Kemungkinan error :</u> <br>'+
						    //               response.dn_not_exist,
						    html 		: '<u>Kemungkinan error :</u> <br>'+
						                  '<ol>'+
						                  		'<li>Nomor DN belum dibuatkan Surat Jalan.</li>'+
						                  		'<li>Nomor DN sudah discan Loading di transaksi lain.</li>'+
						                  		'<li>Nomor DN tidak ada di database.</li>'+
						                  '</ol>',
						});
				    	$('#dn_adm').val('');
						$('#dn_adm').focus();
						$('#dn_adm_rep').val('');
						$('#dn_adm_rep').focus();
					} else if(response.dn_not_os) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.dn_not_os,
				            showHideTransition	: 'slide',
				            position			: 'top-center',
				            loaderBg			: '#ff6849',
				            icon				: 'error',
				            hideAfter			: 5000            
				    	});
						Swal.fire({
							type 		: 'error',
						  	title 		: '<strong>Error</strong>',
						    html 		: '<u>Kemungkinan error :</u> <br>'+
						                  response.dn_not_os,
						});
				    	$('#dn_adm').val('');
						$('#dn_adm').focus();
						$('#dn_adm_rep').val('');
						$('#dn_adm_rep').focus();
					} else {
						if(response.success) {
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					    	Swal.fire({
								type 		: 'success',
							  	title 		: '<strong>Successfully</strong>',
							    html 		: response.success,
							    timer		: 5000,
							});
							$('#sysid').val(response.sysid);
							load_table_loading();
							//$('#form_loading').trigger("reset");
						} else if(response.error_rollback) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.error_rollback,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'error',
					            hideAfter			: 5000            
					    	});
							Swal.fire({
								type 		: 'error',
							  	title 		: '<strong>Error</strong>',
							    html 		: '<u>Kemungkinan error :</u> <br>'+
							                  response.error_rollback,
							});
					    	$('#dn_adm').val('');
							$('#dn_adm').focus();
							$('#dn_adm_rep').val('');
							$('#dn_adm_rep').focus();
						}
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
			    	Swal.fire({
						type 		: 'error',
					  	title 		: '<strong>Error</strong>',
					    text 		: errorMessage,
					});
			    	$('#dn_adm').val('');
					$('#dn_adm').focus();
					$('#dn_adm_rep').val('');
					$('#dn_adm_rep').focus();
	     		}
			});	
		}
	});

});