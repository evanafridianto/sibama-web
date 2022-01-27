<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('peta_model', 'peta');
	}

	public function index()
	{
		$datacontent = [
			'page_title' => 'Peta Drainase',
		];
		$data['content'] = $this->load->view('web/pages/peta_view', $datacontent, true);
		$this->load->view('web/layouts/main', $data);
	}

	public function about()
	{
		$datacontent = [
			'page_title' => 'About',
		];
		$data['content'] = $this->load->view('web/pages/about_view', $datacontent, true);
		$this->load->view('web/layouts/main', $data);
	}
	public function feedback()
	{
		$datacontent = [
			'page_title' => 'Feedback',
		];
		$data['content'] = $this->load->view('web/pages/feedback_view', $datacontent, true);
		$this->load->view('web/layouts/main', $data);
	}

	public function detail_r24($id)
	{
		$data = $this->peta->getR24byId($id);
		echo json_encode($data);
	}
}