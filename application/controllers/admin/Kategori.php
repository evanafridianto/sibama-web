<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->logged !== true) {
            redirect('admin/login');
        }
        $this->load->model('datakategori_model', 'kategori');
    }

    public function index()
    {
        $datacontent = [
            'page_title' => 'Data Kategori',
        ];
        $data['content'] = $this->load->view('admin/datakategori/kategori_view', $datacontent, true);
        $this->load->view('admin/layouts/main', $data);
    }

    public function show_all($table = 'tipe_saluran')
    {
        if ($table == 'tipe_saluran') {
            $tipe_saluran = $this->kategori->get_kategori('tipe_saluran', 'id_tipe_saluran');
            $data = array();
            $no = 1;
            foreach ($tipe_saluran->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['tipe_saluran'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kategori(' . "'" . 'tipe_saluran' . "'" . ',' . "'" . $value['id_tipe_saluran'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kategori(' . "'" . 'tipe_saluran' . "'" . ',' . "'" . $value['id_tipe_saluran'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($tipe_saluran) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } elseif ($table == 'arah_aliran') {
            $arah_aliran = $this->kategori->get_kategori('arah_aliran', 'id_arah_aliran');
            $data = array();
            $no = 1;
            foreach ($arah_aliran->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['arah_aliran'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kategori(' . "'" . 'arah_aliran' . "'" . ',' . "'" . $value['id_arah_aliran'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kategori(' . "'" . 'arah_aliran' . "'" . ',' . "'" . $value['id_arah_aliran'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($arah_aliran) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } elseif ($table == 'kondisi_fisik') {
            $kondisi_fisik = $this->kategori->get_kategori('kondisi_fisik', 'id_kondisi_fisik');
            $data = array();
            $no = 1;
            foreach ($kondisi_fisik->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['kondisi_fisik'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kategori(' . "'" . 'kondisi_fisik' . "'" . ',' . "'" . $value['id_kondisi_fisik'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kategori(' . "'" . 'kondisi_fisik' . "'" . ',' . "'" . $value['id_kondisi_fisik'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($kondisi_fisik) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } elseif ($table == 'kondisi_sedimen') {
            $kondisi_sedimen = $this->kategori->get_kategori('kondisi_sedimen', 'id_kondisi_sedimen');
            $data = array();
            $no = 1;
            foreach ($kondisi_sedimen->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['kondisi_sedimen'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kategori(' . "'" . 'kondisi_sedimen' . "'" . ',' . "'" . $value['id_kondisi_sedimen'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kategori(' . "'" . 'kondisi_sedimen' . "'" . ',' . "'" . $value['id_kondisi_sedimen'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($kondisi_sedimen) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } elseif ($table == 'penanganan') {
            $penanganan = $this->kategori->get_kategori('penanganan', 'id_penanganan');
            $data = array();
            $no = 1;
            foreach ($penanganan->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['penanganan'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kategori(' . "'" . 'penanganan' . "'" . ',' . "'" . $value['id_penanganan'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kategori(' . "'" . 'penanganan' . "'" . ',' . "'" . $value['id_penanganan'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($penanganan) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        } elseif ($table == 'lajur_drainase') {
            $lajur_drainase = $this->kategori->get_kategori('lajur_drainase', 'id_lajur_drainase');
            $data = array();
            $no = 1;
            foreach ($lajur_drainase->result_array() as $value) {
                $row = array();
                $row[] = $no++;
                $row[] = $value['lajur_drainase'];
                //add html for action
                $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kategori(' . "'" . 'lajur_drainase' . "'" . ',' . "'" . $value['id_lajur_drainase'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kategori(' . "'" . 'lajur_drainase' . "'" . ',' . "'" . $value['id_lajur_drainase'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
                $data[] = $row;
            }
            if ($lajur_drainase) {
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('data' => 0));
            }
        }
    }

    public function add($table = 'tipe_saluran')
    {
        $this->_validate();
        if ($table == 'tipe_saluran') {
            $data = [
                'tipe_saluran' => $this->input->post('nama_kategori'),
            ];
            $this->kategori->create('tipe_saluran', $data);
        } elseif ($table == 'arah_aliran') {
            $data = [
                'arah_aliran' => $this->input->post('nama_kategori'),
            ];
            $this->kategori->create('arah_aliran', $data);
        } elseif ($table == 'kondisi_fisik') {
            $data = [
                'kondisi_fisik' => $this->input->post('nama_kategori'),
            ];
            $this->kategori->create('kondisi_fisik', $data);
        } elseif ($table == 'penanganan') {
            $data = [
                'penanganan' => $this->input->post('nama_kategori'),
            ];
            $this->kategori->create('penanganan', $data);
        } elseif ($table == 'kondisi_sedimen') {
            $data = [
                'kondisi_sedimen' => $this->input->post('nama_kategori'),
            ];
            $this->kategori->create('kondisi_sedimen', $data);
        } else {
            $data = [
                'lajur_drainase' => $this->input->post('nama_kategori'),
            ];
            $this->kategori->create('lajur_drainase', $data);
        }
        echo json_encode(array("status" => TRUE));
    }

    public function edit($table = 'tipe_saluran', $id = '')
    {
        if ($table == 'tipe_saluran') {
            $data = $this->kategori->get_kategori_by_id('tipe_saluran', 'id_tipe_saluran', $id);
        } elseif ($table == 'arah_aliran') {
            $data = $this->kategori->get_kategori_by_id('arah_aliran', 'id_arah_aliran', $id);
        } elseif ($table == 'kondisi_fisik') {
            $data = $this->kategori->get_kategori_by_id('kondisi_fisik', 'id_kondisi_fisik', $id);
        } elseif ($table == 'penanganan') {
            $data = $this->kategori->get_kategori_by_id('penanganan', 'id_penanganan', $id);
        } elseif ($table == 'kondisi_sedimen') {
            $data = $this->kategori->get_kategori_by_id('kondisi_sedimen', 'id_kondisi_sedimen', $id);
        } else {
            $data = $this->kategori->get_kategori_by_id('lajur_drainase', 'id_lajur_drainase', $id);
        }
        echo json_encode($data);
    }

    public function update($table = 'tipe_saluran')
    {
        $this->_validate();
        if ($table == 'tipe_saluran') {
            $data = array(
                'tipe_saluran' => $this->input->post('nama_kategori'),
            );
            $this->kategori->update('tipe_saluran', array('id_tipe_saluran' => $this->input->post('id_kategori')), $data);
        } elseif ($table == 'arah_aliran') {
            $data = array(
                'arah_aliran' => $this->input->post('nama_kategori'),
            );
            $this->kategori->update('arah_aliran', array('id_arah_aliran' => $this->input->post('id_kategori')), $data);
        } elseif ($table == 'kondisi_fisik') {
            $data = array(
                'kondisi_fisik' => $this->input->post('nama_kategori'),
            );
            $this->kategori->update('kondisi_fisik', array('id_kondisi_fisik' => $this->input->post('id_kategori')), $data);
        } elseif ($table == 'penanganan') {
            $data = array(
                'penanganan' => $this->input->post('nama_kategori'),
            );
            $this->kategori->update('penanganan', array('id_penanganan' => $this->input->post('id_kategori')), $data);
        } elseif ($table == 'kondisi_sedimen') {
            $data = array(
                'kondisi_sedimen' => $this->input->post('nama_kategori'),
            );
            $this->kategori->update('kondisi_sedimen', array('id_kondisi_sedimen' => $this->input->post('id_kategori')), $data);
        } else {
            $data = array(
                'lajur_drainase' => $this->input->post('nama_kategori'),
            );
            $this->kategori->update('lajur_drainase', array('id_lajur_drainase' => $this->input->post('id_kategori')), $data);
        }
        echo json_encode(array("status" => TRUE));
    }

    public function delete($table = 'tipe_saluran', $id = '')
    {
        if ($table == 'tipe_saluran') {
            $this->kategori->delete('tipe_saluran', 'id_tipe_saluran', $id);
        } elseif ($table == 'arah_aliran') {
            $this->kategori->delete('arah_aliran', 'id_arah_aliran', $id);
        } elseif ($table == 'kondisi_fisik') {
            $this->kategori->delete('kondisi_fisik', 'id_kondisi_fisik', $id);
        } elseif ($table == 'penanganan') {
            $this->kategori->delete('penanganan', 'id_penanganan', $id);
        } elseif ($table == 'kondisi_sedimen') {
            $this->kategori->delete('kondisi_sedimen', 'id_kondisi_sedimen', $id);
        } else {
            $this->kategori->delete('lajur_drainase', 'id_lajur_drainase', $id);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_kategori') == '') {
            $data['inputerror'][] = 'nama_kategori';
            $data['error_string'][] = 'Kategori is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Kategori.php */