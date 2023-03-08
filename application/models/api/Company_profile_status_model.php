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
        $this->db->where("status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_company_profile_status($data = [])
    {
        return $this->db->insert("company_profile_status", $data);
    }

    public function update_company_profile_status($id, $data)
    {
        $this->db->where("cps_id", $id);
        return $this->db->update("company_profile_status", $data);
    }
}
