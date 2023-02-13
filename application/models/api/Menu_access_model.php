<?php

class Menu_access_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_menu_Accesses()
    {
        $this->db->select("*");
        $this->db->from("menu_Access");
        $this->db->where("status", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_menu_Accesses_by_roles_level($id_role, $level)
    {
        $this->db->select("menu_access.id, menu_access.id_parent, menu_access.level, menu_access.menu, menu_access.icon, menu_access.url, role.id AS id_role, role.nama AS nama_role ");
        $this->db->from("menu_access");
        $this->db->join("menu_role_access", "menu_role_access.id_menu = menu_access.id");
        $this->db->join("role", "role.id = menu_role_access.id_role");
        $this->db->where("menu_access.status", "ditampilkan");
        $this->db->where("menu_role_access.id_role", $id_role);
        $this->db->where("menu_access.level", $level);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_menu_Accesses_by_roles_level_parent($id_role, $level, $parent)
    {
        $this->db->select("menu_access.id, menu_access.id_parent, menu_access.level, menu_access.menu, menu_access.icon, menu_access.url, role.id AS id_role, role.nama AS nama_role");
        $this->db->from("menu_access");
        $this->db->join("menu_role_access", "menu_role_access.id_menu = menu_access.id");
        $this->db->join("role", "role.id = menu_role_access.id_role");
        $this->db->where("menu_access.status", "ditampilkan");
        $this->db->where("menu_role_access.id_role", $id_role);
        $this->db->where("menu_access.id_parent", $parent);
        $this->db->where("menu_access.level", $level);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_menu_access($data = [])
    {
        return $this->db->insert("menu_access", $data);
    }

    public function update_menu_access($id_menu_Access, $data = [])
    {
        $this->db->where("id", $id_menu_Access);
        return $this->db->update("menu_access", $data);
    }
}
