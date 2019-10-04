<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_loading extends CI_Model {

	private $conn_dwasys;
	private $conn_name_dwasys;

	private $table_mst_truk;
	private $table_mst_supir;
	private $table_trx_sj_hdr;
	private $table_trx_loading;
	private $query_trx_outstanding_sj_loading;

	var $column_order_truk 		= array(null, 'Vehicle_Num','Armada_Name');
    var $column_search_truk 	= array('Vehicle_Num','Armada_Name');
    var $order_truk 			= array('Armada_Name' => 'asc', 'Vehicle_Num' => 'asc');

    var $column_order_supir		= array(null, 'NIK','Driver_Name');
    var $column_search_supir 	= array('NIK','Driver_Name');
    var $order_supir 			= array('Driver_Name' => 'asc', 'NIK' => 'asc');

    var $column_order_dn		= array(null, 'DN_Num','CPN','CPName','Unit');
    var $column_search_dn 		= array('DN_Num','CPN','CPName','Unit');
    var $order_dn 				= array('DN_Num' => 'asc', 'CPN' => 'asc');

	function __construct() {
		parent::__construct();

		$this->conn_name_dwasys 				= $this->config->item('CONN_NAME_DWASYS');
		$this->conn_dwasys 						= $this->load->database($this->conn_name_dwasys, TRUE);

		$this->table_mst_truk 					= $this->config->item('TABLE_MST_VEHICLE');
		$this->table_mst_supir 					= $this->config->item('TABLE_MST_DRIVER');
		$this->table_trx_sj_hdr 				= $this->config->item('TABLE_TRX_SURAT_JALAN_HDR');
		$this->table_trx_loading 				= $this->config->item('TABLE_TRX_LOADING');
		$this->query_trx_outstanding_sj_loading	= $this->config->item('QUERY_TRX_OUTSTANDING_SJ_LOADING');
	}

	/* DataTable Truk */
	private function _get_datatables_query_truk() {         
        $this->conn_dwasys->from($this->table_mst_truk); 
        $i = 0;     
        foreach ($this->column_search_truk as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->conn_dwasys->group_start();
                    $this->conn_dwasys->like($item, $_POST['search']['value']);
                } else {
                    $this->conn_dwasys->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_truk) - 1 == $i)
                    $this->conn_dwasys->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->conn_dwasys->order_by($this->column_search_truk[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->conn_dwasys->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_truk() {
        $this->_get_datatables_query_truk();
        if($_POST['length'] != -1)
        $this->conn_dwasys->limit($_POST['length'], $_POST['start']);
        $query = $this->conn_dwasys->get();
        return $query->result();
    }
 
    function count_filtered_truk() {
        $this->_get_datatables_query_truk();
        $query = $this->conn_dwasys->get();
        return $query->num_rows();
    }
 
    public function count_all_truk() {
        $this->conn_dwasys->from($this->table_mst_truk);
        return $this->conn_dwasys->count_all_results();
    }
	/* DataTable Truk */

	/* DataTable Supir */
	private function _get_datatables_query_supir() {
        $this->conn_dwasys->from($this->table_mst_supir);

        $i = 0;     
        foreach ($this->column_search_supir as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->conn_dwasys->group_start();
                    $this->conn_dwasys->like($item, $_POST['search']['value']);
                } else {
                    $this->conn_dwasys->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_supir) - 1 == $i)
                    $this->conn_dwasys->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->conn_dwasys->order_by($this->column_search_supir[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->conn_dwasys->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_supir() {
        $this->_get_datatables_query_supir();
        if($_POST['length'] != -1)
        $this->conn_dwasys->limit($_POST['length'], $_POST['start']);
        $query = $this->conn_dwasys->get();
        return $query->result();
    }
 
    function count_filtered_supir() {
        $this->_get_datatables_query_supir();
        $query = $this->conn_dwasys->get();
        return $query->num_rows();
    }
 
    public function count_all_supir() {
        $this->conn_dwasys->from($this->table_mst_supir);
        return $this->conn_dwasys->count_all_results();
    }
	/* DataTable Supir */

	/* DataTable Loading */
	private function _get_datatables_query_dn($id) {
        $this->conn_dwasys->from($this->table_trx_loading);
        $this->conn_dwasys->where('Sysid', $id);

        $i = 0;     
        foreach ($this->column_search_dn as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->conn_dwasys->group_start();
                    $this->conn_dwasys->like($item, $_POST['search']['value']);
                } else {
                    $this->conn_dwasys->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_dn) - 1 == $i)
                    $this->conn_dwasys->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->conn_dwasys->order_by($this->column_search_dn[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->conn_dwasys->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_dn($id) {
        $this->_get_datatables_query_dn($id);
        if($_POST['length'] != -1)
        $this->conn_dwasys->limit($_POST['length'], $_POST['start']);
        $query = $this->conn_dwasys->get();
        return $query->result();
    }
 
    function count_filtered_dn($id) {
        $this->_get_datatables_query_dn($id);
        $query = $this->conn_dwasys->get();
        return $query->num_rows();
    }
 
    public function count_all_dn($id) {
        $this->conn_dwasys->from($this->table_trx_loading);
        $this->conn_dwasys->where('Sysid', $id);
        return $this->conn_dwasys->count_all_results();
    }
	/* DataTable Loading */

   	/* SJ */
    function scan_trx_outstanding_sj_loading($no_dn) {
    	return $this->conn_dwasys->get_where($this->query_trx_outstanding_sj_loading, array('DN_Number'=>$no_dn, 'Qty_Balance >'=>0));
	}
    function scan_trx_sj_header($no_dn) {
    	return $this->conn_dwasys->get_where($this->table_trx_sj_hdr, array('DN_Number'=>$no_dn));
	}
    /* SJ */

    function insert_loading($Sysid, 
		                    $DN_Num, 
		                    $Tanggal, 
		                    $Jam, 
		                    $Vehicle_Num, 
		                    $Transporter, 
		                    $Driver_name, 
		                    $CPN, 
		                    $CPName, 
		                    $Unit, 
		                    $Qty, 
		                    $Cust, 
		                    $Sysdocid, 
		                    $Recuserid, 
		                    $Recdate, 
		                    $Rectime) {
		$data = array(
			'Sysid' 		=> $Sysid,
			'DN_Num'		=> $DN_Num,
			'Tanggal'		=> $Tanggal,
			'Jam'			=> $Jam,
			'Vehicle_Num'	=> $Vehicle_Num,
			'Transporter'	=> $Transporter,
			'Driver_name'	=> $Driver_name,
			'CPN'			=> $CPN,
			'CPName'		=> $CPName,
			'Unit'			=> $Unit,
			'Qty'			=> $Qty,
			'Cust'			=> $Cust,
			'Sysdocid' 		=> $Sysdocid,
			'Recuserid' 	=> $Recuserid,
			'Recdate' 		=> $Recdate,
			'Rectime' 		=> $Rectime,
		);
        return $this->conn_dwasys->insert($this->table_trx_loading, $data);
    }

}
