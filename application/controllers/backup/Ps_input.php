<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ps_input extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_complaint_input');
	}

	public function index() {
		$data = array(
			'title' => 'Problem Solving',
			'page_title' => '<i class="icon-tag"></i> Problem Solving Input',
			'active_menu_root' => 'problem_solving',
			'active_menu_child' => 'problem_solving',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
							 <li class="breadcrumb-item active">Problem Solving Input</li>',
			'get_data' => $this->m_complaint_input->get_data_ps(),
			'custom_scripts' => ""
		);
		$this->template->view('v_ps_input', $data);
	}

	public function edit_ps() {
		$data = array(
			'title' => 'Problem Solving',
			'page_title' => '<i class="icon-tag"></i> Problem Solving',
			'active_menu_root' => 'problem_solving',
			'active_menu_child' => 'problem_solving',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item">Problem Solving</li>
							 <li class="breadcrumb-item active">Problem Solving Input</li>',
			'get_data' => $this->m_complaint_input->get_data_ps($this->uri->segment(3)),
			'custom_scripts' => ""
		);
		$this->template->view('v_ps_input', $data);
	}

	function create_ps() {
		$rand = rand(10, 99).'-';
		$dateNow = date('YmdGis');
		if ($_FILES['fupload']['name'] != null) {
			$folderPath = $this->config->item('PATH_ASSET_PS').$dateNow;
    		mkdir($folderPath, 0777, true);
            chmod($folderPath, 0777);

		    $indexFile = fopen($folderPath.'/index.html', "w");
		    fwrite($indexFile, '<!DOCTYPE html> <html> <head> <title>403 Forbidden</title> </head> <body> <p>Directory access is forbidden.</p> </body> </html>');
		    fclose($indexFile);
            chmod($folderPath.'/index.html',0777);

			$filesCount = count($_FILES['fupload']['name']);
			for($i = 0; $i < $filesCount; $i++){

				$ext = pathinfo($_FILES['fupload']['name'][$i], PATHINFO_EXTENSION);
				// $_FILES['files']['name']     = $i.'.'.$ext;
				$_FILES['files']['name']     = $_FILES['fupload']['name'][$i];
				$_FILES['files']['type']     = $_FILES['fupload']['type'][$i];
				$_FILES['files']['tmp_name'] = $_FILES['fupload']['tmp_name'][$i];
				$_FILES['files']['error']    = $_FILES['fupload']['error'][$i];
				$_FILES['files']['size']     = $_FILES['fupload']['size'][$i];

				$config['upload_path']   = $folderPath;
				$config['allowed_types'] = 'pdf|jpg|jpeg|png|gif';
				// $config['file_name'] = $_FILES['fupload']['name'][$i];

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ( !$this->upload->do_upload('files') ){
					echo $this->upload->display_errors();
				}
				else{
					$data        = array('upload_data' => $this->upload->data());
					$upload_data = $this->upload->data(); //Mengambil detail data yang di upload
					$filename    = $upload_data['file_name'];//Nama File
					ini_set('memory_limit', '-1');

					$inputFileName = $this->config->item('PATH_ASSET_PS').$folderPath.'/'.$filename;
				}
			}

			$txtdocname = $this->input->post('txtdocname');
			$kode = $this->input->post('kode');
			$desc = $this->input->post('desc');
			$data = array(
				'kode_error' => $kode,
				'deskripsi_error' => $txtdocname,
				'solusi_error' => $desc,
				'file' => $dateNow,
			);
			if ($this->db->insert($this->config->item('TABLE_PROBLEM_SOLVING'), $data)) {
				$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Tambah Data'] );
			}else {
				$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Tambah Data'] );
			}
			redirect(base_url('ps_input'));
		}
	}

	function edited_ps() {
		$rand = rand(11, 999).'-';
		if ($_FILES['fupload']['name'] != null) {
			$folderPath = $this->config->item('PATH_ASSET_PS').$this->input->post('last-fupload');
			$filesCount = count($_FILES['fupload']['name']);
			for($i = 0; $i < $filesCount; $i++){

				$ext = pathinfo($_FILES['fupload']['name'][$i], PATHINFO_EXTENSION);
				// $_FILES['files']['name']     = $i.'.'.$ext;
				$_FILES['files']['name']     = $_FILES['fupload']['name'][$i];
				$_FILES['files']['type']     = $_FILES['fupload']['type'][$i];
				$_FILES['files']['tmp_name'] = $_FILES['fupload']['tmp_name'][$i];
				$_FILES['files']['error']    = $_FILES['fupload']['error'][$i];
				$_FILES['files']['size']     = $_FILES['fupload']['size'][$i];

				$config['upload_path']   = $folderPath;
				$config['allowed_types'] = 'pdf|jpg|jpeg|png|gif';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ( !$this->upload->do_upload('files') ){
					echo $this->upload->display_errors();
				}
				else{
					$data        = array('upload_data' => $this->upload->data());
					$upload_data = $this->upload->data(); //Mengambil detail data yang di upload
					$filename    = $upload_data['file_name'];//Nama File
					ini_set('memory_limit', '-1');

					$inputFileName = $this->config->item('PATH_ASSET_PS').$folderPath.'/'.$filename;
				}
			}

			$txtdocname = $this->input->post('txtdocname');
			$kode = $this->input->post('kode');
			$desc = $this->input->post('desc');
			$id = $this->input->post('id');

			$data = array(
				'kode_error' => $kode,
				'deskripsi_error' => $txtdocname,
				'solusi_error' => $desc,
			);

			if ($this->db->update($this->config->item('TABLE_PROBLEM_SOLVING'), $data, ['id' => $id])) {
				$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Edit Data'] );
			}else {
				$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Edit Data'] );
			}
		// }


		// if ($_FILES['fupload']['name'] != null) {


		// 	$config['upload_path']   = $this->config->item('PATH_ASSET_PS');
		// 	$config['allowed_types'] = 'pdf';
		// 	$config['file_name']     = $rand.$_FILES['fupload']['name'];
		// 	$this->load->library('upload', $config);
		// 	if ( !$this->upload->do_upload('fupload') ){
		// 		echo $this->upload->display_errors();
		// 	}
		// 	else{
		// 		$data        = array('upload_data' => $this->upload->data());
		// 		$upload_data = $this->upload->data(); //Mengambil detail data yang di upload
		// 		$filename    = $upload_data['file_name'];//Nama File
		// 		ini_set('memory_limit', '-1');

		// 		$inputFileName = $this->config->item('PATH_ASSET_PS').$filename;

		// 		$txtdocname = $this->input->post('txtdocname');
		// 		$desc = $this->input->post('desc');
		// 		$lastfilename = $this->input->post('last-fupload');
		// 		$id = $this->input->post('id');

		// 		// unlink($this->config->item('PATH_ASSET_PS').$lastfilename);
		// 		$data = array(
		// 			'kode_error' => $kode,
		// 			'deskripsi_error' => $txtdocname,
		// 			'solusi_error' => $desc,
		// 			// 'file' => $filename,
		// 		);

		// 		if ($this->db->update($this->config->item('TABLE_PROBLEM_SOLVING'), $data, ['id' => $id])) {
		// 			$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Edit Data'] );
		// 		}else {
		// 			$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Edit Data'] );
		// 		}
		// 	}
		}else {
			$txtdocname   = $this->input->post('txtdocname');
			$desc         = $this->input->post('desc');
			$lastfilename = $this->input->post('last-fupload');
			$id = $this->input->post('id');
			$data = array(
				'kode_error' => $kode,
				'deskripsi_error' => $txtdocname,
				'solusi_error' => $desc,
				'file' => $lastfilename,
			);
			if ($this->db->update($this->config->item('TABLE_PROBLEM_SOLVING'), $data, ['id' => $id])) {
				$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Edit Data'] );
			}else {
				$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Edit Data'] );
			}
		}

		redirect(base_url('ps_input'));

	}

	function del_ps() {
		$rand = rand(10, 99).'-';
		$data = $this->m_complaint_input->get_data_ps($this->uri->segment(3));
		if (count($data) > 0) {
			$files = glob( $this->config->item('PATH_ASSET_PS').$data->file . '/*');
			$totalFiles = count($files);
			$index = 0;
			foreach($files as $file){
				if (unlink($file)) {
					$index++;
				}else {
					$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Hapus File, Folder & Data'] );
				}
			}
			if ($totalFiles == $index) {
				if (rmdir($this->config->item('PATH_ASSET_PS').$data->file)) {
					if ($this->db->delete($this->config->item('TABLE_PROBLEM_SOLVING'), ['id' => $this->uri->segment(3)])) {
						$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Hapus Data'] );
					}else {
						$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Hapus Data'] );
					}
				}else {
					$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Hapus Folder & Data'] );
				}
			}
		}else {
			$this->session->set_userdata( ['status' => 0, 'msg' => 'Terjadi Kesalahan!'] );
		}
		redirect(base_url('ps_input'));
	}

	function del_file() {
		if (unlink($_GET['file'])) {
			$this->session->set_userdata( ['status' => 1, 'msg' => 'Berhasil Hapus File'] );
		}else {
			$this->session->set_userdata( ['status' => 0, 'msg' => 'Gagal Hapus File'] );
		}
		redirect(base_url('ps_input/edit_ps/'.$_GET['q']));
	}

}
