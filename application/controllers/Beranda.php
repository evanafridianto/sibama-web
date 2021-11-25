<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Beranda_model', 'Beranda');
		//Do your magic here
	}

	public function index()
	{
		$datacontent['page_title'] = 'Beranda';
		$data['content'] = $this->load->view('admin/beranda_view', $datacontent, true);
		$this->load->view('layouts/html', $data);
	}
}

/* End of file  BerandaController.php */