$(document).ready(function() {

    $('#tgl_sj').bootstrapMaterialDatePicker({
        time 		: false,
        format 		: 'DD-MM-YYYY'
    });

    $('#tgl_sj').val(moment().format('DD-MM-YYYY'));

	$('[name="nomor_dn"]').focus();

    var table_dn = $('#tbl_dn').DataTable({
    	'autoWidth'		: false,
		'responsive'	: true,
		'searching'		: false,
		'info'			: false,
		"lengthChange"	: false,
		"paging"		: false,
    	"bFilter" 		: true,
		"bProcessing" 	: true,
		"bServerSide" 	: true,
		"sServerMethod" : "GET",
		"sAjaxSource" 	: "pulling/get_data_temp_dn",
		"iDisplayLength": 10,
		"aLengthMenu" 	: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"aaSorting" 	: [[1, 'asc']], // 0 kolom 1
		"aoColumns" 	: [
			{ "bVisible": false, "bSearchable": false, "bSortable": false }, 	// Sys ID 0
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// No. DN 1
			{ "bVisible": true, "bSearchable": false, "bSortable": false } 		// Action 2
		],
		"columnDefs" 	: [
			{ "className": "text-center", "targets": [1, 2] },
		]
    });

    var table_kanban = $('#tbl_kanban').DataTable({
    	'autoWidth'		: false,
		'responsive'	: true,
		'searching'		: false,
		'info'			: false,
		"lengthChange"	: false,
		"paging"		: true,
    	"bFilter" 		: true,
		"bProcessing" 	: true,
		"bServerSide" 	: true,
		"sServerMethod" : "GET",
		"sAjaxSource" 	: "pulling/get_data_temp_kanban",
		"iDisplayLength": 10,
		"aLengthMenu" 	: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"aaSorting" 	: [[1, 'asc']], // 0 kolom 1
		"aoColumns" 	: [
			{ "bVisible": false, "bSearchable": false, "bSortable": false }, 	// Sys ID 0
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Job No 1
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// CPN Number 2
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// CPN Name 3
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Unit 4
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Qty Kanban 5
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Qty Packing 6
			{ "bVisible": true, "bSearchable": false, "bSortable": false } 		// Action 7
		],
		"columnDefs" 	: [
			{ "className": "text-center", "targets": [1, 2, 4, 7] },
			{ "className": "text-right", "targets": [5, 6] },
		]
    });

    var table_tagok = $('#tbl_tagok').DataTable({
    	'autoWidth'		: false,
		'responsive'	: true,
		'searching'		: false,
		'info'			: false,
		"lengthChange"	: false,
		"paging"		: true,
    	"bFilter" 		: true,
		"bProcessing" 	: true,
		"bServerSide" 	: true,
		"sServerMethod" : "GET",
		"sAjaxSource" 	: "pulling/get_data_temp_tagok",
		"iDisplayLength": 10,
		"aLengthMenu" 	: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"aaSorting" 	: [[1, 'asc']], // 0 kolom 1
		"aoColumns" 	: [
			{ "bVisible": false, "bSearchable": false, "bSortable": false }, 	// Sys ID 0
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Barcode ID 1
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Job No 2
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// CPN Number 3
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// CPN Name 4
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Unit 5
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Qty Packing 6
			{ "bVisible": true, "bSearchable": false, "bSortable": false } 		// Action 7
		],
		"columnDefs" 	: [
			{ "className": "text-center", "targets": [1, 2, 3, 5, 7] },
			{ "className": "text-right", "targets": [6] },
		]
    });

    var table_listsj = $('#tbl_listsj').DataTable({
    	"processing"	: true,
        "serverSide"	: true,
        "order"			: [],
        "ajax"			: {
            "url"		: "pulling/datatable_sjhdr_list",
            "type"		: "POST"
        },
        "aoColumns" 	: [
			{ "bVisible": false, "bSearchable": false, "bSortable": false }, 	// Sys ID 0
			{ "bVisible": true, "bSearchable": false, "bSortable": false }, 	// No 1
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// No DN 2
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// No SJ 3
			{ "bVisible": true, "bSearchable": true, "bSortable": true }, 		// Tgl SJ 4
		],
        "columnDefs"	: [
        	{ "className": "text-center", "targets": [1, 2, 3] },
			{ "className": "text-right", "targets": [4] },
        ]
    });

    $('#nomor_dn').keypress(function(event) {	
		var keycode = (event.keyCode ? event.keyCode : event.which);
		$nomor_dn 	= $('#nomor_dn').val();
		if(keycode == '13') {
			if(($nomor_dn).length == 0) {
				$.toast({
		        	heading				: 'Error',
		            text				: 'Nomor DN belum diisi !!!',
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
				                  'Nomor DN belum diisi !!!',
				});
				return false;
			}
			$.ajax({
				type 		: 'POST',
				url 		: 'pulling/scan_dn',
				dataType	: 'json',
				data 		: $('#form_scan').serialize(),
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
						                  		'<li>Nomor DN sudah dibuatkan Surat Jalan.</li>'+
						                  		'<li>Nomor DN belum dibuatkan Sales Order.</li>'+
						                  		'<li>Nomor DN tidak ada di database.</li>'+
						                  '</ol>',
						});
				    	$('#nomor_dn').val('');
						$('#nomor_dn').focus();
					} else if(response.exist) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.exist,
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
						                  response.exist,
						});
				    	$('#nomor_dn').val('');
						$('#nomor_dn').focus();
					} else {
						if(response.empty_success) {
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.empty_success,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					  		// Swal.fire({
							// 	type 		: 'success',
							//   	title 		: '<strong>Successfully</strong>',
							//     html 		: response.empty_success,
							//     timer 		: 5000,
							// });
							table_dn.ajax.reload(null, false);
							$('#nomor_dn').val('');
							$('[name="nomor_kanban"]').focus();
						} else if(response.empty_error) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.empty_error,
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
							                  response.empty_error,
							});
					    	$('#nomor_dn').val('');
							$('#nomor_dn').focus();
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
			    	$('#nomor_dn').val('');
			    	$('#nomor_dn').focus();
	     		}
			});	
		}
	});

	$("body").on("click", "#tbl_dn .delete_dn", function() {
    	var sysid = $(this).data('sysid');
    	var no_dn = $(this).data('no_dn');

    	swal({
			title 				: 'Hapus Data ?',
			html 				: 'Yakin akan menghapus data DN '+no_dn+' ? <br>'+
			                      'Data DN, Kanban, & Tag OK yang sudah diinput akan terhapus semua',
			type 				: 'warning',
			showCancelButton 	: true,
			confirmButtonText 	: 'Yes',
			cancelButtonText 	: "No",
			confirmButtonClass 	: "btn-danger",
			showLoaderOnConfirm : true,
			preConfirm 			: function() {
			  	return new Promise(function(resolve) {
					$.ajax({
						url 		: 'pulling/delete_temp_dn',
						type 		: 'POST',
						dataType 	: 'json',
						data 		: { 
							'sysid' : sysid,
							'no_dn'	: no_dn,
						}
					})
					.done(function(response){
						if (response.success) {
							table_dn.ajax.reload(null, false);
							table_kanban.ajax.reload(null, false);
					    	table_tagok.ajax.reload(null, false);
							swal.close(); // https://stackoverflow.com/questions/44973038/how-to-close-sweet-alert-on-ajax-request-completion
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					  		//Swal.fire({
							// 	type 		: 'success',
							//   	title 		: '<strong>Successfully</strong>',
							//     html 		: response.success,
							//     timer 		: 5000,
							// });
							$('#nomor_dn').val('');
							$('#nomor_dn').focus();
						}
					})
					.fail(function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText
						Swal.fire({
							type 		: 'error',
						  	title 		: '<strong>Error</strong>',
						    text 		: errorMessage,
						});
						$('#nomor_dn').val('');
						$('#nomor_dn').focus();
					});
			  	});
			},
			allowOutsideClick: false     
		});
    });

    $('#nomor_kanban').keypress(function(event) {	
		var keycode 	= (event.keyCode ? event.keyCode : event.which);
		$nomor_kanban 	= $('#nomor_kanban').val();
		if(keycode == '13') {
			if(($nomor_kanban).length == 0) {
				$.toast({
		        	heading				: 'Error',
		            text				: 'Nomor Kanban belum diisi !!!',
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
				                  'Nomor Kanban belum diisi !!!',
				});
				return false;
			}
			$.ajax({
				type 		: 'POST',
				url 		: 'pulling/scan_kanban',
				dataType	: 'json',
				data 		: $('#form_scan').serialize(),
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
						    html 		: '<u>Kemungkinan error :</u> <br>'+
						                  response.dn_not_exist,
						});
				    	$('#nomor_kanban').val('');
						$('#nomor_kanban').focus();
					} else if(response.error_kanban_packing_0) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.error_kanban_packing_0,
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
						                  response.error_kanban_packing_0,
						});
				    	$('#nomor_kanban').val('');
						$('#nomor_kanban').focus();
					} else if(response.exist) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.exist,
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
						                  response.exist,
						});
				    	$('#nomor_kanban').val('');
						$('#nomor_kanban').focus();
					} else {
						if(response.empty_success) {
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.empty_success,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					  		// Swal.fire({
							// 	type 		: 'success',
							//   	title 		: '<strong>Successfully</strong>',
							//     html 		: response.empty_success,
							//     timer 		: 5000,
							// });
							$('#nomor_kanban').val('');
							table_kanban.ajax.reload(null, false);
							$('[name="nomor_kanban"]').focus();
						} else if(response.empty_error) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.empty_error,
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
							                  response.empty_error,
							});
					    	$('#nomor_kanban').val('');
							$('#nomor_kanban').focus();
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
					    html 		: errorMessage,
					});
			    	$('#nomor_kanban').val('');
					$('#nomor_kanban').focus();
	     		}
			});	
		}
	});

	$("body").on("click", "#tbl_kanban .delete_kanban", function() {
    	var sysid 	= $(this).data('sysid');
    	var no_dn 	= $(this).data('no_dn');
    	var job_no 	= $(this).data('job_no');

    	swal({
			title 				: 'Hapus Data ?',
			html 				: 'Yakin akan menghapus data Kanban ? <br>'+
			                      'Data Kanban, & Tag OK yang sudah diinput akan terhapus semua',
			type 				: 'warning',
			showCancelButton 	: true,
			confirmButtonText 	: 'Yes',
			cancelButtonText 	: "No",
			confirmButtonClass 	: "btn-danger",
			showLoaderOnConfirm : true,
			preConfirm 			: function() {
			  	return new Promise(function(resolve) {
					$.ajax({
						url 		: 'pulling/delete_temp_kanban',
						type 		: 'POST',
						dataType 	: 'json',
						data 		: { 
							'sysid' 	: sysid,
							'no_dn'		: no_dn,
							'job_no' 	: job_no,
						}
					})
					.done(function(response){
						if (response.success) {							
							table_kanban.ajax.reload(null, false);
					    	table_tagok.ajax.reload(null, false);
							swal.close(); // https://stackoverflow.com/questions/44973038/how-to-close-sweet-alert-on-ajax-request-completion
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					  		// Swal.fire({
							// 	type 		: 'success',
							//   	title 		: '<strong>Successfully</strong>',
							//     html 		: response.success,
							//     timer 		: 5000,
							// });
							$('#nomor_kanban').val('');
							$('#nomor_kanban').focus();
						}
					})
					.fail(function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText
						Swal.fire({
							type 		: 'error',
						  	title 		: '<strong>Error</strong>',
						    text 		: errorMessage,
						});
						$('#nomor_dn').val('');
						$('#nomor_dn').focus();
					});
			  	});
			},
			allowOutsideClick: false     
		});
    });

    $('#nomor_tagok').keypress(function(event) {	
		var keycode 	= (event.keyCode ? event.keyCode : event.which);
		$nomor_tagok 	= $('#nomor_tagok').val();
		if(keycode == '13') {
			if(($nomor_tagok).length == 0) {
				$.toast({
		        	heading				: 'Error',
		            text				: 'Tag OK belum diisi !!!',
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
				                  'Tag OK belum diisi !!!',
				});
				return false;
			}
			$.ajax({
				type 		: 'POST',
				url 		: 'pulling/scan_tagok',
				dataType	: 'json',
				data 		: $('#form_scan').serialize(),
				beforeSend 	: function() {
					$("body").mLoading({
	  					text: "Loading...",
					});
				},
				complete 	: function() {
					$("body").mLoading('hide');
				},
				success 	: function(response) {
					if(response.tagok_not_exist) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.tagok_not_exist,
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
						                  response.tagok_not_exist,
						});
				    	$('#nomor_tagok').val('');
						$('#nomor_tagok').focus();
					} else if(response.job_no_not_match) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.job_no_not_match,
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
						                  response.job_no_not_match,
						});
				    	$('#nomor_tagok').val('');
						$('#nomor_tagok').focus();
					} else if(response.empty_success) {
						$.toast({
				        	heading				: 'Successfully',
				            text				: response.empty_success,
				            showHideTransition	: 'slide',
				            position			: 'top-center',
				            loaderBg			: '#ff6849',
				            icon				: 'success',
				            hideAfter			: 5000            
				    	});
				  		// Swal.fire({
						// 	type 		: 'success',
						//   	title 		: '<strong>Successfully</strong>',
						//     html 		: response.empty_success,
						//     timer 		: 5000,
						// });
						$('#nomor_tagok').val('');
						table_tagok.ajax.reload(null, false);
						$('[name="nomor_tagok"]').focus();
					} else if(response.empty_error) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.empty_error,
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
						                  response.empty_error,
						});
				    	$('#nomor_tagok').val('');
						$('#nomor_tagok').focus();
					} else if(response.exist) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.exist,
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
						                  response.exist,
						});
				    	$('#nomor_tagok').val('');
						$('#nomor_tagok').focus();
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
			    	$('#nomor_tagok').val('');
					$('#nomor_tagok').focus();
	     		}
			});	
		}
	});

	$("body").on("click", "#tbl_tagok .delete_tagok", function() {
    	var sysid 				= $(this).data('sysid');
    	var barcode_id_tag_ok 	= $(this).data('barcode_id_tag_ok');

    	swal({
			title 				: 'Hapus Data ?',
			html 				: 'Yakin akan menghapus data Tag OK '+barcode_id_tag_ok+' ? <br>'+
		                          'Data Tag OK yang sudah diinput akan terhapus',
			type 				: 'warning',
			showCancelButton 	: true,
			confirmButtonText 	: 'Yes',
			cancelButtonText 	: "No",
			confirmButtonClass 	: "btn-danger",
			showLoaderOnConfirm : true,
			preConfirm 			: function() {
			  	return new Promise(function(resolve) {
					$.ajax({
						url 		: 'pulling/delete_temp_tagok',
						type 		: 'POST',
						dataType 	: 'json',
						data 		: { 
							'sysid' 			: sysid,
							'barcode_id_tag_ok'	: barcode_id_tag_ok,
						}
					})
					.done(function(response){
						if (response.success) {							
					    	table_tagok.ajax.reload(null, false);
							swal.close(); // https://stackoverflow.com/questions/44973038/how-to-close-sweet-alert-on-ajax-request-completion
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					  		// Swal.fire({
							// 	type 		: 'success',
							//   	title 		: '<strong>Successfully</strong>',
							//     html 		: response.success,
							//     timer 		: 5000,
							// });
							$('#nomor_tagok').val('');
							$('#nomor_tagok').focus();
						}
					})
					.fail(function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText
						Swal.fire({
							type 		: 'error',
						  	title 		: '<strong>Error</strong>',
						    text 		: errorMessage,
						});
						$('#nomor_tagok').val('');
						$('#nomor_tagok').focus();
					});
			  	});
			},
			allowOutsideClick: false     
		});
    });

    $("#btn_create_sj").click(function() {
    	Swal.fire({
			title 				: 'Create Surat Jalan ?',
			html 				: 'Yakin akan melanjutkan proses membuat Surat Jalan (SJ) ?',
			type 				: 'question',
			showCancelButton 	: true,
			confirmButtonText 	: 'Yes',
			cancelButtonText 	: "No",
			confirmButtonClass 	: "btn-warning",
			showLoaderOnConfirm : true,
			preConfirm 			: function() {
			  	return new Promise(function(resolve) {
					$.ajax({
						url 		: 'pulling/create_sj',
						type 		: 'POST',
						dataType 	: 'json',
						data 		: $('#form_scan').serialize(),
					})
					.done(function(response){
						swal.close(); // https://stackoverflow.com/questions/44973038/how-to-close-sweet-alert-on-ajax-request-completion
						if (response.error_empty_dn) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.error_empty_dn,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'error'       
					    	});
					  		Swal.fire({
								type 		: 'error',
							  	title 		: '<strong>Error</strong>',
							    html 		: '<u>Kemungkinan error :</u> <br>'+
							                  response.error_empty_dn,
							});
						} else if (response.qty_not_match) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.qty_not_match,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'error'       
					    	});
					  		Swal.fire({
								type 		: 'error',
							  	title 		: '<strong>Error</strong>',
							    html 		: '<u>Kemungkinan error :</u> <br>'+
							                  response.qty_not_match,
							});
						} else if (response.error_rollback) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.error_rollback,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'error'
					    	});
						} else if (response.success) {							
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success+' '+response.success_message,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					    	Swal.fire({
								type 		: 'success',
							  	title 		: '<strong>Successfully</strong>',
							    html 		: response.success+'<br>'+response.success_message
							});
							$('#nomor_dn').val('');
							$('#nomor_dn').focus();
							table_dn.ajax.reload(null, false);
							table_kanban.ajax.reload(null, false);
					    	table_tagok.ajax.reload(null, false);
					    	table_listsj.ajax.reload(null, false);					    	
						}
					})
					.fail(function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText
						Swal.fire({
							type 		: 'error',
						  	title 		: '<strong>Error</strong>',
						    text 		: errorMessage,
						});
					});
			  	});
			},
			allowOutsideClick: false     
		});
    });

});