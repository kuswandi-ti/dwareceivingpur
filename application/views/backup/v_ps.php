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
			<table class="table table-striped table-hover table-bordered" cellspacing="0" id="fndTable">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>Kode Error</th>
						<th>Deskripsi Error</th>
						<th>Solusi Error</th>
						<th width="15%">File</th>
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
		<script>
			function fndFilePreview(x) {
				filename = "<?= base_url($this->config->item('PATH_ASSET_PS')) ?>" + x;
				$('#fndModalPreview').modal('show');
				$('#fndModalPreview .modal-header').html('Preview ' + x);
				$('#fndModalPreview .modal-body').html('<iframe width="100%" height="550px" src="'+filename+'#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>');
			}
		</script>
	</div>
</div>