<?php if ( $this->uri->segment(2) == 'edit_ik' && !empty($this->uri->segment(3)) ){ ?>
<div class="row">
    <div class="col-12">
		<div class="card-box">
			<form class="form-horizontal" role="form" method="POST" action="<?= base_url('ik_input/edited_ik') ?>" enctype="multipart/form-data">
				<div class="form-group row group-docname">
					<label for="txtdocname" class="col-3 control-label">Nama Modul * :</label>
					<div class="col-9">
						<input type="text" class="form-control" name="txtdocname" id="txtdocname" required autofocus autocomplete="off" value="<?= $get_data->nama_dokumen ?>">
						<span class="help-block info-docname" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				<div class="form-group row group-desc">
					<label for="desc" class="col-3 control-label">Description * :</label>
					<div class="col-9">
						<textarea class="form-control" name="desc" id="desc" rows="6" required  autocomplete="off"><?= $get_data->deskripsi ?></textarea>
						<span class="help-block info-desc" style="display: none"><small>* Field is required</small></span>
					</div>
				</div>
				<div class="form-group row group-fupload">
					<label for="last-fupload" class="col-3 control-label">File Sebelumnya :</label>
					<div class="col-9">
						<input type="hidden" name="last-fupload" required readonly value="<?= $get_data->file ?>">
						<input type="hidden" name="id" required readonly value="<?= $this->uri->segment(3) ?>">
						<a href="javascript:void(0)" data-toggle='modal' data-target='#fndModalPreview'><?= $get_data->file ?></a>
						<div class="modal fade" id="fndModalPreview">
							<div class="modal-dialog" style="width: 96%; max-width: 96%">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="receive-complaint">Preview <?= $get_data->file ?></h4>
									</div>
									<div class="modal-body p-0">
										<iframe width="100%" height="550px" src="<?= base_url($this->config->item('PATH_ASSET_IK').$get_data->file) ?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>
						            </div>
						        </div>
						    </div>
						</div>
					</div>
				</div>
				<div class="form-group row group-fupload">
					<label for="fupload" class="col-3 control-label">Attachment File Baru:</label>
					<div class="col-9">
						<input type="file" class="filestyle" name="fupload" id="fupload" accept=".pdf" data-btnClass="btn-light">
						<span class="help-block info-fupload" style="display: none"><small>* Field is required (PDF Only)</small></span>
					</div>
				</div>
				<hr>
				<div class="form-group text-right m-b-0">					
					<button type="reset" class="btn btn-warning" onclick="location.href='<?= base_url('ik_input') ?>'"> Cancel </button>
					<button type="submit" class="btn btn-custom" id="btnsubmit"> Submit </button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="row">
    <div class="col-12">
		<div class="card-box" id="fndContentMonitoring">
	    	<?php if (isset($_SESSION['status']) && $_SESSION['status'] == 1): ?>
	    		<div class="alert alert-success alert-dismissible fade show" role="alert">
	    			<?= $_SESSION['msg']; ?>
	    			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	    			</button>
	    		</div>
	    	<?php unset($_SESSION['status'], $_SESSION['msg']); endif ?>
	    	<?php if (isset($_SESSION['status']) && $_SESSION['status'] == 0): ?>
	    		<div class="alert alert-danger alert-dismissible fade show" role="alert">
	    			<?= $_SESSION['msg']; ?>
	    			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	    			</button>
	    		</div>
	    	<?php unset($_SESSION['status'], $_SESSION['msg']); endif ?>
			<button class="btn btn-primary" id="fndBtnAdd"><i class="icon-plus"></i> Upload Instruksi Kerja</button><br><br>
			<table class="table table-striped table-hover table-bordered" cellspacing="0" id="fndTable">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>Nama Modul</th>
						<th>Deskripsi</th>
						<th>File</th>
						<th width="15%" class="text-center"><i class="icon-settings"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1;
						foreach ($get_data->result() as $row) {
						if ($row != null) {
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= $row->nama_dokumen ?></td>
						<td><?= $row->deskripsi ?></td>
						<td> <a href="javascript:void(0)" id="" onclick="fndFilePreview('<?= $row->file ?>')"><?= $row->file ?></a></td>
						<td class="text-center">
							<button class="btn btn-sm btn-info" onclick="location.href='<?= base_url('ik_input/edit_ik/'.$row->id) ?>'"><i class="icon-pencil"></i> Edit</button>
							<a class="btn btn-sm btn-danger" href="<?= base_url('ik_input/del_ik/'.$row->id) ?>" onclick="return confirm('Hapus data ini ?')"><i class="icon-trash"></i> Hapus</a>
						</td>
					</tr>
					<?php $no++; } } ?>
				</tbody>
			</table>
			<div class="modal fade" id="fndModalPreview">
				<div class="modal-dialog" style="width: 97%; max-width: 97%">
					<div class="modal-content">
						<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title"></h4>
						</div>
						<div class="modal-body p-0"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
						</div>
			        </div>
			    </div>
			</div>
		</div>
		<div class="card-box" id="fndContentFormAdd" style="display: none;">
			<form class="form-horizontal" role="form" method="POST" action="<?= base_url('ik_input/create_ik') ?>" enctype="multipart/form-data">
				<div class="form-group row group-docname">
					<label for="txtdocname" class="col-3 control-label">Nama Modul * :</label>
					<div class="col-9">
						<input type="text" class="form-control" name="txtdocname" id="txtdocname" required autofocus autocomplete="off">
						<span class="help-block info-docname" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				<div class="form-group row group-desc">
					<label for="desc" class="col-3 control-label">Description * :</label>
					<div class="col-9">
						<textarea class="form-control" name="desc" id="desc" rows="6" required  autocomplete="off"></textarea>
						<span class="help-block info-desc" style="display: none"><small>* Field is required</small></span>
					</div>
				</div>
				<div class="form-group row group-fupload">
					<label for="fupload" class="col-3 control-label">Attachment File * :</label>
					<div class="col-9">
						<input type="file" class="filestyle" name="fupload" id="fupload" accept=".pdf" data-btnClass="btn-light" required>
						<span class="help-block info-fupload" style="display: none"><small>* Field is required (PDF Only)</small></span>
					</div>
				</div>
				<hr>
				<div class="form-group text-right m-b-0">					
					<button type="reset" class="btn btn-warning" id="btnReset"> Cancel </button>
					<button type="submit" class="btn btn-custom" id="btnsubmit"> Submit </button>
				</div>
			</form>
		</div>
		<script>
			function fndFilePreview(x) {
				// $.ajax({
				// 	url: '<?= base_url() ?>',
				// 	data: {status: 'OK'},
				// 	success: function () {
				// 	}
				// });
				filename = "<?= base_url($this->config->item('PATH_ASSET_IK')) ?>" + x;
				$('#fndModalPreview').modal('show');
				$('#fndModalPreview .modal-header').html('Preview ' + x);
				$('#fndModalPreview .modal-body').html('<iframe width="100%" height="550px" src="'+filename+'#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>');
			}
			$('#fndBtnAdd, #btnReset').click(function() {$('#fndContentMonitoring, #fndContentFormAdd').slideToggle(); });
		</script>
	</div>
</div>
<?php } ?>
