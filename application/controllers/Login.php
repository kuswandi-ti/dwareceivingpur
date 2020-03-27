<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_login');		
	}

	public function index() {
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
				echo json_encode(['error'=>'NIK belum terdaftar di sistem / NIK tidak terdaftar dari department PUR']);
			} else {
				// https://codeigniter.com/user_guide/database/results.html?highlight=stdclass%20object#custom-result-objects
				$data = $query->row_array();
				$session_data = array(
					'sess_nik_receivingpur'			=> $data['NIK'],
					'sess_nama_receivingpur'		=> $data['Nama'],
					'sess_nama_init_receivingpur'	=> $data['Nama_Init'],
					'sess_dept_receivingpur'		=> $data['Dept'],
					'sess_dept_code_receivingpur'	=> $data['Dept_Code'],
					'sess_dept_alias_receivingpur'	=> $data['Dept_Alias'],
				);
				$this->session->set_userdata($session_data);
				echo json_encode(['success'=>'Login sukses']);
			}
		}		
	}

	public function logout() {
        //$this->session->sess_destroy();
        $array_items = array('sess_nik_receivingpur', 'sess_nama_receivingpur', 'sess_nama_init_receivingpur', 'sess_dept_receivingpur', 'sess_dept_code_receivingpur', 'sess_dept_alias_receivingpur');
        $this->session->unset_userdata($array_items);
    }

}
