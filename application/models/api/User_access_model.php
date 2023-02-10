<?php

class User_access_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_accesses($id_user)
    {
        $this->db->select("user_access.*, menu_access.menu");
        $this->db->from("user_access");
        $this->db->join("menu_access", "menu_access.id = user_access.id_menu");
        $this->db->where("user_access.id_user", $id_user);
        $this->db->where("user_access.status", "ditampilkan");
        $this->db->where("menu_access.status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_user_access($data = [])
    {
        return $this->db->insert("user_access", $data);
    }

    public function update_user_access($id_user_access, $data = [])
    {
        $this->db->where("id", $id_user_access);
        return $this->db->update("user_access", $data);
    }
}
