<?php

require APPPATH . 'libraries/REST_Controller.php';

class User_access extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/user_access_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $user_data = json_decode(file_get_contents('php://input'), true);
        $id_user = $user_data["id_user"];
        $user_menu = $user_data["menu_access"];

        $user_access_db = $this->user_access_model->get_user_accesses($id_user);
        //Hapus User Access
        for ($i = 0; $i < count($user_access_db); $i++) {
            $is_user_access_exist = false;
            for ($j = 0; $j < count($user_menu); $j++) {
                if ($user_access_db[$i]->id_menu == $user_menu[$j]) {
                    $is_user_access_exist = true;
                }
            }

            if (!$is_user_access_exist) {
                $user_access = array(
                    "status" => "dihapus"
                );

                if (!$this->user_access_model->update_user_access($user_access_db[$i]->id, $user_access)) {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        //Tambah User Access
        for ($i = 0; $i < count($user_menu); $i++) {
            $is_user_access_exist = false;
            for ($j = 0; $j < count($user_access_db); $j++) {
                if ($user_menu[$i] == $user_access_db[$j]->id_menu) {
                    $is_user_access_exist = true;
                }
            }

            if (!$is_user_access_exist) {
                $user_access = array(
                    "id_user" => $id_user,
                    "id_menu" => $user_menu[$i],
                );

                if (!$this->user_access_model->insert_user_access($user_access)) {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        return $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Ditambah',
        ], REST_Controller::HTTP_OK);
    }

    public function index_get()
    {
        $id_user = $this->security->xss_clean($this->get("id_user"));
        if (empty($id_user)) {
            return $this->response([
                'status' => "Error",
                'message' => 'Semua Data Param Harus Diisi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $user_access = $this->user_access_model->get_user_accesses($id_user);

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $user_access,
        ], 200);
    }
}
