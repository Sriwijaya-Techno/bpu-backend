<?php

class Kerjasama_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kerjasamas()
    {
        $this->db->select("kerjasama.id AS id_kerjasama, detail_kerjasama.id AS id_detail, company_profile.nama_perusahaan, detail_kerjasama.judul_kegiatan, 
                            kerjasama.status, detail_kerjasama.nilai_kontrak, detail_kerjasama.tanggal_mulai, detail_kerjasama.tanggal_akhir, detail_kerjasama.metode_pembayaran");
        $this->db->from("kerjasama");
        $this->db->join("company_profile", "kerjasama.user_id = company_profile.user_id");
        $this->db->join("detail_kerjasama", "detail_kerjasama.id_kerjasama = kerjasama.id");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_detail_kerjasama($id_kerjasama)
    {
        $this->db->select("id AS id_detail, id_kerjasama, judul_kegiatan, ruang_lingkup, deskripsi, lama_pekerjaan, metode_pembayaran, jumlah_termin, nilai_kontrak, status");
        $this->db->from("detail_kerjasama");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_kerjasamas_by_id($user_id)
    {
        $this->db->select("kerjasama.id AS id_kerjasama, detail_kerjasama.id AS id_detail, kerjasama.nomor, kategori.nama AS layanan, kerjasama.status, 
                            detail_kerjasama.tanggal_mulai, detail_kerjasama.tanggal_akhir, detail_kerjasama.nilai_kontrak");
        $this->db->from("kerjasama");
        $this->db->join("kategori", "kategori.id = kerjasama.id_kategori");
        $this->db->join("detail_kerjasama", "detail_kerjasama.id_kerjasama = kerjasama.id");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_rab_kerjasama($id_kerjasama)
    {
        $this->db->select("*");
        $this->db->from("rab_kerjasama");
        $this->db->join("rab", "rab.id = rab_kerjasama.id_rab");
        $this->db->where("rab_kerjasama.id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_pembayaran_kerjasama($id_kerjasama)
    {
        $this->db->select("id AS id_pembayaran, id_kerjasama, nominal, tujuan_rekening, tujuan_rekening, COALESCE(tanggal, '') AS tanggal, bukti_pembayaran, status");
        $this->db->from("pembayaran");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_status_detail_kerjasama($id_kerjasama)
    {
        $this->db->select("status");
        $this->db->from("detail_kerjasama");
        $this->db->where("detail_kerjasama.id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_status_rab_kerjasama($id_kerjasama)
    {
        $this->db->select("status");
        $this->db->from("rab_kerjasama");
        $this->db->where("rab_kerjasama.id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_status_draft_kerjasama($id_kerjasama)
    {
        $this->db->select("status");
        $this->db->from("draft_kerjasama");
        $this->db->where("draft_kerjasama.id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_kerjasama($data = [])
    {
        return $this->db->insert("kerjasama", $data);
    }

    public function insert_detail_kerjasama($data = [])
    {
        return $this->db->insert("detail_kerjasama", $data);
    }

    public function insert_rab_kerjasama($data = [])
    {
        return $this->db->insert("rab_kerjasama", $data);
    }

    public function insert_draft_kerjasama($data = [])
    {
        return $this->db->insert("draft_kerjasama", $data);
    }

    public function insert_pembayaran_kerjasama($data = [])
    {
        return $this->db->insert("pembayaran", $data);
    }

    public function update_detail_kerjasama($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("detail_kerjasama", $data);
    }

    public function update_pembayaran_kerjasama($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("pembayaran", $data);
    }

    public function update_status_detail_kerjasama($id, $data)
    {
        $this->db->where("id_kerjasama", $id);
        return $this->db->update("detail_kerjasama", $data);
    }

    public function update_status_rab_kerjasama($id, $data)
    {
        $this->db->where("id_kerjasama", $id);
        return $this->db->update("rab_kerjasama", $data);
    }

    public function update_status_kerjasama($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("kerjasama", $data);
    }

    public function update_status_draft_kerjasama($id, $data)
    {
        $this->db->where("id_kerjasama", $id);
        return $this->db->update("draft_kerjasama", $data);
    }

    public function hapus_pembayaran($id)
    {
        $this->db->where("id_kerjasama", $id);
        return $this->db->delete("pembayaran");
    }
}
