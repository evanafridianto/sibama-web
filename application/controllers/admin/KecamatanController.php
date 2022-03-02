<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KecamatanController extends CI_Controller
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
            'page_title' => 'Data Kecamatan',
        ];
        $data['content'] = $this->load->view('admin/datamaster/kecamatan_view', $datacontent, true);
        $this->load->view('admin/layouts/main', $data);
    }

    public function show_all()
    {
        $data_kecamatan = $this->master->getKecamatan();
        $data = array();
        $no = 1;
        foreach ($data_kecamatan->result_array() as $value) {
            $row = array();
            $row[] = $no++;
            $row[] = $value['nama_kecamatan'];
            $row[] = $value['file_geojson'];
            //add html for action
            $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kecamatan(' . "'" . $value['id_kecamatan'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kecamatan(' . "'" . $value['id_kecamatan'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
            $data[] = $row;
        }
        if ($data_kecamatan) {
            echo json_encode(array('data' => $data));
        } else {
            echo json_encode(array('data' => 0));
        }
    }

    public function edit($id)
    {
        $data = $this->master->getDatabyId('kecamatan', 'id_kecamatan', $id);
        echo json_encode($data);
    }

    public function save()
    {
        $this->form_validation->set_rules('nama_kecamatan', 'Nama Kecamatan', 'trim|required');
        $data = array(
            'nama_kecamatan' => $this->input->post('nama_kecamatan'),
            'file_geojson'    => $this->input->post('file_geojson')
        );
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array("error" => ['nama_kecamatan' => form_error('nama_kecamatan')], "status" => FALSE));
        } else {
            if ($this->input->post('id') == '') {
                $this->master->create('kecamatan', $data);
                echo json_encode(array("status" => TRUE));
            } else {
                $this->master->update('kecamatan', array('id_kecamatan' => $this->input->post('id')), $data);
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function delete($id)
    {
        $this->master->delete('kecamatan', 'id_kecamatan', $id);
        echo json_encode(array("status" => TRUE));
    }
}