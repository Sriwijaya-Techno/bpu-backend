<?php

class Home_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_layanan()
    {
        $this->db->select("*");
        $this->db->from("layanan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_kategori($id_layanan)
    {
        $this->db->select("*");
        $this->db->where("id_layanan", $id_layanan);
        $this->db->from("kategori");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_item_kategori($id_kategori)
    {
        $this->db->select("*");
        $this->db->from("item_kategori");
        $this->db->where("id_kategori", $id_kategori);
        $this->db->limit(4);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_img_item_kategori($id_item_kategori)
    {
        $this->db->select("*");
        $this->db->from("img_item_kategori");
        $this->db->where("id_item_kategori", $id_item_kategori);
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_header_home()
    {
        $this->db->select("*");
        $this->db->from("header_home");
        $query = $this->db->get();

        return $query->row() ?? [];
    }

    public function cek_header_home()
    {
        $this->db->select("*");
        $this->db->from("header_home");
        $query = $this->db->get();

        if (count($query->result()) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tentang_home()
    {
        $this->db->select("*");
        $this->db->from("tentang_home");
        $query = $this->db->get();

        return $query->row();
    }

    public function cek_tentang_home()
    {
        $this->db->select("*");
        $this->db->from("tentang_home");
        $query = $this->db->get();

        if (count($query->result()) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_testimoni()
    {
        $this->db->select("*");
        $this->db->from("testimoni");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_team()
    {
        $this->db->select("*");
        $this->db->from("team");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_header_home($data = [])
    {
        return $this->db->insert("header_home", $data);
    }

    public function insert_tentang_home($data = [])
    {
        return $this->db->insert("tentang_home", $data);
    }

    public function insert_testimoni($data = [])
    {
        return $this->db->insert("testimoni", $data);
    }

    public function insert_team($data = [])
    {
        return $this->db->insert("team", $data);
    }

    public function update_header_home($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("header_home", $data);
    }

    public function update_tentang_home($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tentang_home", $data);
    }

    public function update_testimoni($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("testimoni", $data);
    }

    public function update_team($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("team", $data);
    }

    public function delete_header_home($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("header_home");
    }

    public function delete_tentang_home($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("tentang_home");
    }

    public function delete_testimoni($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("testimoni");
    }

    public function delete_team($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("team");
    }
}
