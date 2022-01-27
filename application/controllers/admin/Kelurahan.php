<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kelurahan extends CI_Controller
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
            'page_title' => 'Data Kelurahan',
            'data_kecamatan' => $this->master->select('kecamatan')->result_array()
        ];
        $data['content'] = $this->load->view('admin/datamaster/kelurahan_view', $datacontent, true);
        $this->load->view('admin/layouts/main', $data);
    }

    public function show_all()
    {
        $data_kelurahan = $this->master->getKelurahan();
        $data = array();
        $no = 1;
        foreach ($data_kelurahan->result_array() as $value) {
            $row = array();
            $row[] = $no++;
            $row[] = $value['nama_kelurahan'];
            $row[] = $value['nama_kecamatan'];
            //add html for action
            $row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_kelurahan(' . "'" . $value['id_kelurahan'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_kelurahan(' . "'" . $value['id_kelurahan'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
            $data[] = $row;
        }
        if ($data_kelurahan) {
            echo json_encode(array('data' => $data));
        } else {
            echo json_encode(array('data' => 0));
        }
    }

    public function add()
    {
        $this->_validate('add_update');
        $data = array(
            'nama_kelurahan' => $this->input->post('nama_kelurahan'),
            'id_kecamatan'    => $this->input->post('id_kecamatan')
        );
        $this->master->create('kelurahan', $data);
        echo json_encode(array("status" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->master->getDatabyId('kelurahan', 'id_kelurahan', $id);
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate('add_update');
        $data = array(
            'nama_kelurahan' => $this->input->post('nama_kelurahan'),
            'id_kecamatan'    => $this->input->post('id_kecamatan')
        );
        $this->master->update('kelurahan', array('id_kelurahan' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        $this->master->delete('kelurahan', 'id_kelurahan', $id);
        echo json_encode(array("status" => TRUE));
    }

    public function truncate()
    {
        $this->master->truncateTable('kelurahan');
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
        $sheet->setCellValue('B1', "nama_kelurahan");
        $sheet->setCellValue('C1', "id_kecamatan");

        // Apply style header ke masing-masing kolom header
        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        $sheet->getStyle('C1')->applyFromArray($style_col);

        $kelurahan = $this->master->getKelurahan()->result(); // data kelurahan 
        $no = 1;
        $numrow = 2;
        foreach ($kelurahan as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->nama_kelurahan);
            $sheet->setCellValue('C' . $numrow, $data->id_kecamatan);

            // Apply style row 
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(20);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Laporan Data Kelurahan");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Kelurahan.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function import()
    {
        $this->_validate('import');

        $file_tmp = $_FILES['import_excel']['tmp_name'];
        $file_name = $_FILES['import_excel']['name'];
        $file_size = $_FILES['import_excel']['size'];
        $file_type = $_FILES['import_excel']['type'];

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file_tmp);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $data = array();
        $numrow = 1;
        $kosong = 0;
        foreach ($sheet as $row) {
            if ($numrow > 1) {
                array_push($data, [
                    'nama_kelurahan' => $row['B'],
                    'id_kecamatan' => $row['C'],
                ]);
                if ($row["B"] == "" or $row["C"] == "") {
                    $kosong++;
                }
            }
            $numrow++;
        }
        if ($kosong > 0) {
            echo json_encode(array("status" => null, 'msg' => $kosong));
        } else {
            $this->master->create_multiple('kelurahan', $data);
            echo json_encode(array("status" => TRUE));
        }
    }

    private function _validate($for)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($for == 'import') {
            $allowed = array('xlsx');
            $filename = $_FILES['import_excel']['name'];
            $filetmp = $_FILES['import_excel']['tmp_name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if (!file_exists($filetmp)) {
                $data['inputerror'][] = 'import_excel';
                $data['error_string'][] = 'No files selected';
                $data['status'] = FALSE;
            }

            if (file_exists($filetmp) && !in_array($ext, $allowed)) {
                $data['inputerror'][] = 'import_excel';
                $data['error_string'][] = 'Extension not supported';
                $data['status'] = FALSE;
            }
        }

        if ($for == 'add_update') {
            if ($this->input->post('nama_kelurahan') == '') {
                $data['inputerror'][] = 'nama_kelurahan';
                $data['error_string'][] = 'Nama Kelurahan is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_kecamatan') == '') {
                $data['inputerror'][] = 'id_kecamatan';
                $data['error_string'][] = 'Kecamatan is required';
                $data['status'] = FALSE;
            }
        }
        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}