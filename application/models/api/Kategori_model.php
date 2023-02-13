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
        $this->db->select("kategori.id_layanan, kategori.id AS id_kategori, layanan.nama AS nama_layanan, kategori.nama AS nama_kategori, kategori.slug, kategori.icon");
        $this->db->from("kategori");
        $this->db->join("layanan", "layanan.id = kategori.id_layanan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_kategori_tentang()
    {
        $this->db->select("*");
        $this->db->from("tentang_kategori");
        $this->db->where("status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_kategori_artikel()
    {
        $this->db->select("*");
        $this->db->from("artikel_kategori");
        $this->db->where("status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function cek_slug_kategori_tentang($slug_kategori)
    {
        $this->db->select("*");
        $this->db->from("tentang_kategori");
        $this->db->where("slug", $slug_kategori);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cek_slug_kategori_artikel($slug_kategori)
    {
        $this->db->select("*");
        $this->db->from("artikel_kategori");
        $this->db->where("slug", $slug_kategori);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_kategori($data = [])
    {
        try {
            return $this->db->insert("kategori", $data);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function insert_kategori_tentang($data = [])
    {
        return $this->db->insert("tentang_kategori", $data);
    }

    public function insert_kategori_artikel($data = [])
    {
        return $this->db->insert("artikel_kategori", $data);
    }

    public function update_kategori($id, $data = [])
    {
        $this->db->where("id", $id);
        return $this->db->update("kategori", $data);
    }

    public function update_kategori_tentang($id, $data = [])
    {
        $this->db->where("id", $id);
        return $this->db->update("tentang_kategori", $data);
    }

    public function update_kategori_artikel($id, $data = [])
    {
        $this->db->where("id", $id);
        return $this->db->update("artikel_kategori", $data);
    }

    public function delete_kategori($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("kategori");
    }
}
