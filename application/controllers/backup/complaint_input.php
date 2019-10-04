<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class complaint_input extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_input');
	}

	public function index() {
		$data = array(
			'title' => 'Create New Complaint Problem',
			'page_title' => '<i class="icon-plus"></i> Create New Complaint Problem',
			'active_menu_root' => 'complaint_problem',
			'active_menu_child' => 'complaint_input',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item">Complaint Problem</li>
							 <li class="breadcrumb-item active">Create New Complaint Input</li>',
			'get_data_department' => $this->m_complaint_input->get_data_department(),
			'get_data_pc_laptop_name' => $this->m_complaint_input->get_data_pc_laptop_name(),
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."complaint_input.js type='text/javascript'></script>"
		);
		$this->template->view('v_complaint_input', $data);
	}

	function get_modul($menu_group) {
		$this->m_complaint_input->get_modul($menu_group);
	}

	function create_complaint() {
		$doc_date_post = $this->input->post('txtcomplaintdate_all');
		$doc_date = date_format(new DateTime($doc_date_post), $this->config->item('FORMAT_DATE_TO_INSERT'));
		$month2 = date_format(new DateTime($doc_date_post), 'm');
		$month1 = date_format(new DateTime($doc_date_post), 'n');
		$year4 = date_format(new DateTime($doc_date_post), 'Y');
		$year2 = date_format(new DateTime($doc_date_post), 'y');

		$doc_time = $this->input->post('txtcomplainttime_all');
		$department_id = $this->input->post('cbodepartment_all');
		$department_code = $this->input->post('cbodepartmentcode_all');
		$username = $this->input->post('txtusername_all');
		$no_ext = $this->input->post('txtnoext_all');
		
		$group_type = $this->input->post('rdogroup_all');
		
		$last_doc_number = create_doc_number($this->config->item('TRX_NAME_COMPLAINT_PROBLEM'),
		                                     $month1,
											 $year4,
											 $department_id) + 1;
		$doc_no = $group_type.'-'.
				  $department_code.'-'.
				  $year2.$month2.substr('0000'.$last_doc_number, -4); // CA-MIS-YYMMXXXX

		$ca_application = $this->input->post('cboapplication_ca');
		$ca_modul_id = $this->input->post('cbomodul_ca');
		$ca_problem_desc = $this->input->post('txtproblemdescription_ca');		

		$ch_computername = $this->input->post('cbocomputername_ch');
		$ch_problem_desc = $this->input->post('txtproblemdescription_ch');

		$ce_accountemail = $this->input->post('txtaccountemail_ce');
		$ce_problem_desc = $this->input->post('txtproblemdescription_ce');		

		$rec_createdate = $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT');

		if ($group_type == $this->config->item('INIT_COMPLAINT_APPLICATION')) {
			$file_name_ca = $_FILES['file_ca']['name'];
			$array_var_ca = explode(".", $file_name_ca);
			$file_ext_ca = end($array_var_ca);
			$file_tmp_ca = $_FILES['file_ca']['tmp_name'];
			$new_file_ca = $this->config->item('PATH_ASSET_IMAGE_COMPLAINT_PROBLEM').$file_name_ca;
			$rename_file_ca = $this->config->item('PATH_ASSET_IMAGE_COMPLAINT_PROBLEM').$doc_no.".".$file_ext_ca;
			move_uploaded_file($file_tmp_ca, $new_file_ca);
			rename($new_file_ca, $rename_file_ca);
			$data = array(
				'doc_no'				=> $doc_no,
				'doc_date'				=> $doc_date,
				'doc_time'				=> $doc_time,
				'department_id'			=> $department_id,
				'username'				=> $username,
				'no_ext'				=> $no_ext,
				'group_type'			=> $group_type,
				'ca_application'		=> $ca_application,
				'ca_modul_id'			=> $ca_modul_id,
				'ca_problem_desc'		=> $ca_problem_desc,
				'ca_filename'			=> $rename_file_ca,
				'rec_createdate'		=> $rec_createdate
			);
		} else if ($group_type == $this->config->item('INIT_COMPLAINT_HARDWARE')) {
			$data = array(
				'doc_no'				=> $doc_no,
				'doc_date'				=> $doc_date,
				'doc_time'				=> $doc_time,
				'department_id'			=> $department_id,
				'username'				=> $username,
				'no_ext'				=> $no_ext,
				'group_type'			=> $group_type,
				'ch_computername'		=> $ch_computername,
				'ch_problem_desc'		=> $ch_problem_desc,
				'rec_createdate'		=> $rec_createdate
			);
		} else if ($group_type == $this->config->item('INIT_COMPLAINT_EMAIL')) {
			$file_name_ce = $_FILES['file_ce']['name'];
			$array_var_ce = explode(".", $file_name_ce);
			$file_ext_ce = end($array_var_ce);
			$file_tmp_ce = $_FILES['file_ce']['tmp_name'];
			$new_file_ce = $this->config->item('PATH_ASSET_IMAGE_COMPLAINT_PROBLEM').$file_name_ce;
			$rename_file_ce = $this->config->item('PATH_ASSET_IMAGE_COMPLAINT_PROBLEM').$doc_no.".".$file_ext_ce;
			move_uploaded_file($file_tmp_ce, $new_file_ce);
			rename($new_file_ce, $rename_file_ce);
			$data = array(
				'doc_no'				=> $doc_no,
				'doc_date'				=> $doc_date,
				'doc_time'				=> $doc_time,
				'department_id'			=> $department_id,
				'username'				=> $username,
				'no_ext'				=> $no_ext,
				'group_type'			=> $group_type,
				'ce_accountemail'		=> $ce_accountemail,
				'ce_problem_desc'		=> $ce_problem_desc,
				'ca_filename'			=> $rename_file_ce,
				'rec_createdate'		=> $rec_createdate
			);
		}
		$this->db->insert($this->config->item('TABLE_COMPLAINT_PROBLEM'), $data);

		$data['doc_no'] = $doc_no;
		echo json_encode($data);
	}

}
