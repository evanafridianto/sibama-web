<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda_model extends CI_Model {

	function get_drainase_rusak()
	{
		$this->db->select('*');
		$this->db->from('drainase');
        $this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$this->db->where('drainase.id_kondisi_fisik=3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function count_drainase()
	{
		return $this->db->count_all_results('drainase');
	}
	public function count_jalan()
	{
		return $this->db->count_all_results('jalan');
	}
	public function count_kelurahan()
	{
		return $this->db->count_all_results('kelurahan');
	}
	public function count_kecamatan()
	{
		return $this->db->count_all_results('kecamatan');
	}

} 

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */


?>