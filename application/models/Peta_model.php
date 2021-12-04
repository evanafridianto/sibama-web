<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta_model extends CI_Model {

	function get_peta()
	{
		$this->db->from('drainase');
        $this->db->join('jalan', 'jalan.id_jalan=drainase.id_jalan', 'LEFT');
		$this->db->join('arah_aliran', 'drainase.id_arah_aliran=arah_aliran.id_arah_aliran', 'LEFT');
		$this->db->join('kondisi_fisik', 'drainase.id_kondisi_fisik=kondisi_fisik.id_kondisi_fisik', 'LEFT');
		$this->db->join('lajur_drainase', 'drainase.id_lajur_drainase=lajur_drainase.id_lajur_drainase', 'LEFT');
		$this->db->join('kelurahan', 'jalan.id_kelurahan=kelurahan.id_kelurahan', 'LEFT');
		$this->db->join('kecamatan', 'kelurahan.id_kecamatan=kecamatan.id_kecamatan', 'LEFT');
		$query = $this->db->get()->result_array();
		return ($query);
	}
    
    function get_kecamatan()
	{
		$this->db->order_by('nama_kecamatan', 'ASC');
		return $this->db->get('kecamatan')->result();
	}

	public function get_kelurahan()
    {
        return $this->db->get('kelurahan')->result();
    }

	public function get_r24_by_id($id)
	{
		$this->db->from('setting_r24');
		$this->db->where('id_r24',$id);
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

?>