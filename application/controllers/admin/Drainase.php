<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Drainase extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->logged !== true) {
            redirect('admin/login');
        }
        // $this->load->library('pdf_report');
        $this->load->model('datamaster_model', 'master');
    }

    public function index()
    {
        $datacontent = [
            'page_title' => 'Data Drainase',
            'lajur_drainase' => $this->master->select('lajur_drainase')->result(),
            'arah_aliran' => $this->master->select('arah_aliran')->result(),
            'kondisi_fisik' => $this->master->select('kondisi_fisik')->result(),
            'kondisi_sedimen' => $this->master->select('kondisi_sedimen')->result(),
            'tipe_saluran' => $this->master->select('tipe_saluran')->result(),
            'penanganan' => $this->master->select('penanganan')->result(),
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
            $row[] = '<input class="select1" value="' . $value['id'] . '" type="checkbox">';
            $row[] = $no++;
            $row[] =  $this->_isMobileDevice() ? $value['nama_jalan'] :
                $value['nama_jalan'] . ', ' . $value['nama_kelurahan'] . ', ' . $value['nama_kecamatan'];
            $row[] = $value['lat_awal'];
            $row[] = $value['long_awal'];
            $row[] = $value['lat_akhir'];
            $row[] = $value['long_akhir'];
            $row[] = $value['lajur_drainase'];
            //add html for action
            $row[] = '<button class="table-action-btn btn-success" onclick="edit_drainase(' . "'" . $value['id'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
            <button class="table-action-btn btn-danger" onclick="delete_drainase(' . "'" . $value['id'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
            $data[] = $row;
        }
        if ($data_drainase) {
            echo json_encode(array('data' => $data));
        } else {
            echo json_encode(array('data' => 0));
        }
    }

    public function add()
    {
        $this->_validate('add_update');
        $data = array(
            'id_jalan' => $this->input->post('id_jalan'),
            'sta' => $this->input->post('sta'),
            'lat_awal' => round($this->input->post('lat_awal'), 9),
            'long_awal' =>  round($this->input->post('long_awal'), 9),
            'lat_akhir' => round($this->input->post('lat_akhir'), 9),
            'long_akhir' => round($this->input->post('long_akhir'), 9),
            'panjang_saluran' => $this->input->post('panjang_saluran'),
            'slope' => $this->input->post('slope'),
            'catchment_area' => $this->input->post('catchment_area'),
            'tinggi_saluran' => $this->input->post('tinggi_saluran'),
            'lebar_saluran' => $this->input->post('lebar_saluran'),
            'luas_penampung' => $this->input->post('luas_penampung'),
            'keliling_penampung' => $this->input->post('keliling_penampung'),
            'nama_file_dimensi' => $this->input->post('nama_file_dimensi'),
            'nama_file_foto' => $this->input->post('nama_file_foto'),
            'id_arah_aliran' => $this->input->post('id_arah_aliran'),
            'id_kondisi_fisik' => $this->input->post('id_kondisi_fisik'),
            'id_kondisi_sedimen' => $this->input->post('id_kondisi_sedimen'),
            'id_tipe_saluran' => $this->input->post('id_tipe_saluran'),
            'id_penanganan' => $this->input->post('id_penanganan'),
            'id_lajur_drainase' => $this->input->post('id_lajur_drainase'),
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
        $this->master->create('drainase', $data);
        echo json_encode(array("status" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->master->getDatabyId('drainase', 'id', $id);
        if (!file_exists('upload/dimensi/' . $data->file_dimensi)) {
            $data->file_dimensi = 'noimage.jpg';
        }
        if (!file_exists('upload/foto/' . $data->file_foto)) {
            $data->file_foto = 'noimage.jpg';
        }
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate('add_update');
        $data = array(
            'id_jalan' => $this->input->post('id_jalan'),
            'sta' => $this->input->post('sta'),
            'lat_awal' => round($this->input->post('lat_awal'), 9),
            'long_awal' =>  round($this->input->post('long_awal'), 9),
            'lat_akhir' => round($this->input->post('lat_akhir'), 9),
            'long_akhir' => round($this->input->post('long_akhir'), 9),
            'panjang_saluran' => $this->input->post('panjang_saluran'),
            'slope' => $this->input->post('slope'),
            'catchment_area' => $this->input->post('catchment_area'),
            'tinggi_saluran' => $this->input->post('tinggi_saluran'),
            'lebar_saluran' => $this->input->post('lebar_saluran'),
            'luas_penampung' => $this->input->post('luas_penampung'),
            'keliling_penampung' => $this->input->post('keliling_penampung'),
            'nama_file_dimensi' => $this->input->post('nama_file_dimensi'),
            'nama_file_foto' => $this->input->post('nama_file_foto'),
            'id_arah_aliran' => $this->input->post('id_arah_aliran'),
            'id_kondisi_fisik' => $this->input->post('id_kondisi_fisik'),
            'id_kondisi_sedimen' => $this->input->post('id_kondisi_sedimen'),
            'id_tipe_saluran' => $this->input->post('id_tipe_saluran'),
            'id_penanganan' => $this->input->post('id_penanganan'),
            'id_lajur_drainase' => $this->input->post('id_lajur_drainase'),
            'date' => $this->input->post('date')
        );
        // if remove dimensi checked
        if ($this->input->post('remove_dimensi')) {
            if (file_exists('upload/dimensi/' . $this->input->post('remove_dimensi')) && $this->input->post('remove_dimensi')) {
                unlink('upload/dimensi/' . $this->input->post('remove_dimensi'));
                $data['file_dimensi'] = '';
            }
        }
        // update dimensi
        if (!empty($_FILES['file_dimensi']['name'])) {
            $uploadDimensi = $this->_do_upload('dimensi');
            $data['file_dimensi'] = $uploadDimensi;
        }
        // end
        // if remove foto checked
        if ($this->input->post('remove_foto')) {
            if (file_exists('upload/foto/' . $this->input->post('remove_foto')) && $this->input->post('remove_foto')) {
                unlink('upload/foto/' . $this->input->post('remove_foto'));
                $data['file_foto'] = '';
            }
        }
        // update foto
        if (!empty($_FILES['file_foto']['name'])) {
            $uploadFoto = $this->_do_upload('foto');
            $data['file_foto'] = $uploadFoto;
        }
        // end
        $this->master->update('drainase', array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        $drainase = $this->master->getDatabyId('drainase', 'id', $id);
        if (file_exists('upload/dimensi/' . $drainase->file_dimensi) && $drainase->file_dimensi)
            unlink('upload/dimensi/' . $drainase->file_dimensi);
        if (file_exists('upload/foto/' . $drainase->file_foto) && $drainase->file_foto)
            unlink('upload/foto/' . $drainase->file_foto);

        $this->master->delete('drainase', 'id', $id);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_all()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            for ($count = 0; $count < count($id); $count++) {
                $this->master->delete('drainase', 'id', $id[$count]);
            }
        }
    }

    public function truncate()
    {
        $this->master->truncateTable('drainase');
        echo json_encode(array("status" => TRUE));
    }

    // public function export_pdf()
    // {
    //     // header('Content-Type: application/pdf');
    //     ini_set('memory_limit', '8080M');
    //     ini_set('max_execution_time', 240);
    //     $data_drainase = $this->master->get_drainase();
    //     ob_start();
    //     $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //     $pdf->SetTitle('Data Drainase Report');
    //     $pdf->setFooterMargin(0);
    //     $pdf->SetFont('helvetica', 'B', 8);
    //     $pdf->AddPage('L', 'C3');

    //     $tbl = '<table border="1">
    //     <tr>
    //             <th>No</th>
    //             <th>ID Jalan</th>
    //             <th>Latitude Awal</th>
    //             <th>Longitude Awal</th>
    //             <th>Latitude Akhir</th>
    //             <th>Longitude Akhir</th>
    //             <th>STA</th>
    //             <th>Panjang Saluran</th>
    //             <th>Slope</th>
    //             <th>Catchment Area</th>
    //             <th>Tinggi Saluran</th>
    //             <th>Lebar Saluran</th>
    //             <th>Luas Penampung</th>
    //             <th>Keliling Penampung</th>
    //             <th>ID Arah Aliran</th>
    //             <th>ID Kondisi Fisik</th>
    //             <th>ID Kondisi Sedimen</th>
    //             <th>ID Tipe Saluran</th>
    //             <th>ID Penanganan</th>
    //             <th>ID Lajur Drainase</th>
    //             <th>Nama File Dimensi</th>
    //             <th>Nama File Foto</th>
    //             <th>File Dimensi</th>
    //             <th>File Foto</th>
    //             <th>Tanggal</th>
    //     </tr>';
    //     $no = 1;
    //     foreach ($data_drainase->result() as $row) {
    //         $tbl .= '<tr>
    //             <td>' . $no++ . '</td>
    //             <td>' . $row->id_jalan . '</td>
    //             <td>' . $row->lat_awal . '</td>
    //             <td>' . $row->long_awal . '</td>
    //             <td>' . $row->lat_akhir . '</td>
    //             <td>' . $row->long_akhir . '</td>
    //             <td>' . $row->sta . '</td>
    //             <td>' . $row->panjang_saluran . '</td>
    //             <td>' . $row->slope . '</td>
    //             <td>' . $row->catchment_area . '</td>
    //             <td>' . $row->tinggi_saluran . '</td>
    //             <td>' . $row->lebar_saluran . '</td>
    //             <td>' . $row->luas_penampung . '</td>
    //             <td>' . $row->keliling_penampung . '</td>
    //             <td>' . $row->id_arah_aliran . '</td>
    //             <td>' . $row->id_kondisi_fisik . '</td>
    //             <td>' . $row->id_kondisi_sedimen . '</td>
    //             <td>' . $row->id_tipe_saluran . '</td>
    //             <td>' . $row->id_penanganan . '</td>
    //             <td>' . $row->id_lajur_drainase . '</td>
    //             <td>' . $row->nama_file_dimensi . '</td>
    //             <td>' . $row->nama_file_foto . '</td>
    //             <td>' . $row->file_dimensi . '</td>
    //             <td>' . $row->file_foto . '</td>
    //             <td>' . $row->date . '</td>
    //             </tr>';
    //     }
    //     $tbl .= '</table>';
    //     $pdf->writeHTML($tbl, true, false, false, false, '');
    //     $pdf->Output('data_drainase.pdf', 'I');
    //     ob_end_flush();
    // }

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
        $sheet->setCellValue('C1', "sta");
        $sheet->setCellValue('D1', "lat_awal");
        $sheet->setCellValue('E1', "long_awal");
        $sheet->setCellValue('F1', "lat_akhir");
        $sheet->setCellValue('G1', "long_akhir");
        $sheet->setCellValue('H1', "panjang_saluran");
        $sheet->setCellValue('I1', "slope");
        $sheet->setCellValue('J1', "catchment_area");
        $sheet->setCellValue('K1', "tinggi_saluran");
        $sheet->setCellValue('L1', "lebar_saluran");
        $sheet->setCellValue('M1', "luas_penampung");
        $sheet->setCellValue('N1', "keliling_penampung");
        $sheet->setCellValue('O1', "file_dimensi");
        $sheet->setCellValue('P1', "nama_file_dimensi");
        $sheet->setCellValue('Q1', "file_foto");
        $sheet->setCellValue('R1', "nama_file_foto");
        $sheet->setCellValue('S1', "id_tipe_saluran");
        $sheet->setCellValue('T1', "id_arah_aliran");
        $sheet->setCellValue('U1', "id_kondisi_fisik");
        $sheet->setCellValue('V1', "id_kondisi_sedimen");
        $sheet->setCellValue('W1', "id_penanganan");
        $sheet->setCellValue('X1', "id_lajur_drainase");
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
            $sheet->setCellValue('C' . $numrow, $data->sta);
            $sheet->setCellValue('D' . $numrow, $data->lat_awal);
            $sheet->setCellValue('E' . $numrow, $data->long_awal);
            $sheet->setCellValue('F' . $numrow, $data->lat_akhir);
            $sheet->setCellValue('G' . $numrow, $data->long_akhir);
            $sheet->setCellValue('H' . $numrow, $data->panjang_saluran);
            $sheet->setCellValue('I' . $numrow, $data->slope);
            $sheet->setCellValue('J' . $numrow, $data->catchment_area);
            $sheet->setCellValue('K' . $numrow, $data->tinggi_saluran);
            $sheet->setCellValue('L' . $numrow, $data->lebar_saluran);
            $sheet->setCellValue('M' . $numrow, $data->luas_penampung);
            $sheet->setCellValue('N' . $numrow, $data->keliling_penampung);
            $sheet->setCellValue('O' . $numrow, $data->file_dimensi);
            $sheet->setCellValue('P' . $numrow, $data->nama_file_dimensi);
            $sheet->setCellValue('Q' . $numrow, $data->file_foto);
            $sheet->setCellValue('R' . $numrow, $data->nama_file_foto);
            $sheet->setCellValue('S' . $numrow, $data->id_tipe_saluran);
            $sheet->setCellValue('T' . $numrow, $data->id_arah_aliran);
            $sheet->setCellValue('U' . $numrow, $data->id_kondisi_fisik);
            $sheet->setCellValue('V' . $numrow, $data->id_kondisi_sedimen);
            $sheet->setCellValue('W' . $numrow, $data->id_penanganan);
            $sheet->setCellValue('X' . $numrow, $data->id_lajur_drainase);
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
        $sheet->getColumnDimension('C')->setWidth(25);
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
        $sheet->getColumnDimension('P')->setWidth(25);
        $sheet->getColumnDimension('Q')->setWidth(25);
        $sheet->getColumnDimension('R')->setWidth(25);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(20);
        $sheet->getColumnDimension('V')->setWidth(20);
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->getColumnDimension('X')->setWidth(20);
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
                    'id_jalan' => $row['B'],
                    'sta' => $row['C'],
                    'lat_awal' => $row['D'],
                    'long_awal' => $row['E'],
                    'lat_akhir' => $row['F'],
                    'long_akhir' => $row['G'],
                    'panjang_saluran' => $row['H'],
                    'slope' => $row['I'],
                    'catchment_area' => $row['J'],
                    'tinggi_saluran' => $row['K'],
                    'lebar_saluran' => $row['L'],
                    'luas_penampung' => $row['M'],
                    'keliling_penampung' => $row['N'],
                    'file_dimensi' => $row['O'],
                    'nama_file_dimensi' => $row['P'],
                    'file_foto' => $row['Q'],
                    'nama_file_foto' => $row['R'],
                    'id_tipe_saluran' => $row['S'],
                    'id_arah_aliran' => $row['T'],
                    'id_kondisi_fisik' => $row['U'],
                    'id_kondisi_sedimen' => $row['V'],
                    'id_penanganan' => $row['W'],
                    'id_lajur_drainase' => $row['X'],
                    'date' => $row['Y'],
                ]);
                if ($row["B"] == "" or $row["C"] == "" or $row["D"] == "" or $row["E"] == "" or $row["F"] == "" or $row["G"] == "" or $row['H'] == "" or $row['I'] == "" or $row['J'] == "" or $row['K'] == "" or $row['L'] == "" or $row['M'] == "" or $row['N'] == "" or $row['O'] == "" or $row['P'] == "" or $row['Q'] == "" or $row['R'] == "" or $row['S'] == "" or $row['T'] == "" or $row['U'] == "" or $row['V'] == "" or $row['W'] == "" or $row['X'] == "" or $row['Y'] == "") {
                    $kosong++;
                }
            }
            $numrow++;
        }
        if ($kosong > 0) {
            echo json_encode(array("status" => null, 'msg' => $kosong));
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
                $data['inputerror'][] = 'file_dimensi';
                $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }
            return $this->upload->data('file_name');
        } else {
            $configFoto['upload_path'] = FCPATH . 'upload/foto/';
            $configFoto['allowed_types'] = 'gif|jpg|png';
            $configFoto['max_size'] = 24000; //set max size allowed in Kilobyte
            $configFoto['max_width'] = 5000; // set max width image allowed
            $configFoto['max_height'] = 5000; // set max height allowed
            $configFoto['file_name'] = 'file_foto_' . round(microtime(true) * 1000);
            $this->upload->initialize($configFoto);
            $this->load->library('upload', $configFoto);
            if (!$this->upload->do_upload('file_foto')) //upload and validate
            {
                $data['inputerror'][] = 'file_foto';
                $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
                $data['status'] = FALSE;
                echo json_encode($data);
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

    private function _validate($for = 'add_update')
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
            if ($this->input->post('id_jalan') == '') {
                $data['inputerror'][] = 'id_jalan';
                $data['error_string'][] = 'Jalan is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('lat_awal') == '') {
                $data['inputerror'][] = 'lat_awal';
                $data['error_string'][] = 'Latitude Awal is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('lat_awal') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('lat_awal'))
            ) {
                $data['inputerror'][] = 'lat_awal';
                $data['error_string'][] = 'Latitude Awal type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('long_awal') == '') {
                $data['inputerror'][] = 'long_awal';
                $data['error_string'][] = 'Longitude Awal is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('long_awal') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('long_awal'))
            ) {
                $data['inputerror'][] = 'long_awal';
                $data['error_string'][] = 'Longitude Awal type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('lat_akhir') == '') {
                $data['inputerror'][] = 'lat_akhir';
                $data['error_string'][] = 'Latitude Akhir is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('lat_akhir') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('lat_akhir'))
            ) {
                $data['inputerror'][] = 'lat_akhir';
                $data['error_string'][] = 'Latitude Akhir type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('long_akhir') == '') {
                $data['inputerror'][] = 'long_akhir';
                $data['error_string'][] = 'Longitude Akhir is required';
                $data['status'] = FALSE;
            }
            if (
                $this->input->post('long_akhir') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('long_akhir'))
            ) {
                $data['inputerror'][] = 'long_akhir';
                $data['error_string'][] = 'Longitude Akhir type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('sta') == '') {
                $data['inputerror'][] = 'sta';
                $data['error_string'][] = 'STA is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('panjang_saluran') == '') {
                $data['inputerror'][] = 'panjang_saluran';
                $data['error_string'][] = 'Panjang Saluran is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('panjang_saluran') !== '' && !preg_match(
                "/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/",
                $this->input->post('panjang_saluran')
            )) {
                $data['inputerror'][] = 'panjang_saluran';
                $data['error_string'][] = 'Panjang Saluran type in decimal format';
                $data['status'] = FALSE;
            }


            if ($this->input->post('slope') == '') {
                $data['inputerror'][] = 'slope';
                $data['error_string'][] = 'Slope is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('slope') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('slope'))
            ) {
                $data['inputerror'][] = 'slope';
                $data['error_string'][] = 'Slope type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('catchment_area') == '') {
                $data['inputerror'][] = 'catchment_area';
                $data['error_string'][] = 'Catchment Area is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('catchment_area') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('catchment_area'))
            ) {
                $data['inputerror'][] = 'catchment_area';
                $data['error_string'][] = 'Catchment Area are type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('tinggi_saluran') == '') {
                $data['inputerror'][] = 'tinggi_saluran';
                $data['error_string'][] = 'Tinggi Saluran is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('tinggi_saluran') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('tinggi_saluran'))
            ) {
                $data['inputerror'][] = 'tinggi_saluran';
                $data['error_string'][] = 'Tinggi Saluran type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('lebar_saluran') == '') {
                $data['inputerror'][] = 'lebar_saluran';
                $data['error_string'][] = 'Lebar Saluran is required';
                $data['status'] = FALSE;
            }
            if (
                $this->input->post('lebar_saluran') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('lebar_saluran'))
            ) {
                $data['inputerror'][] = 'lebar_saluran';
                $data['error_string'][] = 'Lebar Saluran type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('luas_penampung') == '') {
                $data['inputerror'][] = 'luas_penampung';
                $data['error_string'][] = 'Luas Penampung is required';
                $data['status'] = FALSE;
            }
            if (
                $this->input->post('luas_penampung') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('luas_penampung'))
            ) {
                $data['inputerror'][] = 'luas_penampung';
                $data['error_string'][] = 'Luas Penampung type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('keliling_penampung') == '') {
                $data['inputerror'][] = 'keliling_penampung';
                $data['error_string'][] = 'Keliling Penampung is required';
                $data['status'] = FALSE;
            }

            if (
                $this->input->post('keliling_penampung') !== '' &&
                !preg_match("/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/", $this->input->post('keliling_penampung'))
            ) {
                $data['inputerror'][] = 'keliling_penampung';
                $data['error_string'][] = 'Keliling Penampung type in decimal format';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_arah_aliran') == '') {
                $data['inputerror'][] = 'id_arah_aliran';
                $data['error_string'][] = 'Arah Aliran is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_kondisi_fisik') == '') {
                $data['inputerror'][] = 'id_kondisi_fisik';
                $data['error_string'][] = 'Kondisi Fisik is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_kondisi_sedimen') == '') {
                $data['inputerror'][] = 'id_kondisi_sedimen';
                $data['error_string'][] = 'Kondisi Sedimen is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_tipe_saluran') == '') {
                $data['inputerror'][] = 'id_tipe_saluran';
                $data['error_string'][] = 'Tipe Saluran is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_penanganan') == '') {
                $data['inputerror'][] = 'id_penanganan';
                $data['error_string'][] = 'Penanganan is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('id_lajur_drainase') == '') {
                $data['inputerror'][] = 'id_lajur_drainase';
                $data['error_string'][] = 'Lajur Drainase is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('nama_file_dimensi') == '') {
                $data['inputerror'][] = 'nama_file_dimensi';
                $data['error_string'][] = 'Nama File Dimensi is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('nama_file_foto') == '') {
                $data['inputerror'][] = 'nama_file_foto';
                $data['error_string'][] = 'Nama File Foto is required';
                $data['status'] = FALSE;
            }

            if ($this->input->post('date') == '') {
                $data['inputerror'][] = 'date';
                $data['error_string'][] = 'Tanggal is required';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}