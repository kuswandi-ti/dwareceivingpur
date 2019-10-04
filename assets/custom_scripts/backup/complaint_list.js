$(document).ready(function() {
	table_open = $('#table_open').DataTable({
								"processing": true,
								"serverSide": true,
								"order": [], 
								"ajax": {
									"url": "complaint_list/ajax_list",
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
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Comment 8
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status 9
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status Date 10
								],
								"columnDefs": [
									{ "className": "text-center", "targets": [0, 1, 3, 4, 5, 7, 9] },
									{ "className": "text-right", "targets": [2, 10] }
								],
								'autoWidth': false,
								'responsive': true
							});
							
	table_on_progress = $('#table_on_progress').DataTable({
								"processing": true,
								"serverSide": true,
								"order": [], 
								"ajax": {
									"url": "complaint_list/ajax_list",
									"type": "POST",
									"data": {
										'status': 'ON PROGRESS'
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
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Comment 8
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status 9
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status Date 10
								],
								"columnDefs": [
									{ "className": "text-center", "targets": [0, 1, 3, 4, 5, 7, 9] },
									{ "className": "text-right", "targets": [2, 10] }
								],
								'autoWidth': false,
								'responsive': true
							});
							
	table_closed = $('#table_closed').DataTable({
						"processing": true,
						"serverSide": true,
						"order": [], 
						"ajax": {
							"url": "complaint_list/ajax_list",
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
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Comment 8
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status 9
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Status Date 10
						],
						"columnDefs": [
							{ "className": "text-center", "targets": [0, 1, 3, 4, 5, 7, 9] },
							{ "className": "text-right", "targets": [2, 10] }
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
});