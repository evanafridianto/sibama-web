<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DrainaseController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->logged !== true) {
            redirect('login');
        }
        // $this->load->library('pdf_report');
        $this->load->model('datamaster_model', 'master');
    }

    public function index()
    {
        $datacontent = [
            'page_title' => 'Data Drainase',
            'jalan' => $this->master->getJalan()->result(),
            'kondisi_fisik' => $this->master->get('kondisi_fisik_drainase')->result(),
            'kondisi_sedimen' => $this->master->get('kondisi_sedimen_drainase')->result(),
            'penanganan' => $this->master->get('penanganan_drainase')->result(),
        ];
        $data['content'] = $this->load->view('admin/datamaster/drainase_view', $datacontent, true);
        $this->load->view('admin/layouts/main', $data);
        $this->load->view('admin/datamaster/drainase_form');
    }

    public function show_all()
    {
        $data_drainase = $this->master->getDrainase();
        $data = array();
        $no = 1;
        foreach ($data_drainase->result_array()  as $value) {
            $row = array();
            $row[] = '<input class="select1" value="' . $value['id_drainase'] . '" type="checkbox">';
            $row[] = $no++;
            $row[] =  $this->_isMobileDevice() ? $value['nama_jalan'] :
                $value['nama_jalan'] . ', ' . $value['nama_kelurahan'] . ', ' . $value['nama_kecamatan'];
            $row[] = $value['lat_awal'];
            $row[] = $value['long_awal'];
            $row[] = $value['lat_akhir'];
            $row[] = $value['long_akhir'];
            $row[] = $value['jalur_jalan'];
            //add html for action
            $row[] = '<button class="table-action-btn btn-success" onclick="edit_drainase(' . "'" . $value['id_drainase'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
            <button class="table-action-btn btn-danger" onclick="delete_drainase(' . "'" . $value['id_drainase'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
            $data[] = $row;
        }
        if ($data_drainase) {
            echo json_encode(array('data' => $data));
        } else {
            echo json_encode(array('data' => 0));
        }
    }

    public function edit($id)
    {
        $data = $this->master->getDatabyId('drainase', 'id_drainase', $id);
        echo json_encode($data);
    }

    public function save()
    {
        $config = array(
            [
                'field' => 'id_jalan',
                'label' => 'Jalan',
                'rules' => 'required',
            ],
            [
                'field' => 'lat_awal',
                'label' => 'Latitude Awal',
                'rules' => 'required|trim|numeric'
            ],
            [
                'field' => 'long_awal',
                'label' => 'Longitude Awal',
                'rules' => 'required|trim|numeric'
            ],
            [
                'field' => 'lat_akhir',
                'label' => 'Latitude Akhir',
                'rules' => 'required|trim|numeric'
            ],
            [
                'field' => 'long_akhir',
                'label' => 'Longitude Akhir',
                'rules' => 'required|trim|numeric'
            ],
            [
                'field' => 'sta',
                'label' => 'STA',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'panjang',
                'label' => 'Panjang',
                'rules' => 'required|trim|numeric|decimal',
            ],
            [
                'field' => 'tinggi',
                'label' => 'Tinggi',
                'rules' => 'required|trim|numeric|decimal'
            ],
            [
                'field' => 'lebar',
                'label' => 'Lebar',
                'rules' => 'required|trim|numeric|decimal'
            ],
            [
                'field' => 'slope',
                'label' => 'Slope',
                'rules' => 'required|trim|numeric|decimal'
            ],
            [
                'field' => 'catchment_area',
                'label' => 'Catchment Area',
                'rules' => 'required|trim|numeric'
            ],
            [
                'field' => 'luas_penampung',
                'label' => 'Luas Penampung',
                'rules' => 'required|trim|numeric|decimal'
            ],
            [
                'field' => 'keliling_penampung',
                'label' => 'Keliling Penampung',
                'rules' => 'required|trim|numeric|decimal'
            ],
            [
                'field' => 'tipe',
                'label' => 'Tipe',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'arah_air',
                'label' => 'Arah Air',
                'rules' => 'required'
            ],
            [
                'field' => 'jalur_jalan',
                'label' => 'Jalur Jalan',
                'rules' => 'required'
            ],
            [
                'field' => 'id_kondisi_fisik',
                'label' => 'Kondisi Fisik',
                'rules' => 'required'
            ],
            [
                'field' => 'id_kondisi_sedimen',
                'label' => 'Kondisi Sedimen',
                'rules' => 'required'
            ],
            [
                'field' => 'id_penanganan',
                'label' => 'Penanganan',
                'rules' => 'required'
            ],
            [
                'field' => 'date',
                'label' => 'Tanggal',
                'rules' => 'required|trim'
            ]
        );
        $this->form_validation->set_rules($config);

        $data = array(
            'id_jalan' => $this->input->post('id_jalan'),
            'jalur_jalan' => $this->input->post('jalur_jalan'),
            'lat_awal' => $this->input->post('lat_awal'),
            'long_awal' =>  $this->input->post('long_awal'),
            'lat_akhir' => $this->input->post('lat_akhir'),
            'long_akhir' => $this->input->post('long_akhir'),
            'sta' => $this->input->post('sta'),
            'panjang' => $this->input->post('panjang'),
            'tinggi' => $this->input->post('tinggi'),
            'lebar' => $this->input->post('lebar'),
            'slope' => $this->input->post('slope'),
            'catchment_area' => $this->input->post('catchment_area'),
            'luas_penampung' => $this->input->post('luas_penampung'),
            'keliling_penampung' => $this->input->post('keliling_penampung'),
            'tipe' => $this->input->post('tipe'),
            'arah_air' => $this->input->post('arah_air'),
            'id_kondisi_fisik' => $this->input->post('id_kondisi_fisik'),
            'id_kondisi_sedimen' => $this->input->post('id_kondisi_sedimen'),
            'id_penanganan' => $this->input->post('id_penanganan'),
            'nama_file_dimensi' => $this->input->post('nama_file_dimensi'),
            'nama_file_foto' => $this->input->post('nama_file_foto'),
            'date' => $this->input->post('date')
        );
        if (!empty($_FILES['file_dimensi']['name'])) {
            $upload_dimensi = $this->_do_upload('dimensi');
            $data['file_dimensi'] = $upload_dimensi;
        }
        if (!empty($_FILES['file_foto']['name'])) {
            $upload_foto = $this->_do_upload('foto');
            $data['file_foto'] = $upload_foto;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            $json = array(
                'id_jalan' => form_error('id_jalan'),
                'lat_awal' => form_error('lat_awal'),
                'long_awal' => form_error('long_awal'),
                'lat_akhir' => form_error('lat_akhir'),
                'long_akhir' => form_error('long_akhir'),
                'sta' => form_error('sta'),
                'panjang' => form_error('panjang'),
                'tinggi' => form_error('tinggi'),
                'lebar' => form_error('lebar'),
                'slope' => form_error('slope'),
                'catchment_area' => form_error('catchment_area'),
                'luas_penampung' => form_error('luas_penampung'),
                'keliling_penampung' => form_error('keliling_penampung'),
                'tipe' => form_error('tipe'),
                'arah_air' => form_error('arah_air'),
                'jalur_jalan' => form_error('jalur_jalan'),
                'id_kondisi_fisik' => form_error('id_kondisi_fisik'),
                'id_kondisi_sedimen' => form_error('id_kondisi_sedimen'),
                'id_penanganan' => form_error('id_penanganan'),
                'date' => form_error('date'),
            );
            echo json_encode(array("error" => $json, "status" => FALSE));
        } else {
            if ($this->input->post('id_drainase') == '') {
                $this->master->create('drainase', $data);
                echo json_encode(array("status" => TRUE));
            } else {
                $this->master->update('drainase', array('id_drainase' => $this->input->post('id_drainase')), $data);
                //replace file dimensi
                if ($_FILES['file_dimensi']['name'] != '' || !empty($_FILES['file_dimensi']['name'])) {
                    if (file_exists('upload/dimensi/' . $this->input->post('remove_dimensi'))) {
                        unlink('upload/dimensi/' . $this->input->post('remove_dimensi'));
                    }
                }
                //replace file foto
                if ($_FILES['file_foto']['name'] != '' || !empty($_FILES['file_foto']['name'])) {
                    if (file_exists('upload/foto/' . $this->input->post('remove_foto'))) {
                        unlink('upload/foto/' . $this->input->post('remove_foto'));
                    }
                }
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function delete($id)
    {
        $drainase = $this->master->getDatabyId('drainase', 'id_drainase', $id);
        if (file_exists('upload/dimensi/' . $drainase->file_dimensi) && $drainase->file_dimensi)
            unlink('upload/dimensi/' . $drainase->file_dimensi);
        if (file_exists('upload/foto/' . $drainase->file_foto) && $drainase->file_foto)
            unlink('upload/foto/' . $drainase->file_foto);

        $this->master->delete('drainase', 'id_drainase', $id);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_multi()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            for ($count = 0; $count < count($id); $count++) {
                $this->master->delete('drainase', 'id_drainase', $id[$count]);
            }
        }
    }

    public function truncate()
    {
        $this->master->truncateTable('drainase');
        echo json_encode(array("status" => TRUE));
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [  // variabel untuk menampung pengaturan style dari header tabel
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $style_row = [  // variabel untuk menampung pengaturan style dari isi tabel
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "no");
        $sheet->setCellValue('B1', "id_jalan");
        $sheet->setCellValue('C1', "jalur_jalan");
        $sheet->setCellValue('D1', "lat_awal");
        $sheet->setCellValue('E1', "long_awal");
        $sheet->setCellValue('F1', "lat_akhir");
        $sheet->setCellValue('G1', "long_akhir");
        $sheet->setCellValue('H1', "sta");
        $sheet->setCellValue('I1', "panjang");
        $sheet->setCellValue('J1', "tinggi");
        $sheet->setCellValue('K1', "lebar");
        $sheet->setCellValue('L1', "slope");
        $sheet->setCellValue('M1', "catchment_area");
        $sheet->setCellValue('N1', "luas_penampung");
        $sheet->setCellValue('O1', "keliling_penampung");
        $sheet->setCellValue('P1', "tipe");
        $sheet->setCellValue('Q1', "arah_air");
        $sheet->setCellValue('R1', "id_kondisi_fisik");
        $sheet->setCellValue('S1', "id_kondisi_sedimen");
        $sheet->setCellValue('T1', "id_penanganan");
        $sheet->setCellValue('U1', "file_dimensi");
        $sheet->setCellValue('V1', "nama_file_dimensi");
        $sheet->setCellValue('W1', "file_foto");
        $sheet->setCellValue('X1', "nama_file_foto");
        $sheet->setCellValue('Y1', "date");

        // Apply style header ke masing-masing kolom header
        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        $sheet->getStyle('C1')->applyFromArray($style_col);
        $sheet->getStyle('D1')->applyFromArray($style_col);
        $sheet->getStyle('E1')->applyFromArray($style_col);
        $sheet->getStyle('F1')->applyFromArray($style_col);
        $sheet->getStyle('G1')->applyFromArray($style_col);
        $sheet->getStyle('H1')->applyFromArray($style_col);
        $sheet->getStyle('I1')->applyFromArray($style_col);
        $sheet->getStyle('J1')->applyFromArray($style_col);
        $sheet->getStyle('K1')->applyFromArray($style_col);
        $sheet->getStyle('L1')->applyFromArray($style_col);
        $sheet->getStyle('M1')->applyFromArray($style_col);
        $sheet->getStyle('N1')->applyFromArray($style_col);
        $sheet->getStyle('O1')->applyFromArray($style_col);
        $sheet->getStyle('P1')->applyFromArray($style_col);
        $sheet->getStyle('Q1')->applyFromArray($style_col);
        $sheet->getStyle('R1')->applyFromArray($style_col);
        $sheet->getStyle('S1')->applyFromArray($style_col);
        $sheet->getStyle('T1')->applyFromArray($style_col);
        $sheet->getStyle('U1')->applyFromArray($style_col);
        $sheet->getStyle('V1')->applyFromArray($style_col);
        $sheet->getStyle('W1')->applyFromArray($style_col);
        $sheet->getStyle('X1')->applyFromArray($style_col);
        $sheet->getStyle('Y1')->applyFromArray($style_col);

        $drainase = $this->master->getDrainase()->result(); // data drainase 
        $no = 1;
        $numrow = 2;
        foreach ($drainase as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->id_jalan);
            $sheet->setCellValue('C' . $numrow, $data->jalur_jalan);
            $sheet->setCellValue('D' . $numrow, $data->lat_awal);
            $sheet->setCellValue('E' . $numrow, $data->long_awal);
            $sheet->setCellValue('F' . $numrow, $data->lat_akhir);
            $sheet->setCellValue('G' . $numrow, $data->long_akhir);
            $sheet->setCellValue('H' . $numrow, $data->sta);
            $sheet->setCellValue('I' . $numrow, $data->panjang);
            $sheet->setCellValue('J' . $numrow, $data->tinggi);
            $sheet->setCellValue('K' . $numrow, $data->lebar);
            $sheet->setCellValue('L' . $numrow, $data->slope);
            $sheet->setCellValue('M' . $numrow, $data->catchment_area);
            $sheet->setCellValue('N' . $numrow, $data->luas_penampung);
            $sheet->setCellValue('O' . $numrow, $data->keliling_penampung);
            $sheet->setCellValue('P' . $numrow, $data->tipe);
            $sheet->setCellValue('Q' . $numrow, $data->arah_air);
            $sheet->setCellValue('R' . $numrow, $data->id_kondisi_fisik);
            $sheet->setCellValue('S' . $numrow, $data->id_kondisi_sedimen);
            $sheet->setCellValue('T' . $numrow, $data->id_penanganan);
            $sheet->setCellValue('U' . $numrow, $data->file_dimensi);
            $sheet->setCellValue('V' . $numrow, $data->nama_file_dimensi);
            $sheet->setCellValue('W' . $numrow, $data->file_foto);
            $sheet->setCellValue('X' . $numrow, $data->nama_file_foto);
            $sheet->setCellValue('Y' . $numrow, $data->date);

            // Apply style row 
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('O' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('R' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('S' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('T' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('U' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('W' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('X' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Y' . $numrow)->applyFromArray($style_row);
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(20);
        $sheet->getColumnDimension('V')->setWidth(25);
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->getColumnDimension('X')->setWidth(25);
        $sheet->getColumnDimension('Y')->setWidth(20);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Laporan Data Drainase");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Drainase.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function import()
    {
        $config['upload_path'] = FCPATH . 'upload/excel/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = 24000; //set max size allowed in Kilobyte
        $config['max_width'] = 5000; // set max width image allowed
        $config['max_height'] = 5000; // set max height allowed
        $config['file_name'] = 'file_drainase_' . round(microtime(true) * 1000);

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('import_excel')) //upload and validate
        {
            echo json_encode(array("error" => ["import_excel" => $this->upload->display_errors('', '')], "status" => FALSE));
            exit();
        }

        if (is_file('upload/excel/' . $this->upload->data('file_name')))
            unlink('upload/excel/' . $this->upload->data('file_name'));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($_FILES['import_excel']['tmp_name']);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $data = array();
        $numrow = 1;
        $kosong = 0;
        foreach ($sheet as $row) {
            if ($numrow > 1) {
                array_push($data, [
                    'id_jalan' => $row['B'],
                    'jalur_jalan' => $row['C'],
                    'lat_awal' => $row['D'],
                    'long_awal' => $row['E'],
                    'lat_akhir' => $row['F'],
                    'long_akhir' => $row['G'],
                    'sta' => $row['H'],
                    'panjang' => $row['I'],
                    'tinggi' => $row['J'],
                    'lebar' => $row['K'],
                    'slope' => $row['L'],
                    'catchment_area' => $row['M'],
                    'luas_penampung' => $row['N'],
                    'keliling_penampung' => $row['O'],
                    'tipe' => $row['P'],
                    'arah_air' => $row['Q'],
                    'id_kondisi_fisik' => $row['R'],
                    'id_kondisi_sedimen' => $row['S'],
                    'id_penanganan' => $row['T'],
                    'file_dimensi' => $row['U'],
                    'nama_file_dimensi' => $row['V'],
                    'file_foto' => $row['W'],
                    'nama_file_foto' => $row['X'],
                    'date' => $row['Y'],
                ]);
                if ($row["B"] == "" or $row["C"] == "" or $row["D"] == "" or $row["E"] == "" or $row["F"] == "" or $row["G"] == "" or $row['H'] == "" or $row['I'] == "" or $row['J'] == "" or $row['K'] == "" or $row['L'] == "" or $row['M'] == "" or $row['N'] == "" or $row['O'] == "" or $row['P'] == "" or $row['Q'] == "" or $row['R'] == "" or $row['S'] == "" or $row['T'] == "" or $row['U'] == "" or $row['V'] == "" or $row['W'] == "" or $row['X'] == "" or $row['Y'] == "") {
                    $kosong++;
                }
            }
            $numrow++;
        }
        if ($kosong > 0) {
            echo json_encode(array("status" => null, "msg" => $kosong));
        } else {
            $this->master->create_multiple('drainase', $data);
            echo json_encode(array("status" => TRUE));
        }
    }

    private function _do_upload($for)
    {
        if ($for == 'dimensi') {
            $config['upload_path'] = FCPATH . 'upload/dimensi/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 24000; //set max size allowed in Kilobyte
            $config['max_width'] = 5000; // set max width image allowed
            $config['max_height'] = 5000; // set max height allowed
            $config['file_name'] = 'file_dimensi_' . round(microtime(true) * 1000);

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_dimensi')) //upload and validate
            {
                echo json_encode(array("error" => ["file_dimensi" => $this->upload->display_errors('', '')], "status" => FALSE));
                exit();
            }
            return $this->upload->data('file_name');
        } else {
            $config['upload_path'] = FCPATH . 'upload/foto/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 24000; //set max size allowed in Kilobyte
            $config['max_width'] = 5000; // set max width image allowed
            $config['max_height'] = 5000; // set max height allowed
            $config['file_name'] = 'file_foto_' . round(microtime(true) * 1000);

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_foto')) //upload and validate
            {
                echo json_encode(array("error" => ["file_foto" => $this->upload->display_errors('', '')], "status" => FALSE));
                exit();
            }
            return $this->upload->data('file_name');
        }
    }

    private function _isMobileDevice()
    {
        return preg_match(
            "/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
            $_SERVER["HTTP_USER_AGENT"]
        );
    }
}