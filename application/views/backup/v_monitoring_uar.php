<?php
	
	$header_table = '
		<th class="text-center" width="5%">No.</th>
		<th class="text-center" width="10%">Doc. No.</th>
		<th class="text-center" width="20%">Nama Pemohon</th>
		<th class="text-center" width="5%">Dept.</th>
	';
	
	$header_table_not_yet_start = $header_table.'
		<th class="text-center">Tgl. Permohonan</th>
		<th class="text-center">Tgl. Permohonan Selesai</th>
		<th class="text-center">Tgl. Kesanggupan</th>
		<th class="text-center">Penjelasan Permintaan</th>
		<th class="text-center">Programmer</th>
	';
	
	$header_table_on_progress = $header_table_not_yet_start.'
		<th class="text-center">Tgl. Pengerjaan</th>
	';
	
	$header_table_finish = $header_table_on_progress.'
		<th class="text-center">Tgl. Selesai</th>
		<th class="text-center">Total Waktu Pengerjaan (Hari)</th>
		<th class="text-center">Implementasi</th>
	';

?>

<style>
	table.dataTable thead tr {
		background-color: #e7e7e7;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<div class="card-box">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="#tab_not_yet_start" data-toggle="tab" aria-expanded="true" class="nav-link active">
					   <i class="fa fa-tasks mr-2"></i> Not yet Start
					</a>
				</li>
				<li class="nav-item">
					<a href="#tab_on_progress" data-toggle="tab" aria-expanded="false" class="nav-link">
						<i class="fa fa fa-hourglass-2 mr-2"></i>On Progress
					</a>
				</li>
				<li class="nav-item">
					<a href="#tab_finish" data-toggle="tab" aria-expanded="false" class="nav-link">
						<i class="fa fa-check-square-o mr-2"></i> Finish
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="tab_not_yet_start">
					<table id="table_not_yet_start" class="table table-hover table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<?php echo $header_table_not_yet_start; ?>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_on_progress">
					<table id="table_on_progress" class="table table-hover table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<?php echo $header_table_on_progress; ?>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_finish">
					<table id="table_finish" class="table table-hover table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<?php echo $header_table_finish; ?>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>