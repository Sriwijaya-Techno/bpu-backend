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
        $this->db->select("kerjasama.id AS id_kerjasama, item_kategori.id AS id_item_kategori, detail_kerjasama.id AS id_detail, company_profile.nama_perusahaan, item_kategori.judul AS item_kategori, detail_kerjasama.judul_kegiatan, 
                            kerjasama.status, detail_kerjasama.nilai_kontrak, detail_kerjasama.tanggal_mulai, detail_kerjasama.tanggal_akhir, detail_kerjasama.metode_pembayaran");
        $this->db->from("kerjasama");
        $this->db->join("company_profile", "kerjasama.user_id = company_profile.user_id");
        $this->db->join("item_kategori", "item_kategori.id = kerjasama.id_item_kategori");
        $this->db->join("detail_kerjasama", "detail_kerjasama.id_kerjasama = kerjasama.id");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_detail_kerjasama($id_kerjasama)
    {
        $this->db->select("id AS id_detail, id_kerjasama, judul_kegiatan, ruang_lingkup, deskripsi, detail_kerjasama.tanggal_mulai, detail_kerjasama.tanggal_akhir, lama_pekerjaan, metode_pembayaran, jumlah_termin, nilai_kontrak, status");
        $this->db->from("detail_kerjasama");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_kerjasamas_by_id($user_id)
    {
        $this->db->select("kerjasama.id AS id_kerjasama, item_kategori.id AS id_item_kategori, detail_kerjasama.id AS id_detail, kerjasama.nomor, item_kategori.judul AS item_kategori, detail_kerjasama.judul_kegiatan, kerjasama.status, 
                            detail_kerjasama.tanggal_mulai, detail_kerjasama.tanggal_akhir, detail_kerjasama.nilai_kontrak");
        $this->db->from("kerjasama");
        $this->db->join("item_kategori", "item_kategori.id = kerjasama.id_item_kategori");
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

    public function get_draft_kerjasama($id_kerjasama)
    {
        $this->db->select("*");
        $this->db->from("draft_kerjasama");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_pasal_draft($draft_id)
    {
        $this->db->select("*");
        $this->db->from("pasal");
        $this->db->where("draft_id", $draft_id);
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

    public function cek_pembayaran_kerjasama($id_kerjasama)
    {
        $this->db->select("sum(nominal) as total_bayar");
        $this->db->from("pembayaran");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $query = $this->db->get();

        if ($query->row()->total_bayar > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_total_bayar_kerjasama($id_kerjasama)
    {
        $this->db->select("sum(nominal) as total_bayar");
        $this->db->from("pembayaran");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $this->db->where("status", 'lunas');
        $query = $this->db->get();

        return $query->row();
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

    public function get_draft_cp_kerjasama($id_draft)
    {
        $this->db->select("draft_kerjasama.*, company_profile.*");
        $this->db->from("draft_kerjasama");
        $this->db->join("company_profile", "company_profile.id = draft_kerjasama.id_cp");
        $this->db->where("draft_kerjasama.id", $id_draft);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_company_profile_by_id_kerjasama($id_kerjasama)
    {
        $this->db->select("company_profile.*");
        $this->db->from("kerjasama");
        $this->db->join("company_profile", "company_profile.user_id = kerjasama.user_id");
        $this->db->where("kerjasama.id", $id_kerjasama);
        $query = $this->db->get();

        return $query->result();
    }

    public function cek_draft_kerjasama_by_id_kerjasama($id_kerjasama)
    {
        $this->db->select("count(*) AS jumlah_data");
        $this->db->from("draft_kerjasama");
        $this->db->where("id_kerjasama", $id_kerjasama);
        $query = $this->db->get();
        $jumlah_data = $query->row();

        if ($jumlah_data->jumlah_data > 0) {
            return true;
        } else {
            return false;
        }
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

    public function update_rab_kerjasama($id_kerjasama, $id_rab, $data = [])
    {
        $this->db->where("id_kerjasama", $id_kerjasama);
        $this->db->where("id_rab", $id_rab);
        return $this->db->update("rab_kerjasama", $data);
    }

    public function delete_rab_kerjasama($id_kerjasama, $id_rab)
    {
        $this->db->where("id_kerjasama", $id_kerjasama);
        $this->db->where("id_rab", $id_rab);
        return $this->db->delete("rab_kerjasama");
    }

    public function insert_draft_kerjasama($data = [])
    {
        return $this->db->insert("draft_kerjasama", $data);
    }

    public function update_draft_kerjasama($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("draft_kerjasama", $data);
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

    public function update_file_draft_kerjasama($id, $data)
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
