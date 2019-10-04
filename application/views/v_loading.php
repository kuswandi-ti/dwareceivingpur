<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" id="form_loading" method="post">
                	<div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-left col-md-3">No. Truk :</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="vehicle_num" name="vehicle_num" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <a href="javascript:void(0);"><i class="ti-search" id="browse_truk"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="armada_name" name="armada_name" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-left col-md-3">ID Supir :</label>
                                <div class="col-md-9">
			                       <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nik" name="nik" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <a href="javascript:void(0);"><i class="ti-search" id="browse_supir"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="driver_name" name="driver_name" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-left col-md-3">DN ADM :</label>
                                <div class="col-md-9">
                                    <div class="input-group">
			                            <div class="input-group-prepend">
			                                <span class="input-group-text" id="basic-addon1">
			                                    <i class="ti-file"></i>
			                                </span>
			                            </div>
			                            <input type="text" class="form-control" id="dn_adm" name="dn_adm">
			                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="dn_adm_rep" name="dn_adm_rep" readonly>
                                    <input type="hidden" class="form-control" id="sysid" name="sysid" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr></div>

                    <div class="row">
                        <div class="col-md-12">
                        	<div class="table-responsive">
				                <table id="tbl_loading" class="table table-striped dt-responsive" width="100%">
				                    <thead>
				                        <tr>
				                        	<th class="text-center">No.</th>
				                            <th class="text-center">No. DN</th>
				                            <th class="text-center">CPN Number</th>
				                            <th class="text-left">CPN Name</th>
				                            <th class="text-center">Unit</th>
				                            <th class="text-center">Qty</th>
				                        </tr>
				                    </thead>
				                    <tbody></tbody>
				                </table>
				            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr></div>

                    <div class="row">
                    	<div class="col-md-12">
                        	<button class="btn btn-warning btn-md btn-block waves-effect waves-light" id="btn_cetak_loading" type="button">CETAK</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_truk" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Browse Data Truk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
            	<div class="row">
                    <div class="col-md-12">
                    	<div class="table-responsive">
			                <table id="tbl_browse_truk" class="table table-striped dt-responsive" width="100%">
			                    <thead>
			                        <tr>
			                        	<th class="text-center">No.</th>
			                            <th class="text-center">No. Truk</th>
			                            <th class="text-center">Nama Armada</th>
			                            <th class="text-center">Action</th>
			                        </tr>
			                    </thead>
			                    <tbody></tbody>
			                </table>
			            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="btn-label"><i class="ti-power-off "></i></span> Close
                </button>
            </div>
        </div>
    </div>
</div>

<div id="modal_supir" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Browse Data Supir</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
            	<div class="row">
                    <div class="col-md-12">
                    	<div class="table-responsive">
			                <table id="tbl_browse_supir" class="table table-striped dt-responsive" width="100%">
			                    <thead>
			                        <tr>
			                        	<th class="text-center">No.</th>
			                            <th class="text-center">NIK</th>
			                            <th class="text-center">Nama Supir</th>
			                            <th class="text-center">Action</th>
			                        </tr>
			                    </thead>
			                    <tbody></tbody>
			                </table>
			            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="btn-label"><i class="ti-power-off "></i></span> Close
                </button>
            </div>
        </div>
    </div>
</div>