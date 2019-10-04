<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class monitoring_uar extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_monitoring_uar');
	}

	public function index() {
		$data = array(
			'title' => 'Monitoring User Application Request (UAR)',
			'page_title' => '<i class="icon-screen-desktop"></i> Monitoring User Application Request (UAR)',
			'active_menu_root' => 'monitoring_uar',
			'active_menu_child' => '',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item active">Monitoring UAR</li>',
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."monitoring_uar.js type='text/javascript'></script>"
		);
		$this->template->view('v_monitoring_uar', $data);
	}
	
	public function ajax_list() {
		$status = $this->input->post('status');
		
        $list = $this->m_monitoring_uar->get_datatables();
        $data = array();
        $no = $_POST['start'];
		
        foreach ($list as $uar) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $uar->Doc_Num;
            $row[] = $uar->User_Nama;
            $row[] = $uar->User_Dept;
			
			if ($uar->Status == $this->config->item('STATUS_UAR_NOT_YET_START')) {
				$row[] = is_null($uar->Tgl_Permohonan) ? '' : date_format(new DateTime($uar->Tgl_Permohonan), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_ReqFinish) ? '' : date_format(new DateTime($uar->Tgl_ReqFinish), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_Kesanggupan) ? '' : date_format(new DateTime($uar->Tgl_Kesanggupan), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = $uar->Keterangan;
				$row[] = $uar->Programmer;
				
			} else if ($uar->Status == $this->config->item('STATUS_UAR_ON_PROGRESS')) {
				$row[] = is_null($uar->Tgl_Permohonan) ? '' : date_format(new DateTime($uar->Tgl_Permohonan), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_ReqFinish) ? '' : date_format(new DateTime($uar->Tgl_ReqFinish), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_Kesanggupan) ? '' : date_format(new DateTime($uar->Tgl_Kesanggupan), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = $uar->Keterangan;
				$row[] = $uar->Programmer;
				$row[] = is_null($uar->Tgl_OnProgress) ? '' : date_format(new DateTime($uar->Tgl_OnProgress), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				
			} else if ($uar->Status == $this->config->item('STATUS_UAR_FINISH')) {
				$row[] = is_null($uar->Tgl_Permohonan) ? '' : date_format(new DateTime($uar->Tgl_Permohonan), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_ReqFinish) ? '' : date_format(new DateTime($uar->Tgl_ReqFinish), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_Kesanggupan) ? '' : date_format(new DateTime($uar->Tgl_Kesanggupan), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = $uar->Keterangan;
				$row[] = $uar->Programmer;
				$row[] = is_null($uar->Tgl_OnProgress) ? '' : date_format(new DateTime($uar->Tgl_OnProgress), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = is_null($uar->Tgl_Finish) ? '' : date_format(new DateTime($uar->Tgl_Finish), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
				$row[] = $uar->Tot_Finish;
				if ($uar->Implementasi == 'Belum') {
					$row[] = '<span class="badge badge-danger">'.$uar->Implementasi.'</span>';
				} else if ($uar->Implementasi == 'Sudah') {
					$row[] = '<span class="badge badge-primary">'.$uar->Implementasi.'</span>';
				} else {
					$row[] = '';
				}				
			}
			
			/*if ($uar->Status == $this->config->item('STATUS_UAR_NOT_YET_START')) {
				$row[] = "<span class='badge badge-custom'>".$uar->Status."</span>";
			} else if ($uar->Status == $this->config->item('STATUS_UAR_ON_PROGRESS')) {
				$row[] = "<span class='badge badge-warning'>".$uar->Status."</span>";
			} else if ($uar->Status == $this->config->item('STATUS_UAR_FINISH')) {
				$row[] = "<span class='badge badge-success'>".$uar->Status."</span>";
			} else {
				$row[] = "";
			}
			if ($uar->Implementasi == 'Belum') {
				$row[] = "<span class='badge badge-danger'>".$uar->Implementasi."</span>";
			} else if ($uar->Implementasi == 'Sudah') {
				$row[] = "<span class='badge badge-primary'>".$uar->Implementasi."</span>";
			} else {
				$row[] = "";
			}*/
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_monitoring_uar->count_all(),
                        "recordsFiltered" => $this->m_monitoring_uar->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

}
