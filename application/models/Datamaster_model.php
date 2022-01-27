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
	public function select($table)
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
		$this->db->join('arah_aliran', 'drainase.id_arah_aliran=arah_aliran.id_arah_aliran', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$this->db->join('tipe_saluran', 'drainase.id_tipe_saluran=tipe_saluran.id_tipe_saluran', 'LEFT');
		$this->db->join('kondisi_sedimen', 'drainase.id_kondisi_sedimen=kondisi_sedimen.id_kondisi_sedimen', 'LEFT');
		$this->db->join('penanganan', 'drainase.id_penanganan=penanganan.id_penanganan', 'LEFT');
		$this->db->order_by('drainase.id');
		return $this->db->get();
	}
	// END DRAINASE 

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
	public function getChainKelurahan($id_kecamatan)
	{
		return $this->db->get_where('kelurahan', ['id_kecamatan' => $id_kecamatan])->result();
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
}