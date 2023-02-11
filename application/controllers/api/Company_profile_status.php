<?php

require APPPATH . 'libraries/REST_Controller.php';

class Company_profile_status extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/company_profile_status_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $cp_nama = $this->security->xss_clean($this->post("cp_nama"));
        $this->form_validation->set_rules("cp_nama", "Cp_nama", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($cp_nama)) {
                $cp_status = array(
                    "cp_nama" => $cp_nama,
                );

                if ($this->company_profile_status_model->insert_company_profile_status($cp_status)) {
                    $this->response([
                        'status' => "Success",
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
        $users = $this->company_profile_status_model->get_company_profile_statuses();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }
}
