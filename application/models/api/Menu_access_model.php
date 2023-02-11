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
        $this->db->select("id, id_parent, menu, icon, url");
        $this->db->from("menu_Access");
        $this->db->where("status", "ditampilkan");
        $this->db->where("id_role", $id_role);
        $this->db->where("level", $level);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_menu_Accesses_by_roles_level_parent($id_role, $level, $parent)
    {
        $this->db->select("id, id_parent, menu, icon, url");
        $this->db->from("menu_Access");
        $this->db->where("status", "ditampilkan");
        $this->db->where("id_role", $id_role);
        $this->db->where("id_parent", $parent);
        $this->db->where("level", $level);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_menu_Access($data = [])
    {
        return $this->db->insert("menu_Access", $data);
    }

    public function update_menu_Access($id_menu_Access, $data = [])
    {
        $this->db->where("id", $id_menu_Access);
        return $this->db->update("menu_Access", $data);
    }
}
