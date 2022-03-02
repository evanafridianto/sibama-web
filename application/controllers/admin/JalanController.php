<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JalanController extends CI_Controller
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
			'page_title' => 'Data Jalan',
			'kecamatan' => $this->master->getKecamatan()->result(),
		];
		$data['content'] = $this->load->view('admin/datamaster/jalan_view', $datacontent, true);
		$this->load->view('admin/layouts/main', $data);
	}

	// chained kecamatan => kelurahan
	public function get_kelurahan()
	{
		$id = $this->input->post('id', true);
		$data = $this->db->get_where('kelurahan', ['id_kecamatan' => $id])->result();
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

	public function edit($id)
	{
		$data = $this->master->getDatabyId('jalan', 'id_jalan', $id);
		echo json_encode($data);
	}

	public function save()
	{
		$config = array(
			[
				'field' => 'nama_jalan',
				'label' => 'Nama Jalan',
				'rules' => 'required',
			],
			[
				'field' => 'id_kecamatan',
				'label' => 'Kecamatan',
				'rules' => 'required',
			],
			[
				'field' => 'id_kelurahan',
				'label' => 'Kelurahan',
				'rules' => 'required',
			],
		);
		$this->form_validation->set_rules($config);
		$data = array(
			'nama_jalan' => $this->input->post('nama_jalan'),
			'id_kecamatan'	=> $this->input->post('id_kecamatan'),
			'id_kelurahan' => $this->input->post('id_kelurahan'),
		);

		if ($this->form_validation->run() == FALSE) {
			$this->form_validation->set_error_delimiters('', '');
			$json = array(
				'nama_jalan' => form_error('nama_jalan'),
				'id_kecamatan' => form_error('id_kecamatan'),
				'id_kelurahan' => form_error('id_kelurahan'),
			);
			echo json_encode(array("error" => $json, "status" => FALSE));
		} else {
			if ($this->input->post('id_jalan') == '') {
				$this->master->create('jalan', $data);
				echo json_encode(array("status" => TRUE));
			} else {
				$this->master->update('jalan', array('id_jalan' => $this->input->post('id_jalan')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}
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
		$config['upload_path'] = FCPATH . 'upload/excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size'] = 24000; //set max size allowed in Kilobyte
		$config['max_width'] = 5000; // set max width image allowed
		$config['max_height'] = 5000; // set max height allowed
		$config['file_name'] = 'file_jalan_' . round(microtime(true) * 1000);

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
}