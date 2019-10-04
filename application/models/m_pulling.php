<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_pulling extends CI_Model {

	private $conn_name_dwasys_rescue;
	private $conn_dwasys_rescue;

	private $conn_dwasys;
	private $conn_name_dwasys;

	private $table_tmp_scandn;
	private $table_tmp_scankanban;
	private $table_tmp_scantagok;
	private $table_mst_machine_part;
	private $table_trx_packing;
	private $table_trx_so_hdr;
	private $query_trx_so_dtl;
	private $query_trx_outstanding_so_sj;
	private $table_trx_sj_hdr;

	var $column_order 	= array(null, 'SysId','DN_Number','SJ_Number','SJ_Date');
    var $column_search 	= array('SysId','DN_Number','SJ_Number','SJ_Date');
    var $order 			= array('DN_Number' => 'asc', 'SJ_Number' => 'asc');
		
	function __construct() {
		parent::__construct();

		$this->conn_name_dwasys_rescue 		= $this->config->item('CONN_NAME_DWASYS_RESCUE'); // Untuk test
		$this->conn_dwasys_rescue 			= $this->load->database($this->conn_name_dwasys_rescue, TRUE); // Untuk test

		$this->conn_name_dwasys 			= $this->config->item('CONN_NAME_DWASYS');
		$this->conn_dwasys 					= $this->load->database($this->conn_name_dwasys, TRUE);

		$this->table_tmp_scandn 			= $this->config->item('TABLE_TMP_SCAN_DN');
		$this->table_tmp_scankanban 		= $this->config->item('TABLE_TMP_SCAN_KANBAN');
		$this->table_tmp_scantagok 			= $this->config->item('TABLE_TMP_SCAN_TAGOK');
		$this->table_mst_machine_part 		= $this->config->item('TABLE_MST_MACHINE_PART');
		$this->table_trx_packing 			= $this->config->item('TABLE_TRX_PACKING');
		$this->table_trx_so_hdr 			= $this->config->item('TABLE_TRX_SALES_ORDER_HDR');
		$this->query_trx_so_dtl 			= $this->config->item('QUERY_TRX_SALES_ORDER_DTL');
		$this->query_trx_outstanding_so_sj	= $this->config->item('QUERY_TRX_OUTSTANDING_SO_SJ');
		$this->table_trx_sj_hdr 			= $this->config->item('TABLE_TRX_SURAT_JALAN_HDR');
	}

	/* DataTable Surat Jalan */
	private function _get_datatables_query() {
		$this->conn_dwasys_rescue->where('SJ_Date', date($this->config->item('FORMAT_DATE_TO_INSERT')));
        $this->conn_dwasys_rescue->from($this->table_trx_sj_hdr); 
        $i = 0;     
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->conn_dwasys_rescue->group_start();
                    $this->conn_dwasys_rescue->like($item, $_POST['search']['value']);
                } else {
                    $this->conn_dwasys_rescue->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i)
                    $this->conn_dwasys_rescue->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->conn_dwasys_rescue->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->conn_dwasys_rescue->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->conn_dwasys_rescue->limit($_POST['length'], $_POST['start']);
        $query = $this->conn_dwasys_rescue->get();
        return $query->result();
    }
 
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->conn_dwasys_rescue->get();
        return $query->num_rows();
    }
 
    public function count_all() {
    	$this->conn_dwasys_rescue->where('SJ_Date', date($this->config->item('FORMAT_DATE_TO_INSERT')));
        $this->conn_dwasys_rescue->from($this->table_trx_sj_hdr);
        return $this->conn_dwasys_rescue->count_all_results();
    }
	/* DataTable Surat Jalan */

	/* TEMP DN */
	function get_data_temp_dn($nik_user_login) {
		$this->db->limit(1);
		return $this->db->get_where($this->table_tmp_scandn, array('user_login'=>$nik_user_login));
	}
	function scan_temp_dn($no_dn, $nik_user_login) {
		return $this->db->get_where($this->table_tmp_scandn, array('no_dn'=>$no_dn, 'user_login'=>$nik_user_login));
	}
	function insert_temp_dn($no_dn, $nik_user_login) {
		$data = array(
			'no_dn' 		=> $no_dn,
			'user_login' 	=> $nik_user_login,
		);
        return $this->db->insert($this->table_tmp_scandn, $data);
    }
    function delete_temp_dn($sysid) {
		return $this->db->delete($this->table_tmp_scandn, array('sysid' => $sysid));
    }
    function delete_all_temp_dn($no_dn, $user_login) {
		return $this->db->delete($this->table_tmp_scandn, array('no_dn' => $no_dn, 'user_login' => $user_login));
    }
    /* TEMP DN */


    /* TEMP KANBAN */
    function scan_temp_kanban($no_dn, $job_no, $nik_user_login) {
		return $this->db->get_where($this->table_tmp_scankanban, array('no_dn'=>$no_dn, 'job_no'=>$job_no, 'user_login'=>$nik_user_login));
	}
	function insert_temp_kanban($no_dn, 
		                        $job_no, 
		                        $cpn_id, 
		                        $cpn_number, 
		                        $cpn_name, 
		                        $unit_id, 
		                        $unit_name, 
		                        $pn_id, 
		                        $pn_number, 
		                        $pn_name, 
		                        $qty_kanban, 
		                        $qty_packing, 
		                        $nik_user_login) {
		$data = array(
			'no_dn' 		=> $no_dn,
			'job_no'		=> $job_no,
			'cpn_id'		=> $cpn_id,
			'cpn_number'	=> $cpn_number,
			'cpn_name'		=> $cpn_name,
			'unit_id'		=> $unit_id,
			'unit_name'		=> $unit_name,
			'pn_id'			=> $pn_id,
			'pn_number'		=> $pn_number,
			'pn_name'		=> $pn_name,
			'qty_kanban'	=> $qty_kanban,
			'qty_packing'	=> $qty_packing,
			'user_login' 	=> $nik_user_login,
		);
        return $this->db->insert($this->table_tmp_scankanban, $data);
    }
    function delete_temp_kanban($sysid) {
		return $this->db->delete($this->table_tmp_scankanban, array('sysid'=>$sysid));
    }
    function delete_all_temp_kanban($no_dn, $nik_user_login) {
		return $this->db->delete($this->table_tmp_scankanban, array('no_dn'=>$no_dn, 'user_login'=>$nik_user_login));
    }
    /* TEMP KANBAN */


    /* TEMP TAG OK */
    function scan_trx_packing($barcode_id_tag_ok) {
    	$this->db->limit(1);
		return $this->db->get_where($this->table_trx_packing, array('barcode_id_tag'=>$barcode_id_tag_ok));
	}
    function scan_temp_tagok($barcode_id_tag_ok, $no_dn, $job_no, $nik_user_login) {
		return $this->db->get_where($this->table_tmp_scantagok, array('barcode_id_tag_ok'=>$barcode_id_tag_ok, 'no_dn'=>$no_dn, 'job_no'=>$job_no, 'user_login'=>$nik_user_login));
	}
	function insert_temp_tagok($barcode_id_tag_ok, 
							   $no_dn, 
							   $job_no, 
							   $cpn_id, 
		                       $cpn_number, 
		                       $cpn_name, 
		                       $unit_id, 
		                       $unit_name, 
		                       $pn_id, 
		                       $pn_number, 
		                       $pn_name, 
		                       $qty_kanban, 
		                       $qty_packing, 
		                       $nik_user_login) {
		$data = array(
			'barcode_id_tag_ok'	=> $barcode_id_tag_ok,
			'no_dn' 			=> $no_dn,
			'job_no'			=> $job_no,
			'cpn_id'			=> $cpn_id,
			'cpn_number'		=> $cpn_number,
			'cpn_name'			=> $cpn_name,
			'unit_id'			=> $unit_id,
			'unit_name'			=> $unit_name,
			'pn_id'				=> $pn_id,
			'pn_number'			=> $pn_number,
			'pn_name'			=> $pn_name,
			'qty_kanban'		=> $qty_kanban,
			'qty_packing'		=> $qty_packing,
			'user_login' 		=> $nik_user_login,
		);
        return $this->db->insert($this->table_tmp_scantagok, $data);
    }
    function delete_temp_tagok($sysid) {
		return $this->db->delete($this->table_tmp_scantagok, array('sysid'=>$sysid));
    }
    function delete_all_temp_tagok($no_dn, $nik_user_login) {
    	return $this->db->delete($this->table_tmp_scantagok, array('no_dn'=>$no_dn, 'user_login'=>$nik_user_login));
    }
    function delete_temp_tagok_by_job_no($no_dn, $job_no, $nik_user_login) {
    	return $this->db->delete($this->table_tmp_scantagok, array('no_dn'=>$no_dn, 'job_no'=>$job_no, 'user_login'=>$nik_user_login));
    }
    /* TEMP TAG OK */

    function get_data_master_machine_part($cpn_number) {
		return $this->db->get_where($this->table_mst_machine_part, array('cpn_number'=>$cpn_number));
	}


    /* SO */
    function scan_trx_outstanding_so_sj($no_dn) {
    	return $this->conn_dwasys->get_where($this->query_trx_outstanding_so_sj, array('DN_Number'=>$no_dn));
	}
    function scan_trx_so_header($no_dn) {
    	return $this->conn_dwasys->get_where($this->table_trx_so_hdr, array('DN_Number'=>$no_dn));
	}
	function scan_trx_so_detail($no_dn, $job_no) {
    	return $this->conn_dwasys->get_where($this->query_trx_so_dtl, array('DN_Number'=>$no_dn, 'Job_No'=>$job_no));
	}
    /* SO */

    /* CREATE SJ */
    function get_data_temp_kanban($nik_user_login) {
		return $this->db->get_where($this->table_tmp_scankanban, array('user_login'=>$nik_user_login));
	}
    function sum_qty_tag_ok($no_dn, $cpn_number, $nik_user_login) {
    	$this->db->select_sum('qty_packing');
    	return $this->db->get_where($this->table_tmp_scantagok, array('no_dn'=>$no_dn, 
    		                                                          'cpn_number'=>$cpn_number,
    		                                                          'user_login'=>$nik_user_login));
	}
    /* CREATE SJ */

}
