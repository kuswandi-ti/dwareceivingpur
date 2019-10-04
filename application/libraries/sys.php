<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Sys {

	var $CI = NULL;
 
 	private $conn_name_dwasys;
	private $conn_dwasys;	
	private $table_counter_docnumber;
	private $table_counter_sysid;

	function __construct() {
		$this->CI =& get_instance();

		$this->conn_name_dwasys 		= $this->CI->config->item('CONN_NAME_DWASYS_RESCUE'); // Untuk test saja. Jika sudah live ganti dengan CONN_NAME_DWASYS
		$this->conn_dwasys 				= $this->CI->load->database($this->conn_name_dwasys, TRUE);
		
		$this->table_counter_docnumber 	= $this->CI->config->item('TABLE_COUNTER_DOCNUMBER');
		$this->table_counter_sysid 		= $this->CI->config->item('TABLE_COUNTER_SYSID');
	}

	function last_doc_number($trx_name, $month, $year) {
		$this->conn_dwasys->select('CurrDocNumber')
		            	  ->from($this->table_counter_docnumber)
			        	  ->where(array('TrxName' 	=> $trx_name,
				                  		'TrxMonth'	=> $month,
							      		'TrxYear' 	=> $year));
		$result = $this->conn_dwasys->get();
		if ($result->num_rows() > 0) {
			$curr_docnumber = $result->row()->CurrDocNumber;
			$this->conn_dwasys->set('CurrDocNumber', 'CurrDocNumber + 1', FALSE)
			            	  ->where(array('TrxName' 	=> $trx_name,
							      			'TrxMonth'	=> $month,
							      			'TrxYear' 	=> $year))
			            	  ->update($this->table_counter_docnumber);
		} else {
			$curr_docnumber = 0;
			$data = array(
		        'TrxName' 		=> $trx_name,
		        'TrxMonth'		=> $month,
		        'TrxYear' 		=> $year,
		        'CurrDocNumber'	=> 1
			);
			$this->conn_dwasys->insert($this->table_counter_docnumber, $data);
		}
		return $curr_docnumber;
	}

	function last_sysid($table_name) {
		$this->conn_dwasys->select('CurrSysId')
		        		  ->from($this->table_counter_sysid)
			   			  ->where(array('TableName'=>$table_name));
		$result = $this->conn_dwasys->get();
		if ($result->num_rows() > 0) {
			$curr_sysid = $result->row()->CurrSysId;
			$this->conn_dwasys->set('CurrSysId', 'CurrSysId + 1', FALSE)
			        		  ->where(array('TableName'=>$table_name))
			       			  ->update($this->table_counter_sysid);
		} else {
			$curr_sysid = 0;
			$data = array(
		        'TableName'	=> $table_name,
		        'CurrSysId' => 1
			);
			$this->conn_dwasys->insert($this->table_counter_sysid, $data);
		}
		return $curr_sysid;
	}

}