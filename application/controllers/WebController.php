<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WebController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('datamaster_model', 'master');
	}

	public function index()
	{
		$datacontent = [
			'page_title' => 'Peta Drainase',
		];
		$this->load->view('website/index', $datacontent);
	}
}