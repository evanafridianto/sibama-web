<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataJson extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('datajson_model', 'json');
	}

	public function data($layer = 'kecamatan', $type = 'line', $id = '')
	{
		header('Content-Type: application/json');
		$response = [];
		if ($layer == 'drainase') {
			if ($type == 'line') {
				if ($id != '') {
					$this->db->where('kecamatan.id_kecamatan', $id);
				}
				$getDrainase = $this->json->get_drainase();

				foreach ($getDrainase as $row) {
					if (!file_exists('upload/dimensi/' . $row->file_dimensi)) {
						$row->file_dimensi = 'noimage.jpg';
					}
					if (!file_exists('upload/foto/' . $row->file_foto)) {
						$row->file_foto = 'noimage.jpg';
					}

					$data = null;
					$data['type'] = "FeatureCollection";
					$data['features'] =
						[
							[
								"type" => "Feature",
								"geometry" =>
								[
									"type" => "LineString",
									"coordinates" =>
									[
										[$row->long_awal, $row->lat_awal],
										[$row->long_akhir, $row->lat_akhir]
									]
								],
								"properties" =>
								[
									"lokasi" => $row->nama_jalan . ', Kel. ' . $row->nama_kelurahan . ', Kec. ' . $row->nama_kecamatan,
									"tipe_saluran" => $row->tipe_saluran,
									"kondisi_fisik" => $row->kondisi_fisik,
									"kondisi_sedimen" => $row->kondisi_sedimen,
									"penanganan" => $row->penanganan,
									"arah_aliran" => $row->arah_aliran,
									"lajur_drainase" => $row->lajur_drainase,
									"tinggi_saluran" => $row->tinggi_saluran,
									"lebar_saluran" => $row->lebar_saluran,
									"slope" => $row->slope,
									"luas_penampung" => $row->luas_penampung,
									"keliling_penampung" => $row->keliling_penampung,
									"panjang_saluran" => $row->panjang_saluran,
									"catchment_area" => $row->catchment_area,
									"file_foto" => $row->file_foto,
									"file_dimensi" => $row->file_dimensi,
									"date" => $row->date,
									"admin" => $this->session->logged,
									"button" => '<div class="button-list"><button class="table-action-btn btn-success" onclick="edit_drainase(' . "'" . $row->id . "'" . ')"><i class="mdi mdi-eye" title="Detail"></i></button>
								<button class="table-action-btn btn-danger btn-del" onclick="delete_drainase(' . "'" . $row->id . "'" . ')"><i class="mdi mdi-close" title="Delete"></i></button></div>',
									"underConstruction" => false
								],
								"id" => $row->id
							]
						];
					$response[] = $data;
				}
			}
			echo json_encode($response, JSON_PRETTY_PRINT);
		}
		if ($layer == 'jalan') {
			$getJalan = $this->json->get_jalan();
			foreach ($getJalan as $key) {
				$data['id_jalan'] = $key->id_jalan;
				$data['nama_jalan'] = $key->nama_jalan;
				$data['nama_kelurahan'] = $key->nama_kelurahan;
				$data['nama_kecamatan'] = $key->nama_kecamatan;
				$response[] = $data;
			}
			echo "var dataJalan=" . json_encode($response, JSON_PRETTY_PRINT);
		}
		if ($layer == 'kelurahan') {
			$getKelurahan = $this->json->get_kelurahan();
			foreach ($getKelurahan as $key) {
				$data['id_kelurahan'] = $key->id_kelurahan;
				$data['nama_kelurahan'] = $key->nama_kelurahan;
				$data['nama_kecamatan'] = $key->nama_kecamatan;
				$response[] = $data;
			}
			echo "var dataKelurahan=" . json_encode($response, JSON_PRETTY_PRINT);
		}
		if ($layer == 'kecamatan') {
			$getKecamatan = $this->json->get_kecamatan();
			foreach ($getKecamatan as $key) {
				$data['id_kecamatan'] = $key->id_kecamatan;
				$data['nama_kecamatan'] = $key->nama_kecamatan;
				$data['file_geojson'] = $key->file_geojson;
				$response[] = $data;
			}
			echo "var dataKecamatan=" . json_encode($response, JSON_PRETTY_PRINT);
		}
	}
}