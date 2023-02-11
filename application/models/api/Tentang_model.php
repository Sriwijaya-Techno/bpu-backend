<?php

class Tentang_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_tentangs()
    {

        $this->db->select("tentang.*, tentang_kategori.nama AS kategori");
        $this->db->from("tentang");
        $this->db->join("tentang_kategori", "tentang_kategori.id = tentang.id_kategori");
        $this->db->where("tentang.status", "ditampilkan");
        $this->db->where("tentang_kategori.status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_tentang($data = array())
    {
        return $this->db->insert("tentang", $data);
    }

    public function update_tentang($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tentang", $data);
    }
}
