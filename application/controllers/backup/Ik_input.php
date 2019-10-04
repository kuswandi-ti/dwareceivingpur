<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ik_input extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_input');
	}

	public function index() {
		$data = array(
			'title' => 'Instruksi Kerja',
			'page_title' => '<i class="icon-book-open"></i> Instruksi Kerja Input',
			'active_menu_root' => 'instruksi_kerja',
			'active_menu_child' => 'instruksi_kerja',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
							 <li class="breadcrumb-item active">Instruksi Kerja Input</li>',
			'get_data' => $this->m_complaint_input->get_data_ik(),
			'custom_scripts' => ""
		);
		$this->template->view('v_ik_input', $data);
	}

	public function edit_ik() {
		$data = array(
			'title' => 'Instruksi Kerja',
			'page_title' => '<i class="icon-book-open"></i> Instruksi Kerja',
			'active_menu_root' => 'instruksi_kerja',
			'active_menu_child' => 'instruksi_kerja',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item">Instruksi Kerja</li>
							 <li class="breadcrumb-item active">Instruksi Kerja Input</li>',
			'get_data' => $this->m_complaint_input->get_data_ik($this->uri->segment(3)),
			'custom_scripts' => ""
		);
		$this->template->view('v_ik_input', $data);
	}

	function create_ik() {
		$rand = rand(10, 99).'-';
		if ($_FILES['fupload']['name'] != null) {
			$config['upload_path']   = $this->config->item('PATH_ASSET_IK');
			$config['allowed_types'] = 'pdf';
			$config['file_name']     = $rand.$_FILES['fupload']['name'];
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('fupload') ){
				echo $this->upload->display_errors();
			}
			else{
				$data        = array('upload_data' => $this->upload->data());
				$upload_data = $this->upload->data(); //Mengambil detail data yang di upload
				$filename    = $upload_data['file_name'];//Nama File
				ini_set('memory_limit', '-1');

				$inputFileName = $this->config->item('PATH_ASSET_IK').$filename;

				$txtdocname = $this->input->post('txtdocname');
				$desc = $this->input->post('desc');
				$data = array(
					'nama_dokumen' => $txtdocname,
					'deskripsi'    => $desc,
					'file'         => $filename,
				);
				if ($this->db->insert($this->config->item('TABLE_IK'), $data)) {
					$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Tambah Data'] );
				}else {
					$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Tambah Data'] );
				}
				redirect(base_url('ik_input'));
			}
		}
	}

	function edited_ik() {
		$rand = rand(11, 999).'-';
		if ($_FILES['fupload']['name'] != null) {
			$config['upload_path']   = $this->config->item('PATH_ASSET_IK');
			$config['allowed_types'] = 'pdf';
			$config['file_name']     = $rand.$_FILES['fupload']['name'];
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('fupload') ){
				echo $this->upload->display_errors();
			}
			else{
				$data        = array('upload_data' => $this->upload->data());
				$upload_data = $this->upload->data(); //Mengambil detail data yang di upload
				$filename    = $upload_data['file_name'];//Nama File
				ini_set('memory_limit', '-1');

				$inputFileName = $this->config->item('PATH_ASSET_IK').$filename;

				$txtdocname = $this->input->post('txtdocname');
				$desc = $this->input->post('desc');
				$lastfilename = $this->input->post('last-fupload');
				$id = $this->input->post('id');

				unlink($this->config->item('PATH_ASSET_IK').$lastfilename);
				$data = array(
					'nama_dokumen' => $txtdocname,
					'deskripsi' => $desc,
					'file' => $filename,
				);

			if ($this->db->update($this->config->item('TABLE_IK'), $data, ['id' => $id])) {
				$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Edit Data'] );
			}else {
				$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Edit Data'] );
			}
			}
		}else {
			$txtdocname   = $this->input->post('txtdocname');
			$desc         = $this->input->post('desc');
			$lastfilename = $this->input->post('last-fupload');
			$id = $this->input->post('id');
			$data = array(
				'nama_dokumen' => $txtdocname,
				'deskripsi' => $desc,
				'file' => $lastfilename,
			);			
			if ($this->db->update($this->config->item('TABLE_IK'), $data, ['id' => $id])) {
				$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Edit Data'] );
			}else {
				$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Edit Data'] );
			}
		}

		redirect(base_url('ik_input'));

	}

	function del_ik() {
		$rand = rand(10, 99).'-';
		$data = $this->m_complaint_input->get_data_ik($this->uri->segment(3));
		if (count($data) > 0) {
			if (unlink($this->config->item('PATH_ASSET_IK').$data->file)) {
				if ($this->db->delete($this->config->item('TABLE_IK'), ['id' => $this->uri->segment(3)])) {
					$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Hapus Data'] );
				}else {
					$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Hapus Data'] );
				}
			}else {
				$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Hapus File & Data'] );
			}
		}else {
			$this->session->set_userdata( ['status' => 0, 'msg' => 'Terjadi Kesalahan!'] );
		}
		redirect(base_url('ik_input'));
	}

}
