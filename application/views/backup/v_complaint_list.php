<?php
	$header_table = '
		<th class="text-center" width="5%">No.</th>
		<th class="text-center" width="15%">Complaint No.</th>
		<th class="text-center" width="15%">Complaint Date</th>
		<th class="text-center" width="10%">Dept.</th>
		<th class="text-center" width="10%">User</th>
		<th class="text-center" width="5%">Ext.</th>
		<th class="text-center" width="15%">Problem Description</th>
		<th class="text-center" width="10%">MIS Person</th>
		<th class="text-center" width="10%">Comment</th>
		<th class="text-center" width="5%">Status</th>
		<th class="text-center" width="5%">Status Date</th>
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
					<a href="#tab_open" data-toggle="tab" aria-expanded="true" class="nav-link active">
					   <i class="fa fa-folder-open-o mr-2"></i> Open
					</a>
				</li>
				<li class="nav-item">
					<a href="#tab_on_progress" data-toggle="tab" aria-expanded="false" class="nav-link">
						<i class="fa fa-hourglass-2 mr-2"></i>On Progress
					</a>
				</li>
				<li class="nav-item">
					<a href="#tab_closed" data-toggle="tab" aria-expanded="false" class="nav-link">
						<i class="fa fa-hourglass-2 mr-2"></i>Closed
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="tab_open">
					<table id="table_open" class="table table-hover table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<?php echo $header_table; ?>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="tab-pane show" id="tab_on_progress">
					<table id="table_on_progress" class="table table-hover table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<?php echo $header_table; ?>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_closed">
					<table id="table_closed" class="table table-hover table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<?php echo $header_table; ?>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>