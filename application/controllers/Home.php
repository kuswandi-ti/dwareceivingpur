<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->auth->restrict();		
	}

	public function index() {
		$data = array(
			'title' => 'Home',
			'page_title' => 'Home',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="ti-home"></i><a href="home"> Home</a></li>
							 <li class="breadcrumb-item active"><i class="ti-desktop"></i> Dashboard</li>',
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."home.js type='text/javascript'></script>",
		);
		$this->template->view('v_home', $data);
	}

}
