$(document).ready(function() {
	
	update_count_complaint_open();
	
	setInterval(function() {
		//window.location.reload(true);
		window.location = "complaint_action";
		update_count_complaint_open();
	}, 100000); // 30 menit, 1 menit = 10.000
	
	$('.select2').select2();
	
	var table_open_onprogress = $('#table_open_onprogress').DataTable({
									"processing": true,
									"serverSide": true,
									"order": [], 
									"ajax": {
										"url": "complaint_action/ajax_list",
										"type": "POST",
										"data": {
											'status': 'OPEN'
										}
									},
									"aoColumns": [
										{ "bVisible": true, "bSearchable": false, "bSortable": false }, // No. 0
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Complaint No. 1
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Complaint Date 2
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Department 3
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // User 4
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // No. Ext. 5
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Problem Description 6
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // MIS Person 7
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Source Code 8
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status 9
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Comments 10
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Kategori Problem 11
										{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Action 12
									],
									"columnDefs": [
										{ "className": "text-center", "targets": [0, 1, 3, 4, 5, 7, 8, 9, 11, 12] },
										{ "className": "text-right", "targets": [2] }
									],
									'autoWidth': false,
									'responsive': true
								});
							
	var table_closed = $('#table_closed').DataTable({
							"processing": true,
							"serverSide": true,
							"order": [], 
							"ajax": {
								"url": "complaint_action/ajax_list",
								"type": "POST",
								"data": {
									'status': 'CLOSED'
								}
							},
							"aoColumns": [
								{ "bVisible": true, "bSearchable": false, "bSortable": false }, // No. 0
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Complaint No. 1
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Complaint Date 2
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Department 3
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // User 4
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // No. Ext. 5
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Problem Description 6
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // MIS Person 7
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Source Code 8
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status 9
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Comments 10
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Kategori Problem 11
								{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Action 12
							],
							"columnDefs": [
								{ "className": "text-center", "targets": [0, 1, 3, 4, 5, 7, 8, 9, 11, 12] },
								{ "className": "text-right", "targets": [2] }
							],
							'autoWidth': false,
							'responsive': true
						});
	
	// http://live.datatables.net/rerimoxo/1/edit
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		$('.table:visible').each( function(e) {
			$(this).DataTable().columns.adjust().responsive.recalc();
		});
	});
	
	$('.btnsave').on('click', function() {
		var mis_person = $('#cbomisperson').val();
		
		if (mis_person == 0) {
			$('.info-mis_person').addClass('text-danger');
			$('.info-mis_person').show();
			return false;
		} else {
			$('.info-mis_person').removeClass('text-danger');
			$('.info-mis_person').hide();
		}
		
		$.ajax({
            type: 'post',
            url: 'complaint_action/update_complaint',
            data: {
				'sysid': $('#txtsysid').val(),
				'mis_person_id': $('#cbomisperson').val()
			},
			beforeSend: function() {
				$("body").mLoading('show'); 
			},
            success: function(data) {
				$("body").mLoading('hide');
                $('#modal_receive').modal('hide');
				table_open_onprogress.ajax.reload();
				table_closed.ajax.reload();
            },
            error: function() {
				$("body").mLoading('hide');
                alert("process failure");
            }
        });
	});
	
	$('.btnclosed').on('click', function() {
		var remark_status = $('#txtremarkstatus').val();
		
		$.ajax({
            type: 'post',
            url: 'complaint_action/closed_complaint',
            data: {
				'sysid': $('#txtsysid').val(),
				'remark_status': remark_status,
				'kategori_problem_id': $('#cbokategoriproblem').val()
			},
			beforeSend: function() {
				$("body").mLoading('show'); 
			},
            success: function(data) {
				$("body").mLoading('hide');
                $('#modal_closed').modal('hide');
				table_open_onprogress.ajax.reload();
				table_closed.ajax.reload();
            },
            error: function() {
				$("body").mLoading('hide');
                alert("process failure");
            }
        });
	});
});

// http://jagocoding.com/tutorial/365/Membuat_Form_Edit_Menggunakan_Modal_Twitter_Bootstrap_amp_jQuery
$(document).on("click", ".receive", function () {
     var v_sysid = $(this).data('id');
     $(".modal-body #txtsysid").val( v_sysid );
});

$(document).on("click", ".closed", function () {
     var v_sysid = $(this).data('id');
     $(".modal-body #txtsysid").val( v_sysid );
});

function update_count_complaint_open() {
	$.ajax({
		type: 'post',
		url: 'complaint_action/count_complaint_open',
		cache: false,
		dataType: 'json',
		success: function(data) {
			$(document).attr('title', '('+data.count_complaint_open+')' + ' ' + 'MIS Helpdesk Web System | Complaint Action');
		},
		error: function() {
			alert('Error update count complaint open');
		}
	});
}