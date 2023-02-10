<?php

require APPPATH . 'libraries/REST_Controller.php';

class Menu_access extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/menu_access_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $menu = $this->security->xss_clean($this->post("menu"));
        $this->form_validation->set_rules("menu", "Menu", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($menu)) {
                $menu_access = array(
                    "menu" => $menu
                );

                if ($this->menu_access_model->insert_menu_Access($menu_access)) {
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
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Semua Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $id = $this->security->xss_clean($this->put("id_menu"));
        $menu = $this->security->xss_clean($this->put("menu"));

        if (!empty($id) && !empty($menu)) {
            $menu_access = array(
                "id" => $id,
                "menu" => $menu
            );

            if ($this->menu_access_model->update_menu_Access($id, $menu_access)) {
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
                'message' => 'Semua Data Harus Diisi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete("id_menu");
        $menu_access = array(
            "status" => 'dihapus'
        );

        if ($this->menu_access_model->update_menu_Access($id, $menu_access)) {
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
        $menu_access = $this->menu_access_model->get_menu_Accesses();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $menu_access,
        ], 200);
    }
}
