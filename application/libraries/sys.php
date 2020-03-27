<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Sys {

	var $CI = NULL;
 
 	private $conn_name_dwasys;
	private $conn_dwasys;
	private $conn_name_dwafinacct;
	private $conn_dwafinacct;
	private $table_counter_docnumber;
	private $table_counter_sysid;
	private $table_counter_docnumber_dwafinacct;
	private $table_counter_sysid_dwafinacct;

	function __construct() {
		$this->CI =& get_instance();

		// $this->conn_name_dwasys             = $this->CI->config->item('CONN_NAME_DWASYS_RESCUE'); /* Test */
        $this->conn_name_dwasys             		= $this->CI->config->item('CONN_NAME_DWASYS'); /* Live */
        $this->conn_dwasys                  		= $this->CI->load->database($this->conn_name_dwasys, TRUE);

        $this->conn_name_dwafinacct         		= $this->CI->config->item('CONN_NAME_DWAFINACCT'); /* Live */
        $this->conn_dwafinacct              		= $this->CI->load->database($this->conn_name_dwafinacct, TRUE);
		
		$this->table_counter_docnumber 				= $this->CI->config->item('TABLE_COUNTER_DOCNUMBER');
		$this->table_counter_sysid 					= $this->CI->config->item('TABLE_COUNTER_SYSID');

		$this->table_counter_docnumber_dwafinacct	= $this->CI->config->item('TABLE_COUNTER_DOCNUMBER_DWAFINACCT');
		$this->table_counter_sysid_dwafinacct 		= $this->CI->config->item('TABLE_COUNTER_SYSID_DWAFINACCT');
	}

	function last_doc_number_dwasys($trx_name, $month, $year) {
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

	function last_sysid_dwasys($table_name) {
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

	function last_doc_number_dwafinacct($trx_name, $month, $year) {
		$this->conn_dwafinacct->select('CurrDocNumber')
		            	  	  ->from($this->table_counter_docnumber_dwafinacct)
			        	  	  ->where(array('TransName' 	=> $trx_name,
				                  			'TransMonth'	=> $month,
							      			'TransYear' 	=> $year));
		$result = $this->conn_dwafinacct->get();
		if ($result->num_rows() > 0) {
			$curr_docnumber = $result->row()->CurrDocNumber;
			$this->conn_dwafinacct->set('CurrDocNumber', 'CurrDocNumber + 1', FALSE)
			            	  	  ->where(array('TransName' 	=> $trx_name,
							      				'TransMonth'	=> $month,
							      				'TransYear' 	=> $year))
			            	  	  ->update($this->table_counter_docnumber_dwafinacct);
		} else {
			$curr_docnumber = 0;
			$data = array(
		        'TransName' 		=> $trx_name,
		        'TransMonth'		=> $month,
		        'TransYear' 		=> $year,
		        'CurrDocNumber'	=> 1
			);
			$this->conn_dwafinacct->insert($this->table_counter_docnumber_dwafinacct, $data);
		}
		return $curr_docnumber;
	}

	function last_sysid_dwafinacct($table_name) {
		$this->conn_dwafinacct->select('CurrSysId')
		        		  	  ->from($this->table_counter_sysid_dwafinacct)
			   			  	  ->where(array('TableName'=>$table_name));
		$result = $this->conn_dwafinacct->get();
		if ($result->num_rows() > 0) {
			$curr_sysid = $result->row()->CurrSysId;
			$this->conn_dwafinacct->set('CurrSysId', 'CurrSysId + 1', FALSE)
			        		  	  ->where(array('TableName'=>$table_name))
			       			  	  ->update($this->table_counter_sysid_dwafinacct);
		} else {
			$curr_sysid = 0;
			$data = array(
		        'TableName'	=> $table_name,
		        'CurrSysId' => 1
			);
			$this->conn_dwafinacct->insert($this->table_counter_sysid_dwafinacct, $data);
		}
		return $curr_sysid;
	}

}