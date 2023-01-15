<?php

class Company_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_company_profile_by_user_id($user_id)
    {
        $this->db->select("*");
        $this->db->from("company_profile");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_company_profile($data = [])
    {
        return $this->db->insert("company_profile", $data);
    }
}
