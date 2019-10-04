<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_home extends CI_Model {
	
	private $db_mssql;
	
	function __construct() {
		parent::__construct();
		$this->db_mssql = $this->load->database('db_dwasys', TRUE);
	}

    /*function get_data_persentase_app() {
		$tahun = $this->input->post('tahun');
		
		$data = array();
		
		$sql = "
			select
				sum(case when ca_application = 'DWASYS' then 1 else 0 end) as 'count_dwasys',
				sum(case when ca_application = 'DWAFINACCT' then 1 else 0 end) as 'count_dwafinacct',
				sum(case when ca_application = 'DWAHRIS' then 1 else 0 end) as 'count_dwahris',
				sum(case when ca_application = 'POWS' then 1 else 0 end) as 'count_pows',
				sum(case when ca_application = 'PLTAM' then 1 else 0 end) as 'count_pltam'
			from
				".$this->config->item('VIEW_COMPLAINT_PROBLEM')."
			where
				year(doc_date) = '".$tahun."'
		";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}*/
	
	/*function get_data_grafik_uar() {
		$status = $this->input->post('status');
		
		$data = array();
		
		$query = $this->db_mssql->select("SUM(CASE WHEN User_Dept = 'ACC' THEN 1 ELSE 0 END) AS 'count_acc',
										  SUM(CASE WHEN User_Dept = 'BOD' THEN 1 ELSE 0 END) AS 'count_bod',
										  SUM(CASE WHEN User_Dept = 'CDC' THEN 1 ELSE 0 END) AS 'count_cdc',
										  SUM(CASE WHEN User_Dept = 'CMA' THEN 1 ELSE 0 END) AS 'count_cma',
										  SUM(CASE WHEN User_Dept = 'CSA' THEN 1 ELSE 0 END) AS 'count_csa',
										  SUM(CASE WHEN User_Dept = 'FIN' THEN 1 ELSE 0 END) AS 'count_fin',
										  SUM(CASE WHEN User_Dept = 'HRG' THEN 1 ELSE 0 END) AS 'count_hrg',
										  SUM(CASE WHEN User_Dept = 'KAI' THEN 1 ELSE 0 END) AS 'count_kai',
										  SUM(CASE WHEN User_Dept = 'MIS' THEN 1 ELSE 0 END) AS 'count_mis',
										  SUM(CASE WHEN User_Dept = 'MRE' THEN 1 ELSE 0 END) AS 'count_mre',
										  SUM(CASE WHEN User_Dept = 'MTC' THEN 1 ELSE 0 END) AS 'count_mtc',
										  SUM(CASE WHEN User_Dept = 'PMO' THEN 1 ELSE 0 END) AS 'count_pmo',
										  SUM(CASE WHEN User_Dept = 'PPC' THEN 1 ELSE 0 END) AS 'count_ppc',
										  SUM(CASE WHEN User_Dept = 'PPR' THEN 1 ELSE 0 END) AS 'count_ppr',
										  SUM(CASE WHEN User_Dept = 'PRD' THEN 1 ELSE 0 END) AS 'count_prd',
										  SUM(CASE WHEN User_Dept = 'PRE' THEN 1 ELSE 0 END) AS 'count_pre',
										  SUM(CASE WHEN User_Dept = 'PRO' THEN 1 ELSE 0 END) AS 'count_pro',
										  SUM(CASE WHEN User_Dept = 'PUR' THEN 1 ELSE 0 END) AS 'count_pur',
										  SUM(CASE WHEN User_Dept = 'QAS' THEN 1 ELSE 0 END) AS 'count_qas',
										  SUM(CASE WHEN User_Dept = 'SEC' THEN 1 ELSE 0 END) AS 'count_sec',
										  SUM(CASE WHEN User_Dept = 'SHE' THEN 1 ELSE 0 END) AS 'count_she',
										  SUM(CASE WHEN User_Dept = 'SLS' THEN 1 ELSE 0 END) AS 'count_sls',
										  SUM(CASE WHEN User_Dept = 'SMA' THEN 1 ELSE 0 END) AS 'count_sma',
										  SUM(CASE WHEN User_Dept = 'WHS' THEN 1 ELSE 0 END) AS 'count_whs',
										  SUM(CASE WHEN User_Dept = 'KOPERASI' THEN 1 ELSE 0 END) AS 'count_koperasi'")
		                        ->from($this->config->item('VIEW_COMPLAINT_PROBLEM'))
								->where('Status', $status)
								->get();
								
		if ($query->num_rows() > 0) {
			foreach($query->result() as $r) {
				$data[] = $r;
			}
		}
		
		return $data;
	}*/
	
	public function count_complaint_all() {
		$this->db->from($this->config->item('VIEW_COMPLAINT_PROBLEM'));
        return $this->db->count_all_results();
    }
	
	public function count_complaint_status($status) {
		$this->db->from($this->config->item('VIEW_COMPLAINT_PROBLEM'))
				 ->where('status', $status);
        return $this->db->count_all_results();
    }
	
	public function count_uar_all() {
		$this->db_mssql->from($this->config->item('VIEW_UAR'));
        return $this->db_mssql->count_all_results();
    }
	
	public function count_uar_status($status) {
		$this->db_mssql->from($this->config->item('VIEW_UAR'))
				       ->where('Status', $status);
        return $this->db_mssql->count_all_results();
    }
	
	function dashboard_info_uar($status) {
		$query = $this->db_mssql->select('User_Dept,COUNT(User_Dept) AS Count_UAR')
							    ->from($this->config->item('VIEW_UAR'))
							    ->where('Status', $status)
							    ->group_by('User_Dept')
							    ->order_by('User_Dept')
								->get();
		return $query;
	}

}
