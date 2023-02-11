<?php

class Artikel_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_artikel($user_id = '', $artikel_id = '', $start = '', $limit = '', $desc = '', $id_kategori = '')
    {
        if (!empty($artikel_id)) {
            $q = " SELECT a.* FROM artikel a ";
        } else {
            if ($desc == 'true') {
                $q = " SELECT a.id, a.user_id, b.username, a.judul, a.isi, a.slug, a.cover, c.nama AS kategori, a.tanggal FROM 
                artikel a 
                INNER JOIN user b 
                ON a.user_id=b.id 
                INNER JOIN artikel_kategori c 
                ON a.id_kategori = c.id ";
            } else {
                $q = " SELECT a.id, a.user_id, b.username, a.judul, SUBSTRING((a.isi), 1, 500) AS isi, a.slug, a.cover, c.nama AS kategori, a.tanggal FROM 
                artikel a 
                INNER JOIN user b 
                ON a.user_id=b.id 
                INNER JOIN artikel_kategori c 
                ON a.id_kategori = c.id ";
            }
        }

        $q .= " WHERE a.id IS NOT NULL AND a.status = 'ditampilkan' AND c.status = 'ditampilkan'";

        if (!empty($artikel_id))
            $q .= " AND a.id = '$artikel_id' ";

        if (!empty($user_id))
            $q .= " AND a.user_id = '$user_id' ";

        if (!empty($id_kategori))
            $q .= " AND a.id_kategori = '$id_kategori' ";

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
