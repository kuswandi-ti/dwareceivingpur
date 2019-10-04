<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instruksi_kerja extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_input');
	}

	public function index() {
		$data = array(
			'title' => 'Instruksi Kerja Program',
			'page_title' => '<i class="icon-book-open"></i> Instruksi Kerja Program',
			'active_menu_root' => 'intruksikerja',
			'active_menu_child' => 'intruksikerja',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
							 <li class="breadcrumb-item active">Instruksi Kerja Program</li>',
			'get_data' => $this->m_complaint_input->get_data_ik(),
			'custom_scripts' => ""
		);
		$this->template->view('v_ik', $data);
	}
}
