<?php

class Kategori_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kategoris()
    {
        $this->db->select("kategori.id_layanan, kategori.id AS id_kategori, layanan.nama AS nama_layanan, kategori.nama AS nama_kategori");
        $this->db->from("kategori");
        $this->db->join("layanan", "layanan.id = kategori.id_layanan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_kategori($data = [])
    {
        return $this->db->insert("kategori", $data);
    }
}
