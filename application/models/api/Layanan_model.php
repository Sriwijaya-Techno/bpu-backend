<?php

class Layanan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_layanans()
    {
        $this->db->select("*");
        $this->db->from("layanan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_layanan($data = [])
    {

        return $this->db->insert("layanan", $data);
    }
}
