<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jalan extends CI_Controller
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
			'page_title' => 'Data Jalan',
			'data_kecamatan' => $this->master->select('kecamatan')->result_array()
		];
		$data['content'] = $this->load->view('admin/datamaster/jalan_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
	}

	// chained kecamatan => kelurahan
	public function get_kelurahan()
	{
		$id = $this->input->post('id', true);
		$data = $this->master->getChainKelurahan($id);
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	public function show_all()
	{
		$data_jalan = $this->master->getJalan();
		$data = array();
		$no = 1;
		foreach ($data_jalan->result_array() as $value) {
			$row = array();
			$row[] = $no++;
			$row[] = $value['nama_jalan'];
			$row[] = $value['nama_kelurahan'];
			$row[] = $value['nama_kecamatan'];
			//add html for action
			$row[] = '<div class="text-center"><button class="table-action-btn btn-success" onclick="edit_jalan(' . "'" . $value['id_jalan'] . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
			<button class="table-action-btn btn-danger" onclick="delete_jalan(' . "'" . $value['id_jalan'] . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>';
			$data[] = $row;
		}
		if ($data_jalan) {
			echo json_encode(array('data' => $data));
		} else {
			echo json_encode(array('data' => 0));
		}
	}

	public function add()
	{
		$this->_validate('add_update');
		$data = array(
			'nama_jalan' => $this->input->post('nama_jalan'),
			'id_kelurahan' => $this->input->post('id_kelurahan'),
			'id_kecamatan'	=> $this->input->post('id_kecamatan')
		);
		$this->master->create('jalan', $data);
		echo json_encode(array("status" => TRUE));
	}

	public function edit($id)
	{
		$data = $this->master->getDatabyId('jalan', 'id_jalan', $id);
		echo json_encode($data);
	}

	public function update()
	{
		$this->_validate('add_update');
		$data = array(
			'nama_jalan' => $this->input->post('nama_jalan'),
			'id_kelurahan' => $this->input->post('id_kelurahan'),
			'id_kecamatan'	=> $this->input->post('id_kecamatan')
		);
		$this->master->update('jalan', array('id_jalan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function delete($id)
	{
		$this->master->delete('jalan', 'id_jalan', $id);
		echo json_encode(array("status" => TRUE));
	}

	public function truncate()
	{
		$this->master->truncateTable('jalan');
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
		$sheet->setCellValue('B1', "nama_jalan");
		$sheet->setCellValue('C1', "id_kelurahan");
		$sheet->setCellValue('D1', "id_kecamatan");

		// Apply style header ke masing-masing kolom header
		$sheet->getStyle('A1')->applyFromArray($style_col);
		$sheet->getStyle('B1')->applyFromArray($style_col);
		$sheet->getStyle('C1')->applyFromArray($style_col);
		$sheet->getStyle('D1')->applyFromArray($style_col);


		$jalan = $this->master->getJalan()->result(); // data jalan 
		$no = 1;
		$numrow = 2;
		foreach ($jalan as $data) {
			$sheet->setCellValue('A' . $numrow, $no);
			$sheet->setCellValue('B' . $numrow, $data->nama_jalan);
			$sheet->setCellValue('C' . $numrow, $data->id_kelurahan);
			$sheet->setCellValue('D' . $numrow, $data->id_kecamatan);

			// Apply style row 
			$sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('D' . $numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);

		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->setTitle("Laporan Data Jalan");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Jalan.xlsx"'); // Set nama file excel nya
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
					'nama_jalan' => $row['B'],
					'id_kelurahan' => $row['C'],
					'id_kecamatan' => $row['D'],
				]);
				if ($row["B"] == "" or $row["C"] == "" or $row["D"] == "") {
					$kosong++;
				}
			}
			$numrow++;
		}
		if ($kosong > 0) {
			echo json_encode(array("status" => null, 'msg' => $kosong));
		} else {
			$this->master->create_multiple('jalan', $data);
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
			if ($this->input->post('nama_jalan') == '') {
				$data['inputerror'][] = 'nama_jalan';
				$data['error_string'][] = 'Nama Jalan is required';
				$data['status'] = FALSE;
			}

			if ($this->input->post('id_kecamatan') == '') {
				$data['inputerror'][] = 'id_kecamatan';
				$data['error_string'][] = 'Kecamatan is required';
				$data['status'] = FALSE;
			}

			if ($this->input->post('id_kelurahan') == '') {
				$data['inputerror'][] = 'id_kelurahan';
				$data['error_string'][] = 'Kelurahan is required';
				$data['status'] = FALSE;
			}
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}