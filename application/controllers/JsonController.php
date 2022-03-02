<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JsonController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('datamaster_model', 'master');
	}

	public function data($layer = 'drainase', $type = 'line', $id = '')
	{
		header('Content-Type: application/json');
		$response = [];
		if ($layer == 'drainase') {
			// if ($type === 'line') {
			if ($id != '') {
				$this->db->where('kecamatan.id_kecamatan', $id);
			}
			$getDrainase = $this->master->getDrainase();
			foreach ($getDrainase->result() as $row) {
				global $kesimpulan;
				if ($row->luas_penampung > 0 && $row->keliling_penampung > 0 && $row->slope > 0 && $row->panjang > 0 && $row->catchment_area > 0) {
					// q  
					$v = floatval($row->luas_penampung) / pow($row->keliling_penampung, 2 / 3) * pow($row->slope, 1 / 2) / 0.012; // (m/dtk)
					$q = $v * floatval($row->luas_penampung); // (m3/jam)
					// end q  

					// cia 
					$tc = pow((0.872 *  pow(floatval($row->panjang), 2)) / (1000 *  floatval($row->slope)), 0.385);
					$i = (floatval($row->r24) / 24) * pow(24 / floatval($tc), 2 / 3); // intensitas hujan (mm/jam)
					$cia = 0.278 * floatval(0.6) * $i * floatval($row->catchment_area);

					if ($cia > $q) {
						$kesimpulan = "Melimpah";
					} else {
						$kesimpulan = "Tidak Melimpah";
					}
				} else {
					$kesimpulan = "Tidak Melimpah";
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
								"status_genangan" => $kesimpulan,
								"lokasi" => $row->nama_jalan . ', ' . $row->nama_kelurahan . ', ' . $row->nama_kecamatan  . ' #' . $row->id_drainase,
								// "jalan" =>  $row->nama_jalan,
								// "kelurahan" => $row->nama_kelurahan,
								// "kecamatan" => $row->nama_kecamatan,
								"r24" => $row->r24,
								"tipe" => $row->tipe,
								"arah_air" => $row->arah_air,
								"kondisi_fisik" => $row->nama_kondisi_fisik,
								"kondisi_sedimen" => $row->nama_kondisi_sedimen,
								"penanganan" => $row->nama_penanganan,
								"jalur_jalan" => $row->jalur_jalan,
								"tinggi" => $row->tinggi,
								"lebar" => $row->lebar,
								"slope" => $row->slope,
								"luas_penampung" => $row->luas_penampung,
								"keliling_penampung" => $row->keliling_penampung,
								"panjang" => $row->panjang,
								"catchment_area" => $row->catchment_area,
								"file_foto" => $row->file_foto,
								"file_dimensi" => $row->file_dimensi,
								"date" => $row->date,
								"admin" => $this->session->logged,
								"underConstruction" => false
							],
							"id" => $row->id_drainase
						]
					];
				$response[] = $data;
			}
			if ($type === 'line') {
				echo json_encode($response, JSON_PRETTY_PRINT);
			} else {
				$fp = fopen('drainase.geojson', 'w');
				fwrite($fp, json_encode($response, JSON_PRETTY_PRINT));
				fclose($fp);
				$file_content = file_get_contents('drainase.geojson'); // Read the file's contents
				if (file_exists('drainase.geojson')) {
					unlink('drainase.geojson');
				}
				force_download('drainase.geojson', $file_content);
			}
		}
		if ($layer == 'jalan') {
			$getJalan = $this->master->getJalan();
			foreach ($getJalan->result() as $key) {
				$data['id_jalan'] = $key->id_jalan;
				$data['nama_jalan'] = $key->nama_jalan;
				$data['nama_kelurahan'] = $key->nama_kelurahan;
				$data['nama_kecamatan'] = $key->nama_kecamatan;
				$response[] = $data;
			}
			if ($type === 'download') {
				$fp = fopen('jalan.json', 'w');
				fwrite($fp, json_encode($response, JSON_PRETTY_PRINT));
				fclose($fp);
				$file_content = file_get_contents('jalan.json'); // Read the file's contents
				if (file_exists('jalan.json')) {
					unlink('jalan.json');
				}
				force_download('jalan.json', $file_content);
			} else {
				echo "var dataJalan=" . json_encode($response, JSON_PRETTY_PRINT);
			}
		}
		if ($layer == 'kelurahan') {
			$getKelurahan = $this->master->getKelurahan();
			foreach ($getKelurahan->result() as $key) {
				$data['id_kelurahan'] = $key->id_kelurahan;
				$data['nama_kelurahan'] = $key->nama_kelurahan;
				$data['nama_kecamatan'] = $key->nama_kecamatan;
				$response[] = $data;
			}
			if ($type === 'download') {
				$fp = fopen('kelurahan.json', 'w');
				fwrite($fp, json_encode($response, JSON_PRETTY_PRINT));
				fclose($fp);
				$file_content = file_get_contents('kelurahan.json'); // Read the file's contents
				if (file_exists('kelurahan.json')) {
					unlink('kelurahan.json');
				}
				force_download('kelurahan.json', $file_content);
			} else {
				echo "var dataKelurahan=" . json_encode($response, JSON_PRETTY_PRINT);
			}
		}
		if ($layer == 'kecamatan') {
			$getKecamatan = $this->master->getKecamatan();
			foreach ($getKecamatan->result() as $key) {
				$data['id_kecamatan'] = $key->id_kecamatan;
				$data['nama_kecamatan'] = $key->nama_kecamatan;
				$data['file_geojson'] = $key->file_geojson;
				$response[] = $data;
			}
			if ($type === 'download') {
				$fp = fopen('kecamatan.json', 'w');
				fwrite($fp, json_encode($response, JSON_PRETTY_PRINT));
				fclose($fp);
				$file_content = file_get_contents('kecamatan.json'); // Read the file's contents
				if (file_exists('kecamatan.json')) {
					unlink('kecamatan.json');
				}
				force_download('kecamatan.json', $file_content);
			} else {
				echo "var dataKecamatan=" . json_encode($response, JSON_PRETTY_PRINT);
			}
		}
	}
}