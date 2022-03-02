<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
	function getCountDrainaseKelurahan()
	{
		$this->db->select('nama_kelurahan, COUNT(id_drainase) as total');
		$this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->group_by('nama_kelurahan');
		$this->db->order_by('total', 'desc');
		$query =  $this->db->get('drainase');
		return $query->result_array();
	}

	public function count($table)
	{
		return $this->db->count_all_results($table);
	}
} 

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */