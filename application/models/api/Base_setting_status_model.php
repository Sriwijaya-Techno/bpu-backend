<?php

class Base_setting_status_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_base_setting_statuses()
    {
        $this->db->select("*");
        $this->db->from("base_setting_status");
        $query = $this->db->get();

        return $query->result();
    }
}
