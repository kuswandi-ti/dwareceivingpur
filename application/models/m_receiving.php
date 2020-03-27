<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_receiving extends CI_Model {

	private $conn_dwasys;
	private $conn_name_dwasys;

	private $query_os_po_rr_hdr_bpp;
	private $query_os_po_rr_hdr_cer;
	private $query_get_data_po_bpp;
	private $query_get_data_po_cer;

	private $table_tmp_po_rr_bpp_cer;

	private $query_bcd_operator;
	private $session_nik;

	var $column_order 	= array(null, 'SysId_Hdr', 'Doc_No', 'Doc_Rev', 'Doc_Date', 'Vendor_Code', 'Vendor_Name', 'Vendor_All', 'Remarks');
    var $column_search 	= array('SysId_Hdr', 'Doc_No', 'Doc_Rev', 'Doc_Date', 'Vendor_Code', 'Vendor_Name', 'Vendor_All', 'Remarks');
    var $order 			= array('SysId_Hdr' => 'desc');
		
	function __construct() {
		parent::__construct();

		// $this->conn_name_dwasys 			= $this->config->item('CONN_NAME_DWASYS_RESCUE'); /* Test */
		$this->conn_name_dwasys 			= $this->config->item('CONN_NAME_DWASYS'); /* Live */
		$this->conn_dwasys 					= $this->load->database($this->conn_name_dwasys, TRUE);

		$this->query_os_po_rr_hdr_bpp		= $this->config->item('QUERY_OS_PO_RR_HDR_BPP');
		$this->query_os_po_rr_hdr_cer		= $this->config->item('QUERY_OS_PO_RR_HDR_CER');
		$this->query_get_data_po_bpp 		= $this->config->item('QUERY_GET_DATA_PO_BPP');
		$this->query_get_data_po_cer 		= $this->config->item('QUERY_GET_DATA_PO_CER');

		$this->table_tmp_po_rr_bpp_cer 		= $this->config->item('TABLE_TMP_PO_VS_RR');

		$this->query_bcd_operator 			= $this->config->item('QUERY_BCD_OPERATOR');
		$this->session_nik 			        = $this->session->userdata('sess_nik_receivingpur');
	}

	/* BEGIN - Browse List Data PO */
	function get_datatables_po($source) {
        $this->_get_datatables_query_po($source);
        if($_POST['length'] != -1)
        $this->conn_dwasys->limit($_POST['length'], $_POST['start']);
        $query = $this->conn_dwasys->get();
        return $query->result();
    }

    private function _get_datatables_query_po($source) {
    	if ($source == 'bpp') {
    		$this->conn_dwasys->from($this->query_os_po_rr_hdr_bpp);
        } elseif ($source == 'cer') {
        	$this->conn_dwasys->from($this->query_os_po_rr_hdr_cer);
        }

        $i = 0;     
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->conn_dwasys->group_start();
                    $this->conn_dwasys->like($item, $_POST['search']['value']);
                } else {
                    $this->conn_dwasys->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i)
                    $this->conn_dwasys->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->conn_dwasys->order_by($this->column_search[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->conn_dwasys->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_po($source) {
        $this->_get_datatables_query_po($source);
        $query = $this->conn_dwasys->get();
        return $query->num_rows();
    }
 
    public function count_all_po($source) {
    	if ($source == 'bpp') {
    		$this->conn_dwasys->from($this->query_os_po_rr_hdr_bpp);
        } elseif ($source == 'cer') {
        	$this->conn_dwasys->from($this->query_os_po_rr_hdr_cer);
        }        
        return $this->conn_dwasys->count_all_results();
    }
    /* END - Browse List Data PO */

    function get_data_po($source, $po_id, $po_number) {
		$this->conn_dwasys->delete($this->table_tmp_po_rr_bpp_cer, array('PO_Id' => $po_id, 'User_Login' => $this->session_nik));

		if ($source == 'bpp') {
			$query = "INSERT INTO ".$this->table_tmp_po_rr_bpp_cer." 
						(PO_Id, PO_No, Product_Id, Product_Code, Product_Name, Unit_Name, Unit_Koversi_Code, 
						Unit_Koversi_Value, Qty_PO, Qty_OS, Qty_RR, Remarks, User_Login) 
					SELECT 
						SysId_Hdr, '".$po_number."', SysId_Barang, Part_Number, Part_Name, LTRIM(RTRIM(Unit)), Unit_Konversi, 
						Unit_Konversi_Value, Qty_You, 0, Qty, Remark, '".$this->session_nik."'
					FROM 
						".$this->query_get_data_po_bpp."
					WHERE
				 		SysId_Hdr = '".$po_id."'
				 		AND Qty > 0";

		} elseif ($source == 'cer') {
			$query = "INSERT INTO ".$this->table_tmp_po_rr_bpp_cer." 
						(PO_Id, PO_No, Product_Id, Product_Initial, Product_Code, Product_Name, Product_Description, 
						Unit_Name, Remarks, Qty_PO, Qty_OS, Qty_RR, User_Login) 
					SELECT 
						SysId_Hdr, '".$po_number."', Product_Id, Product_Initial, Product_Code, Product_Name, Product_Description,
						Product_Unit, Remarks_Dtl, PO_Qty, 0, PO_OS_Qty, '".$this->session_nik."'
					FROM 
						".$this->query_get_data_po_cer."
					WHERE
				 		SysId_Hdr = '".$po_id."'
				 		AND PO_OS_Qty > 0";
		}

		return $this->conn_dwasys->query($query);
	}

	function list_data_detail_rr($po_id, $user_login) {
		return $this->conn_dwasys->get_where($this->table_tmp_po_rr_bpp_cer, array('PO_Id' => $po_id, 'User_Login' => $user_login));
    }

    function delete_temp_rr($sysid) {
		return $this->conn_dwasys->delete($this->table_tmp_po_rr_bpp_cer, array('SysId' => $sysid));
    }

    function edit_temp_rr($sysid) {
    	$this->conn_dwasys->from($this->table_tmp_po_rr_bpp_cer);
        $this->conn_dwasys->where('sysid', $sysid);
        $query = $this->conn_dwasys->get(); 
        return $query->row();
    }

    function update_temp_rr($sysid, $qty_os, $qty_rr, $qty_rr_old) {
    	$hasil_rr = ($qty_os + $qty_rr_old) - $qty_rr;
    	$data = array(
    		'Qty_RR' 	=> $qty_rr,
    		'Qty_OS' 	=> $hasil_rr,
    	);
    	$this->conn_dwasys->where('SysId', $sysid); 
    	$res_update = $this->conn_dwasys->update($this->table_tmp_po_rr_bpp_cer, $data);

    	if ($res_update == 1) {
    		echo json_encode(['success_update' => 'Sukses update data receive RR']);
    	} else {
    		echo json_encode(['failed_update' => 'Error proses update receive RR']);
    	}
    }

    function list_temp_rr($po_no, $nik) {
		return $this->conn_dwasys->get_where($this->table_tmp_po_rr_bpp_cer, array('PO_No'=>$po_no, 'User_Login'=>$nik));
	}

	function get_trx_rr($source_scan, $key) {
    	if ($source_scan == 'dn') {
    		return $this->conn_dwasys->get_where($this->table_trx_so_hdr, array('DN_Number'=>$key));
    	} else if ($source_scan == 'manifest') {
    		return $this->conn_dwasys->get_where($this->table_trx_so_hdr, array('RIGHT(PO_Number, 10) ='=>$key));
    	} else if ($source_scan == 'so') {
    		return $this->conn_dwasys->get_where($this->table_trx_so_hdr, array('SysId'=>$key));
    	}    	
	}

	function cek_requester($nik_req, $dept_req) {		
		return $this->conn_dwasys->get_where($this->query_bcd_operator, array('NIK'=>$nik_req, 'Dept_Alias'=>$dept_req));
	}

}
