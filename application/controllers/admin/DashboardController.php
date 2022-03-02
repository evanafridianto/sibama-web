<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('login');
		}
		$this->load->model('Dashboard_model', 'dashboard');
		$this->load->model('Datamaster_model', 'master');
	}

	public function index()
	{
		$datacontent = [
			'page_title' => 'Dashboard',
			'count_drainase' => $this->dashboard->count('drainase'),
			'count_jalan' => $this->dashboard->count('jalan'),
			'count_kelurahan' => $this->dashboard->count('kelurahan'),
			'count_kecamatan' => $this->dashboard->count('kecamatan'),
		];
		$data['content'] = $this->load->view('admin/dashboard_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
	}

	public function drainase_kelurahan()
	{
		$data_drainase = $this->dashboard->getCountDrainaseKelurahan();
		$data = array();
		$no = 1;
		foreach ($data_drainase as $value) {
			$row = array();
			$row[] = '<div class="text-center">' . $no++ . '</div>';
			$row[] = $value['nama_kelurahan'];
			$row[] = '<div class="text-center">' . $value['total'] . '</div>';
			$data[] = $row;
		}
		if ($data_drainase) {
			echo json_encode(array('data' => $data));
		} else {
			echo json_encode(array('data' => 0));
		}
	}
}

/* End of file  DashboardController.php */