<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_complaint_action extends CI_Model {
	
	var $column_order 		= array(null, 'doc_no', 'doc_date', 'doc_time', 'department_code', 
									'department_name', 'username', 'no_ext', 'group_type', 'ca_application',
									'menu_group', 'menu_l1', 'menu_l2', 'menu_exe', 'menu_folder',
									'ca_problem_desc', 'ch_computername', 'ch_problem_desc',
									'ce_accountemail', 'ce_problem_desc', 'status_desc', 'remark_status',
									'kategori_problem_id', 'nama_kategori_problem', 'image_filename', 
									'rec_createdate');
    var $column_search 		= array('doc_no', 'doc_date', 'doc_time', 'department_code', 
									'department_name', 'username', 'no_ext', 'group_type', 'ca_application',
									'menu_group', 'menu_l1', 'menu_l2', 'menu_exe', 'menu_folder',
									'ca_problem_desc', 'ch_computername', 'ch_problem_desc',
									'ce_accountemail', 'ce_problem_desc', 'status_desc', 'remark_status',
									'kategori_problem_id', 'nama_kategori_problem', 'image_filename', 
									'rec_createdate');
    var $order 				= array('rec_createdate' => 'desc');

	private function _get_datatables_query() { 
        $status = $this->input->post('status');
		if ($status == 'OPEN') {
			$this->db->from($this->config->item('VIEW_COMPLAINT_PROBLEM'))
			         ->where('status', $this->config->item('STATUS_COMPLAINT_OPEN'))
					 ->or_where('status', $this->config->item('STATUS_COMPLAINT_ONPROGRESS'));
		} else if ($status == 'CLOSED') {
			$this->db->from($this->config->item('VIEW_COMPLAINT_PROBLEM'))
			         ->where('status', $this->config->item('STATUS_COMPLAINT_CLOSED'));
		}
		
        $i = 0;
     
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
                if($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all() {
        $status = $this->input->post('status');
		if ($status == 'OPEN') {
			$this->db->from($this->config->item('VIEW_COMPLAINT_PROBLEM'))
			         ->where('status', $this->config->item('STATUS_COMPLAINT_OPEN'))
					 ->or_where('status', $this->config->item('STATUS_COMPLAINT_ONPROGRESS'));
		} else if ($status == 'CLOSED') {
			$this->db->from($this->config->item('VIEW_COMPLAINT_PROBLEM'))
			         ->where('status', $this->config->item('STATUS_COMPLAINT_CLOSED'));
		}
        return $this->db->count_all_results();
    }
	
	function get_data_mis_person() {
        return $this->db->get($this->config->item('TABLE_MIS_PERSON'));
	}
	
	function get_data_kategori_problem() {
        return $this->db->order_by('nama_kategori')
		                ->get($this->config->item('TABLE_KATEGORI_PROBLEM'));
	}
	
	public function get_count_complaint_open() {
		$query = $this->db->query("SELECT COUNT(status) AS count_row 
								   FROM ".$this->config->item('VIEW_COMPLAINT_PROBLEM')." 
								   WHERE (status = '".$this->config->item('STATUS_COMPLAINT_OPEN')."' 
										OR status = '".$this->config->item('STATUS_COMPLAINT_ONPROGRESS')."')");
		if ($query->num_rows() > 0) {
			$row = $query->row_array(); 
			$data = array('count_complaint_open' => $row['count_row']);
			echo json_encode($data);
		}
    }

}
