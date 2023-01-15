<?php

class Lembaga_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_lembagas()
    {
        $this->db->select("*");
        $this->db->from("lembaga");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_lembaga($data = [])
    {
        return $this->db->insert("lembaga", $data);
    }
}
