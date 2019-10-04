<div class="row">
	<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
		<div class="card-box tilebox-one" style="cursor: pointer" id="div_complaint_open">
			<i class="fa fa-folder-open-o float-right text-muted"></i>
			<h5 class="text-muted text-uppercase mt-0">Complaint Open</h5>
			<h2 class="m-b-20" data-plugin="counterup"><?php echo $count_complaint_open; ?></h2>
			<?php
				if ($count_complaint_open == 0) {
					$persentase = 0;
				} else {
					$persentase = number_format((($count_complaint_open / $count_complaint_all) * 100), 2);
				}
			?>
			<span class="badge badge-custom"> <h5><?php echo $persentase; ?> %</h5> </span> <span class="text-muted">From total complaint</span>
		</div>
	</div>
	
	<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
		<div class="card-box tilebox-one" style="cursor: pointer" id="div_complaint_on_progress">
			<i class="fa fa fa-hourglass-2 float-right text-muted"></i>
			<h5 class="text-danger text-uppercase mt-0">Complaint On Progress</h5>
			<h2 class="m-b-20" data-plugin="counterup"><?php echo $count_complaint_on_progress; ?></h2>
			<?php
				if ($count_complaint_on_progress == 0) {
					$persentase = 0;
				} else {
					$persentase = number_format((($count_complaint_on_progress / $count_complaint_all) * 100), 2);
				}
			?>
			<span class="badge badge-danger"> <h5><?php echo $persentase; ?> %</h5> </span> <span class="text-muted">From total complaint</span>
		</div>
	</div>
	
	<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
		<div class="card-box tilebox-one" style="cursor: pointer" id="div_complaint_close">
			<i class="fa fa-battery-full float-right text-muted"></i>
			<h5 class="text-warning text-uppercase mt-0">Complaint Close</h5>
			<h2 class="m-b-20" data-plugin="counterup"><?php echo $count_complaint_close; ?></h2>
			<?php
				if ($count_complaint_close == 0) {
					$persentase = 0;
				} else {
					$persentase = number_format((($count_complaint_close / $count_complaint_all) * 100), 2);
				}
			?>
			<span class="badge badge-warning"> <h5><?php echo $persentase; ?> %</h5> </span> <span class="text-muted">From total complaint</span>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
		<div class="card-box tilebox-one" style="cursor: pointer" data-toggle="modal" data-target="#modal_uar_not_yet_start">
			<i class="fa fa-tasks float-right text-muted"></i>
			<h5 class="text-custom text-uppercase mt-0">UAR Not yet Start</h5>
			<h2 class="m-b-20" data-plugin="counterup"><span data-plugin="counterup"><?php echo $count_uar_not_yet_start; ?></span></h2>
			<?php
				if ($count_uar_not_yet_start == 0 or $count_uar_all == 0) {
					$persentase = 0;
				} else {
					$persentase = number_format((($count_uar_not_yet_start / $count_uar_all) * 100), 2);
				}
			?>
			<span class="badge badge-custom"> <h5><?php echo $persentase; ?> %</h5> </span> <span class="text-muted">From total UAR</span>
		</div>
	</div>

	<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
		<div class="card-box tilebox-one" style="cursor: pointer" data-toggle="modal" data-target="#modal_uar_on_progress">
			<i class="fa fa fa-hourglass-2 float-right text-muted"></i>
			<h5 class="text-danger text-uppercase mt-0">UAR On Progress</h5>
			<h2 class="m-b-20" data-plugin="counterup"><span data-plugin="counterup"><?php echo $count_uar_on_progress; ?></span></h2>
			<?php
				if ($count_uar_on_progress == 0 or $count_uar_all == 0) {
					$persentase = 0;
				} else {
					$persentase = number_format((($count_uar_on_progress / $count_uar_all) * 100), 2);
				}
			?>
			<span class="badge badge-danger"> <h5><?php echo $persentase; ?> %</h5> </span> <span class="text-muted">From total UAR</span>
		</div>
	</div>
	
	<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
		<div class="card-box tilebox-one" style="cursor: pointer" data-toggle="modal" data-target="#modal_uar_finish">
			<i class="fa fa-handshake-o float-right text-muted"></i>
			<h5 class="text-warning text-uppercase mt-0">UAR Finish</h5>
			<h2 class="m-b-20" data-plugin="counterup"><span data-plugin="counterup"><?php echo $count_uar_finish; ?></span></h2>
			<?php
				if ($count_uar_finish == 0 or $count_uar_all == 0) {
					$persentase = 0;
				} else {
					$persentase = number_format((($count_uar_finish / $count_uar_all) * 100), 2);
				}
			?>
			<span class="badge badge-warning"> <h5><?php echo $persentase; ?> %</h5> </span> <span class="text-muted">From total UAR</span>
		</div>
	</div>
</div>

<div id="modal_uar_not_yet_start" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">UAR Not yet Start (Detail)</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width: 4%; text-align: center;">No.</th>
							<th style="width: 75%; text-align: center;">Department</th>
							<th style="width: 21%; text-align: center;">Count</th>
						</tr>
					</thead>				
					<tbody>
						<?php
							$i = 0;
							if ($detail_uar_not_yet_start->num_rows() > 0) {
								foreach($detail_uar_not_yet_start->result() as $r) {
									$i++;
									echo "<tr>";
									echo	"<td style='width: 4%; text-align: center;'>".$i."</td>";
									echo	"<td style='width: 75%; text-align: center;'>".$r->User_Dept."</td>";
									echo	"<td style='width: 21%; text-align: center;'>".number_format($r->Count_UAR)."</td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="modal_uar_on_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">UAR On Progress (Detail)</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width: 4%; text-align: center;">No.</th>
							<th style="width: 75%; text-align: center;">Department</th>
							<th style="width: 21%; text-align: center;">Count</th>
						</tr>
					</thead>				
					<tbody>
						<?php
							$i = 0;
							if ($detail_uar_on_progress->num_rows() > 0) {
								foreach($detail_uar_on_progress->result() as $r) {
									$i++;
									echo "<tr>";
									echo	"<td style='width: 4%; text-align: center;'>".$i."</td>";
									echo	"<td style='width: 75%; text-align: center;'>".$r->User_Dept."</td>";
									echo	"<td style='width: 21%; text-align: center;'>".number_format($r->Count_UAR)."</td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="modal_uar_finish" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">UAR Finished (Detail)</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width: 4%; text-align: center;">No.</th>
							<th style="width: 75%; text-align: center;">Department</th>
							<th style="width: 21%; text-align: center;">Count</th>
						</tr>
					</thead>				
					<tbody>
						<?php
							$i = 0;
							if ($detail_uar_finish->num_rows() > 0) {
								foreach($detail_uar_finish->result() as $r) {
									$i++;
									echo "<tr>";
									echo	"<td style='width: 4%; text-align: center;'>".$i."</td>";
									echo	"<td style='width: 75%; text-align: center;'>".$r->User_Dept."</td>";
									echo	"<td style='width: 21%; text-align: center;'>".number_format($r->Count_UAR)."</td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>