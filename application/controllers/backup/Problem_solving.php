<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Problem_solving extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_input');
	}

	public function index() {
		$data = array(
			'title' => 'Problem Solving',
			'page_title' => '<i class="icon-tag"></i> Problem Solving',
			'active_menu_root' => 'problem_solving',
			'active_menu_child' => 'problem_solving',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
							 <li class="breadcrumb-item active">Problem Solving</li>',
			'get_data' => $this->m_complaint_input->get_data_ps(),
			'custom_scripts' => ""
		);
		$this->template->view('v_ps', $data);
	}
}
