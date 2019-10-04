<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loading extends CI_Controller {

	private $conn_dwasys;
	private $conn_name_dwasys;

	private $table_mst_truk;
	private $table_mst_supir;	
	private $table_trx_loading;

	private $session_nik;

	public function __construct() {
		parent::__construct();

		$this->auth->restrict();
		$this->load->model('m_loading');

		$this->conn_name_dwasys 	= $this->config->item('CONN_NAME_DWASYS');
		$this->conn_dwasys 			= $this->load->database($this->conn_name_dwasys, TRUE);

		$this->table_mst_truk 		= $this->config->item('TABLE_MST_VEHICLE');
		$this->table_mst_supir 		= $this->config->item('TABLE_MST_DRIVER');
		$this->table_trx_loading 	= $this->config->item('TABLE_TRX_LOADING');

		$this->session_nik 			= $this->session->userdata('sess_nik');
	}

	public function index() {
		$data = array(
			'title' 			=> 'Proses Loading',
			'page_title' 		=> 'Proses Loading',
			'breadcrumb' 		=> '<li class="breadcrumb-item"><i class="ti-home"></i><a href="home"> Home</a></li>
							 	    <li class="breadcrumb-item active"><i class="ti-truck"></i> Proses Loading</li>',
			'custom_scripts' 	=> "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."loading.js type='text/javascript'></script>"
		);
		$this->template->view('v_loading', $data);
	}

	public function datatable_truk_list() {
        $list 	= $this->m_loading->get_datatables_truk();
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($list as $truks) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $truks->Vehicle_Num;
            $row[] = $truks->Armada_Name;
            $row[] = '<a href="javascript:void(0)" 
			             id="select_vehicle" 
			             data-toggle="tooltip" 
			             title="Select Vehicle" 
			             data-vehicle-num="'.$truks->Vehicle_Num.'" 
			             data-armada-name="'.$truks->Armada_Name.'" 
			             data-original-title="Select Vehicle" 
			             class="btn waves-effect waves-light btn-xs btn-danger">
			             	Pilih
			          </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_loading->count_all_truk(),
                        "recordsFiltered" => $this->m_loading->count_filtered_truk(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatable_supir_list() {	
        $list 	= $this->m_loading->get_datatables_supir();
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($list as $supirs) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $supirs->NIK;
            $row[] = $supirs->Driver_Name;
            $row[] = '<a href="javascript:void(0)" 
			             id="select_driver" 
			             data-toggle="tooltip" 
			             title="Select Driver" 
			             data-nik="'.$supirs->NIK.'" 
			             data-driver-name="'.$supirs->Driver_Name.'"
			             data-original-title="Select Driver" 
			             class="btn waves-effect waves-light btn-xs btn-danger">
			             	Pilih
			          </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_loading->count_all_supir(),
                        "recordsFiltered" => $this->m_loading->count_filtered_supir(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatable_dn_list() {
    	$sysid 	= $this->input->post('sysid');
        $list 	= $this->m_loading->get_datatables_dn($sysid);
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($list as $dns) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dns->DN_Num;
            $row[] = $dns->CPN;
            $row[] = $dns->CPName;
            $row[] = $dns->Unit;
            $row[] = $dns->Qty;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_loading->count_all_dn($sysid),
                        "recordsFiltered" => $this->m_loading->count_filtered_dn($sysid),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function scan_dn() {
		$no_dn 			= $this->input->post('dn_adm');
		$vehicle_num 	= $this->input->post('vehicle_num');
		$vehicle_comp 	= $this->input->post('armada_name');
		$driver_name 	= $this->input->post('driver_name');
		
		$query_sj_hdr = $this->m_loading->scan_trx_sj_header($no_dn);
		if($query_sj_hdr->num_rows() == 0) {
			echo json_encode(['dn_not_exist'=>'No. DN '.$no_dn.' belum dijadikan SJ atau DN tidak ada di database !!!']);
		} else {
			$query_os_sj_loading 	= $this->m_loading->scan_trx_outstanding_sj_loading($no_dn);
			$num_rows 				= $query_os_sj_loading->num_rows();
			if($num_rows == 0) {
				echo json_encode(['dn_not_os'=>'No. DN '.$no_dn.' sudah discan Loading di transaksi lain !!!']);
			} else {				
				$this->load->library('sys');
				$new_sysid = $this->sys->last_sysid($this->config->item('TRX_NAME_LOADING')) + 1;
				$this->conn_dwasys->trans_begin();
				foreach($query_os_sj_loading->result() as $row) {
					$this->m_loading->insert_loading(
						$new_sysid,
						$row->DN_Number,
						date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
						date_format(new DateTime('now'), $this->config->item('FORMAT_TIME_TO_INSERT')),
						$vehicle_num,
						$vehicle_comp,
						$driver_name,
						$row->CPN_Number,
						$row->CPN_Name,
						$row->Unit_Name,
						$row->Qty_Balance,
						$row->Customer_Code,
						$new_sysid,
						$this->session_nik,
						date_format(new DateTime('now'), $this->config->item('FORMAT_DATE_TO_INSERT')),
						date_format(new DateTime('now'), $this->config->item('FORMAT_TIME_TO_INSERT'))
					);
			    }
				
				if ($this->conn_dwasys->trans_status() === FALSE) {
		        	$this->conn_dwasys->trans_rollback();
		        	echo json_encode(['error_rollback'=>'Rollback Transaction']);
				} else {
		        	$this->conn_dwasys->trans_commit();
		        	echo json_encode(['success'=>'Create Dokumen Loading berhasil', 'sysid'=>$new_sysid]);
				}
			}
		}
	}

}
