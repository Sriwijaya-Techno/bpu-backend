<?php

require APPPATH . 'libraries/REST_Controller.php';

class Kategori extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/kategori_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $id = $this->security->xss_clean($this->post("id"));
        $nama = $this->security->xss_clean($this->post("nama"));
        $icon = $this->security->xss_clean($this->post("icon"));
        $this->form_validation->set_rules("nama", "Nama", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($nama)) {
                $kategori = array(
                    "id_layanan" => $id,
                    "nama" => $nama,
                    "icon" => $icon,
                    "slug" => slug($nama),
                );

                if ($this->kategori_model->insert_kategori($kategori)) {
                    $this->response([
                        'status' => "Sukses",
                        'message' => 'Data Berhasil Ditambah',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $kategori = array(
                        "id_layanan" => $id,
                        "nama" => $nama,
                        "icon" => $icon,
                        "slug" => slug($nama) . "-" . rand(0, 99),
                    );

                    if ($this->kategori_model->insert_kategori($kategori)) {
                        $this->response([
                            'status' => "Sukses",
                            'message' => 'Data Berhasil Ditambah',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => "Error",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Gagal Ditambah',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_get()
    {
        $users = $this->kategori_model->get_kategoris();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }
}
