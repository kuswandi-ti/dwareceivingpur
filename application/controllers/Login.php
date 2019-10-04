<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_login');
	}

	public function index() {
		$this->auth->restrict_login();
		$data = array(
			'title' => 'Login',
			'page_title' => 'Login',
			'breadcrumb' => '',
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."login.js type='text/javascript'></script>"
		);
		$this->load->view('v_login', $data);
	}

	public function do_login(){
		$nik = $this->input->post('nik');

		$this->form_validation->set_rules('nik', 'NIK', 'required');

		if ($this->form_validation->run() == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error'=>$errors]);
		} else {
			$query = $this->m_login->login($nik);			
			if ($query->num_rows() == 0) {
				echo json_encode(['error'=>'NIK belum terdaftar di sistem']);
			} else {
				// https://codeigniter.com/user_guide/database/results.html?highlight=stdclass%20object#custom-result-objects
				$data = $query->row_array();
				$session_data = array(
					'sess_nik'		=> $data['NIK'],
					'sess_nama'	    => $data['Nama'],
					'sess_dept'		=> $data['Dept'],
					'sess_pulling'	=> $data['Pulling_GP'],
					'sess_loading'	=> $data['Loading_GP'],
				);
				$this->session->set_userdata($session_data);
				echo json_encode(['success'=>'Login sukses']);
			}
		}		
	}

	public function logout() {
        $this->session->sess_destroy();
    }

}
