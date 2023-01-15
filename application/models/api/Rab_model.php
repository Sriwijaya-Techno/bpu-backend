<?php

class Rab_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_rabs()
    {
        $this->db->select("*");
        $this->db->from("rab");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_rab($data = [])
    {
        return $this->db->insert("rab", $data);
    }
}
