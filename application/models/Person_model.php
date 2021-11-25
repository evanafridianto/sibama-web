<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person_model extends CI_Model {

	function get_datatables()
	{
		$this->db->select('*');
		$this->db->from('persons');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_by_id($id)
	{
		$this->db->from('persons');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert('persons', $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update('persons', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('persons');
	}


}