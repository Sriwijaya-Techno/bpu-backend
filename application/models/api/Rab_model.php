<?php

class Rab_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_rabs()
    {
        $this->db->select("*");
        $this->db->from("rab");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_rab($data = [])
    {
        return $this->db->insert("rab", $data);
    }

    public function insert_surat_rab($data = [])
    {
        return $this->db->insert("rab_surat_kerjasama", $data);
    }

    public function update_rab($id_rab, $data = [])
    {
        $this->db->where("id", $id_rab);
        return $this->db->update("rab", $data);
    }

    public function delete_rab($id_rab)
    {
        $this->db->where("id", $id_rab);
        return $this->db->delete("rab");
    }
}
