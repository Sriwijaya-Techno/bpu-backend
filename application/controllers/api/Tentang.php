<?php

require APPPATH . 'libraries/REST_Controller.php';

class Tentang extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/tentang_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $isi = $this->post("isi");
        $id_kategori = $this->post("id_kategori");

        if (!empty($isi) && !empty($id_kategori)) {
            $tentang = array(
                "isi" => $isi,
                "id_kategori" => $id_kategori,
            );

            if ($this->tentang_model->insert_tentang($tentang)) {
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
                'status' => "Error",
                'message' => 'Semua Data Param Harus Diisi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put("id");
        $isi = $this->put("isi");
        $id_kategori = $this->put("id_kategori");

        if (!empty($id) && !empty($isi) && !empty($id_kategori)) {
            $tentang = array(
                "isi" => $isi,
                "id_kategori" => $id_kategori
            );

            if ($this->tentang_model->update_tentang($id, $tentang)) {
                return $this->response([
                    'status' => "Sukses",
                    'message' => 'Data Berhasil Diupdate',
                ], REST_Controller::HTTP_OK);
            } else {
                return $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Semua Data Param Harus Diisi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete("id");
        $tentang = array(
            "status" => 'dihapus'
        );

        if ($this->tentang_model->update_tentang($id, $tentang)) {
            return $this->response([
                'status' => "Sukses",
                'message' => 'Data Berhasil Dihapus',
            ], REST_Controller::HTTP_OK);
        } else {
            return $this->response([
                'status' => "Gagal",
                'message' => 'Data Gagal Dihapus',
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_get()
    {
        $tentang = $this->tentang_model->get_tentangs();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $tentang,
        ], 200);
    }
}
