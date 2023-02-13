<?php

class Menu_role_access_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_menu_role_accesses_by_id_menu($id_menu)
    {
        $this->db->select("menu_role_access.*, role.nama");
        $this->db->from("menu_role_access");
        $this->db->join("role", "role.id = menu_role_access.id_role");
        $this->db->where("id_menu", $id_menu);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_menu_role_access($data = [])
    {
        return $this->db->insert("menu_role_access", $data);
    }

    public function update_menu_role_access($id_menu_role_access, $data = [])
    {
        $this->db->where("id", $id_menu_role_access);
        return $this->db->update("menu_role_access", $data);
    }

    public function delete_menu_role_access($id_menu, $id_role)
    {
        $this->db->where("id_menu", $id_menu);
        $this->db->where("id_role", $id_role);
        return $this->db->delete("menu_role_access");
    }
}
