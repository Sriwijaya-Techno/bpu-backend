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
        try {
            return $this->db->insert("kategori", $data);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function update_kategori($id, $data = [])
    {
        $this->db->where("id", $id);
        return $this->db->update("kategori", $data);
    }

    public function delete_kategori($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("kategori");
    }
}
