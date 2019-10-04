<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pulling extends CI_Controller {
	
	private $conn_name_dwasys_rescue;
	private $conn_dwasys_rescue;

	private $conn_name_dwasys;
	private $conn_dwasys;	

	private $table_tmp_scandn;
	private $table_tmp_scankanban;
	private $table_tmp_tagok;
	private $table_trx_sj_hdr;
	private $table_trx_sj_dtl;
	private $session_nik;

	public function __construct() {
		parent::__construct();

		$this->auth->restrict();
		$this->load->model('m_pulling');

		$this->conn_name_dwasys_rescue 		= $this->config->item('CONN_NAME_DWASYS_RESCUE'); // Untuk test
		$this->conn_dwasys_rescue 			= $this->load->database($this->conn_name_dwasys_rescue, TRUE); // Untuk test

		$this->conn_name_dwasys 	= $this->config->item('CONN_NAME_DWASYS'); // Untuk live
		$this->conn_dwasys 			= $this->load->database($this->conn_name_dwasys, TRUE); // Untuk live

		$this->table_tmp_scandn 	= $this->config->item('TABLE_TMP_SCAN_DN');
		$this->table_tmp_scankanban = $this->config->item('TABLE_TMP_SCAN_KANBAN');
		$this->table_tmp_scantagok 	= $this->config->item('TABLE_TMP_SCAN_TAGOK');
		$this->table_trx_sj_hdr 	= $this->config->item('TABLE_TRX_SURAT_JALAN_HDR');
		$this->table_trx_sj_dtl 	= $this->config->item('TABLE_TRX_SURAT_JALAN_DTL');
		$this->session_nik 			= $this->session->userdata('sess_nik');
	}

	public function index() {
		$data = array(
			'title' 			=> 'Proses Pulling',
			'page_title' 		=> 'Proses Pulling',
			'breadcrumb' 		=> '<li class="breadcrumb-item"><i class="ti-home"></i><a href="home"> Home</a></li>
							 		<li class="breadcrumb-item active"><i class="ti-shopping-cart"></i> Proses Pulling</li>',
			'custom_scripts' 	=> "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."pulling.js type='text/javascript'></script>"
		);
		$this->template->view('v_pulling', $data);
	}

	public function get_data_temp_dn() {
		/* 
		 * Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('sysid', 'no_dn');
        
        // DB table to use
		$sTable = $this->table_tmp_scandn;
						
        $iDisplayStart 	= $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 	= $this->input->get_post('iSortCol_0', true);
        $iSortingCols 	= $this->input->get_post('iSortingCols', true);
        $sSearch 		= $this->input->get_post('sSearch', true);
        $sEcho 			= $this->input->get_post('sEcho', true);
    
        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if (isset($iSortCol_0)) {
            for ($i=0; $i<intval($iSortingCols); $i++) {
                $iSortCol 	= $this->input->get_post('iSortCol_'.$i, true);
                $bSortable 	= $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir 	= $this->input->get_post('sSortDir_'.$i, true);
    
                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch)) {
            for ($i=0; $i<count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
        }
        
        // Select Data
        $this->db->where('user_login', $this->session_nik);
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $rResult = $this->db->get($sTable);
    
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $this->db->where('user_login', $this->session_nik);
        $iTotal = $this->db->count_all($sTable);
    
        // Output
        $output = array(
            'sEcho' 				=> intval($sEcho),
            'iTotalRecords' 		=> $iTotal,
            'iTotalDisplayRecords' 	=> $iFilteredTotal,
            'aaData' 				=> array()
        );

        $no = $iDisplayStart;
				
        foreach ($rResult->result_array() as $aRow) {
            $row = array();

            $no++;
			$row[] = $aRow['sysid'];
			$row[] = $aRow['no_dn'];			
			$row[] = '<a href="javascript:void(0)" 
			             id="delete_dn" 
			             data-toggle="tooltip" 
			             title="Delete" 
			             data-sysid="'.$aRow['sysid'].'" 
			             data-no_dn="'.$aRow['no_dn'].'" 
			             data-original-title="Delete" 
			             class="btn waves-effect waves-light btn-xs btn-danger delete_dn">
			             	<i class="fa fa-trash"></i>
			          </a>';
			
			$output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function get_data_temp_kanban() {
		/* 
		 * Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('sysid', 'no_dn', 'job_no', 'cpn_number', 'cpn_name', 'unit_name', 'qty_kanban', 'qty_packing');
        
        // DB table to use
		$sTable = $this->table_tmp_scankanban;
						
        $iDisplayStart 	= $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 	= $this->input->get_post('iSortCol_0', true);
        $iSortingCols 	= $this->input->get_post('iSortingCols', true);
        $sSearch 		= $this->input->get_post('sSearch', true);
        $sEcho 			= $this->input->get_post('sEcho', true);
    
        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if (isset($iSortCol_0)) {
            for ($i=0; $i<intval($iSortingCols); $i++) {
                $iSortCol 	= $this->input->get_post('iSortCol_'.$i, true);
                $bSortable 	= $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir 	= $this->input->get_post('sSortDir_'.$i, true);
    
                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch)) {
            for ($i=0; $i<count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
        }
        
        // Select Data
        $this->db->where('user_login', $this->session_nik);
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $rResult = $this->db->get($sTable);
    
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $this->db->where('user_login', $this->session_nik);
        $iTotal = $this->db->count_all($sTable);
    
        // Output
        $output = array(
            'sEcho' 				=> intval($sEcho),
            'iTotalRecords' 		=> $iTotal,
            'iTotalDisplayRecords' 	=> $iFilteredTotal,
            'aaData' 				=> array()
        );
				
        foreach ($rResult->result_array() as $aRow) {
            $row = array();

			$row[] = $aRow['sysid'];
			$row[] = $aRow['job_no'];
			$row[] = $aRow['cpn_number'];
			$row[] = $aRow['cpn_name'];
			$row[] = $aRow['unit_name'];
			$row[] = $aRow['qty_kanban'];
			$row[] = $aRow['qty_packing'];
			$row[] = '<a href="javascript:void(0)" 
			             id="delete_kanban" 
			             data-toggle="tooltip" 
			             title="Delete" 
			             data-sysid="'.$aRow['sysid'].'" 
			             data-no_dn="'.$aRow['no_dn'].'" 
			             data-job_no="'.$aRow['job_no'].'" 
			             data-original-title="Delete" 
			             class="btn waves-effect waves-light btn-xs btn-danger delete_kanban">
			             	<i class="fa fa-trash"></i>
			          </a>';
			
			$output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function get_data_temp_tagok() {
		/* 
		 * Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('sysid', 'barcode_id_tag_ok', 'no_dn', 'job_no', 'cpn_number', 'cpn_name', 'unit_name', 'qty_packing');
        
        // DB table to use
		$sTable = $this->table_tmp_scantagok;
						
        $iDisplayStart 	= $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 	= $this->input->get_post('iSortCol_0', true);
        $iSortingCols 	= $this->input->get_post('iSortingCols', true);
        $sSearch 		= $this->input->get_post('sSearch', true);
        $sEcho 			= $this->input->get_post('sEcho', true);
    
        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if (isset($iSortCol_0)) {
            for ($i=0; $i<intval($iSortingCols); $i++) {
                $iSortCol 	= $this->input->get_post('iSortCol_'.$i, true);
                $bSortable 	= $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir 	= $this->input->get_post('sSortDir_'.$i, true);
    
                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch)) {
            for ($i=0; $i<count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
        }
        
        // Select Data
        $this->db->where('user_login', $this->session_nik);
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $rResult = $this->db->get($sTable);
    
        // Data set length after filtering        
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $this->db->where('user_login', $this->session_nik);
        $iTotal = $this->db->count_all($sTable);
    
        // Output
        $output = array(
            'sEcho' 				=> intval($sEcho),
            'iTotalRecords' 		=> $iTotal,
            'iTotalDisplayRecords' 	=> $iFilteredTotal,
            'aaData' 				=> array()
        );
				
        foreach ($rResult->result_array() as $aRow) {
            $row = array();

			$row[] = $aRow['sysid'];
			$row[] = $aRow['barcode_id_tag_ok'];
			$row[] = $aRow['job_no'];
			$row[] = $aRow['cpn_number'];
			$row[] = $aRow['cpn_name'];
			$row[] = $aRow['unit_name'];
			$row[] = $aRow['qty_packing'];
			$row[] = '<a href="javascript:void(0)" 
			             id="delete_tagok" 
			             data-toggle="tooltip" 
			             title="Delete" 
			             data-sysid="'.$aRow['sysid'].'" 
			             data-no_dn="'.$aRow['no_dn'].'"
			             data-job_no="'.$aRow['job_no'].'"
			             data-barcode_id_tag_ok="'.$aRow['barcode_id_tag_ok'].'"
			             data-original-title="Delete" 
			             class="btn waves-effect waves-light btn-xs btn-danger delete_tagok">
			             	<i class="fa fa-trash"></i>
			          </a>';
			
			$output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function datatable_sjhdr_list() {
        $list = $this->m_pulling->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sj) {
            $no++;
            $row = array();
            $row[] = $sj->SysId;
            $row[] = $no;
            $row[] = $sj->DN_Number;
            $row[] = $sj->SJ_Number;
            $row[] = date_format(new DateTime($sj->SJ_Date), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_pulling->count_all(),
                        "recordsFiltered" => $this->m_pulling->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    function delete_temp_dn() {
    	$sysid 		= $this->input->post('sysid');
    	$no_dn 		= $this->input->post('no_dn');

		$notifikasi = $this->m_pulling->delete_temp_dn($sysid);

		if ($notifikasi == 1) {
			$this->m_pulling->delete_all_temp_kanban($no_dn, $this->session_nik);
			$this->m_pulling->delete_all_temp_tagok($no_dn, $this->session_nik);
			$notifikasi = 'Delete data DN '.$no_dn.' berhasil';
		} else {
			$notifikasi = 'Delete data DN '.$no_dn.' gagal !!! <br> 
			               Kesalahan di prosedur DELETE DATA. Silahkan hubungi administrator';
		}

		echo json_encode(['success'=>$notifikasi]);
	}

	public function scan_dn() {
		$no_dn 			= $this->input->post('nomor_dn');		

		// $query_so_hdr = $this->m_pulling->scan_trx_outstanding_so_sj($no_dn); // Untuk live (dari oustanding)
		$query_so_hdr = $this->m_pulling->scan_trx_so_header($no_dn); // Untuk test (dari so header)
		if($query_so_hdr->num_rows() == 0) {
			echo json_encode(['dn_not_exist'=>'No. DN '.$no_dn.' belum dijadikan SO atau DN sudah dijadikan Surat Jalan atau DN tidak ada di database !!!']);

		} else {
			$query 		= $this->m_pulling->scan_temp_dn($no_dn, $this->session_nik);
			$num_rows 	= $query->num_rows();

			if($num_rows == 0) { // Belum ada di tabel temp
				$notifikasi = $this->m_pulling->insert_temp_dn($no_dn, $this->session_nik);
				if ($notifikasi == 1) {
					$notifikasi = 'Scan DN '.$no_dn.' berhasil';
					echo json_encode(['empty_success'=>$notifikasi]);
				} else {
					$notifikasi = 'Scan DN '.$no_dn.' gagal !!! <br>
					               Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator';
					echo json_encode(['empty_error'=>$notifikasi]);
				}			
			} elseif($num_rows > 0) { // Sudah ada di tabel temp
				echo json_encode(['exist'=>'No. DN '.$no_dn.' sudah discan di transaksi ini !!!']);
			}
		}
	}

	function delete_temp_kanban() {
    	$sysid 		= $this->input->post('sysid');
    	$no_dn 		= $this->input->post('no_dn');
    	$job_no		= $this->input->post('job_no');

		$notifikasi = $this->m_pulling->delete_temp_kanban($sysid);

		if ($notifikasi == 1) {
			$this->m_pulling->delete_temp_tagok_by_job_no($no_dn, $job_no, $this->session_nik);
			$notifikasi = 'Delete data Kanban dengan Job No '.$job_no.' berhasil';
		} else {
			$notifikasi = 'Delete data Kanban dengan Job No '.$job_no.' gagal !!! <br>
			               Kesalahan di prosedur DELETE DATA. Silahkan hubungi administrator';
		}

		echo json_encode(['success'=>$notifikasi]);
	}

	public function scan_kanban() {
		$no_dn 	= substr($this->input->post('nomor_kanban'), 0, 16);
		$job_no = substr($this->input->post('nomor_kanban'), 16, 7);

		$query_so_dtl = $this->m_pulling->scan_trx_so_detail($no_dn, $job_no);
		if($query_so_dtl->num_rows() == 0) {
			echo json_encode(['dn_not_exist'=>'No. DN '.$no_dn.' & Job No '.$job_no.' tidak ada di database !!!']);
		} else {
			$data_so_dtl 	= $query_so_dtl->row_array();
			$cpn_id 		= $data_so_dtl['CPN_Id'];
			$cpn_number 	= $data_so_dtl['CPN_Number'];
			$cpn_name 		= $data_so_dtl['CPN_Name'];
			$unit_id 		= $data_so_dtl['Unit_Id'];
			$unit_name 		= $data_so_dtl['Unit_Name'];
			$pn_id 			= $data_so_dtl['PN_Id'];
			$pn_number 		= $data_so_dtl['PN_Number'];
			$pn_name 		= $data_so_dtl['PN_Name'];

            /* qty kanban & packing dari master mysql */
            $query_mst_machine_part = $this->m_pulling->get_data_master_machine_part($cpn_number);
            if($query_mst_machine_part->num_rows() == 0) {
                $qty_kanban   = 0;
                $qty_packing  = 0;
            } else {
                $data_mst_machine_part = $query_mst_machine_part->row_array();
                $qty_kanban   = $data_mst_machine_part['qty_kanban'];
                $qty_packing  = $data_mst_machine_part['qty_packing'];
            }

            if(($qty_kanban == 0 || $qty_packing == 0)) {
                echo json_encode(['error_kanban_packing_0'=>'Qty kanban & qty packing belum disetting']);
            } else {
                $query_temp_kanban = $this->m_pulling->scan_temp_kanban($no_dn, $job_no, $this->session_nik);
                $num_rows = $query_temp_kanban->num_rows();

                if($num_rows == 0) { // Belum ada di tabel temp
                    $notifikasi = $this->m_pulling->insert_temp_kanban($no_dn, 
                                                                       $job_no, 
                                                                       $cpn_id,
                                                                       $cpn_number, 
                                                                       $cpn_name, 
                                                                       $unit_id, 
                                                                       $unit_name, 
                                                                       $pn_id,
                                                                       $pn_number, 
                                                                       $pn_name,
                                                                       $qty_kanban, 
                                                                       $qty_packing, 
                                                                       $this->session_nik);
                    if ($notifikasi == 1) {
                        $notifikasi = 'Scan Kanban berhasil';
                        echo json_encode(['empty_success'=>$notifikasi]);
                    } else {
                        $notifikasi = 'Scan Kanban gagal !!! <br> 
                                       Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator';
                        echo json_encode(['empty_error'=>$notifikasi]);
                    }           
                } elseif($num_rows > 0) { // Sudah ada di tabel temp
                    echo json_encode(['exist'=>'Kanban sudah discan !!!']);
                }
            }
		}
	}

	function delete_temp_tagok() {
    	$sysid 				= $this->input->post('sysid');
    	$barcode_id_tag_ok 	= $this->input->post('barcode_id_tag_ok');

		$notifikasi = $this->m_pulling->delete_temp_tagok($sysid);

		if ($notifikasi == 1) {
			$notifikasi = 'Delete data Tag OK '.$barcode_id_tag_ok.' berhasil';
		} else {
			$notifikasi = 'Delete data Tag OK '.$barcode_id_tag_ok.' gagal !!! <br> 
			               Kesalahan di prosedur DELETE DATA. Silahkan hubungi administrator';
		}

		echo json_encode(['success'=>$notifikasi]);
	}

	public function scan_tagok() {
		$nomor_tagok = $this->input->post('nomor_tagok');

		// Cek di tabel tmp dn, apakah sudah discan ?
		$query_data_tmp_dn = $this->m_pulling->get_data_temp_dn($this->session_nik);
		if($query_data_tmp_dn->num_rows() == 0) {
			echo json_encode(['no_dn_not_exist'=>'Nomor DN belum discan !!!']);
			return false;
		} else {
			$data_tmp_dn 	= $query_data_tmp_dn->row_array();
			$no_dn_kanban 	= $data_tmp_dn['no_dn'];
		}

		// Cek di tabel trx packing, apakah sudah dibuatkan Tag OK ?
		$query_trx_packing = $this->m_pulling->scan_trx_packing($nomor_tagok);
		if($query_trx_packing->num_rows() == 0) {
			echo json_encode(['tagok_not_exist'=>'Barcode Tag OK '.$nomor_tagok.' belum dibuat atau tidak ada di database !!!']);

		} else {
			$data_trx_packing = $query_trx_packing->row_array();
			$job_no_tagok = $data_trx_packing['job_no']; // Dapatkan job_no dari tabel trx packing
			$query_temp_kanban = $this->m_pulling->scan_temp_kanban($no_dn_kanban, $job_no_tagok, $this->session_nik);
			if($query_temp_kanban->num_rows() > 0) {
				$data_temp_kanban = $query_temp_kanban->row_array();
				$job_no_kanban 	= $data_temp_kanban['job_no']; // Dapatkan job_no dari tabel tmp kanban
				$cpn_id 		= $data_temp_kanban['cpn_id'];
				$cpn_number 	= $data_temp_kanban['cpn_number'];
				$cpn_name 		= $data_temp_kanban['cpn_name'];
				$unit_id		= $data_temp_kanban['unit_id'];
				$unit_name		= $data_temp_kanban['unit_name'];
				$pn_id 			= $data_temp_kanban['pn_id'];
				$pn_number 		= $data_temp_kanban['pn_number'];
				$pn_name 		= $data_temp_kanban['pn_name'];
				$qty_kanban 	= $data_temp_kanban['qty_kanban'];
				$qty_packing 	= $data_temp_kanban['qty_packing'];
			} else {
				$job_no_kanban 	= '';
				$cpn_id 		= '';
				$cpn_number 	= '';
				$cpn_name 		= '';
				$unit_id		= '';
				$unit_name		= '';
				$pn_id 			= '';
				$pn_number 		= '';
				$pn_name 		= '';
				$qty_kanban 	= 0;
				$qty_packing 	= 0;
			}

			// Bandingkan job no di tabel tmp kanban & di tabel tmp tag ok
			if($job_no_tagok !== $job_no_kanban) {
				echo json_encode(['job_no_not_match'=>'Job No di Tag OK ('.$job_no_tagok.') dan di Kanban tidak sama !!!']);
			} else {
				// Cek di tabel tmp tag ok
				$query_temp_tagok = $this->m_pulling->scan_temp_tagok($nomor_tagok, $no_dn_kanban, $job_no_tagok, $this->session_nik);
				$num_rows = $query_temp_tagok->num_rows();
				if($num_rows == 0) { // Belum ada di tabel temp
					$notifikasi = $this->m_pulling->insert_temp_tagok($nomor_tagok, 
																	  $no_dn_kanban, 
																	  $job_no_tagok, 
						                                              $cpn_id,
					 											      $cpn_number, 
					 											   	  $cpn_name, 
					 											   	  $unit_id, 
					 											      $unit_name, 
					 											      $pn_id,
					 											      $pn_number, 
					 											      $pn_name,
						                                              $qty_kanban, 
						                                              $qty_packing, 
						                                              $this->session_nik);
					if ($notifikasi == 1) {
						$notifikasi = 'Scan Tag OK '.$nomor_tagok.' berhasil';
						echo json_encode(['empty_success'=>$notifikasi]);
					} else {
						$notifikasi = 'Scan Tag OK '.$nomor_tagok.' gagal !!! <br> 
			                           Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator';
						echo json_encode(['empty_error'=>$notifikasi]);
					}			
				} elseif($num_rows > 0) { // Sudah ada di tabel temp
					echo json_encode(['exist'=>'Tag OK '.$nomor_tagok.' sudah discan !!!']);
				}
			}
		}
	}

	function create_sj() {
		$sj_date_post 	= $this->input->post('tgl_sj');
		$month1 		= date_format(new DateTime($sj_date_post), 'n');
		$month2 		= date_format(new DateTime($sj_date_post), 'm');
		$year2 			= date_format(new DateTime($sj_date_post), 'y');
		$year4 			= date_format(new DateTime($sj_date_post), 'Y');

		$no_dn = '';

		// 1. Cek kesesuaian antara qty total di tag ok dengan di kanban
		$query_get_data_temp_kanban = $this->m_pulling->get_data_temp_kanban($this->session_nik);
		if ($query_get_data_temp_kanban->num_rows() > 0) {
			foreach($query_get_data_temp_kanban->result() as $row) {
				$no_dn 			= $row->no_dn;
				$job_no 		= $row->job_no;
				$cpn_number 	= $row->cpn_number;
				$qty_kanban 	= $row->qty_kanban;
				$qty_packing 	= $row->qty_packing;

				$query_get_data_temp_tagok 	= $this->m_pulling->sum_qty_tag_ok($no_dn, $cpn_number, $this->session_nik);
				$data_temp_tagok 			= $query_get_data_temp_tagok->row_array();
				$qty_sum_packing 			= $data_temp_tagok['qty_packing'];

				if ($qty_kanban !== $qty_sum_packing) {
					echo json_encode(['qty_not_match'=>'Qty Kanban dan Tag OK tidak sama untuk CPN '.$cpn_number.'.<br> Qty Kanban : '.$qty_kanban.', Qty Packing : '.$qty_sum_packing]);
					return false;
				}
			}
		}

		$query_temp_dn = $this->m_pulling->scan_temp_dn($no_dn, $this->session_nik);
		if ($query_temp_dn->num_rows() == 0) {
			echo json_encode(['error_empty_dn'=>'Tidak ada data untuk diproses !!!']);
			return false;
		}

		// 2. Jika qty sama, lanjutkan dengan membuat surat jalan
		$this->load->library('sys');		

		// 3. Header
		// $this->conn_dwasys->trans_begin();
		$this->conn_dwasys_rescue->trans_begin();
		$new_sysid_header 	= $this->sys->last_sysid($this->config->item('TABLE_TRX_SURAT_JALAN_HDR')) + 1;
		$count_doc_number 	= $this->sys->last_doc_number($this->config->item('TRX_NAME_SURAT_JALAN'), $month1, $year4) + 1;
		$new_doc_number 	= 'SJ-'.$year2.'/'.$month2.'-'.substr('0000'.$count_doc_number, -4);
		$query_so_hdr 		= $this->m_pulling->scan_trx_so_header($no_dn);
		if($query_so_hdr->num_rows() > 0) {
			$data_so_hdr 	= $query_so_hdr->row_array();
			$data = array(
				'SysId'					=> $new_sysid_header,
				'SJ_Number' 			=> $new_doc_number,
				'SJ_Rev'				=> 0,
				'SJ_Date'				=> date_format(new DateTime($sj_date_post), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Exec_Date'				=> date_format(new DateTime($sj_date_post), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'SO_Id'					=> $data_so_hdr['SysId'],
				'SO_Number'				=> $data_so_hdr['SO_Number'],
				'SO_Rev'				=> $data_so_hdr['SO_Rev'],
				'SO_Date' 				=> $data_so_hdr['SO_Date'],
				'PO_Number' 			=> $data_so_hdr['PO_Number'],
				'PO_Date' 				=> $data_so_hdr['PO_Date'],
				'DN_Number' 			=> $data_so_hdr['DN_Number'],
				'DN_Date' 				=> $data_so_hdr['DN_Date'],
				'Customer_Id' 			=> $data_so_hdr['Customer_Id'],
				'Customer_Code' 		=> $data_so_hdr['Customer_Code'],
				'Customer_Name' 		=> $data_so_hdr['Customer_Name'],
				'CustomerAddress_Id' 	=> $data_so_hdr['CustomerAddress_Id'],
				'Customer_Address' 		=> $data_so_hdr['Customer_Address'],
				'Approve' 				=> 0,
				'MainFolder_Id' 		=> $data_so_hdr['SysId'],
				'Trigger_Id' 			=> $data_so_hdr['SysId'],
				'Rec_UserId' 			=> $this->session_nik,
				'Rec_LastDate' 			=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
				'Rec_LastTime' 			=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TIME_TO_INSERT'))
			);
	        // $this->conn_dwasys->insert($this->table_trx_sj_hdr, $data);
	        $this->conn_dwasys_rescue->insert($this->table_trx_sj_hdr, $data);
		}

		// 4. Detail
		$sql = "SELECT
					cpn_id,
					cpn_number,
					cpn_name,
					job_no,
					unit_id,
					unit_name,
					pn_id,
					pn_number,
					pn_name,
					SUM(qty_packing) AS qty
				FROM
					".$this->table_tmp_scantagok."
				WHERE
					no_dn = '".$no_dn."'
					AND user_login = '".$this->session_nik."'
			  	GROUP BY
					cpn_id,
					cpn_number,
					cpn_name,
					job_no,
					unit_id,
					unit_name,
					pn_id,
					pn_number,
					pn_name";
		$query_detail = $this->db->query($sql);
		if ($query_detail->num_rows() > 0) {
			foreach($query_detail->result() as $row) {
				$new_sysid_detail = $this->sys->last_sysid($this->config->item('TABLE_TRX_SURAT_JALAN_DTL')) + 1;
				$data = array(
					'SysId'					=> $new_sysid_detail,
					'SysId_Hdr' 			=> $new_sysid_header,
					'CPN_Id'				=> $row->cpn_id,
					'CPN_Number'			=> $row->cpn_number,
					'CPN_Name'				=> $row->cpn_name,
					'Job_No'				=> $row->job_no,
					'Unit_Id'				=> $row->unit_id,
					'Unit_Name'				=> $row->unit_name,
					'PN_Id'					=> $row->pn_id,
					'PN_Number'				=> $row->pn_number,
					'PN_Name'				=> $row->pn_name,
					'Qty'					=> $row->qty,
					'Rec_UserId' 			=> $this->session_nik,
					'Rec_LastDate' 			=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
					'Rec_LastTime' 			=> date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TIME_TO_INSERT'))
				);
		        // $this->conn_dwasys->insert($this->table_trx_sj_dtl, $data);
		        $this->conn_dwasys_rescue->insert($this->table_trx_sj_dtl, $data);
			}
		}

		/*if ($this->conn_dwasys->trans_status() === FALSE) {
        	$this->conn_dwasys->trans_rollback();*/
        if ($this->conn_dwasys_rescue->trans_status() === FALSE) {
        	$this->conn_dwasys_rescue->trans_rollback();
        	echo json_encode(['error_rollback'=>'Rollback Transaction']);
		} else {
        	// $this->conn_dwasys->trans_commit();
        	$this->conn_dwasys_rescue->trans_commit();
        	$this->m_pulling->delete_all_temp_dn($no_dn, $this->session_nik);
			$this->m_pulling->delete_all_temp_kanban($no_dn, $this->session_nik);
			$this->m_pulling->delete_all_temp_tagok($no_dn, $this->session_nik);
        	echo json_encode(['success'=>'Create Surat Jalan berhasil', 'success_message'=>'Nomor Surat Jalan : '.$new_doc_number]);
		}		
	}

}
