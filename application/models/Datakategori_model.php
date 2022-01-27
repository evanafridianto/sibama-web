<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datakategori_model extends CI_Model
{
    // get kategori
    public function get_kategori($table, $id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($id);
        return $this->db->get();
    }

    // general cud
    public function create($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $where, $data)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_kategori_by_id($table, $pk, $id)
    {
        $this->db->from($table);
        $this->db->where($pk, $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete($table, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->delete($table);
    }
}

/* End of file Datakategori_model.php */