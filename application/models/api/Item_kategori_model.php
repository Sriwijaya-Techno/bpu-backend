<?php

class Item_kategori_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_items_kategori($id_kategori)
    {
        $this->db->select("*");
        $this->db->from("item_kategori");
        $this->db->where("id_kategori", $id_kategori);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_imgs_item_kategori($id_item_kategori)
    {
        $this->db->select("*");
        $this->db->from("img_item_kategori");
        $this->db->where("id_item_kategori", $id_item_kategori);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_item_kategori($data = [])
    {
        return $this->db->insert("item_kategori", $data);
    }

    public function insert_img_item_kategori($data = [])
    {
        return $this->db->insert("img_item_kategori", $data);
    }
}
