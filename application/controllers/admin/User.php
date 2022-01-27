<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('admin/login');
		}
		$this->load->model('datamaster_model', 'master');
	}

	public function index()
	{
		$datacontent = [
			'page_title' => 'Data User',
		];
		$data['content'] = $this->load->view('admin/datamaster/user_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
	}

	public function show_all()
	{
		$data_user = $this->master->getUser();
		$data = array();
		$no = 1;
		foreach ($data_user->result_array() as $value) {
			$row = array();
			$row[] = $no++;
			$row[] = $value['username'];
			$row[] = $value['nama'];
			$row[] = '<a href="' . base_url('upload/users/' . $value['photo']) . '"data-lightbox="gallery-set">' . $value['photo'] . '';
			//add html for action
			$row[] = '<div class="text-center">
			<button class="table-action-btn btn-danger" onclick="delete_user(' . "'" . $value['id_user'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
			// $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_user(' . "'" . $value['id_user'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			// <button class="table-action-btn btn-danger" onclick="delete_user(' . "'" . $value['id_user'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
			$data[] = $row;
		}
		if ($data_user) {
			echo json_encode(array('data' => $data));
		} else {
			echo json_encode(array('data' => 0));
		}
	}

	public function add()
	{
		$this->_validate('add');
		$data = array(
			'username' => $this->input->post('username'),
			'nama'    => $this->input->post('nama'),
			'password'    => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
		);

		if (!empty($_FILES['photo']['name'])) {
			$uploadFoto = $this->_do_upload_photo();
			$data['photo'] = $uploadFoto;
		}
		$this->master->create('user', $data);
		echo json_encode(array("status" => TRUE));
	}

	public function edit($id)
	{
		$data = $this->master->getDatabyId('user', 'id_user', $id);

		if (
			!file_exists('upload/users/' . $data->photo) ||
			$data->photo == ''
		) {
			$data->photo = 'noimage.jpg';
		}
		echo json_encode($data);
	}

	public function update($type)
	{
		$data = 0;
		if ($type == 'profil') {
			$this->_validate('profil');
			$data = array(
				'username' => $this->input->post('username'),
				'nama'    => $this->input->post('nama'),
			);

			// if remove foto checked
			if ($this->input->post('remove_photo')) {
				if (file_exists('upload/users/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo')) {
					unlink('upload/users/' . $this->input->post('remove_photo'));
					$data['photo'] = '';
				}
			}
			// update foto
			if (!empty($_FILES['photo']['name'])) {
				$uploadFoto = $this->_do_upload_photo();
				$data['photo'] = $uploadFoto;
			}
			// end
		}
		if ($type == 'password') {
			$this->_validate('password');
			$data = array(
				'password' => password_hash($this->input->post('konfir_password'), PASSWORD_DEFAULT),
			);
		}
		$this->master->update('user', array('id_user' => $this->input->post('id_user')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete($id)
	{
		$data = $this->master->getDatabyId('user', 'id_user', $id);
		if (file_exists('upload/users/' . $data->photo) && $data->photo)
			unlink('upload/users/' . $data->photo);

		$this->master->delete('user', 'id_user', $id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload_photo()
	{
		$nameFile = $this->input->post('username');
		$config['upload_path'] = 'upload/users/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 24000; //set max size allowed in Kilobyte
		$config['max_width'] = 5000; // set max width image allowed
		$config['max_height'] = 5000; // set max height allowed
		$config['file_name'] = $nameFile . '_' . round(microtime(true) * 1000);

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('photo')) //upload and validate
		{
			$data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	private function _validate($for)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($for == 'add') {
			if ($this->input->post('nama') == '') {
				$data['inputerror'][] = 'nama';
				$data['error_string'][] = 'Nama is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('username') == '') {
				$data['inputerror'][] = 'username';
				$data['error_string'][] = 'Username is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('password') == '') {
				$data['inputerror'][] = 'password';
				$data['error_string'][] = 'Password Lama is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('konfir_password') == '') {
				$data['inputerror'][] = 'konfir_password';
				$data['error_string'][] = 'Konfirmasi Password is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('password') != $this->input->post('konfir_password') && !empty($this->input->post('konfir_password'))) {
				$data['inputerror'][] = 'konfir_password';
				$data['error_string'][] = "Konfirmasi Password doesn't match";
				$data['status'] = FALSE;
			}
		}
		if ($for == 'profil') {
			if ($this->input->post('nama') == '') {
				$data['inputerror'][] = 'nama';
				$data['error_string'][] = 'Nama is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('username') == '') {
				$data['inputerror'][] = 'username';
				$data['error_string'][] = 'Username is required';
				$data['status'] = FALSE;
			}
		}

		if ($for == 'password') {
			if ($this->input->post('password') == '') {
				$data['inputerror'][] = 'password';
				$data['error_string'][] = 'Password Lama is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('password_baru') == '') {
				$data['inputerror'][] = 'password_baru';
				$data['error_string'][] = 'Password Baru is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('konfir_password') == '') {
				$data['inputerror'][] = 'konfir_password';
				$data['error_string'][] = 'Konfirmasi Password is required';
				$data['status'] = FALSE;
			}
			if ($this->input->post('password_baru') != $this->input->post('konfir_password') && !empty($this->input->post('konfir_password'))) {
				$data['inputerror'][] = 'konfir_password';
				$data['error_string'][] = "Konfirmasi Password doesn't match";
				$data['status'] = FALSE;
			}

			$cek  = $this->db->get_where('user', ['id_user' => $this->session->id_user])->row();
			if (!password_verify($this->input->post('password'), $cek->password) && !empty($this->input->post('password'))) {
				$data['inputerror'][] = 'password';
				$data['error_string'][] = "Password Lama is wrong";
				$data['status'] = FALSE;
			}
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}

/* End of file User.php */