<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-12">
		<div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#scan" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-barcode-scan"></i></span> <span class="hidden-xs-down">Scan DN</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#list_sj" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-format-list-bulleted"></i></span> <span class="hidden-xs-down">List SJ</span></a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="scan" role="tabpanel">
                	<div class="p-20">
                		<form class="form-horizontal row" role="form" id="form_scan" method="post">
                			<div class="col-12">
                				<div class="form-group">
                                    <label class="form-control-label" for="nomor_dn">Nomor DN :</label>
                                    <input type="text" class="form-control" id="nomor_dn" name="nomor_dn">
                                    <div class="form-control-feedback"></div>
                                    <small class="form-text text-muted"></small>                                    
                                </div>
                                <div class="table-responsive">
					                <table id="tbl_dn" class="table table-striped dt-responsive" width="100%">
					                    <thead>
					                        <tr>
					                        	<th class="text-center">SysId</th>
					                            <th class="text-center">No. DN</th>
					                            <th class="text-center">Action</th>
					                        </tr>
					                    </thead>
					                    <tbody></tbody>
					                </table>
					            </div>
                			</div>

                			<div class="col-12"><hr><br><br></div>

                			<div class="col-12">
                				<div class="form-group">
                                    <label class="form-control-label" for="nomor_kanban">Kanban :</label>
                                    <input type="text" class="form-control" id="nomor_kanban" name="nomor_kanban">
                                    <div class="form-control-feedback"></div>
                                    <small class="form-text text-muted"></small>                                    
                                </div>
                                <div class="table-responsive">
					                <table id="tbl_kanban" class="table table-striped dt-responsive" width="100%">
					                    <thead>
					                        <tr>
					                        	<th class="text-center">SysId</th>
					                            <th class="text-center">Job No</th>
					                            <th class="text-center">CPN Number</th>
					                            <th class="text-left">CPN Name</th>
					                            <th class="text-center">Unit</th>
					                            <th class="text-right">Qty Kanban</th>
					                            <th class="text-right">Qty Packing</th>
					                            <th class="text-center">Action</th>
					                        </tr>
					                    </thead>
					                    <tbody></tbody>
					                </table>
					            </div>
                			</div>

                			<div class="col-12"><hr><br><br></div>

                			<div class="col-12">
                				<div class="form-group">
                                    <label class="form-control-label" for="nomor_tagok">Tag OK :</label>
                                    <input type="text" class="form-control" id="nomor_tagok" name="nomor_tagok">
                                    <div class="form-control-feedback"></div>
                                    <small class="form-text text-muted"></small>                                    
                                </div>
                                <div class="table-responsive">
					                <table id="tbl_tagok" class="table table-striped dt-responsive" width="100%">
					                    <thead>
					                        <tr>
					                        	<th class="text-center">SysId</th>
					                        	<th class="text-center">Tag ID</th>
					                            <th class="text-center">Job No</th>
					                            <th class="text-center">CPN Number</th>
					                            <th class="text-left">CPN Name</th>
					                            <th class="text-center">Unit</th>
					                            <th class="text-right">Qty Packing</th>
					                            <th class="text-center">Action</th>
					                        </tr>
					                    </thead>
					                    <tbody></tbody>
					                </table>
					            </div>
                			</div>

                			<div class="col-12"><hr><br><br></div>

                			<div class="col-12">
                				<div class="form-group">
                					<label class="form-control-label" for="tgl_sj">Tanggal SJ :</label>
                                    <div class="input-group">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text" id="basic-addon1">
	                                            <i class="fas fa-calendar-alt"></i>
	                                        </span>
	                                    </div>	                                    
	                                    <input type="text" class="form-control" id="tgl_sj" name="tgl_sj">
	                                </div>
                                </div>
                            </div>

                            <div class="col-12">
                            	<div class="form-group">
                                	<button class="btn btn-warning btn-md btn-block waves-effect waves-light" id="btn_create_sj" type="button">CREATE SURAT JALAN (SJ)</button>
                                </div>
                            </div>
                    	</form>
                    </div>
                </div>
                <div class="tab-pane p-20" id="list_sj" role="tabpanel">
					<div class="table-responsive">
		                <table id="tbl_listsj" class="table table-striped dt-responsive" width="100%">
		                    <thead>
		                        <tr>
		                        	<th>SYSID</th>
		                        	<th class="text-center">NO</th>
		                            <th class="text-center">NO. DN</th>
		                            <th class="text-center">NO. SJ</th>
		                            <th class="text-right">TGL. SJ</th>
		                        </tr>
		                    </thead>
		                    <tbody></tbody>
		                </table>
        			</div>
                </div>
            </div>
        </div>
	</div>	
</div>