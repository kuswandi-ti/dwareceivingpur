<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class calendar_event extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = array(
			'title' => 'Calendar Event',
			'page_title' => '<i class="icon-calender"></i> Calendar Event',
			'active_menu_root' => 'calendar_event',
			'active_menu_child' => '',
			'breadcrumb' => '<li class="breadcrumb-item"><i class="icon-home"></i><a href=""> Home</a></li>
                             <li class="breadcrumb-item active">Calendar Event</li>',
			'custom_scripts' => "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."calendar_event.js type='text/javascript'></script>"
		);
		$this->template->view('v_calendar_event', $data);
	}

}
