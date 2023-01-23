<?php

class Company_profile_status_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_company_profile_statuses()
    {
        $this->db->select("*");
        $this->db->from("company_profile_status");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_company_profile_status($data = [])
    {
        return $this->db->insert("company_profile_status", $data);
    }
}
