<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

	var $CI = NULL;

	private $conn_dwasys;
	private $conn_name_dwasys;
	private $query_bcd_operator;
	
	function __construct() {
		// get CI's object
		$this->CI =& get_instance();

		$this->conn_name_dwasys 	= $this->CI->config->item('CONN_NAME_DWASYS');
		$this->conn_dwasys 			= $this->CI->load->database($this->conn_name_dwasys, TRUE);
		
		$this->query_bcd_operator 	= $this->CI->config->item('QUERY_BCD_OPERATOR');		
	}
	
	// untuk validasi di setiap halaman yang mengharuskan authentikasi
	function restrict() {
		if(empty($this->CI->session->userdata('sess_nik'))) {
			redirect('');
		}
	}

	function restrict_login() {
		if($this->CI->session->userdata('sess_nik') != '') {
			redirect('home');
		}
	}

	function build_menu($nik) {
		$query = $this->conn_dwasys->get_where($this->query_bcd_operator, array('NIK'=>$nik));
		if($query->num_rows() > 0) {
			foreach($query->result() as $res) {
				if($res->Pulling_GP) {
					echo '
							<li>
                    			<a class="waves-effect waves-dark" href="pulling" aria-expanded="false"><i class="ti-shopping-cart"></i><span class="hide-menu">Pulling</span></a>
                		  	</li>
                		 ';
				}
				if($res->Loading_GP) {
					echo '
							<li>
                    			<a class="waves-effect waves-dark" href="loading" aria-expanded="false"><i class="ti-truck"></i><span class="hide-menu">Loading</span></a>
                			</li>
						 ';
				}
			}
		}                
	}
	
}

/* End of file auth.php */
/* Location: ./application/libraries/auth.php */