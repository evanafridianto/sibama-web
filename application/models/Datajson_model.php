<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datajson_model extends CI_Model
{
	public function get_drainase()
	{
		$this->db->join('jalan', 'drainase.id_jalan=jalan.id_jalan', 'LEFT');
		$this->db->join('arah_aliran', 'drainase.id_arah_aliran=arah_aliran.id_arah_aliran', 'LEFT');
		$this->db->join('tipe_saluran', 'drainase.id_tipe_saluran=tipe_saluran.id_tipe_saluran', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$this->db->join('kondisi_sedimen', 'drainase.id_kondisi_sedimen=kondisi_sedimen.id_kondisi_sedimen', 'LEFT');
		$this->db->join('penanganan', 'drainase.id_penanganan=penanganan.id_penanganan', 'LEFT');
		return $this->db->get('drainase')->result();
	}

	public function get_jalan()
	{
		$this->db->order_by('nama_jalan', 'ASC');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->join('kecamatan', 'jalan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		return $this->db->get('jalan')->result();
	}

	public function get_kelurahan()
	{
		$this->db->order_by('nama_kelurahan', 'ASC');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		return $this->db->get('kelurahan')->result();
	}

	public function get_kecamatan()
	{
		$this->db->order_by('nama_kecamatan', 'ASC');
		return $this->db->get('kecamatan')->result();
	}
}

/* End of file Datajson.php */