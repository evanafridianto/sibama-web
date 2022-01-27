<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peta_model extends CI_Model
{

	public function getR24byId($id)
	{
		$this->db->from('setting_r24');
		$this->db->where('id_r24', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_r24($where, $data)
	{
		$this->db->update('setting_r24', $data, $where);
		return $this->db->affected_rows();
	}
} 

/* End of file Peta_model.php */