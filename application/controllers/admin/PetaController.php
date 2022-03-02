<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PetaController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('login');
		}
		$this->load->model('datamaster_model', 'master');
	}

	public function index()
	{
		$datacontent = [
			'page_title' => 'Peta Drainase',
			'jalan' => $this->master->getJalan()->result(),
			'kondisi_fisik' => $this->master->get('kondisi_fisik_drainase')->result(),
			'kondisi_sedimen' => $this->master->get('kondisi_sedimen_drainase')->result(),
			'penanganan' => $this->master->get('penanganan_drainase')->result(),
		];
		$data['content'] = $this->load->view('admin/peta/peta_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
		$this->load->view('admin/datamaster/drainase_form');
	}
}