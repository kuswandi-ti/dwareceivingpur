<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('m_home');
	}

	public function index() {
		$data = array(
			'title' => 'Home',
			'page_title' => '<i class="icon-speedometer"></i> Dashboard',
			'active_menu_root' => 'home',
			'active_menu_child' => '',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item active">Dashboard</li>',
			'count_complaint_all' => $this->m_home->count_complaint_all(),
			'count_complaint_open' => $this->m_home->count_complaint_status($this->config->item('STATUS_COMPLAINT_OPEN')),
			'count_complaint_on_progress' => $this->m_home->count_complaint_status($this->config->item('STATUS_COMPLAINT_ONPROGRESS')),
			'count_complaint_close' => $this->m_home->count_complaint_status($this->config->item('STATUS_COMPLAINT_CLOSED')),
			'count_uar_all' => $this->m_home->count_uar_all(),
			'count_uar_not_yet_start' => $this->m_home->count_uar_status($this->config->item('STATUS_UAR_NOT_YET_START')),
			'count_uar_on_progress' => $this->m_home->count_uar_status($this->config->item('STATUS_UAR_ON_PROGRESS')),
			'count_uar_finish' => $this->m_home->count_uar_status($this->config->item('STATUS_UAR_FINISH')),
			'detail_uar_not_yet_start' => $this->m_home->dashboard_info_uar($this->config->item('STATUS_UAR_NOT_YET_START')),
			'detail_uar_on_progress' => $this->m_home->dashboard_info_uar($this->config->item('STATUS_UAR_ON_PROGRESS')),
			'detail_uar_finish' => $this->m_home->dashboard_info_uar($this->config->item('STATUS_UAR_FINISH')),
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."home.js type='text/javascript'></script>"
		);
		$this->template->view('v_home', $data);
	}
	
	/*public function get_data_persentase_app() {
		echo json_encode($this->m_home->get_data_persentase_app());
	}*/
	
	/*public function get_data_grafik_uar() {
		print json_encode($this->m_home->get_data_grafik_uar());
	}*/

}
