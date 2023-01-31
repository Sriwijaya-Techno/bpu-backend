<?php

class Item_kategori_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_items_kategori()
    {
        $this->db->select("*");
        $this->db->from("item_kategori");
        $query = $this->db->get();

        return $query->result();
    }
    public function get_items_kategori($data)
    {
        $this->db->select("
        item_kategori.*,
        kategori.id_layanan,
        kategori.nama as nama_kategori,
        kategori.slug as slug_kategori,
        layanan.slug as slug_layanan,
        layanan.nama as nama_layanan
        ");
        $this->db->from("item_kategori");
        $this->db->join('kategori', 'kategori.id = item_kategori.id_kategori');
        $this->db->join('layanan', 'layanan.id = kategori.id_layanan');
        if (!empty($data['id_kategori'])) {
            $this->db->where("item_kategori.id_kategori", $data['id_kategori']);
        }
        if (!empty($data['id_layanan'])) {
            $this->db->where("kategori.id_layanan", $data['id_layanan']);
        }
        if (!empty($data['slug_kategori'])) {
            $this->db->where("kategori.slug", $data['slug_kategori']);
        }
        if (!empty($data['slug_layanan'])) {
            $this->db->where("layanan.slug", $data['slug_layanan']);
        }
        if (!empty($data['id_item_kategori'])) {
            $this->db->where("item_kategori.id", $data['id_item_kategori']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function cek_slug_item_kategori($slug)
    {
        $this->db->select("count(*) as jumlah");
        $this->db->from("item_kategori");
        $this->db->where("slug", $slug);
        $query = $this->db->get();

        if ($query->row()->jumlah > 0) {
            return true;
        } else {
            return false;
        }
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

    public function update_item_kategori($id_item_kategori, $data = [])
    {
        $this->db->where("id", $id_item_kategori);
        return $this->db->update("item_kategori", $data);
    }

    public function delete_imgs_item_kategori($id_item_kategori)
    {
        $this->db->where("id_item_kategori", $id_item_kategori);
        return $this->db->delete("img_item_kategori");
    }

    public function delete_item_kategori($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("item_kategori");
    }
}
