<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('peta_model','peta');
		$this->load->model('masterdata_model','master');

	}

	public function index()
	{
		$datacontent = [ 
			'page_title' =>'Peta Drainase',
			'jalan' => $this->master->select_jalan(),
			'lajur_drainase' => $this->master->select_lajur_drainase(),
			'arah_aliran' => $this->master->select_arah_aliran(),
			'kondisi_fisik' => $this->master->select_kondisi_fisik(),
			'kondisi_sedimen' => $this->master->select_kondisi_sedimen(),
			'tipe_saluran' => $this->master->select_tipe_saluran(),
			'penanganan' => $this->master->select_penanganan(),
            'kecamatan' => $this->peta->get_kecamatan(),
		];
		$data['content']= $this->load->view('admin/peta/peta_view', $datacontent, true);
		$this->load->view('layouts/html', $data);
		$this->load->view('admin/masterdata/drainase_crud');
	
	}
	
	public function titik_drainase()
	{
		$titik_drainase = $this->peta->get_peta();
		echo json_encode($titik_drainase,JSON_PRETTY_PRINT);
	}
	
	public function edit_r24($id)
	{
		$data = $this->peta->get_r24_by_id($id);
		echo json_encode($data);
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

		if($this->input->post('r24')=='')
		{
			$data['inputerror'][] = 'r24';
			$data['error_string'][] ='R24 is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('r24')!=='' && !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('r24')))
        {
        $data['inputerror'][] = 'r24';
        $data['error_string'][] ='R24 type in decimal format';
        $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}