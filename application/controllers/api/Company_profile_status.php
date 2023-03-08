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
        $cps_nama = $this->security->xss_clean($this->post("cps_nama"));
        $this->form_validation->set_rules("cps_nama", "Cps_nama", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($cps_nama)) {
                $cp_status = array(
                    "cps_nama" => $cps_nama,
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

    public function index_put()
    {
        $id = $this->security->xss_clean($this->put("id"));
        $cps_nama = $this->security->xss_clean($this->put("cps_nama"));

        if (!empty($id) && !empty($cps_nama)) {
            $cp_status = array(
                "cps_nama" => $cps_nama,
            );

            if ($this->company_profile_status_model->update_company_profile_status($id, $cp_status)) {
                $this->response([
                    'status' => "Success",
                    'message' => 'Data Berhasil Diupdate',
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Diupdate',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->security->xss_clean($this->delete("id"));

        if (!empty($id)) {
            $cp_status = array(
                "status" => "dihapus",
            );

            if ($this->company_profile_status_model->update_company_profile_status($id, $cp_status)) {
                $this->response([
                    'status' => "Success",
                    'message' => 'Data Berhasil Dihapus',
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Dihapus',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Dihapus',
            ], REST_Controller::HTTP_BAD_REQUEST);
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
