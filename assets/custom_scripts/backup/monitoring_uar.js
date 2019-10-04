$(document).ready(function() {
	table_not_yet_start = $('#table_not_yet_start').DataTable({
								"processing": true,
								"serverSide": true,
								"order": [], 
								"ajax": {
									"url": "monitoring_uar/ajax_list",
									"type": "POST",
									"data": {
										'status': 'Not yet Start'
									}
								},
								"aoColumns": [
									{ "bVisible": true, "bSearchable": false, "bSortable": false }, // No. 0
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Doc. No. 1
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Nama Pemohon 2
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Department 3
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Permohonan 4
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Permohonan Selesai 5
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Kesanggupan 6
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Alasan 7
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Programmer 8
								],
								"columnDefs": [
									{ "className": "text-center", "targets": [0, 1, 2, 3, 4, 5, 6, 8] }
								],
								'autoWidth': false,
								'responsive': true
							});
							
	table_on_progress = $('#table_on_progress').DataTable({
								"processing": true,
								"serverSide": true,
								"order": [],
								"ajax": {
									"url": "monitoring_uar/ajax_list",
									"type": "POST",
									"data": {
										'status': 'On Progress'
									}
								},
								"aoColumns": [
									{ "bVisible": true, "bSearchable": false, "bSortable": false }, // No. 0
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Doc. No. 1
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Nama Pemohon 2
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Department 3
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Permohonan 4
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Permohonan Selesai 5
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Kesanggupan 6
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Alasan 7
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Programmer 8
									{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Pengerjaan 9
								],
								"columnDefs": [
									{ "className": "text-center", "targets": [0, 1, 2, 3, 4, 5, 6, 8, 9] }
								],
								'autoWidth': false,
								'responsive': true
							});
							
	table_finish = $('#table_finish').DataTable({
						"processing": true,
						"serverSide": true,
						"ajax": {
							"url": "monitoring_uar/ajax_list",
							"type": "POST",
							"data": {
								'status': 'Finish'
							}
						},
						"aoColumns": [
							{ "bVisible": true, "bSearchable": false, "bSortable": false }, // No. 0
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Doc. No. 1
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Nama Pemohon 2
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Department 3
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Permohonan 4
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Permohonan Selesai 5
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Kesanggupan 6
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Alasan 7
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Programmer 8
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Pengerjaan 9
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Tgl. Selesai 10
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Total Hari 11
							{ "bVisible": true, "bSearchable": true, "bSortable": true }, // Implementasi 12
						],
						"order": [['10', 'asc']],
						"columnDefs": [
							{ "className": "text-center", "targets": [0, 1, 2, 3, 4, 5, 6, 8, 9, 10] }
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