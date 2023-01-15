<?php

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/user_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    // GET: <project_url>/index.php/user
    public function index_get()
    {
        $users = $this->user_model->get_users();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }
}
