<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_complaint_input extends CI_Model {

    function get_data_department() {
        return $this->db->get($this->config->item('TABLE_DEPARTMENT'));
	}

    function get_data_ik($where = null) {
        if ($where == null) {
            return $this->db->get($this->config->item('TABLE_IK'));
        }else{
            $data = $this->db->get_where($this->config->item('TABLE_IK'), ['id' => $where]);
            return $data->row();
        }
    }

    function get_data_ps($where = null) {
        if ($where == null) {
            return $this->db->get($this->config->item('TABLE_PROBLEM_SOLVING'));
        }else{
            $data = $this->db->get_where($this->config->item('TABLE_PROBLEM_SOLVING'), ['id' => $where]);
            return $data->row();
        }
    }
	
	function get_data_pc_laptop_name() {
        return $this->db->get($this->config->item('TABLE_PC_LAPTOP_NAME'));
	}

    function get_modul($menu_group) {
        $this->db->select("sysid, concat_ws('  ->  ', menu_l1, menu_l2) as menu_name")
                 ->from($this->config->item('TABLE_MENU'))
                 ->where('menu_group', $menu_group)
                 ->order_by('menu_l1', 'ASC');
        $query = $this->db->get();
		echo json_encode($query->result());
	}

    function create_complaint($data) {
		return $this->db->insert($this->config->item('TABLE_COMPLAINT_PROBLEM'), $data);
	}

}
