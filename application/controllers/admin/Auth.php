<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
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
    $this->_validate();

    $username = htmlspecialchars($this->input->post('username'));
    $password = htmlspecialchars($this->input->post('password'));

    $query  = $this->db->get_where('user', ['username' => $username]);

    if ($query->num_rows() > 0) {
      $row = $query->row();
      if (password_verify($password, $row->password)) {
        $session_data = array(
          'logged' => true,
          'id_user' => $row->id_user,
          'username' => $row->username,
          // 'password' => $row->password,
          'nama' => $row->nama,
          'photo' => $row->photo
        );
        $this->session->set_userdata($session_data);
        echo json_encode(array("status" => TRUE));
      } else {
        $this->session->set_userdata("logged", FALSE);
        echo json_encode(array("status" => FALSE, 'msg' => 'Password salah'));
      }
    } else {
      $this->session->set_userdata("logged", FALSE);
      echo json_encode(array("status" => FALSE, 'msg' => 'Username tidak tersedia'));
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    echo json_encode(array("status" => TRUE));
  }

  private function _validate()
  {
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if ($this->input->post('username') == '') {
      $data['inputerror'][] = 'username';
      $data['error_string'][] = 'Username is required';
      $data['status'] = FALSE;
    }
    if ($this->input->post('password') == '') {
      $data['inputerror'][] = 'password';
      $data['error_string'][] = 'Password is required';
      $data['status'] = FALSE;
    }
    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    }
  }
}

/* End of file  AuthController.php */