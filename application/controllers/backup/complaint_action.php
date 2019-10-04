<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class complaint_action extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_action');
	}

	public function index() {
		$data = array(
			'title' => 'Complaint Action',
			'page_title' => '<i class="icon-cursor"></i> Complaint Action',
			'active_menu_root' => '',
			'active_menu_child' => '',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item">Complaint Problem</li>
							 <li class="breadcrumb-item active">Complaint Action</li>',
			'get_data_mis_person' => $this->m_complaint_action->get_data_mis_person(),
			'get_data_kategori_problem' => $this->m_complaint_action->get_data_kategori_problem(),
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."complaint_action.js type='text/javascript'></script>"
		);
		$this->template->view('v_complaint_action', $data);
	}
	
	public function ajax_list() {
        $list = $this->m_complaint_action->get_datatables();
        $data = array();
        $no = $_POST['start'];
		
        foreach ($list as $complaints) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='".$complaints->image_filename."' target='_blank'>".$complaints->doc_no."</a>";
            $row[] = date_format(new DateTime($complaints->doc_date), $this->config->item('FORMAT_DATE_TO_DISPLAY')).'<br />'.$complaints->doc_time;
            $row[] = $complaints->department_code;
            $row[] = $complaints->username;
			$row[] = $complaints->no_ext;
			if ($complaints->group_type == $this->config->item('INIT_COMPLAINT_APPLICATION')) {
				$row[] = '<li><b>Application / Program :</b> '.$complaints->ca_aplication_program.'</li>
						  <li><b>Problem Description :</b> '.$complaints->ca_problem_desc.'</li>';
			} else if ($complaints->group_type == $this->config->item('INIT_COMPLAINT_HARDWARE')) {
				$row[] = '<li><b>Computer Name :</b> '.$complaints->ch_computername.'</li>
				          <li><b>Problem Description :</b> '.$complaints->ch_problem_desc.'</li>';
			} else if ($complaints->group_type == $this->config->item('INIT_COMPLAINT_EMAIL')) {
				$row[] = '<li><b>Email Account :</b> '.$complaints->ce_accountemail.'</li>
				          <li><b>Problem Description :</b> '.$complaints->ce_problem_desc.'</li>';
			} else {
				$row[] = '';
			}            
            $row[] = $complaints->mis_person_name;
			$row[] = $complaints->menu_folder; // 8
			if ($complaints->status == $this->config->item('STATUS_COMPLAINT_OPEN')) {
				$row[] = "<span class='badge badge-info'>".$complaints->status_desc."</span>";
				$row[] = "";
				$row[] = "";
				$row[] = "
							<div class='btn-group'>
								<button type='button' class='btn btn-purple dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
									Actions
									<span class='caret'></span>
								</button>
								<div class='dropdown-menu'>
									<a class='dropdown-item receive' href='#modal_receive' data-id=".$complaints->sysid." data-toggle='modal' data-target='#modal_receive'><i class='fa fa-thumbs-up'></i> Receive</a>
								</div>
							</div>
				";
			} else if ($complaints->status == $this->config->item('STATUS_COMPLAINT_ONPROGRESS')) {
				$row[] = "<span class='badge badge-warning'>".$complaints->status_desc."</span>";
				$row[] = "";
				$row[] = "";
				$row[] = "
							<div class='btn-group'>
								<button type='button' class='btn btn-purple dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
									Actions
									<span class='caret'></span>
								</button>
								<div class='dropdown-menu'>
									<a class='dropdown-item closed' href='#modal_closed' data-id=".$complaints->sysid." data-toggle='modal' data-target='#modal_closed'><i class='fa fa-window-close'></i> Closed</a>
								</ul>
							</div>
				";
			} else if ($complaints->status == $this->config->item('STATUS_COMPLAINT_CLOSED')) {
				$row[] = "<span class='badge badge-success'>".$complaints->status_desc."</span>";
				$row[] = $complaints->remark_status;
				$row[] = $complaints->nama_kategori_problem;
				$row[] = "<span class='badge badge-primary'>No Action</span>";
			} else {
				$row[] = "";
			}
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_complaint_action->count_all(),
                        "recordsFiltered" => $this->m_complaint_action->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
	
	function update_complaint() {
		$sysid = $this->input->post('sysid');
		$mis_person_id = $this->input->post('mis_person_id');
		
		$data = array(
			'status'				=> $this->config->item('STATUS_COMPLAINT_ONPROGRESS'),
			'mis_person_id'			=> $mis_person_id,
			'progress_datetime'		=> $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT')
		);
		$this->db->update($this->config->item('TABLE_COMPLAINT_PROBLEM'), $data, array('sysid' => $sysid));
	}
	
	function closed_complaint() {
		$sysid = $this->input->post('sysid');
		$kategori_problem_id = $this->input->post('kategori_problem_id');
		$remark_status = $this->input->post('remark_status');
		
		$data = array(
			'status'				=> $this->config->item('STATUS_COMPLAINT_CLOSED'),
			'remark_status'			=> $remark_status,
			'closed_datetime'		=> $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
			'kategori_problem_id'	=> $kategori_problem_id
		);
		$this->db->update($this->config->item('TABLE_COMPLAINT_PROBLEM'), $data, array('sysid' => $sysid));
	}
	
	/* https://stackoverflow.com/questions/18802531/how-to-get-a-row-from-database-using-ajax-in-codeigniter */
	function count_complaint_open() {
		//$this->session->sess_destroy();
		$this->m_complaint_action->get_count_complaint_open();
	}

}
