<?php

class Role_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_roles()
    {

        $this->db->select("*");
        $this->db->from("role");
        $this->db->where("status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_role($data = array())
    {
        return $this->db->insert("role", $data);
    }

    public function update_role($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("role", $data);
    }
}
