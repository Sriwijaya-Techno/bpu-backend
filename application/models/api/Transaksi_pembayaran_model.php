<?php

class Transaksi_pembayaran_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_transaksi_pembayaran()
    {
        $this->db->select("*");
        $this->db->from("transaksi_pembayaran");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_transaksi_pembayaran_by_id($id_customer)
    {
        $this->db->select("*");
        $this->db->from("transaksi_pembayaran");
        $this->db->where("id_customer", $id_customer);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_transaksi_pembayaran($data = [])
    {
        return $this->db->insert("transaksi_pembayaran", $data);
    }
}
