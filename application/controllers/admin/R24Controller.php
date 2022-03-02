<?php
defined('BASEPATH') or exit('No direct script access allowed');

class R24Controller extends CI_Controller
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
            'page_title' => 'Data Curah Hujan/R24 / Kecamatan',
            'kecamatan' => $this->master->getKecamatan()->result(),
        ];
        $data['content'] = $this->load->view('admin/datamaster/r24_view', $datacontent, true);
        $this->load->view('admin/layouts/main', $data);
    }

    public function show_all()
    {
        $data_r24 = $this->master->getR24();
        $data = array();
        $no = 1;
        foreach ($data_r24->result_array() as $value) {
            $row = array();
            $row[] = $no++;
            $row[] = $value['nama_kecamatan'];
            $row[] = $value['r24'];
            $row[] = $value['tahun'];
            //add html for action
            $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_r24(' . "'" . $value['id_r24'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_r24(' . "'" . $value['id_r24'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
            $data[] = $row;
        }
        if ($data_r24) {
            echo json_encode(array('data' => $data));
        } else {
            echo json_encode(array('data' => 0));
        }
    }

    public function edit($id)
    {
        $data = $this->master->getDatabyId('setting_r24', 'id_r24', $id);
        echo json_encode($data);
    }

    public function save()
    {
        $config = array(
            [
                'field' => 'id_kecamatan',
                'label' => 'Kecamatan',
                'rules' => 'required',
            ],
            [
                'field' => 'r24',
                'label' => 'Nama Jalan',
                'rules' => 'trim|required|decimal',
            ],
            [
                'field' => 'tahun',
                'label' => 'Kelurahan',
                'rules' => 'required',
            ]
        );
        $this->form_validation->set_rules($config);
        $data = array(
            'id_kecamatan'    => $this->input->post('id_kecamatan'),
            'r24' => $this->input->post('r24'),
            'tahun' => $this->input->post('tahun')
        );

        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            $json = array(
                'id_kecamatan' => form_error('id_kecamatan'),
                'r24' => form_error('r24'),
                'tahun' => form_error('tahun'),
            );
            echo json_encode(array("error" => $json, "status" => FALSE));
        } else {
            if ($this->input->post('id_r24') == '') {
                $this->master->create('setting_r24', $data);
                echo json_encode(array("status" => TRUE));
            } else {
                $this->master->update('setting_r24', array('id_r24' => $this->input->post('id_r24')), $data);
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function delete($id)
    {
        $this->master->delete('setting_r24', 'id_r24', $id);
        echo json_encode(array("status" => TRUE));
    }
}