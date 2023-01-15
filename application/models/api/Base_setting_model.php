<?php

class Base_setting_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_base_settings()
    {
        $this->db->select("*");
        $this->db->from("base_setting");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_base_setting($data = [])
    {
        return $this->db->insert("base_setting", $data);
    }
}
