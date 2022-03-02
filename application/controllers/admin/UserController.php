<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
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
			$row[] = is_file('upload/users/' . $value['photo']) ? '<a href="' . base_url('upload/users/' . $value['photo']) . '"data-lightbox="gallery-set"><img src="' . base_url('upload/users/' . $value['photo']) . '" alt="user-img" class="img-circle user-img" style="height:100px"></a>' : 'empty';
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

	public function save()
	{
		$config = array(
			[
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required',
			],
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'trim|required|min_length[5]|is_unique[user.username]',
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|min_length[5]',
			],
			[
				'field' => 'konfir_password',
				'label' => 'Konfirmasi Password',
				'rules' => 'trim|required|matches[password]',
			]
		);
		$this->form_validation->set_rules($config);
		$data = array(
			'username' => $this->input->post('username'),
			'nama'    => $this->input->post('nama'),
			'password'    => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
		);

		if ($this->form_validation->run() == FALSE) {
			$this->form_validation->set_error_delimiters('', '');
			$json = array(
				'nama' => form_error('nama'),
				'username' => form_error('username'),
				'password' => form_error('password'),
				'konfir_password' => form_error('konfir_password'),
			);
			echo json_encode(array("error" => $json, "status" => FALSE));
		} else {
			if (!empty($_FILES['photo']['name'])) {
				$uploadFoto = $this->_do_upload_photo();
				$data['photo'] = $uploadFoto;
			}
			$this->master->create('user', $data);
			echo json_encode(array("status" => TRUE));
		}
	}


	public function update($type)
	{
		if ($type == 'profil') {
			$config = array(
				[
					'field' => 'nama',
					'label' => 'Nama',
					'rules' => 'required',
				],
				[
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'trim|required|min_length[5]',
				]
			);
			$this->form_validation->set_rules($config);
			$data = array(
				'username' => $this->input->post('username'),
				'nama'    => $this->input->post('nama'),
			);
			if ($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('', '');
				$json =
					array(
						'nama' => form_error('nama'),
						'username' => form_error('username'),
					);
				echo json_encode(array("error" => $json, "status" => FALSE));
			} else {
				if (!empty($_FILES['photo']['name'])) {
					$uploadFoto = $this->_do_upload_photo();
					$data['photo'] = $uploadFoto;
				}
				if ($_FILES['photo']['name'] != '' || !empty($_FILES['photo']['name'])) {
					if (file_exists('upload/users/' . $this->input->post('remove_photo'))) {
						unlink('upload/users/' . $this->input->post('remove_photo'));
					}
				}
				$this->master->update('user', array('id_user' => $this->input->post('id_user')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}
		if ($type == 'password') {
			$config = array(
				[
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|callback_password_check',
				],
				[
					'field' => 'password_baru',
					'label' => 'Password Baru',
					'rules' => 'trim|required|min_length[5]',
				],
				[
					'field' => 'konfir_password',
					'label' => 'Konfirmasi Password',
					'rules' => 'trim|required|matches[password_baru]',
				]
			);
			$this->form_validation->set_rules($config);
			$data = array(
				'password' => password_hash($this->input->post('konfir_password'), PASSWORD_DEFAULT),
			);
			if ($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('', '');
				$json =
					array(
						'password' => form_error('password'),
						'password_baru' => form_error('password_baru'),
						'konfir_password' => form_error('konfir_password'),
					);
				echo json_encode(array("error" => $json, "status" => FALSE));
			} else {
				$this->master->update('user', array('id_user' => $this->input->post('id_user')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}
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

	public function password_check($password)
	{
		$sql  = $this->db->get_where('user', ['id_user' => $this->session->id_user])->row();
		if (!password_verify($password, $sql->password) && $password != '') {
			$this->form_validation->set_message('password_check', 'The {field} is wrong');
			return false;
		}
		return true;
	}
}

/* End of file User.php */