<?php if ( $this->uri->segment(2) == 'edit_ps' && !empty($this->uri->segment(3)) ){ ?>
<div class="row">
    <div class="col-12">
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
		<div class="card-box">
			<form class="form-horizontal" role="form" method="POST" action="<?= base_url('ps_input/edited_ps') ?>" enctype="multipart/form-data">
				<div class="form-group row group-docname">
					<label for="kode" class="col-3 control-label">Kode Error * :</label>
					<div class="col-9">
						<input type="text" class="form-control" name="kode" id="kode" required autofocus autocomplete="off" value="<?= $get_data->kode_error ?>">
						<span class="help-block info-docname" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				<div class="form-group row group-docname">
					<label for="txtdocname" class="col-3 control-label">Deskripsi Error * :</label>
					<div class="col-9">
						<textarea class="form-control" name="txtdocname" id="txtdocname" rows="6" required  autocomplete="off"><?= $get_data->deskripsi_error ?></textarea>
						<span class="help-block info-docname" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				<div class="form-group row group-desc">
					<label for="desc" class="col-3 control-label">Solusi Error * :</label>
					<div class="col-9">
						<textarea class="form-control" name="desc" id="desc" rows="6" required  autocomplete="off"><?= $get_data->solusi_error ?></textarea>
						<span class="help-block info-desc" style="display: none"><small>* Field is required</small></span>
					</div>
				</div>
				<div class="form-group row group-fupload">
					<label for="last-fupload" class="col-3 control-label">File Sebelumnya :</label>
					<div class="col-9">
						<input type="hidden" name="last-fupload" required readonly value="<?= $get_data->file ?>">
						<input type="hidden" name="id" required readonly value="<?= $this->uri->segment(3) ?>">
						<ul class="list-group">
						<?php  
							$files = glob( $this->config->item('PATH_ASSET_PS').$get_data->file . '/*');
							$index = 0;
							foreach($files as $file){
							    if($file != $this->config->item('PATH_ASSET_PS').$get_data->file."/index.html" && $file != $this->config->item('PATH_ASSET_PS').$get_data->file."/Thumbs.db"){
							    	echo '<li class="list-group-item">';
								    echo '<a class="popup-iframe" href="'.base_url($file).'" title="'.$get_data->deskripsi_error.'<small>'.$get_data->solusi_error.'</small>'.'">'.str_replace($this->config->item('PATH_ASSET_PS').$get_data->file.'/', '', $file).'</a>';
								    echo '<a class="badge badge-danger float-right" onclick="return confirm(\'Hapus File Ini?\')" href="'.base_url('ps_input/del_file?file='.$file.'&q='.$this->uri->segment(3)).'"><i class="fa fa-trash"></i> &nbsp; Hapus File Ini</a>';
								    echo '</li>';
								        // echo '<a href="'.base_url($file).'" title="'.$get_data->deskripsi_error.'<small>'.$get_data->solusi_error.'</small>'.'">Klik disini untuk melihat file</a>';
								        // echo '<a href="'.base_url($file).'" title="'.$get_data->deskripsi_error.'<small>'.$get_data->solusi_error.'</small>'.'"></a>';
								        // echo '<a class="popup-iframe" href="'.base_url($file).'" title="'.$get_data->deskripsi_error.'<small>'.$get_data->solusi_error.'</small>'.'">x</a>';
							        $index++;
							    }
							}
						?>
						</ul>
						<!-- <a href="javascript:void(0)" data-toggle='modal' data-target='#fndModalPreview'><?= $get_data->file ?></a>
						<div class="modal fade" id="fndModalPreview">
							<div class="modal-dialog" style="width: 96%; max-width: 96%">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="receive-complaint">Preview <?= $get_data->file ?></h4>
									</div>
									<div class="modal-body p-0">
										<iframe width="100%" height="550px" src="<?= base_url($this->config->item('PATH_ASSET_PS').$get_data->file) ?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>
						            </div>
						        </div>
						    </div>
						</div> -->
					</div>
				</div>
				<div class="form-group row group-fupload">
					<label for="fupload" class="col-3 control-label">Attachment File Baru:</label>
					<div class="col-9">
						<input type="file" class="filestyle" name="fupload[]" id="fupload" accept=".jpg, .png, .jpeg, .pdf" multiple data-btnClass="btn-success">
					</div>
				</div>
				<hr>
				<div class="form-group text-right m-b-0">					
					<button type="reset" class="btn btn-warning" onclick="location.href='<?= base_url('ps_input') ?>'"> Cancel </button>
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
			<button class="btn btn-primary" id="fndBtnAdd"><i class="icon-plus"></i> Create New Problem Solving</button><br><br>
			<table class="table table-striped table-hover table-bordered" cellspacing="0" id="fndTable">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>Kode Error</th>
						<th>Deskripsi Error</th>
						<th>Solusi Error</th>
						<th width="15%">File</th>
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
						<td><?= $row->kode_error ?></td>
						<td><?= $row->deskripsi_error ?></td>
						<td><?= $row->solusi_error ?></td>
						<td class="text-center"> 
							<!-- <div class="popup-gallery"> -->
							<?php  
								$files = glob( $this->config->item('PATH_ASSET_PS').$row->file . '/*');
								$index = 0;
								foreach($files as $file){
								    if($file != $this->config->item('PATH_ASSET_PS').$row->file."/index.html" && $file != $this->config->item('PATH_ASSET_PS').$row->file."/Thumbs.db"){
								    	if ($index == 0) {
									        // echo '<a href="'.base_url($file).'" title="'.$row->deskripsi_error.'<small>'.$row->solusi_error.'</small>'.'">Klik disini untuk melihat file</a>';
									        echo '<a class="popup-iframe'.$no.'" href="'.base_url($file).'"><i class="fa fa-file-text"></i> Klik disini untuk melihat file</a>';
								    	}else {
									        // echo '<a href="'.base_url($file).'" title="'.$row->deskripsi_error.'<small>'.$row->solusi_error.'</small>'.'"></a>';
									        echo '<a class="popup-iframe'.$no.'" href="'.base_url($file).'"</a>';
									        // echo '<a class="popup-iframe" href="'.base_url($file).'" title="'.$row->deskripsi_error.'<small>'.$row->solusi_error.'</small>'.'">x</a>';
								    	}
								        $index++;
								    }
								}
							?>
	                        <!-- </div> -->
							
	                        <script>
								$('.popup-iframe<?= $no ?>').magnificPopup({
									disableOn: 700,
									type: 'iframe',
									mainClass: 'mfp-fade',
									removalDelay: 160,
									preloader: true,
									gallery: {
										enabled: true,
										navigateByImgClick: true,
										preload: [0,1] // Will preload 0 - before current, and 1 after the current image
									},
									fixedContentPos: true,
									image: {
										tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
										titleSrc: function(item) {
											return item.el.attr('title');
										}
									}
								});
	                        </script>
							<!-- <a href="javascript:void(0)" onclick="fndFilePreview('<?= $row->file ?>')">Klik disini untuk melihat file</a> -->
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-info" onclick="location.href='<?= base_url('ps_input/edit_ps/'.$row->id) ?>'"><i class="icon-pencil"></i> Edit</button>
							<a class="btn btn-sm btn-danger" href="<?= base_url('ps_input/del_ps/'.$row->id) ?>" onclick="return confirm('Hapus data ini ?')"><i class="icon-trash"></i> Hapus</a>
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
			<form class="form-horizontal" method="POST" action="<?= base_url('ps_input/create_ps') ?>" enctype="multipart/form-data">
				<div class="form-group row group-docname">
					<label for="kode" class="col-3 control-label">Kode Error * :</label>
					<div class="col-9">
						<textarea class="form-control" name="kode" id="kode" rows="6" required  autocomplete="off" autofocus></textarea>
						<span class="help-block info-docname" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				<div class="form-group row group-docname">
					<label for="txtdocname" class="col-3 control-label">Deskripsi Error * :</label>
					<div class="col-9">
						<textarea class="form-control" name="txtdocname" id="txtdocname" rows="6" required  autocomplete="off" autofocus></textarea>
						<span class="help-block info-docname" style="display: none"><small>* Field is required</small></span>
					</div>				
				</div>
				<div class="form-group row group-desc">
					<label for="desc" class="col-3 control-label">Solusi Error * :</label>
					<div class="col-9">
						<textarea class="form-control" name="desc" id="desc" rows="6" required  autocomplete="off"></textarea>
						<span class="help-block info-desc" style="display: none"><small>* Field is required</small></span>
					</div>
				</div>
				<!-- <div class="form-group row group-fupload">
					<label for="fupload" class="col-3 control-label">Attachment File * :</label>
					<div class="col-9">
						<input type="file" class="filestyle" name="fupload" id="fupload" accept=".pdf" data-btnClass="btn-light" required>
						<span class="help-block info-fupload" style="display: none"><small>* Field is required (PDF Only)</small></span>
					</div>
				</div> -->
				<div class="form-group row group-fupload">
					<label for="fupload" class="col-3 control-label">Attachment File * :</label>
					<div class="col-9">
						<input type="file" class="filestyle" name="fupload[]" id="fupload" accept=".jpg, .png, .jpeg, .pdf" multiple data-btnClass="btn-light" required>
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
				filename = "<?= base_url($this->config->item('PATH_ASSET_PS')) ?>" + x;
				$('#fndModalPreview').modal('show');
				$('#fndModalPreview .modal-header').html('Preview ' + x);
				$('#fndModalPreview .modal-body').html('<iframe width="100%" height="550px" src="'+filename+'#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>');
			}
			$('#fndBtnAdd, #btnReset').click(function() {$('#fndContentMonitoring, #fndContentFormAdd').slideToggle(); });
		</script>
	</div>
</div>
<?php } ?>
