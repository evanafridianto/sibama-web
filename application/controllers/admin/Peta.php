<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peta extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('admin/login');
		}
		$this->load->model('peta_model', 'peta');
		$this->load->model('datamaster_model', 'master');
	}

	public function index()
	{
		$datacontent = [
			'page_title' => 'Peta Drainase',
			'lajur_drainase' => $this->master->select('lajur_drainase')->result(),
			'arah_aliran' => $this->master->select('arah_aliran')->result(),
			'kondisi_fisik' => $this->master->select('kondisi_fisik')->result(),
			'kondisi_sedimen' => $this->master->select('kondisi_sedimen')->result(),
			'tipe_saluran' => $this->master->select('tipe_saluran')->result(),
			'penanganan' => $this->master->select('penanganan')->result(),
		];
		$data['content'] = $this->load->view('admin/peta/peta_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
		$this->load->view('admin/datamaster/drainase_form');
	}

	public function update_r24()
	{
		$this->_validate();
		$data = array(
			'r24' => $this->input->post('r24'),
		);
		$this->peta->update_r24(array('id_r24' => $this->input->post('id_r24')), $data);
		echo json_encode(array("status" => TRUE));
	}
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('r24') == '') {
			$data['inputerror'][] = 'r24';
			$data['error_string'][] = 'R24 is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('r24') !== '' && !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('r24'))) {
			$data['inputerror'][] = 'r24';
			$data['error_string'][] = 'R24 type in decimal format';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}