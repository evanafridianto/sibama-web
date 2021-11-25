<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdata_model extends CI_Model {
   
   
    // DRAINASE
	function get_drainase()
	{
		$this->db->select('*');
		$this->db->from('drainase');
        $this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('arah_aliran', 'drainase.id_arah_aliran=arah_aliran.id_arah_aliran', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_drainase_by_id($id)
	{
		$this->db->from('drainase');
		$this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('arah_aliran', 'drainase.id_arah_aliran=arah_aliran.id_arah_aliran', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$this->db->join('tipe_saluran', 'drainase.id_tipe_saluran=tipe_saluran.id_tipe_saluran', 'LEFT');
		$this->db->join('kondisi_sedimen', 'drainase.id_kondisi_sedimen=kondisi_sedimen.id_kondisi_sedimen', 'LEFT');
		$this->db->join('penanganan', 'drainase.id_penanganan=penanganan.id_penanganan', 'LEFT');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insert_drainase($data)
	{
		$this->db->insert('drainase', $data);
		return $this->db->insert_id();
	}

	public function update_drainase($where, $data)
	{
		$this->db->update('drainase', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_drainase($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('drainase');
	}
    
    public function select_jalan()
    {
        $this->db->order_by('nama_jalan', 'ASC');
        return $this->db->get('jalan')->result();
    }
    public function select_lajur_drainase()
    {
        return $this->db->get('lajur_drainase')->result();
    }
    public function select_arah_aliran()
    {
        return $this->db->get('arah_aliran')->result();
    }
    public function select_kondisi_fisik()
    {
        return $this->db->get('kondisi_fisik')->result();
    }
    public function select_kondisi_sedimen()
    {
        return $this->db->get('kondisi_sedimen')->result();
    }
    public function select_tipe_saluran()
    {
        return $this->db->get('tipe_saluran')->result();
    }
    public function select_penanganan()
    {
        return $this->db->get('penanganan')->result();
    }

    // END DRAINASE 
   
    // JALAN
	function get_jalan()
	{
		$this->db->select('*');
		$this->db->from('jalan');
        $this->db->join('kecamatan','jalan.id_kecamatan=kecamatan.id_kecamatan','LEFT');
        $this->db->join('kelurahan','jalan.id_kelurahan=kelurahan.id_kelurahan','LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_jalan_by_id($id)
	{
		$this->db->from('jalan');
		$this->db->where('id_jalan',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insert_jalan($data)
	{
		$this->db->insert('jalan', $data);
		return $this->db->insert_id();
	}

	public function update_jalan($where, $data)
	{
		$this->db->update('jalan', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_jalan($id)
	{
		$this->db->where('id_jalan', $id);
		$this->db->delete('jalan');
	}

    public function get_kecamatan()
    {
        return $this->db->get('kecamatan')->result_array();
    }

    public function get_chain_kelurahan($id_kecamatan){
		return $this->db->get_where('kelurahan', ['id_kecamatan' => $id_kecamatan])->result();
	}


}