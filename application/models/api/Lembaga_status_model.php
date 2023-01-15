<?php

class Lembaga_status_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_lembaga_statuses()
    {
        $this->db->select("*");
        $this->db->from("lembaga_status");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_lembaga_status($data = [])
    {
        return $this->db->insert("lembaga_status", $data);
    }
}
