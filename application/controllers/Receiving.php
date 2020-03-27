<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class receiving extends CI_Controller {

	private $conn_name_dwasys;
	private $conn_dwasys;	

	private $table_trx_rcv_bpp_hdr;
	private $table_trx_rcv_bpp_dtl;
	private $table_trx_rcv_cer_hdr;
	private $table_trx_rcv_cer_dtl;
	private $table_trx_rrr_hdr;
	private $table_trx_rrr_dtl;
	private $table_mst_email_requester;

	private $query_mst_bcd_operator;
	private $query_os_po_rr_hdr_cer;
	private $query_os_po_rr_hdr_bpp;
	private $query_print_rrr;
	private $query_union_rrr_hdr;

	private $table_tmp_po_rr_bpp_cer;

	private $session_nik;

	public function __construct() {
		parent::__construct();

		$this->auth->restrict();
		$this->load->model('m_receiving');
		$this->load->library('sys');
        
        // $this->conn_name_dwasys             = $this->config->item('CONN_NAME_DWASYS_RESCUE'); /* Test */
        $this->conn_name_dwasys             = $this->config->item('CONN_NAME_DWASYS'); /* Live */
        $this->conn_dwasys                  = $this->load->database($this->conn_name_dwasys, TRUE);

        $this->table_trx_rcv_bpp_hdr		= $this->config->item('TABLE_TTX_RCV_BPP_HDR');
		$this->table_trx_rcv_bpp_dtl 		= $this->config->item('TABLE_TTX_RCV_BPP_DTL');
		$this->table_trx_rcv_cer_hdr 		= $this->config->item('TABLE_TTX_RCV_CER_HDR');
		$this->table_trx_rcv_cer_dtl 		= $this->config->item('TABLE_TTX_RCV_CER_DTL');
		$this->table_trx_rrr_hdr			= $this->config->item('TABLE_TRX_RRR_HDR');
		$this->table_trx_rrr_dtl			= $this->config->item('TABLE_TRX_RRR_DTL');
		$this->table_mst_email_requester	= $this->config->item('TABLE_MST_EMAIL_REQ_RR');

		$this->query_mst_bcd_operator		= $this->config->item('QUERY_BCD_OPERATOR');
        $this->query_os_po_rr_hdr_bpp		= $this->config->item('QUERY_OS_PO_RR_HDR_BPP');
		$this->query_os_po_rr_hdr_cer		= $this->config->item('QUERY_OS_PO_RR_HDR_CER');
		$this->query_print_rrr				= $this->config->item('QUERY_PRINT_RRR');
		$this->query_union_rrr_hdr			= $this->config->item('QUERY_RCBRG_HDR');

		$this->table_tmp_po_rr_bpp_cer 		= $this->config->item('TABLE_TMP_PO_VS_RR');

		$this->session_nik 			        = $this->session->userdata('sess_nik_receivingpur');		
	}

	public function index() {
		$data = array(
			'title' 			=> 'Proses Receiving BPP & CER',
			'page_title' 		=> 'Proses Receiving BPP & CER',
			'breadcrumb' 		=> '<li class="breadcrumb-item"><i class="ti-home"></i><a href="home"> Home</a></li>
							 		<li class="breadcrumb-item active"><i class="ti-shopping-cart"></i> Proses Receiving BPP & CER</li>',
			'custom_scripts' 	=> "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."receiving.js type='text/javascript'></script>"
		);
		$this->template->view('v_receiving', $data);
	}

	public function datatable_po() {
		$source = $this->input->post('source');
        $list 	= $this->m_receiving->get_datatables_po($source);
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = $lists->SysId_Hdr;
            $row[] = $no;
            $row[] = $lists->Doc_No;
            $row[] = $lists->Doc_Rev;
            $row[] = date($this->config->item('FORMAT_DATE_TO_DISPLAY'), strtotime($lists->Doc_Date));
            $row[] = $lists->Vendor_Id;
            $row[] = $lists->Vendor_All;
            $row[] = $lists->Remarks;
            $row[] = '<a href="javascript:void(0)" 
                         id="select_po" 
                         data-toggle="tooltip" 
                         title="Select PO"
                         data-sysid="'.$lists->SysId_Hdr.'"
                         data-po-number="'.$lists->Doc_No.'"
                         data-vendor-id="'.$lists->Vendor_Id.'"
                         data-vendor-all="'.$lists->Vendor_All.'"
                         data-department="'.$lists->Department_Init.'"
                         data-original-title="Select PO" 
                         class="btn waves-effect waves-light btn-xs btn-danger select_po">
                            <i class="mdi mdi-arrow-down-drop-circle-outline"></i>
                      </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_receiving->count_all_po($source),
                        "recordsFiltered" => $this->m_receiving->count_filtered_po($source),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    function get_data_po() {
    	$source 	= $this->input->post('rdo_source'); // bpp or cer
		$po_id 		= $this->input->post('po_id');
		$po_number 	= $this->input->post('po_number');

		$data = $this->m_receiving->get_data_po($source, $po_id, $po_number);
		if ($data == 1) {
            $notifikasi = 'Successfully Get Data PO';
            echo json_encode(['success' => $notifikasi]);
        } else {
            $notifikasi = 'Failed Get Data PO';
            echo json_encode(['failure' => $notifikasi]);
        }
	}

	function list_data_detail_rr() {
		$po_id 		= $this->input->post('po_id');
		$po_number 	= $this->input->post('po_number');

        $data = $this->m_receiving->list_data_detail_rr($po_id, $this->session_nik);

        if ($data->num_rows() > 0) {
            $i = 1;
            foreach ($data->result() as $row) {
				echo '<tr>';
				echo    '<td id="sysid" style="display:none;">'.$row->SysId.'</td>';
				echo    '<td id="no" style="width: 4%; text-align: center;">'.$i.'</td>';
				echo    '<td id="product_code" style="width: 9%; text-align: center;">'.$row->Product_Code.'</td>';
				echo    '<td id="product_name" style="width: 20%;">'.$row->Product_Name.'</td>';
				echo    '<td id="unit" style="width: 8%; text-align: center;">'.$row->Unit_Name.'</td>';				
				echo    '<td id="qty_po" style="width: 8%; text-align: right;">'.$row->Qty_PO.'</td>';
				echo    '<td id="qty_os" style="width: 8%; text-align: right;">'.$row->Qty_OS.'</td>';
				echo    '<td id="qty_receive" style="width: 8%; text-align: right;">'.$row->Qty_RR.'</td>';
				echo    '<td id="remarks" style="width: 20%;">'.$row->Remarks.'</td>';
				echo 	'<td style="width: 15%; text-align: center;">';
							echo "<a href='javascript:void(0)'' 
			                         id='edit_rr' 
			                         data-toggle='tooltip' 
			                         title='Edit' 
			                         data-sysid=".$row->SysId."
			                         data-original-title='Edit' 
			                         class='btn waves-effect waves-light btn-xs btn-warning edit_rr'>
			                            <i class='fa fa-edit'></i>
			                      </a>
			                      <a href='javascript:void(0)'' 
			                         id='delete_rr' 
			                         data-toggle='tooltip' 
			                         title='Delete' 
			                         data-sysid=".$row->SysId."
			                         data-original-title='Delete' 
			                         class='btn waves-effect waves-light btn-xs btn-danger delete_rr'>
			                            <i class='fa fa-trash'></i>
			                      </a>";
				echo 	'</td>';
				echo '</tr>';
				
				$i++;
            }
        }		
    }

    function delete_temp_rr() {
        $sysid      = $this->input->post('sysid');

        $notifikasi = $this->m_receiving->delete_temp_rr($sysid);

        if ($notifikasi == 1) {
            $notifikasi = 'Delete data berhasil';
            echo json_encode(['success'=>$notifikasi]);
        } else {
            $notifikasi = 'Delete data gagal !!! <br> 
                           Kesalahan di prosedur DELETE DATA. Silahkan hubungi administrator';
			echo json_encode(['failed'=>$notifikasi]);                           
        }
    }

    public function edit_temp_rr() {
    	$sysid 	= $this->input->post('sysid');
        $data 	= $this->m_receiving->edit_temp_rr($sysid);
        echo json_encode($data);
    }

    public function update_temp_rr() {
        $sysid 		= $this->input->post('edit_sysid');
        $qty_os 	= $this->input->post('edit_qty_os');
        $qty_rr 	= $this->input->post('edit_qty_rr');
        $qty_rr_old	= $this->input->post('edit_qty_rr_old');

        return $this->m_receiving->update_temp_rr($sysid, $qty_os, $qty_rr, $qty_rr_old);
    }

    public function create_trx_rr() {
		$doc_date 			= $this->input->post('doc_date');
		$month1 			= date_format(new DateTime($doc_date), 'n'); // bulan 1, 2, 3, ...
		$month2 			= date_format(new DateTime($doc_date), 'm'); // bulan 01, 02, 03, ...
		$year2 				= date_format(new DateTime($doc_date), 'y'); // tahun 2 digit
		$year4 				= date_format(new DateTime($doc_date), 'Y'); // tahun 4 digit
		$nik_req 			= $this->input->post('nik_req');

		$source_scan    	= $this->input->post('rdo_source'); // bpp or cer
		$cash 				= $this->input->post('ckh_cash'); // cash or no
		//if (isset($cash)) {
		if ($cash == 'cash') {			
			$flag_cash = "1";
		} else {
			$flag_cash = "0";
		}
		$po_id    			= $this->input->post('po_id');
		$po_no    			= $this->input->post('po_number');
		$vendor_id    		= $this->input->post('vendor_id');
		$department_code	= $this->input->post('department');
		$arrival_date 		= $this->input->post('arrival_date');
		$no_sj_supplier		= $this->input->post('no_sj_supplier');
		$date_sj_supplier	= $this->input->post('sj_date_supplier');
		$remarks 			= $this->input->post('remarks');

		$query_temp_rr = $this->m_receiving->list_temp_rr($po_no, $this->session_nik);
		if ($query_temp_rr->num_rows() == 0) {
			echo json_encode(['error_empty_rr'=>'Tidak ada data untuk diproses !!!']);
			return false;
		}

		// 1. Receiving PUR
		$this->conn_dwasys->trans_begin();
		if ($source_scan == 'bpp') {
			// Header
			$new_sysid_header_bpp 	= $this->sys->last_sysid_dwafinacct($this->config->item('TRX_NAME_RECEIVE_BPP')) + 1;
			$count_doc_number_bpp 	= $this->sys->last_doc_number_dwafinacct($this->config->item('TRX_NAME_RECEIVE_BPP'), $month1, $year4) + 1;
			$new_doc_number 		= 'RCV/'.$year2.$month2.'-'.substr('0000'.$count_doc_number_bpp, -4); // RCV/2001-0090
			$data = array(
				'SysId'					=> $new_sysid_header_bpp,
				'SysId_PO' 				=> $po_id,
				'SysId_Vendor'			=> $vendor_id,
				'Department_Code'		=> $this->session->userdata('sess_dept_code_receivingpur'), // $department_code,
				'Doc_No'				=> $new_doc_number,
				'Doc_Revisi'			=> 0,
				'Doc_Date'				=> date_format(new DateTime($doc_date), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Date_Delivery'			=> date_format(new DateTime($arrival_date), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Doc_SJ' 				=> $no_sj_supplier,
				'Date_SJ'				=> date_format(new DateTime($date_sj_supplier), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Remark' 				=> $remarks,
				'Flag_Cash' 			=> $flag_cash,
				'Rec_UserId' 			=> $this->session_nik,
				'Rec_LastDateTime' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATETIME_TO_INSERT'))
			);
			$result_hdr_bpp = $this->conn_dwasys->insert($this->table_trx_rcv_bpp_hdr, $data);
			$last_sysid_header_bpp = $new_sysid_header_bpp;
			if ($result_hdr_bpp == 1) {
				// Detail
				$sql = "SELECT * FROM ".$this->table_tmp_po_rr_bpp_cer." WHERE PO_No = '".$po_no."' AND User_Login = '".$this->session_nik."'";
				$query_detail_bpp = $this->conn_dwasys->query($sql);
				if ($query_detail_bpp->num_rows() > 0) {
					foreach($query_detail_bpp->result() as $row) {
						$data = array(
							'SysId_Hdr' 			=> $last_sysid_header_bpp,
							'SysId_Barang'			=> $row->Product_Id,
							'Part_Number'			=> $row->Product_Code,
							'Part_Name'				=> $row->Product_Name,
							'Unit'					=> $row->Unit_Name,
							'Unit_Konversi'			=> $row->Unit_Koversi_Code,
							'Unit_Konversi_Value' 	=> $row->Unit_Koversi_Value,
							'Qty_PO_OS'				=> $row->Qty_OS,
							'Qty'					=> $row->Qty_RR,
							'Remark'				=> $row->Remarks,
							'Rec_UserId' 			=> $this->session_nik,
							'Rec_LastDateTime' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATETIME_TO_INSERT'))
						);
				        $this->conn_dwasys->insert($this->table_trx_rcv_bpp_dtl, $data);
					}
				}
			} else {
				$notifikasi = 'Insert data header RCV gagal !!! <br>
				               Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator';
				echo json_encode(['error_rcv_bpp_hdr' => $notifikasi]);				               
			}

		} elseif ($source_scan == 'cer') {
			// Header
			$new_sysid_header_cer 	= 0;
			$count_doc_number_cer 	= $this->sys->last_doc_number_dwasys($this->config->item('TRX_NAME_RECEIVE_CER'), $month1, $year4) + 1;
			$new_doc_number 		= 'RR-'.$year2.$month2.'-'.substr('0000'.$count_doc_number_cer, -4); // RR-2001-0000
			$data = array(
				'Doc_No' 				=> $new_doc_number,
				'Doc_Rev'				=> 0,
				'Doc_Date'				=> date_format(new DateTime($doc_date), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Arrival_Date'			=> date_format(new DateTime($arrival_date), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'SJ_No_Supplier'		=> $no_sj_supplier,
				'SJ_Date_Supplier' 		=> date_format(new DateTime($date_sj_supplier), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'PO_Id' 				=> $po_id,
				'Remarks' 				=> $remarks,
				'Flag_Cash' 			=> $flag_cash,
				'Rec_UserId' 			=> $this->session_nik,
				'Rec_CreateDate' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Rec_LastUpdate' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATETIME_TO_INSERT'))
			);
			$result_hdr_cer = $this->conn_dwasys->insert($this->table_trx_rcv_cer_hdr, $data);
			$last_sysid_header_cer = $this->conn_dwasys->insert_id();
			if ($result_hdr_cer == 1) {
				// Detail
				$sql = "SELECT * FROM ".$this->table_tmp_po_rr_bpp_cer." WHERE PO_No = '".$po_no."' AND User_Login = '".$this->session_nik."'";
				$query_detail_cer = $this->conn_dwasys->query($sql);
				if ($query_detail_cer->num_rows() > 0) {
					foreach($query_detail_cer->result() as $row) {
						$data = array(
							'SysId_Hdr' 			=> $last_sysid_header_cer,
							'Product_Id'			=> $row->Product_Id,
							'Product_Initial'		=> $row->Product_Initial,
							'Qty'					=> $row->Qty_RR,
							'Rec_UserId' 			=> $this->session_nik,
							'Rec_CreateDate' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
							'Rec_LastUpdate' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATETIME_TO_INSERT'))
						);
				        $this->conn_dwasys->insert($this->table_trx_rcv_cer_dtl, $data);
					}
				}
			} else {
				$notifikasi = 'Insert data header RR From CER gagal !!! <br>
				               Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator';
				echo json_encode(['error_rcv_cer_hdr' => $notifikasi]);				               
			}
		}

		// Header RRR
		$count_doc_number_rrr 	= $this->sys->last_doc_number_dwasys($this->config->item('TRX_NAME_RECEIVE_REQ').$department_code, $month1, $year4) + 1;
		$new_doc_number_rrr 	= 'RRR-'.$department_code.'-'.$year2.$month2.'-'.substr('0000'.$count_doc_number_rrr, -4); // RRR-HRG-2001-0004
		$sql = "SELECT
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_ID,
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_DOC_NO,
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_DOC_DATE, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_ARRIVAL_DATE, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_SJ_VENDOR_DOC_NO, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_SJ_VENDOR_DOC_DATE, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_VENDOR_ID, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_VENDOR_CODE, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_VENDOR_NAME, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_Q_NO, 
					dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_PO_NO,
					Union_xxx.DocNo_Bpp_Cer AS NO_BPP_CER
             	FROM 
             		(
	             		SELECT 
	             			dbo.TTrxHdr_PUR_BPPQ_BPP.SysId_BPP AS Id_BPP_CER, 
	             			dbo.TTrxHdr_PUR_BPPQ_BPP.Doc_No AS DocNo,
	                        dbo.TTrxHdr_PUR_BPP.Doc_No AS DocNo_Bpp_Cer
	               		FROM 
	               			dbo.TTrxHdr_PUR_BPPQ_BPP 
	               			INNER JOIN dbo.TTrxHdr_PUR_BPP ON dbo.TTrxHdr_PUR_BPPQ_BPP.SysId_BPP = dbo.TTrxHdr_PUR_BPP.SysId
						UNION ALL
		                SELECT 
		                	dbo.TTrxHdr_Pur_CERQuotation_CER.SysId AS Id_BPP_CER, 
		                	dbo.TTrxHdr_Pur_CERQuotation_CER.Doc_No AS DocNo,
							dbo.TTrxHdr_Pur_CERRequest_CER.Doc_No AS DocNo_Bpp_Cer
		          		FROM   
		          			dbo.TTrxHdr_Pur_CERQuotation_CER 
		          			INNER JOIN dbo.TTrxHdr_Pur_CERRequest_CER ON dbo.TTrxHdr_Pur_CERQuotation_CER.CERRequest_Id = dbo.TTrxHdr_Pur_CERRequest_CER.SysId
	          		) AS Union_xxx 
	          		RIGHT OUTER JOIN dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR ON Union_xxx.DocNo = dbo.QView_Pur_OS_RR_VS_RRR_HEADER_RRR.RR_Q_NO
	          	WHERE
	 				RR_DOC_NO = '".$new_doc_number."'";
		$query = $this->conn_dwasys->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$data = array(
				'SysId_RRPUR' 		=> $row->RR_ID,
				'Doc_No'			=> $new_doc_number_rrr,
				'Doc_RRPUR'			=> $row->RR_DOC_NO,
				'Doc_Date'			=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Doc_SJ'			=> $row->RR_SJ_VENDOR_DOC_NO,
				'Date_SJ'			=> $row->RR_SJ_VENDOR_DOC_DATE,
				'Doc_PO'			=> $row->RR_PO_NO,
				'Doc_BPPCER'		=> $row->RR_Q_NO,
				'Remark'			=> '',
				'Rec_UserId' 		=> $this->session_nik,
				'Rec_LastDateTime' 	=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATETIME_TO_INSERT')),
				'DEPT' 				=> $department_code,
			);
			$res_rrr_hdr = $this->conn_dwasys->insert($this->table_trx_rrr_hdr, $data);
			$last_sysid_header = $this->conn_dwasys->insert_id();
			if ($res_rrr_hdr == 1) {
				// Detail RRR
				$sql = "SELECT * FROM ".$this->table_tmp_po_rr_bpp_cer." WHERE PO_No = '".$po_no."' AND User_Login = '".$this->session_nik."'";
				$query_detail = $this->conn_dwasys->query($sql);
				if ($query_detail->num_rows() > 0) {
					foreach($query_detail->result() as $row) {
						$data = array(
							'SysId_Hdr' 			=> $last_sysid_header,
							'SysId_Barang'			=> $row->Product_Id,
							'Doc_no'				=> $new_doc_number_rrr,
							'Part_Number'			=> $row->Product_Code,
							'Part_Name'				=> $row->Product_Name,
							'Unit'					=> $row->Unit_Name,
							'Qty'					=> $row->Qty_RR,
							'Remark'				=> '',
							'Rec_UserId' 			=> $this->session_nik,
							'Rec_LastDateTime' 		=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATETIME_TO_INSERT'))
						);
				        $this->conn_dwasys->insert($this->table_trx_rrr_dtl, $data);
					}
				}
			} else {
				$notifikasi = 'Insert data header RRR gagal !!! <br>
				               Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator';
				echo json_encode(['error_rrr_hdr' => $notifikasi]);				               
			}
		}

		if ($this->conn_dwasys->trans_status() === FALSE) {
        	$this->conn_dwasys->trans_rollback();
        	echo json_encode(['error_rollback'=>'Rollback Transaction']);
		} else {
        	$this->conn_dwasys->trans_commit();

        	// create pdf
			ob_start();
			$sql_header = $this->conn_dwasys->get_where($this->query_union_rrr_hdr, array('SysId' => $last_sysid_header)); // hanya 1 row saja
	        $sql_detail = $this->conn_dwasys->get_where($this->table_trx_rrr_dtl, array('SysId_Hdr' => $last_sysid_header))->result(); // semua row data
	        $data_nama_penerima = $this->conn_dwasys->get_where($this->query_mst_bcd_operator, array('NIK' => $nik_req));
	        $nama_penerima = '';
	        $nama_init_penerima = '';
	        if (!empty($data_nama_penerima)) {
            	$row = $data_nama_penerima->row();
            	$nama_penerima = $row->Nama;
            	$nama_init_penerima = $row->Nama_Init;
            }
	        $data = array(	
	        	'data_header'	=> $sql_header,
	        	'data_detail' 	=> $sql_detail,
	        	'pengirim' 		=> $this->session->userdata('sess_nama_receivingpur'), //$this->session->userdata('sess_nama_init_receivingpur'),
	        	'penerima' 		=> $nama_penerima
	        );
	        $this->load->view('print_rr_view', $data);
			$html = ob_get_contents();
			ob_end_clean();
			require_once('./assets/vendor/html2pdf/html2pdf.class.php');
			$pdf = new HTML2PDF('P', 'A4', 'en');
			$pdf->WriteHTML($html);
			$filename_tmp = "tmp/".$new_doc_number_rrr.".pdf";
			$pdf->Output($filename_tmp, "F"); // https://rachmat.id/laporan-php-dengan-html2pdf/

			// send email
			$no_bppcer_for_subject = '';
	        if (!empty($sql_header)) {
            	$row = $sql_header->row();
            	$no_bppcer_for_subject = $row->Doc_BPPCER;
            }
			$subjek 	= "Bukti Serah Terima Barang - Nomor BPPQ / CERQ : ".$no_bppcer_for_subject;
			$content 	= "Bukti Serah Terima Barang - Nomor BPPQ / CERQ : ".$no_bppcer_for_subject;
			$sendmail 	= array(
				'department' 		=> $department_code,
				'subjek' 			=> $subjek,
				'content' 			=> $content,
				'attachment'		=> $filename_tmp
			);
			$send = $this->mailer->send_email_with_attachment($sendmail);

        	echo json_encode(['success_commit'=>'Create Receiving Report berhasil', 
        					  'success_commit_message_pur'=>'Nomor Receiving Report (PUR) : '.$new_doc_number,
        					  'success_commit_message_dept'=>'Nomor Receiving Report (Requester) : '.$new_doc_number_rrr,
        					  'status_email'=>$send['send_email_status']]);
		}		
	}

	public function cek_requester() {
		$nik_req 	= $this->input->post('nik_req');
		$dept_req 	= $this->input->post('dept_req');

		$query = $this->m_receiving->cek_requester($nik_req, $dept_req);
		if ($query->num_rows() == 0) {
			echo json_encode(['nik_req_not_exist'=>'NIK belum terdaftar di sistem / NIK tidak terdaftar dari department requester '.$dept_req]);
		} else {
			echo json_encode(['nik_req_exist'=>'User terdaftar di sistem']);
		}
	}

	public function create_pdf() {
		ob_start();
		$sql_header = $this->conn_dwasys->get_where($this->query_union_rrr_hdr, array('SysId' => 3321)); // hanya 1 row saja
        $sql_detail = $this->conn_dwasys->get_where($this->table_trx_rrr_dtl, array('SysId_Hdr' => 3321))->result(); // semua row data
        $data_nama_penerima = $this->conn_dwasys->get_where($this->query_mst_bcd_operator, array('NIK' => '18040342'));
        $nama_penerima = '';
        $nama_init_penerima = '';
        if (!empty($data_nama_penerima)) {
        	$row = $data_nama_penerima->row();
        	$nama_penerima = $row->Nama;
        	$nama_init_penerima = $row->Nama_Init;
        }
        $data = array(	
        	'data_header'	=> $sql_header,
        	'data_detail' 	=> $sql_detail,
        	'pengirim' 		=> $this->session->userdata('sess_nama_receivingpur'), //$this->session->userdata('sess_nama_init_receivingpur'),
        	'penerima' 		=> $nama_penerima
        );
        $this->load->view('print_rr_view', $data);

		// // create pdf
		// ob_start();
		// $sql_header = $this->conn_dwasys->get_where($this->query_print_rrr, array('RRR_ID' => 40)); // hanya 1 row saja
  //       $sql_detail = $this->conn_dwasys->get_where($this->query_print_rrr, array('RRR_ID' => 40))->result(); // semua row data
  //       $data = array(
  //       	'data_header' => $sql_header,
  //       	'data_detail' => $sql_detail
  //       );
  //       $this->load->view('print_rr_view', $data);
		// $html = ob_get_contents();
		// ob_end_clean();
		// require_once('./assets/vendor/html2pdf/html2pdf.class.php');
		// $pdf = new HTML2PDF('P', 'A4', 'en');
		// $pdf->WriteHTML($html);
		// $pdf->Output("tmp/contoh_laporan.pdf", "F"); // https://rachmat.id/laporan-php-dengan-html2pdf/

		// send email
		// $subjek 	= "Test Email";
		// $content 	= "content";
		// $sendmail 	= array(
		// 	'department' 		=> 'CDC',
		// 	'subjek' 			=> $subjek,
		// 	'content' 			=> $content,
		// 	'attachment'		=> "tmp/RRR-CDC-2001-0023.pdf"
		// );
		// $send = $this->mailer->send_email_with_attachment($sendmail);
		// echo $send['send_email_status'];
	}

}
