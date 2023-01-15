<?php

require APPPATH . 'libraries/REST_Controller.php';

class Lembaga_status extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/lembaga_status_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $ls_nama = $this->security->xss_clean($this->post("ls_nama"));
        $this->form_validation->set_rules("ls_nama", "Ls_nama", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($ls_nama)) {
                $lembaga_status = array(
                    "ls_nama" => $ls_nama,
                );

                if ($this->lembaga_status_model->insert_kategori($lembaga_status)) {
                    $this->response([
                        'status' => "Sukses",
                        'message' => 'Data Berhasil Ditambah',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Ditambah',
                    ], REST_Controller::HTTP_OK);
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
