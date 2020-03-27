$(document).ready(function() {

    $('#doc_date').val(moment().format('DD-MM-YYYY'));

    $('#arrival_date').bootstrapMaterialDatePicker({
        time 		: false,
        format 		: 'DD-MM-YYYY'
    });
    $('#arrival_date').val(moment().format('DD-MM-YYYY'));

    $('#sj_date_supplier').bootstrapMaterialDatePicker({
        time 		: false,
        format 		: 'DD-MM-YYYY'
    });
    $('#sj_date_supplier').val(moment().format('DD-MM-YYYY'));

    // https://codepedia.info/jquery-allow-numbers-decimal-only-in-textbox-numeric-input/
    $('#edit_qty_rr').on("input", function(evt) {
   		var self = $(this);
   		self.val(self.val().replace(/[^0-9\.]/g, ''));
   		if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
     		evt.preventDefault();
   		}
 	});

 	$('#edit_qty_rr').blur(function() {
		if($("#edit_qty_rr").val().length == 0) {
			$("#edit_qty_rr").val(0);
		}
    });

    function browse_table_po() {
    	var result = $("input:radio[name=rdo_source]:checked").val(); // bpp or cer
    	var table_po = $('#tbl_browse_po').DataTable();
    	table_po.clear(); // https://datatables.net/reference/api/clear()
	    table_po = $('#tbl_browse_po').DataTable({
	    	"destroy" 		: true,
	    	"processing"	: true,
	        "serverSide"	: true,
	        "order"			: [],
	        "ajax"			: {
	            "url"		: "receiving/datatable_po",
	            "type"		: "POST",
	            "data"		: {
	            	"source" 	: result,
	            }
	        },
	        "aoColumns": [
				{ "bVisible": false, "bSearchable": false, "bSortable": false }, // SysId. 0
				{ "bVisible": true, "bSearchable": false, "bSortable": false }, // No 1
				{ "bVisible": true, "bSearchable": true, "bSortable": true }, // PO Number 2
				{ "bVisible": true, "bSearchable": true, "bSortable": true }, // PO Rev 3
				{ "bVisible": true, "bSearchable": true, "bSortable": true }, // PO Date 4
				{ "bVisible": false, "bSearchable": false, "bSortable": false }, // Vendor Id 5
				{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Vendor 6
				{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Remarks 7
				{ "bVisible": true, "bSearchable": false, "bSortable": false } // Action 8
			],
			"columnDefs": [
				{ "className": "text-center", "targets": [0, 1, 2, 3, 8] },
				{ "className": "text-right", "targets": [4] },
				{ "width": "5%", "targets": [0] },  // No.
				{ "width": "10%", "targets": [8] } // Action
			],
	    });	    
	}

	$('body').on('click', '#select_po', function (e) {
		var po_id 		= $(this).data('sysid');
		var po_number 	= $(this).data('po-number');
		var vendor_id 	= $(this).data('vendor-id');
		var vendor_all 	= $(this).data('vendor-all');
		var department 	= $(this).data('department');

		$('#po_id').val(po_id);
		$('#po_number').val(po_number);
		$('#vendor_id').val(vendor_id);
		$('#vendor').val(vendor_all);
		$('#department').val(department);

		swal({
            title               : 'Get Data PO ?',
            text                : "Yakin akan melanjutkan proses ? Data yang lama akan direplace",
            type                : 'question',
            showCancelButton    : true,
            confirmButtonText   : 'Yes',
            cancelButtonText    : "No",
            confirmButtonClass  : "btn-warning",
            showLoaderOnConfirm : true,
            preConfirm          : function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url     	: 'receiving/get_data_po',
                        type    	: 'POST',
                        dataType 	: 'json',
                        async 		: false,
                        data 		: $('#form_receive').serialize(),
                    })
                    .done(function(response) {
                        if (response.success) {
							list_data_detail_rr();
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
					    	$('#modal_detail_po').modal('hide');
						}
                    })
                    .fail(function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        Swal.fire({
                            type        : 'error',
                            title       : '<strong>Error</strong>',
                            text        : errorMessage,
                        });
                    });
                });
            },
            allowOutsideClick: false     
        });
    });

    function list_data_detail_rr() {
        $.ajax({
            url   	: 'receiving/list_data_detail_rr',
            async 	: false,
            type    : 'POST',
            data 	: $('#form_receive').serialize(),
            success : function(data) {
                $('#show_detail_receive').html(data);
            }
        });
    }
    

    $("body").on("click", "#browse_po", function() {
    	browse_table_po();
    	$('#modal_detail_po').modal('show');
    });

    $("body").on("click", "#tbl_receive_dtl #delete_rr", function() {
    	var sysid = $(this).data('sysid');

    	swal({
			title 				: 'Hapus Data ?',
			html 				: 'Yakin akan menghapus data ?',
			type 				: 'warning',
			showCancelButton 	: true,
			confirmButtonText 	: 'Yes',
			cancelButtonText 	: "No",
			confirmButtonClass 	: "btn-danger",
			showLoaderOnConfirm : true,
			preConfirm 			: function() {
			  	return new Promise(function(resolve) {
					$.ajax({
						url 		: 'receiving/delete_temp_rr',
						type 		: 'POST',
						dataType 	: 'json',
						data 		: { 
							'sysid' : sysid,
						}
					})
					.done(function(response){
						if (response.success) {
							list_data_detail_rr();
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

     function reset_input_header() {
		$('#po_number').val('');
		$('#po_id').val('');
		$('#department').val('');
		$('#doc_date').val(moment().format('DD-MM-YYYY'));
		$('#arrival_date').val(moment().format('DD-MM-YYYY'));
		$('#vendor').val('');
		$('#vendor_id').val('');
		$('#sj_date_supplier').val(moment().format('DD-MM-YYYY'));
		$('#no_sj_supplier').val('');
		$('#remarks').val('');
	}

    function readonly_input_detail() {
		$('#edit_product_code').attr('readonly', true);
		$('#edit_product_name').attr('readonly', true);
		$('#edit_unit').attr('readonly', true);

		$('#edit_qty_po').attr('readonly', true);
		$('#edit_qty_os').attr('readonly', true);
	}

    function reset_input_detail() {
		$('#sysid').val('');

		$('#edit_product_code').val('');
		$('#edit_product_name').val('');
		$('#edit_unit').val('');

		$('#edit_qty_po').val('0');
		$('#edit_qty_os').val('0');
		$('#edit_qty_rr').val('0');
		$('#edit_qty_rr_old').val('0');
	}

    $('body').on('click', '#edit_rr', function (e) {
		e.preventDefault();

		reset_input_detail();

		var sysid = $(this).data('sysid');
		$.ajax({
			url: 'receiving/edit_temp_rr',
			type: 'POST',
			data: {
				'sysid': sysid
			},
			dataType: 'json',
			beforeSend: function() {
				$("body").mLoading({
  					text: "Loading...",
				});
			},
			complete: function() {
				$("body").mLoading('hide');
			},
			success: function(data) {
				$('#edit_sysid').val(data.SysId);
				$('#edit_product_code').val(data.Product_Code); 
				$('#edit_product_name').val(data.Product_Name);
				$('#edit_unit').val(data.Unit_Name);
				$('#edit_qty_po').val(data.Qty_PO);
				$('#edit_qty_os').val(data.Qty_OS);
				$('#edit_qty_rr').val(data.Qty_RR);
				$('#edit_qty_rr_old').val(data.Qty_RR);
				readonly_input_detail();
				$('#modal_edit_rr').modal('show');				
			}
		});
	});

	$('body').on('click', '#btn_save', function() {
		$('#btn_save').prop('disabled', true);
		var url = 'receiving/update_temp_rr';

		var formData = new FormData($('#form_edit_rr')[0]);
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			contentType: false,       
		    cache: false,             
		    processData: false,
			data: formData,
			beforeSend : function() {
				$("body").mLoading({
  					text: "Loading...",
				});
			},
			complete : function() {
				$("body").mLoading('hide');
			},
			success : function(response) {
				if(response.success_update) {
					$.toast({
			        	heading				: 'Successfully',
			            text				: response.success_update,
			            showHideTransition	: 'slide',
			            position			: 'top-center',
			            loaderBg			: '#ff6849',
			            icon				: 'success',
			            hideAfter			: 5000            
			    	});
			    	Swal.fire({
						type 		: 'success',
					  	title 		: '<strong>Successfully</strong>',
					    html 		: response.success_update
					});
					$('#modal_edit_rr').modal('hide');
					list_data_detail_rr();
				} else {
					$.toast({
			        	heading				: 'Error',
			            text				: response.failed_update,
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
					                  response.failed_update,
					});
				}
				$('#btn_save').prop('disabled', false);
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
				$('#btn_save').prop('disabled', false);
     		}
		});
	});

	$('body').on('click', '#btn_proses_rr', function (e) {
		e.preventDefault();

		if ($('#po_number').val().length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'PO Number belum diinput !!!',
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
			                  'PO Number belum diinput !!!',
			});
			return false;
		}

		if ($('#no_sj_supplier').val().length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'No SJ Supplier tidak boleh kosong !!!',
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
			                  'No SJ Supplier tidak boleh kosong !!!',
			});
			return false;
		}

		$('#modal_scan_nik').modal('show');
		$('#nik_requester').val('');
		$('[name="nik_requester"]').focus();
	});

	$('#nik_requester').keypress(function(event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);		

		if (keycode == '13') {
			event.preventDefault(); // https://stackoverflow.com/questions/8866053/stop-reloading-page-with-enter-key
			var nik_req	= $('#nik_requester').val();

			// cek dulu, apakah nik sesuai dengan department?
			$.ajax({
				type: 'POST',
				url: 'receiving/cek_requester',
				dataType: 'json',
				async: false,
				data: {
					'nik_req': nik_req,
					'dept_req': $('#department').val()
				},
				beforeSend : function() {
					$("body").mLoading({
	  					text: "Loading...",
					});
				},
				complete : function() {
					$("body").mLoading('hide');
				},
				success : function(response) {
					if (response.nik_req_not_exist) {
						$.toast({
				        	heading				: 'Error',
				            text				: response.nik_req_not_exist,
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
						                  response.nik_req_not_exist,
						});
					} else if (response.nik_req_exist) {
						$('[name="no_sj_supplier"]').focus();
						Swal.fire({
							title 				: 'Create Receiving Report ?',
							html 				: 'Yakin akan melanjutkan proses membuat dokumen Receiving Report ?',
							type 				: 'question',
							showCancelButton 	: true,
							confirmButtonText 	: 'Yes',
							cancelButtonText 	: "No",
							confirmButtonClass 	: "btn-warning",
							showLoaderOnConfirm : true,
							preConfirm 			: function() {
							  	return new Promise(function(resolve) {
									$.ajax({
										url 		: 'receiving/create_trx_rr',
										type 		: 'POST',
										dataType 	: 'json',
										async 		: false,
										data 		: $('#form_receive').serialize() + "&nik_req="+nik_req.trim(),
									})
									.done(function(response){
										swal.close(); // https://stackoverflow.com/questions/44973038/how-to-close-sweet-alert-on-ajax-request-completion
										if (response.error_empty_rr) {
											$.toast({
									        	heading				: 'Error',
									            text				: response.error_empty_rr,
									            showHideTransition	: 'slide',
									            position			: 'top-center',
									            loaderBg			: '#ff6849',
									            icon				: 'error'
									    	});
									  		Swal.fire({
												type 		: 'error',
											  	title 		: '<strong>Error</strong>',
											    html 		: '<u>Kemungkinan error :</u> <br>'+
											                  response.error_empty_rr,
											});
										} else if (response.error_rcv_bpp_hdr) {
											$.toast({
									        	heading				: 'Error',
									            text				: response.error_rcv_bpp_hdr,
									            showHideTransition	: 'slide',
									            position			: 'top-center',
									            loaderBg			: '#ff6849',
									            icon				: 'error'       
									    	});
									  		Swal.fire({
												type 		: 'error',
											  	title 		: '<strong>Error</strong>',
											    html 		: '<u>Kemungkinan error :</u> <br>'+
											                  response.error_rcv_bpp_hdr,
											});
										} else if (response.error_rcv_cer_hdr) {
											$.toast({
									        	heading				: 'Error',
									            text				: response.error_rcv_cer_hdr,
									            showHideTransition	: 'slide',
									            position			: 'top-center',
									            loaderBg			: '#ff6849',
									            icon				: 'error'       
									    	});
									  		Swal.fire({
												type 		: 'error',
											  	title 		: '<strong>Error</strong>',
											    html 		: '<u>Kemungkinan error :</u> <br>'+
											                  response.error_rcv_cer_hdr,
											});
										} else if (response.error_rrr_hdr) {
											$.toast({
									        	heading				: 'Error',
									            text				: response.error_rrr_hdr,
									            showHideTransition	: 'slide',
									            position			: 'top-center',
									            loaderBg			: '#ff6849',
									            icon				: 'error'       
									    	});
									  		Swal.fire({
												type 		: 'error',
											  	title 		: '<strong>Error</strong>',
											    html 		: '<u>Kemungkinan error :</u> <br>'+
											                  response.error_rrr_hdr,
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
										} else if (response.success_commit) {							
											$.toast({
									        	heading				: 'Successfully',
									            text				: response.success_commit+'<br/>'+
									             					  response.success_commit_message_pur+'<br/>'+
									             					  response.success_commit_message_dept+'<br/>'+
									             					  response.status_email,
									            showHideTransition	: 'slide',
									            position			: 'top-center',
									            loaderBg			: '#ff6849',
									            icon				: 'success',
									            hideAfter			: 5000            
									    	});
									    	Swal.fire({
												type 		: 'success',
											  	title 		: '<strong>Successfully</strong>',
											    html 		: response.success_commit+'<br/>'+
											    			  response.success_commit_message_pur+'<br/>'+
											    			  response.success_commit_message_dept+'<br/>'+
											    			  response.status_email
											});
											reset_input_header();
											$('#tbl_receive_dtl tbody').empty();
											$('#modal_scan_nik').modal('hide');
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
	     		}
			});
		}
	});

});