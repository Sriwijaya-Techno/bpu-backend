<?php

require APPPATH . 'libraries/REST_Controller.php';

class Layanan extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/layanan_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $nama = $this->security->xss_clean($this->post("nama"));
        $icon = $this->security->xss_clean($this->post("icon"));
        $this->form_validation->set_rules("nama", "Nama", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($nama)) {
                $layanan = array(
                    "nama" => $nama,
                    "icon" => $icon,
                    "slug" => slug($nama),
                );

                if ($this->layanan_model->insert_layanan($layanan)) {
                    return $this->response([
                        'status' => "Sukses",
                        'message' => 'Data Berhasil Ditambah',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $layanan = array(
                        "nama" => $nama,
                        "icon" => $icon,
                        "slug" => slug($nama) . "-" . rand(0, 99),
                    );

                    if ($this->layanan_model->insert_layanan($layanan)) {
                        return $this->response([
                            'status' => "Sukses",
                            'message' => 'Data Berhasil Ditambah',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        return $this->response([
                            'status' => "Error",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Gagal Ditambah',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $id = $this->security->xss_clean($this->put("id"));
        $nama = $this->security->xss_clean($this->put("nama"));
        $icon = $this->security->xss_clean($this->put("icon"));

        if (!empty($nama) && !empty($icon)) {
            $layanan = array(
                "nama" => $nama,
                "icon" => $icon,
                "slug" => slug($nama),
            );

            if ($this->layanan_model->update_layanan($id, $layanan)) {
                return $this->response([
                    'status' => "Sukses",
                    'message' => 'Data Berhasil Diupdate',
                ], REST_Controller::HTTP_OK);
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Semua Data Harus Diisi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete("id");

        if ($this->layanan_model->delete_layanan($id)) {
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
    }

    public function index_get()
    {
        $users = $this->layanan_model->get_layanans();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }
}
