<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KondisiPenangananDrainaseController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->logged !== true) {
            redirect('login');
        }
        $this->load->model('Datamaster_model', 'master');
    }
    public function index()
    {
        $datacontent = [
            'page_title' => 'Kondisi & Penanganan Drainase',
        ];
        $data['content'] = $this->load->view('admin/datamaster/kondisi-penanganan_view', $datacontent, true);
        $this->load->view('admin/layouts/main', $data);
    }

    public function show_all($table = 'kondisi_fisik')
    {
        if ($table == 'kondisi_fisik') {
            $kondisi_fisik = $this->master->get('kondisi_fisik_drainase');
            $data = array();
            $no = 1;
            foreach ($kondisi_fisik->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['nama_kondisi_fisik'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_data(' . "'" . 'kondisi_fisik' . "'" . ',' . "'" . $value['id_kondisi_fisik'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_data(' . "'" . 'kondisi_fisik' . "'" . ',' . "'" . $value['id_kondisi_fisik'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($kondisi_fisik) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } elseif ($table == 'kondisi_sedimen') {
            $kondisi_sedimen = $this->master->get('kondisi_sedimen_drainase');
            $data = array();
            $no = 1;
            foreach ($kondisi_sedimen->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['nama_kondisi_sedimen'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_data(' . "'" . 'kondisi_sedimen' . "'" . ',' . "'" . $value['id_kondisi_sedimen'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_data(' . "'" . 'kondisi_sedimen' . "'" . ',' . "'" . $value['id_kondisi_sedimen'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($kondisi_sedimen) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } else {
            $penanganan = $this->master->get('penanganan_drainase');
            $data = array();
            $no = 1;
            foreach ($penanganan->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['nama_penanganan'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_data(' . "'" . 'penanganan' . "'" . ',' . "'" . $value['id_penanganan'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_data(' . "'" . 'penanganan' . "'" . ',' . "'" . $value['id_penanganan'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($penanganan) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        }
    }

    public function edit($table = 'kondisi_fisik', $id = '')
    {
        if ($table == 'kondisi_fisik') {
            $data = $this->master->getDatabyId('kondisi_fisik_drainase', 'id_kondisi_fisik', $id);
        } elseif ($table == 'kondisi_sedimen') {
            $data = $this->master->getDatabyId('kondisi_sedimen_drainase', 'id_kondisi_sedimen', $id);
        } else {
            $data = $this->master->getDatabyId('penanganan_drainase', 'id_penanganan', $id);
        }
        echo json_encode($data);
    }

    public function save($table = 'kondisi_fisik')
    {
        $this->form_validation->set_rules('nama', 'Nama' . ' ' .  ucwords(str_replace('_', ' ', $table)), 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array("error" => ["nama" => form_error("nama")], "status" => FALSE));
        } else {
            if ($this->input->post('id') == '') {
                if ($table == 'kondisi_fisik') {
                    $data = [
                        'nama_kondisi_fisik' => $this->input->post('nama'),
                    ];
                    $this->master->create('kondisi_fisik_drainase', $data);
                } else if ($table == 'kondisi_sedimen') {
                    $data = [
                        'nama_kondisi_sedimen' => $this->input->post('nama'),
                    ];
                    $this->master->create('kondisi_sedimen_drainase', $data);
                } else {
                    $data = [
                        'nama_penanganan' => $this->input->post('nama'),
                    ];
                    $this->master->create('penanganan_drainase', $data);
                }
                echo json_encode(array("status" => TRUE));
            } else {
                if ($table == 'kondisi_fisik') {
                    $data = array(
                        'nama_kondisi_fisik' => $this->input->post('nama'),
                    );
                    $this->master->update('kondisi_fisik_drainase', array('id_kondisi_fisik' => $this->input->post('id')), $data);
                } elseif ($table == 'penanganan') {
                    $data = array(
                        'nama_penanganan' => $this->input->post('nama'),
                    );
                    $this->master->update('penanganan_drainase', array('id_penanganan' => $this->input->post('id')), $data);
                } else {
                    $data = array(
                        'nama_kondisi_sedimen' => $this->input->post('nama'),
                    );
                    $this->master->update('kondisi_sedimen_drainase', array('id_kondisi_sedimen' => $this->input->post('id')), $data);
                }
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function delete($table = 'tipe_saluran', $id = '')
    {
        if ($table == 'kondisi_fisik') {
            $this->master->delete('kondisi_fisik_drainase', 'id_kondisi_fisik', $id);
        } elseif ($table == 'kondisi_sedimen') {
            $this->master->delete('kondisi_sedimen_drainase', 'id_kondisi_sedimen', $id);
        } else {
            $this->master->delete('penanganan_drainase', 'id_penanganan', $id);
        }
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file KondisiPenangananDrainase.php */