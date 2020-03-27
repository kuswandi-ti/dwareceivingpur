<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
	protected $_ci;

	protected $conn_name_dwasys;
	protected $conn_dwasys;

	protected $table_mst_email_requester;

	public function __construct() { 
		$this->_ci = &get_instance(); // Set variabel _ci dengan Fungsi2-fungsi dari Codeigniter        
		require_once(APPPATH.'third_party/phpmailer/Exception.php');
		require_once(APPPATH.'third_party/phpmailer/PHPMailer.php');
		require_once(APPPATH.'third_party/phpmailer/SMTP.php');

		// $this->conn_name_dwasys             = $this->config->item('CONN_NAME_DWASYS_RESCUE'); /* Test */
        $this->conn_name_dwasys             = $this->_ci->config->item('CONN_NAME_DWASYS'); /* Live */
        $this->conn_dwasys                  = $this->_ci->load->database($this->conn_name_dwasys, TRUE);

        $this->table_mst_email_requester	= $this->_ci->config->item('TABLE_MST_EMAIL_REQ_RR');
	}

	// https://www.mynotescode.com/mengirim-email-localhost-server-codeigniter/
	// https://www.plus2net.com/php_tutorial/php_mailer-multiple.php
	public function send_email_without_attachment($data) {
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_HOST');
		$mail->Username = $this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_EMAIL');
		$mail->Port = $this->_ci->config->item('EMAIL_PORT');
		//$mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging

		$mail->setFrom($this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_EMAIL'), $this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_NAME'));
		$mail->addAddress($data['email_penerima'], $data['nama_penerima']);
		$mail->addCC('kemuning.widantia@dwa.co.id', 'Kemuning Windantia - ACC');
		$mail->isHTML(true); // Aktifkan jika isi emailnya berupa html 
		$mail->Subject = $data['subjek'];
		$mail->Body = $data['content'];
		$send = $mail->send();

		if ($send) { // Jika Email berhasil dikirim
			$response = array('send_email_status'=>'Send Email Sukses', 'send_email_message'=>'Send Email Email berhasil dikirim');
		} else { // Jika Email Gagal dikirim
			$response = array('send_email_status'=>'Send Email Gagal', 'send_email_message'=>'Send Email Email gagal dikirim');
		}
		return $response;
	}

	public function send_email_with_attachment($data) {
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_HOST');
		$mail->Username = $this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_EMAIL');
		$mail->Port = $this->_ci->config->item('EMAIL_PORT');
		//$mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging

		$mail->setFrom($this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_EMAIL'), $this->_ci->config->item('EMAIL_PUR_RECEIVING_FROM_NAME'));

		$data_email_penerima = $this->conn_dwasys->get_where($this->table_mst_email_requester, array('Department' => $data['department']));	
		foreach ($data_email_penerima->result_array() as $row) {
			$nama_penerima = $row['PIC_Nama'];
			$email_penerima = $row['PIC_Email'];
			$mail->addAddress($email_penerima, $nama_penerima);
		}
		//$mail->addAddress($data['email_penerima'], '');
		$mail->addCC('kemuning.widantia@dwa.co.id', 'Kemuning Windantia - ACC');

		$mail->isHTML(true); // Aktifkan jika isi emailnya berupa html
		$mail->Subject = $data['subjek'];
		$mail->Body = $data['content'];
		$mail->addAttachment($data['attachment']);
		$send = $mail->send();
		if ($send) { // Jika Email berhasil dikirim
			$response = array('send_email_status'=>'Send Email Sukses', 'send_email_message'=>'Send Email Email berhasil dikirim');
		} else { // Jika Email Gagal dikirim
			$response = array('send_email_status'=>'Send Email Gagal', 'send_email_message'=>$mail->ErrorInfo);
		}
		return $response;
	}
}