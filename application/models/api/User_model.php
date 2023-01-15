<?php

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_users()
    {

        $this->db->select("*");
        $this->db->from("user");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_user($data = array())
    {

        return $this->db->insert("user", $data);
    }

    public function delete_user($user_id)
    {
        $this->db->where("id", $user_id);
        return $this->db->delete("user");
    }

    public function update_user_information($id, $informations)
    {
        $this->db->where("id", $id);
        return $this->db->update("user", $informations);
    }
}
