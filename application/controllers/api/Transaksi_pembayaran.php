<?php

require APPPATH . 'libraries/REST_Controller.php';

class Transaksi_pembayaran extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/transaksi_pembayaran_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper(array("security", "konversi_helper"));
    }

    public function index_post()
    {
        $id_customer = $this->security->xss_clean($this->post("id_customer"));
        $id_item_kategori = $this->security->xss_clean($this->post("id_item_kategori"));
        $awal = $this->security->xss_clean($this->post("awal"));
        $akhir = $this->security->xss_clean($this->post("akhir"));
        $satuan = $this->security->xss_clean($this->post("satuan"));
        $quantity = $this->security->xss_clean($this->post("quantity"));
        $harga = $this->security->xss_clean($this->post("harga"));
        $kontrak = $this->security->xss_clean($this->post("kontrak"));

        if (
            !empty($id_customer) && !empty($id_item_kategori) && !empty($awal) && !empty($satuan) &&
            !empty($quantity) && !empty($harga) && !empty($kontrak)
        ) {
            $transaksi = array(
                "id_item_kategori" => $id_item_kategori,
                "id_customer" => $id_customer,
                "awal" => $awal,
                "akhir" => $akhir,
                "satuan" => $satuan,
                "quantity" => $quantity,
                "harga" => $harga,
                "kontrak" => $kontrak,
                "kode_bayar" => generateRandomString(),
            );

            if ($this->transaksi_pembayaran_model->insert_transaksi_pembayaran($transaksi)) {
                return $this->response([
                    'status' => "Sukses",
                    'message' => 'Data Berhasil Ditambah',
                ], REST_Controller::HTTP_OK);
            } else {
                return $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Ditambah',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            return $this->response([
                'status' => "Gagal",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_get()
    {
        $users = $this->transaksi_pembayaran_model->get_transaksi_pembayaran();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }

    public function user_get()
    {
        $id_customer = $this->security->xss_clean($this->get("id_customer"));
        $users = $this->transaksi_pembayaran_model->get_transaksi_pembayaran_by_id($id_customer);

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }
}
