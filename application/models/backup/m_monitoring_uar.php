<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_monitoring_uar extends CI_Model {
	
	private $db_mssql;
	
	var $column_order 		= array(null, 'Doc_Num','Doc_Date','Type_Program','Jenis_Program', 
									'Jenis','User_Dept','User_Nama','Tgl_Permohonan',
									'Tgl_ReqFinish','Tgl_Kesanggupan','Tgl_OnProgress','Tgl_Finish',
									'Programmer','Keterangan','Tot_Finish',
									'Status','Implementasi','SysIdHdr','SysId','Doc_Rev','Rec_LastTime');
    var $column_search 		= array('Doc_Num','Doc_Date','Type_Program','Jenis_Program', 
									'Jenis','User_Dept','User_Nama','Tgl_Permohonan',
									'Tgl_ReqFinish','Tgl_Kesanggupan','Tgl_OnProgress','Tgl_Finish',
									'Programmer','Keterangan','Tot_Finish',
									'Status','Implementasi','SysIdHdr','SysId','Doc_Rev','Rec_LastTime');
    var $order 				= array('Rec_LastTime' => 'DESC');
	
	function __construct() {
		parent::__construct();
		$this->db_mssql = $this->load->database('db_dwasys', TRUE);
	}

	private function _get_datatables_query() {
		$status = $this->input->post('status');
		$this->db_mssql->from($this->config->item('VIEW_UAR'))
			           ->where('Status', $status)
					   ->order_by('Tgl_Finish', 'asc');
		
        $i = 0;
     
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
                if($i === 0) {
                    $this->db_mssql->group_start();
                    $this->db_mssql->like($item, $_POST['search']['value']);
                } else {
                    $this->db_mssql->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i)
                    $this->db_mssql->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db_mssql->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db_mssql->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db_mssql->limit($_POST['length'], $_POST['start']);
        $query = $this->db_mssql->get();
        return $query->result();
    }
 
    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db_mssql->get();
        return $query->num_rows();
    }
 
    public function count_all() {
		$status = $this->input->post('status');
		$this->db_mssql->from($this->config->item('VIEW_UAR'))
			           ->where('Status', $status);
        return $this->db_mssql->count_all_results();
    }

}
