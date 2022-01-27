<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('admin/login');
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
			'lajur_drainase' => $this->master->select('lajur_drainase')->result(),
			'arah_aliran' => $this->master->select('arah_aliran')->result(),
			'kondisi_fisik' => $this->master->select('kondisi_fisik')->result(),
			'kondisi_sedimen' => $this->master->select('kondisi_sedimen')->result(),
			'tipe_saluran' => $this->master->select('tipe_saluran')->result(),
			'penanganan' => $this->master->select('penanganan')->result(),
		];
		$data['content'] = $this->load->view('admin/dashboard_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
		$this->load->view('admin/datamaster/drainase_form');
	}

	public function drainase_rusak()
	{
		$data_drainase = $this->dashboard->get_drainase_rusak();
		$data = array();
		$no = 1;
		foreach ($data_drainase as $value) {
			$row = array();
			$row[] = $no++;
			$row[] = $value['nama_jalan'] . ', ' . $value['nama_kelurahan'] . ', ' . $value['nama_kecamatan'];
			$row[] = $value['lat_awal'];
			$row[] = $value['long_awal'];
			$row[] = $value['lat_akhir'];
			$row[] = $value['long_akhir'];
			$row[] = $value['kondisi_fisik'];
			$row[] = $value['lajur_drainase'];
			//add html for action
			$row[] = '<button class="table-action-btn btn-success" onclick="edit_drainase(' . "'" . $value['id'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
            <button class="table-action-btn btn-danger" onclick="delete_drainase(' . "'" . $value['id'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
			$data[] = $row;
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