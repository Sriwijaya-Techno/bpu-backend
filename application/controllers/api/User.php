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

    public function index_get()
    {
        $users = $this->user_model->get_users();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }

    public function by_email_get()
    {
        $email = $this->security->xss_clean($this->get("email"));
        $users = $this->user_model->get_user_by_email($email);

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }

    public function register_post()
    {
        $username = $this->security->xss_clean($this->post("username"));
        $email = $this->security->xss_clean($this->post("email"));
        $password = $this->security->xss_clean($this->post("password"));
        $tipe_akun = $this->security->xss_clean($this->post("tipe_akun"));
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("password", "Password", "required");
        $this->form_validation->set_rules("tipe_akun", "Tipe_akun", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($username) && !empty($email) && !empty($password) && !empty($tipe_akun)) {
                $user_email = $this->user_model->get_user_by_email($email);
                if (count($user_email) > 0) {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Email Sudah Teregistrasi',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $user = array(
                        "username" => $username,
                        "email" => $email,
                        "password" => md5($password),
                        "tipe_akun" => $tipe_akun,
                    );

                    if ($this->user_model->insert_user($user)) {
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
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Gagal Ditambah',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function login_post()
    {
        $email = $this->security->xss_clean($this->post("email"));
        $password = $this->security->xss_clean($this->post("password"));
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("password", "Password", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($email) && !empty($password)) {
                $login_user = $this->user_model->login($email, md5($password));
                if (count($login_user) > 0) {
                    $data_user = $this->user_model->get_user_by_email_password($email, md5($password));
                    $payload['user_id'] = $data_user->id;
                    $payload['username'] = $data_user->username;
                    $payload['email'] = $data_user->email;
                    $payload['tipe_akun'] = $data_user->tipe_akun;
                    // $payload['exp'] = time() + (60 * 60); expire time : 1 jam

                    $data['jwt-token'] = encode_jwt($payload);
                    $this->response([
                        'status' => "Success",
                        'message' => 'Berhasil Login',
                        "data" => $data,
                    ], REST_Controller::HTTP_OK);
                } else {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Login',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
