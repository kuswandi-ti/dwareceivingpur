<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-body">
                <form id="form_receive" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="radio" id="rdo_bpp" name="rdo_source" value="bpp" required checked="true">&nbsp;<label for="rdo_bpp">BPP</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="rdo_cer" name="rdo_source" value="cer" required>&nbsp;<label for="rdo_cer">CER</label>
                                </div>
                            </div>
                        </div>

                        <div class="row"><div class="col-md-12"><hr><br></div></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="checkbox" class="check" id="chk_cash" name="chk_cash" value="cash" data-checkbox="icheckbox_flat-red">
                                    <label for="chk_cash">Cash</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="doc_no">Doc. No</label>
                                    <input type="text" class="form-control" id="doc_no" name="doc_no" value="[ A U T O M A T I C ]" readonly="true">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="po_number">PO Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="po_number" name="po_number" readonly>
                                        <input type="hidden" class="form-control" id="po_id" name="po_id" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
                                                <a href="javascript:void(0);"><i class="ti-search" id="browse_po"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label" for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" readonly="true">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="doc_date">Doc. Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>                                      
                                        <input type="text" class="form-control" id="doc_date" name="doc_date" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="arrival_date">Arrival Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="arrival_date" name="arrival_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="vendor">Vendor</label>
                                    <input type="text" class="form-control" id="vendor" name="vendor" readonly="true">
                                    <input type="hidden" class="form-control" id="vendor_id" name="vendor_id" readonly="true">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="sj_date_supplier">SJ Date Supplier</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>                                      
                                        <input type="text" class="form-control" id="sj_date_supplier" name="sj_date_supplier">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="no_sj_supplier">No. SJ Supplier</label>
                                    <input type="text" class="form-control" id="no_sj_supplier" name="no_sj_supplier">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="remarks">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks">
                                </div>
                            </div>
                        </div>

                        <div class="row"><div class="col-md-12"><hr><br></div></div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tbl_receive_dtl" class="table table-striped dt-responsive" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="display:none;">SysId</th>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Product Code</th>
                                            <th class="text-left">Product Name</th>
                                            <th class="text-center">Unit</th>                                            
                                            <th class="text-right">Qty PO</th>
                                            <th class="text-right">Qty Oustanding</th>
                                            <th class="text-right">Qty Receive</th>
                                            <th class="text-left">Remarks</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_detail_receive"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row"><div class="col-md-12"><hr><br></div></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn-md btn-block waves-effect waves-light" id="btn_proses_rr" type="button"><i class="fas fa-play-circle"></i> PROSES</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>	
</div>

<div id="modal_detail_po" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:95%!important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Browse Data PO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tbl_browse_po" class="table table-striped dt-responsive tbl_browse_po" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="display:none;">SysId</th>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">PO Number</th>
                                        <th class="text-center">PO Rev.</th>
                                        <th class="text-center">PO Date</th>
                                        <th class="text-left" style="display:none;">Vendor Id</th>
                                        <th class="text-left">Vendor</th>
                                        <th class="text-left">Remarks</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="show_detail_po"></tbody>
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

<div class="modal" id="modal_edit_rr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Receiving Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="form_edit_rr" name="form_edit_rr">
                <input type="hidden" name="edit_sysid" id="edit_sysid">

                <div class="modal-body">                
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Product Code :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="edit_product_code" name="edit_product_code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Product Name :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="edit_product_name" name="edit_product_name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Unit :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="edit_unit" name="edit_unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Qty PO :</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control text-right" id="edit_qty_po" name="edit_qty_po" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Qty Outstanding :</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control text-right" id="edit_qty_os" name="edit_qty_os" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Qty RR :</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control text-right" id="edit_qty_rr" name="edit_qty_rr" value="0">
                                        <input type="hidden" class="form-control text-right" id="edit_qty_rr_old" name="edit_qty_rr_old" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btn_save" name="btn_save">
                        <span class="btn-label"><i class="ti-save"></i></span> Save
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="btn-label"><i class="ti-close "></i></span> Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_scan_nik" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Scan NIK Receiver (Department Requester)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="form_scan_nik" name="form_scan_nik">
                <div class="modal-body">                
                    <div class="form-body">
                        <br>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="nik_requester" name="nik_requester" placeholder="NIK">
                            </div>
                        </div>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>