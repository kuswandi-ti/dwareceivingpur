<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_login extends CI_Model {

	private $conn_dwasys;
	private $conn_name_dwasys;
	
	private $query_bcd_operator;

	function __construct() {
		parent::__construct();

		$this->conn_name_dwasys 	= $this->config->item('CONN_NAME_DWASYS');
		$this->conn_dwasys 			= $this->load->database($this->conn_name_dwasys, TRUE);

		$this->query_bcd_operator 	= $this->config->item('QUERY_BCD_OPERATOR');		
	}

	function login($nik) {
		return $this->conn_dwasys->get_where($this->query_bcd_operator, array('NIK'=>$nik, 'Dept_Alias'=>'PUR'));
	}
}
