<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class complaint_list extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_list');
	}

	public function index() {
		$data = array(
			'title' => 'Complaint Problem Monitoring',
			'page_title' => '<i class="icon-screen-desktop"></i> Complaint Problem Monitoring',
			'active_menu_root' => 'complaint_problem',
			'active_menu_child' => 'complaint_list',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item">Complaint Problem</li>
							 <li class="breadcrumb-item active">Complaint Problem Monitoring</li>',
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."complaint_list.js type='text/javascript'></script>"
		);
		$this->template->view('v_complaint_list', $data);
	}
	
	public function ajax_list() {
		$status = $this->input->post('status');
		
        $list = $this->m_complaint_list->get_datatables();
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
			$row[] = $complaints->remark_status;
			if ($complaints->status == $this->config->item('STATUS_COMPLAINT_OPEN')) {
				$row[] = "<span class='badge badge-custom'>".$complaints->status_desc."</span>";
				$row[] = date_format(new DateTime($complaints->doc_date), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
			} else if ($complaints->status == $this->config->item('STATUS_COMPLAINT_ONPROGRESS')) {
				$row[] = "<span class='badge badge-warning'>".$complaints->status_desc."</span>";
				$row[] = date_format(new DateTime($complaints->progress_datetime), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
			} else if ($complaints->status == $this->config->item('STATUS_COMPLAINT_CLOSED')) {
				$row[] = "<span class='badge badge-success'>".$complaints->status_desc."</span>";
				$row[] = date_format(new DateTime($complaints->closed_datetime), $this->config->item('FORMAT_DATE_TO_DISPLAY'));
			} else {
				$row[] = "";
				$row[] = "";
			}			
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_complaint_list->count_all(),
                        "recordsFiltered" => $this->m_complaint_list->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

}
