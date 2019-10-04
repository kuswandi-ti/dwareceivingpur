<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class complaint_close extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = array(
			'title' => 'Complaint Problem Close',
			'page_title' => '',
			'active_menu_root' => '',
			'active_menu_child' => '',
			'breadcrumb' => '',
			'custom_scripts' => ""
		);
		$this->template->view('v_complaint_close', $data);
	}

}
