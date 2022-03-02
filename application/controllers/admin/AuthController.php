<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
  public function index()
  {
    $datacontent = [
      'page_title' => 'Form Login',
    ];
    $this->load->view('admin/auth_view', $datacontent);
  }

  public function check()
  {
    $config = array(
      [
        'field' => 'username',
        'label' => 'Username',
        'rules' => 'required',
      ],
      [
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'required',
      ]
    );
    $this->form_validation->set_rules($config);

    $username = htmlspecialchars($this->input->post('username'));
    $password = htmlspecialchars($this->input->post('password'));

    $query  = $this->db->get_where('user', ['username' => $username]);

    if ($this->form_validation->run() == FALSE) {
      $this->form_validation->set_error_delimiters('', '');
      $json = array(
        'username' => form_error('username'),
        'password' => form_error('password'),
      );
      echo json_encode(array("error" => $json, "status" => FALSE));
    } else {
      if ($query->num_rows() > 0) {
        $row = $query->row();
        if (password_verify($password, $row->password)) {
          $session_data = array(
            'logged' => true,
            'id_user' => $row->id_user,
            'username' => $row->username,
            'password' => $row->password,
            'nama' => $row->nama,
            'photo' => $row->photo
          );
          $this->session->set_userdata($session_data);
          echo json_encode(array("status" => TRUE));
        } else {
          $this->session->set_userdata("logged", FALSE);
          echo json_encode(array("status" => FALSE, "msg" => 'Password salah'));
        }
      } else {
        $this->session->set_userdata("logged", FALSE);
        echo json_encode(array("status" => FALSE, "msg" => 'Username tidak tersedia'));
      }
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    echo json_encode(array("status" => TRUE));
  }
}
/* End of file  AuthController.php */