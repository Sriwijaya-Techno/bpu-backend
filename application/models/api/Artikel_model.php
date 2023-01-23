<?php

class Artikel_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_artikel($user_id = '', $artikel_id = '', $start = '', $limit = '', $desc = '', $jenis = '')
    {
        if (!empty($artikel_id)) {
            $q = " SELECT a.* FROM artikel a ";
        } else {
            if ($desc == 'true') {
                $q = " SELECT a.id, a.user_id, b.username, a.judul, a.isi, a.slug, a.cover, a.jenis, a.tanggal FROM 
                artikel a 
                INNER JOIN user b 
                ON a.user_id=b.id ";
            } else {
                $q = " SELECT a.id, a.user_id, b.username, a.judul, SUBSTRING((a.isi), 1, 500) AS isi, a.slug, a.cover, a.jenis, a.tanggal FROM 
                artikel a 
                INNER JOIN user b 
                ON a.user_id=b.id ";
            }
        }

        $q .= " WHERE a.id IS NOT NULL ";

        if (!empty($user_id))
            $q .= " AND a.user_id = '$user_id' ";

        if (!empty($jenis))
            $q .= " AND a.jenis = '$jenis' ";

        if (!empty($limit) && !empty($start))
            $q .= " limit $start,$limit ";

        if (!empty($limit) && empty($start))
            $q .= " limit $limit ";

        $query = $this->db->query($q)->result();
        return $query;
    }

    public function insert_artikel($data = [])
    {
        return $this->db->insert("artikel", $data);
    }

    public function update_artikel($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("artikel", $data);
    }
}
