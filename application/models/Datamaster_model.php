<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datamaster_model extends CI_Model
{

	// general cud

	// create 
	public function create($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	public function create_multiple($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}
	// update 
	public function update($table, $where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	// delete 
	public function delete($table, $pk, $id)
	{
		$this->db->where($pk, $id);
		$this->db->delete($table);
	}

	// get by id 
	public function getDatabyId($table, $pk, $id)
	{
		$this->db->from($table);
		$this->db->where($pk, $id);
		$query = $this->db->get();
		return $query->row();
	}

	// truncate 
	public function truncateTable($table)
	{
		$this->db->truncate($table);
	}
	// select option 
	public function get($table)
	{
		return $this->db->get($table);
	}

	// DRAINASE
	public function getDrainase()
	{
		$this->db->select('*');
		$this->db->from('drainase');
		$this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$this->db->join('setting_r24', 'setting_r24.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$this->db->join('kondisi_fisik_drainase', 'drainase.id_kondisi_fisik=kondisi_fisik_drainase.id_kondisi_fisik', 'LEFT');
		$this->db->join('kondisi_sedimen_drainase', 'drainase.id_kondisi_sedimen=kondisi_sedimen_drainase.id_kondisi_sedimen', 'LEFT');
		$this->db->join('penanganan_drainase', 'drainase.id_penanganan=penanganan_drainase.id_penanganan', 'LEFT');
		$this->db->order_by('drainase.id_drainase');
		return $this->db->get();
	}

	// JALAN
	public function getJalan()
	{
		$this->db->select('*');
		$this->db->from('jalan');
		$this->db->join('kecamatan', 'jalan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->order_by('jalan.id_jalan');
		return $this->db->get();
	}

	// KELURAHAN
	public function getKelurahan()
	{
		$this->db->select('*');
		$this->db->from('kelurahan');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$this->db->order_by('kelurahan.id_kelurahan');
		return $this->db->get();
	}

	// KECAMATAN
	public function getKecamatan()
	{
		$this->db->select('*');
		$this->db->from('kecamatan');
		$this->db->order_by('id_kecamatan');
		return $this->db->get();
	}
	// User
	public function getUser()
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->order_by('id_user');
		return $this->db->get();
	}

	// R24
	public function getR24()
	{
		$this->db->select('*');
		$this->db->from('setting_r24');
		$this->db->join('kecamatan', 'kecamatan.id_kecamatan=setting_r24.id_kecamatan', 'LEFT');
		$this->db->order_by('id_r24');
		return $this->db->get();
	}
}