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
        
        $query = $this->db->get();
		return $query->result_array();
		// $query = $this->db->get();
		// return $query->result();
	}
    
    function get_kecamatan()
	{
		$this->db->order_by('nama_kecamatan', 'ASC');
		return $this->db->get('kecamatan')->result();
	}

    function get_setting($id)
	{
		$this->db->select('*')
			->from('setting')
			->where('id_setting', $id);

		return $this->db->get()->row();
	}


	

} 

/* End of file Peta_model.php */

?>