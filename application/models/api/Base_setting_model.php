<?php

class Base_setting_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_base_settings($id_kerjasama)
    {
        $this->db->select("base_setting.bs_id, base_setting.bs_nama, base_setting_kerjasama.nama_pj_univ as bs_rektor, base_setting_kerjasama.jabatan AS bs_jabatan, base_setting.bs_keterangan, base_setting.bs_logo");
        $this->db->from("base_setting");
        $this->db->join("base_setting_kerjasama", "base_setting_kerjasama.id_base_setting = base_setting.bs_id");
        $this->db->where("base_setting_kerjasama.id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_old_base_settings()
    {
        $this->db->select("*");
        $this->db->from("base_setting");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_base_setting($data = [])
    {
        return $this->db->insert("base_setting", $data);
    }
}
