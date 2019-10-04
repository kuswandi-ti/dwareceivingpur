<div class="row">
    <div class="col-12">
		<div class="card-box">
			<form class="form-horizontal" role="form" id="form_crp">
				<div class="radio radio-primary form-check-inline col-md-4">
					<input type="radio" name="rdogroup_all" id="rdoca_all" value="<?php echo $this->config->item('INIT_COMPLAINT_APPLICATION'); ?>" checked>
					<label for="rdoca_all"> APPLICATION / PROGRAM </label>
				</div>
				<div class="radio radio-warning form-check-inline col-md-4">
					<input type="radio" name="rdogroup_all" id="rdoch_all" value="<?php echo $this->config->item('INIT_COMPLAINT_HARDWARE'); ?>">
					<label for="rdoch_all"> HARDWARE / NETWORK / INTERNET </label>
				</div>
				<div class="radio radio-danger form-check-inline col-md-3">
					<input type="radio" name="rdogroup_all" id="rdoce_all" value="<?php echo $this->config->item('INIT_COMPLAINT_EMAIL'); ?>">
					<label for="rdoce_all"> E M A I L </label>
				</div>
				
				<hr>
				
				<div class="row">
					<div class="col-12">&nbsp;</div>					
				</div>				
				
				<div class="form-group row">
					<label for="txtcomplaintdate_all" class="col-3 col-form-label">Complaint Date/Time :</label>
					<div class="col-2">
						<input type="text" class="form-control" name="txtcomplaintdate_all" id="txtcomplaintdate_all" readonly>
					</div>
					<div class="col-2">
						<input type="text" class="form-control" name="txtcomplainttime_all" id="txtcomplainttime_all" readonly>
					</div>
                </div>
				
				<div class="form-group row group-departemen_all">
					<label for="cbodepartment_all" class="col-3 control-label">Department :</label>
					<div class="col-9">
						<select class="form-control select2" name="cbodepartment_all" id="cbodepartment_all">
							<option selected value="0">Pilih Departemen</option>
							<?php
								if ($get_data_department->num_rows() > 0) {
									foreach ($get_data_department->result() as $row) {
										echo "<option value='".$row->sysid."'
													  dept_code='".$row->department_code."'>".$row->department_code." - ".$row->department_name."</option>";
									}
								}
							?>
						</select>
						<span class="help-block info-departemen_all" style="display: none"><small>* Field is required</small></span>
					</div>
				</div>
				
				<div class="form-group row group-username_all">
					<label for="txtusername_all" class="col-3 control-label">Username :</label>
					<div class="col-9">
						<input type="text" class="form-control" name="txtusername_all" id="txtusername_all">
						<span class="help-block info-username_all" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				
				<div class="form-group row group-noext_all">
					<label for="txtnoext_all" class="col-3 control-label">No. Ext yang bisa dihubungi :</label>
					<div class="col-9">
						<input type="text" class="form-control" name="txtnoext_all" id="txtnoext_all">
						<span class="help-block info-noext_all" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				
				<hr>
				
				<div id="ca">
					<div class="form-group row group-application_ca">
						<label for="cboapplication_ca" class="col-3 control-label">Application / Program :</label>
						<div class="col-9">
							<select class="form-control select2" name="cboapplication_ca" id="cboapplication_ca" style="width: 100%;">
								<option selected value="0">Pilih Application / Program</option>
								<option value="DWASYS">IMPROVEMENT FINACCT / DWASYS</option>
								<option value="DWAFINACCT">DWAFINACCT</option>
								<option value="DWAHRIS">DWAHRIS</option>
								<option value="POWS">POWS</option>
								<option value="PLTAM">PLTAM</option>
							</select>
							<span class="help-block info-application_ca" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
					<div class="form-group row group-modul_ca">
						<label for="cbomodul_ca" class="col-3 control-label">Modul :</label>
						<div class="col-9">
							<select name="cbomodul_ca" id="cbomodul_ca" class="form-control select2" style="width: 100%;">
								<option selected hidden value="0">Pilih Modul</option>
							</select>
							<span class="help-block info-modul_ca" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
					<div class="form-group row group-problemdescription_ca">
						<label for="txtproblemdescription_ca" class="col-3 control-label">Problem Description :</label>
						<div class="col-9">
							<span class="help-block text-yellow">(please fill in as much detail as possible)</span>
							<textarea class="form-control" name="txtproblemdescription_ca" id="txtproblemdescription_ca" rows="10"></textarea>
							<span class="help-block info-problemdescription_ca" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
					<div class="form-group row group-file_ca">
						<label for="file_ca" class="col-3 control-label">Attachment Image :</label>
						<div class="col-9">
							<input type="file" class="filestyle" name="file_ca" id="file_ca" accept=".png,.jpeg,.jpg" data-btnClass="btn-light">
							<span class="help-block info-file_ca" style="display: none"><small>* Field is required (PNG & JPEG Only)</small></span>
						</div>
					</div>
				</div>

				<div id="ch" style="display: none">
					<div class="form-group row group-computername_ch">
						<label for="cbocomputername_ch" class="col-3 control-label">PC / Laptop Name :</label>
						<div class="col-9">
							<select class="form-control select2" name="cbocomputername_ch" id="cbocomputername_ch" style="width: 100%;">
								<option selected value="0">Pilih Computer Name</option>
								<?php
									if ($get_data_pc_laptop_name->num_rows() > 0) {
										foreach ($get_data_pc_laptop_name->result() as $row) {
											echo "<option value='".$row->sysid."'>".$row->pc_laptop_name."</option>";
										}
									}
								?>
							</select>
							<span class="help-block info-computername_ch" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
					<div class="form-group row group-problemdescription_ch">
						<label for="txtproblemdescription_ch" class="col-3 control-label">Problem Description :</label>
						<div class="col-9">
							<span class="help-block text-yellow">(please fill in as much detail as possible)</span>
							<textarea class="form-control" name="txtproblemdescription_ch" id="txtproblemdescription_ch" rows="10"></textarea>
							<span class="help-block info-problemdescription_ch" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
				</div>

				<div id="ce" style="display: none">
					<div class="form-group row group-accountemail_ce">
						<label for="txtaccountemail_ce" class="col-3 control-label">Account Email :</label>
						<div class="col-9">
							<input type="text" class="form-control" name="txtaccountemail_ce" id="txtaccountemail_ce">
							<span class="help-block info-accountemail_ce" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
					<div class="form-group row group-problemdescription_ce">
						<label for="txtproblemdescription_ce" class="col-3 control-label">Problem Description :</label>
						<div class="col-9">
							<span class="help-block text-yellow">(please fill in as much detail as possible)</span>
							<textarea class="form-control" name="txtproblemdescription_ce" id="txtproblemdescription_ce" rows="10"></textarea>
							<span class="help-block info-problemdescription_ce" style="display: none"><small>* Field is required</small></span>
						</div>
					</div>
					<div class="form-group row group-file_ce">
						<label for="file_ce" class="col-3 control-label">Attachment Image :</label>
						<div class="col-9">
							<input type="file" class="filestyle" name="file_ce" id="file_ce" accept=".png,.jpeg,.jpg" data-btnClass="btn-light">
							<span class="help-block info-file_ce" style="display: none"><small>* Field is required (PNG & JPEG Only)</small></span>
						</div>
					</div>
				</div>

				<hr>
				
				<div class="form-group text-right m-b-0">					
					<button type="reset" class="btn btn-warning" id="btnReset">
						Cancel
					</button>
					<button type="button" class="btn btn-custom" id="btnsubmit">
						Submit
					</button>
				</div>
			</form>
		</div>
	</div>
</div>