<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('peta_model','peta');
	}

	public function index()
	{
		$datacontent = [ 
			'page_title' =>'Peta Drainase',
            'titik_drainase' =>$this->peta->get_peta(),
            'kecamatan' => $this->peta->get_kecamatan()
		];
		$data['content']= $this->load->view('admin/peta/peta_view', $datacontent, true);
		$this->load->view('layouts/html', $data);
		$this->load->view('admin/peta/petaJs');
	}
    

}