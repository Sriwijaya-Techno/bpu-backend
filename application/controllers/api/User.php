<?php

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/user_model", "api/menu_access_model"));
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
        $id_role = $this->security->xss_clean($this->post("id_role"));
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("password", "Password", "required");
        $this->form_validation->set_rules("tipe_akun", "Tipe_akun", "required");
        $this->form_validation->set_rules("id_role", "Id_role", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($username) && !empty($email) && !empty($password) && !empty($tipe_akun) && !empty($id_role)) {
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
                        "id_role" => $id_role
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

    public function index_put()
    {
        $id = $this->security->xss_clean($this->put("id"));
        $username = $this->security->xss_clean($this->put("username"));
        $email = $this->security->xss_clean($this->put("email"));
        $password = $this->security->xss_clean($this->put("password"));
        $tipe_akun = $this->security->xss_clean($this->put("tipe_akun"));
        $id_role = $this->security->xss_clean($this->put("id_role"));

        if (!empty($username) && !empty($email) && !empty($password) && !empty($tipe_akun) && !empty($id_role)) {
            $user_id = $this->user_model->get_user_by_id($id);
            $user_email = $this->user_model->get_user_by_email($email);
            if (count($user_email) > 0 && $user_id[0]->email != $user_email[0]->email) {
                return $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Email Sudah Teregistrasi',
                ], REST_Controller::HTTP_OK);
            } else {
                $user = array(
                    "username" => $username,
                    "email" => $email,
                    "password" => md5($password),
                    "tipe_akun" => $tipe_akun,
                    "id_role" => $id_role
                );

                if ($this->user_model->update_user_information($id, $user)) {
                    return $this->response([
                        'status' => "Success",
                        'message' => 'Data Berhasil Diupdate',
                    ], REST_Controller::HTTP_OK);
                } else {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_OK);
                }
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Diupdate',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->security->xss_clean($this->delete("id"));

        if (!empty($id)) {
            $user = array(
                "status_data" => 'dihapus'
            );
            if ($this->user_model->update_user_information($id, $user)) {
                return $this->response([
                    'status' => "Success",
                    'message' => 'Data Berhasil Dihapus',
                ], REST_Controller::HTTP_OK);
            } else {
                return $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Dihapus',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Semua Data Param Harus Diisi',
            ], REST_Controller::HTTP_BAD_REQUEST);
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

                    $menu_access = $this->menu_access_model->get_menu_Accesses_by_roles_level($data_user->id_role, 0);
                    $this->buildTreeView($data_user->id_role, $menu_access, 0);

                    $data['jwt-token'] = encode_jwt($payload);
                    $data['menu-access'] = $menu_access;
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

    public function buildTreeView($id_role, $data_menus, $parent, $level = 0, $prelevel = -1)
    {
        for ($i = 0; $i < count($data_menus); $i++) {
            if ($parent == $data_menus[$i]->id_parent) {
                $id =  $data_menus[$i]->id;

                if ($level > $prelevel) {
                    $prelevel = $level;
                }
                $level++;

                $new_data = $this->menu_access_model->get_menu_Accesses_by_roles_level_parent($id_role, $level, $id);
                if (count($new_data) > 0) {
                    $data_menus[$i]->child = $new_data;
                    $this->buildTreeView($id_role, $data_menus[$i]->child, $id, $level, $prelevel);
                    $level--;
                }
            }
        }
    }
}
