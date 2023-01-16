<?php

class Pasal_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_pasals()
    {
        $this->db->select("*");
        $this->db->from("pasal");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_pasals_by_id($draft_id)
    {
        $this->db->select("*");
        $this->db->from("pasal");
        $this->db->where("draft_id", $draft_id);
        $this->db->order_by('pasal_kode', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_pasal($data = [])
    {
        return $this->db->insert("pasal", $data);
    }

    public function update_pasal($draft_id, $pasal_kode, $data)
    {
        $this->db->where("draft_id", $draft_id);
        $this->db->where("pasal_kode", $pasal_kode);
        return $this->db->update("pasal", $data);
    }
}
