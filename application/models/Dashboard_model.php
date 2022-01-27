<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

	function get_drainase_rusak()
	{
		$this->db->select('*');
		$this->db->from('drainase');
		$this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$this->db->where('drainase.id_kondisi_fisik=3');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count($table)
	{
		return $this->db->count_all_results($table);
	}
} 

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */