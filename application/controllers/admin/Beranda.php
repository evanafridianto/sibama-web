<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Beranda_model', 'beranda');
		//Do your magic here
	}
	public function index()
	{
		$datacontent = [
			'page_title' => 'Beranda',
			'count_drainase' => $this->beranda->count_drainase(),
			'count_jalan' => $this->beranda->count_jalan(),
			'count_kelurahan' => $this->beranda->count_kelurahan(),
			'count_kecamatan' => $this->beranda->count_kecamatan()
		];
		$data['content'] = $this->load->view('admin/beranda_view', $datacontent, true);
		$this->load->view('layouts/html', $data);
	}
	
	public function drainase_rusak()
	{
		$data_drainase = $this->beranda->get_drainase_rusak();
		$data = array();
		$no = 1;
		foreach ($data_drainase as $value) {
			$row = array();
			$row[] = $no++;
            $row[] = $value['nama_jalan'];
			$row[] = $value['lat_awal'];
			$row[] = $value['long_awal'];
			$row[] = $value['lat_akhir'];
			$row[] = $value['long_akhir'];
			$row[] = $value['kondisi_fisik'];
			$row[] = $value['lajur_drainase'];
			//add html for action
			// $row[] = '<center><button class="table-action-btn btn-primary" onclick="detail_drainase('."'".$value['id']."'".')"><i class="mdi mdi-eye" title="Detail"></i></button>';
			$data[] = $row;
		}
		if ($data_drainase) {
			echo json_encode(array('data' => $data));
		} else {
			echo json_encode(array('data' => 0));
		}
	}
}

/* End of file  BerandaController.php */