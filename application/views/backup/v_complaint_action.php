<?php
	$header_table = '
		<th class="text-center">No.</th>
		<th class="text-center">Complaint No.</th>
		<th class="text-center">Complaint Date</th>
		<th class="text-center">Dept.</th>
		<th class="text-center">User</th>
		<th class="text-center">No. Ext.</th>
		<th class="text-center">Problem Description</th>
		<th class="text-center">MIS Person</th>
		<th class="text-center">Source Code</th>
		<th class="text-center">Status</th>
		<th class="text-center">Comment</th>
		<th class="text-center">Kategori Problem</th>
		<th class="text-center">Actions</th>
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
					<a href="#tab_open_onprogress" data-toggle="tab" aria-expanded="true" class="nav-link active">
					   <i class="fa fa fa-hourglass-2 mr-2"></i> Open & On Progress
					</a>
				</li>
				<li class="nav-item">
					<a href="#tab_closed" data-toggle="tab" aria-expanded="false" class="nav-link">
						<i class="fa fa fa-hourglass-2 mr-2"></i>Closed
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="tab_open_onprogress">
					<table id="table_open_onprogress" class="table table-hover table-striped" cellspacing="0" width="100%">
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

<div class="modal fade" id="modal_receive">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="receive-complaint">Receive Complaint</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtsysid">
				<form role="form">
					<div class="form-group group-mis_person">
						<label for="cbomisperson">Silahkan pilih MIS Person untuk menangani complaint problem ini</label>
						<select class="form-control select2" name="cbomisperson" id="cbomisperson" style="width: 100%;">
							<option selected value="0">Pilih MIS Person</option>
							<?php
								if ($get_data_mis_person->num_rows() > 0) {
									foreach ($get_data_mis_person->result() as $row) {
										echo "<option value='".$row->sysid."'>".$row->person_name."</option>";
									}
								}
							?>
						</select>
                        <span class="help-block info-mis_person" style="display: none"><small>* Field is required</small></span>
					</div>					
				</form>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btnsave">Save</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_closed">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="receive-complaint">Closed Complaint</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtsysid">
				<form role="form">
					<div class="form-group">
						<label for="cbokategoriproblem">Kategori Problem</label>
						<select class="form-control select2" name="cbokategoriproblem" id="cbokategoriproblem" style="width: 100%;">
							<?php
								if ($get_data_kategori_problem->num_rows() > 0) {
									foreach ($get_data_kategori_problem->result() as $row) {
										echo "<option value='".$row->sysid."'>".$row->nama_kategori."</option>";
									}
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="txtremarkstatus">Remark status closed</label>
						<textarea class="form-control" name="txtremarkstatus" id="txtremarkstatus" rows="10"></textarea>
					</div>
				</form>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btnclosed">Save</button>
			</div>
        </div>
    </div>
</div>