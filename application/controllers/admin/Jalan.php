<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jalan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('masterdata_model','master');
	}

	public function index()
	{
		$datacontent = [ 
			'page_title' =>'Data Jalan',
            'data_kecamatan' => $this->master->get_kecamatan()
		];
		$data['content']= $this->load->view('admin/masterdata/jalan_view', $datacontent, true);
		$this->load->view('layouts/html', $data);
	}
    
    // chained kecamatan => kelurahan
	public function get_kelurahan()
	{
		$id= $this->input->post('id',true);
		$data = $this->master->get_chain_kelurahan($id);
		header('Content-Type: application/json');
		echo json_encode($data);  
    }
	public function show_all()
	{
		$data_jalan = $this->master->get_jalan();
		$data = array();
		$no = 1;
		foreach ($data_jalan as $value) {
			$row = array();
			$row[] = $no++;
            $row[] = $value['nama_jalan'];
			$row[] = $value['nama_kelurahan'];
			$row[] = $value['nama_kecamatan'];
			//add html for action
			$row[] = '<center><button type="button" title="Edit" class="btn btn-link btn-primary btn-lg" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Edit" onclick="edit_jalan('."'".$value['id_jalan']."'".')"><i class="fa fa-edit"></i></button>
				  <button type="button" title="Hapus" class="btn btn-link btn-danger btn-lg" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Hapus" onclick="delete_jalan('."'".$value['id_jalan']."'".')"><i class="fa fa-minus-circle"></i></button></center>';
			$data[] = $row;
		}
		if ($data_jalan) {
			echo json_encode(array('data' => $data));
		} else {
			echo json_encode(array('data' => 0));
		}
       
	}

	public function add()
	{
		$this->_validate();
		
		$data = array(
            'nama_jalan' => $this->input->post('nama_jalan'),
            'id_kelurahan' => $this->input->post('id_kelurahan'),
            'id_kecamatan'	=> $this->input->post('id_kecamatan')
			);
		$insert = $this->master->insert_jalan($data);

		echo json_encode(array("status" => TRUE));
	}

	public function edit($id)
	{
		$data = $this->master->get_jalan_by_id($id);
		echo json_encode($data);
	}

	public function update()
	{
		$this->_validate();
		$data = array(
            'nama_jalan' => $this->input->post('nama_jalan'),
            'id_kelurahan' => $this->input->post('id_kelurahan'),
            'id_kecamatan'	=> $this->input->post('id_kecamatan')
			);
		$this->master->update_jalan(array('id_jalan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete($id)
	{
		$this->master->delete_jalan($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_jalan') == '')
		{
			$data['inputerror'][] = 'nama_jalan';
			$data['error_string'][] = 'Nama Jalan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('id_kecamatan') == '')
		{
			$data['inputerror'][] = 'id_kecamatan';
			$data['error_string'][] = 'Kecamatan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('id_kelurahan') == '')
		{
			$data['inputerror'][] = 'id_kelurahan';
			$data['error_string'][] = 'Kelurahan is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}