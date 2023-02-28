<?php

class Layanan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_layanans()
    {
        $this->db->select("*");
        $this->db->from("layanan");
        $this->db->order_by('created_date', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_layanan($data = [])
    {
        try {
            return $this->db->insert("layanan", $data);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function update_layanan($id, $data = [])
    {
        $this->db->where("id", $id);
        return $this->db->update("layanan", $data);
    }

    public function delete_layanan($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("layanan");
    }
}
