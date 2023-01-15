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
        $this->db->select("*");
        $this->db->from("kategori");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_kategori($data = [])
    {

        return $this->db->insert("kategori", $data);
    }
}
