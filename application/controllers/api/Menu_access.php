<?php

require APPPATH . 'libraries/REST_Controller.php';

class Menu_access extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/menu_access_model", "api/menu_role_access_model", "api/role_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $id_role = $this->security->xss_clean($this->post("id_role"));
        $menu = $this->security->xss_clean($this->post("menu"));
        $icon = $this->security->xss_clean($this->post("icon"));
        $url = $this->security->xss_clean($this->post("url"));
        $id_parent = $this->security->xss_clean($this->post("id_parent"));
        $level = $this->security->xss_clean($this->post("level"));
        $id_roles = json_decode($id_role);

        if (!empty($menu) && !empty($url) && count($id_roles) > 0) {
            if (empty($icon)) {
                $icon = '';
            }
            $menu_access = array(
                "menu" => $menu,
                "icon" => $icon,
                "url" => $url,
                "id_parent" => $id_parent,
                "level" => $level,
            );

            if ($this->menu_access_model->insert_menu_access($menu_access)) {
                $id_menu = $this->db->insert_id();

                for ($i = 0; $i < count($id_roles); $i++) {
                    $menu_role_access = array(
                        "id_menu" => $id_menu,
                        "id_role" => $id_roles[$i],
                    );

                    if (!$this->menu_role_access_model->insert_menu_role_access($menu_role_access)) {
                        return $this->response([
                            'status' => "Error",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_OK);
                    }
                }

                return $this->response([
                    'status' => "Success",
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

    public function index_put()
    {
        $id_menu = $this->security->xss_clean($this->put("id_menu"));
        $id_role = $this->security->xss_clean($this->put("id_role"));
        $menu = $this->security->xss_clean($this->put("menu"));
        $icon = $this->security->xss_clean($this->put("icon"));
        $url = $this->security->xss_clean($this->put("url"));
        $id_parent = $this->security->xss_clean($this->put("id_parent"));
        $level = $this->security->xss_clean($this->put("level"));
        $id_roles = json_decode($id_role);
        if (!empty($id_menu) && !empty($menu) && !empty($url) && count($id_roles) > 0) {
            if (empty($icon)) {
                $icon = '';
            }
            $menu_access = array(
                "menu" => $menu,
                "icon" => $icon,
                "url" => $url,
                "id_parent" => $id_parent,
                "level" => $level,
            );

            if ($this->menu_access_model->update_menu_access($id_menu, $menu_access)) {
                $menu_roles = $this->menu_role_access_model->get_menu_role_accesses_by_id_menu($id_menu);

                for ($i = 0; $i < count($id_roles); $i++) {
                    $is_role_menu_exist = false;
                    for ($j = 0; $j < count($menu_roles); $j++) {
                        if ($id_roles[$i] == $menu_roles[$j]->id_role) {
                            $is_role_menu_exist = true;
                        }
                    }

                    if (!$is_role_menu_exist) {
                        $menu_role_access = array(
                            "id_menu" => $id_menu,
                            "id_role" => $id_roles[$i],
                        );

                        if (!$this->menu_role_access_model->insert_menu_role_access($menu_role_access)) {
                            return $this->response([
                                'status' => "Error",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }

                for ($i = 0; $i < count($menu_roles); $i++) {
                    $is_role_menu_exist = false;
                    for ($j = 0; $j < count($id_roles); $j++) {
                        if ($menu_roles[$i]->id_role == $id_roles[$j]) {
                            $is_role_menu_exist = true;
                        }
                    }

                    if (!$is_role_menu_exist) {
                        if (!$this->menu_role_access_model->delete_menu_role_access($id_menu, $menu_roles[$i]->id_role)) {
                            return $this->response([
                                'status' => "Error",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }

                return $this->response([
                    'status' => "Success",
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
        $id = $this->delete("id_menu");
        $menu_access = array(
            "status" => 'dihapus'
        );

        if ($this->menu_access_model->update_menu_access($id, $menu_access)) {
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
    }

    public function index_get()
    {
        $id_role = $this->get("id_role");
        $menu_access_list = [];
        if (empty($id_role)) {
            $id_roles = $this->role_model->get_roles();
            for ($i = 0; $i < count($id_roles); $i++) {
                $role = $this->role_model->get_role_by_id($id_roles[$i]->id);
                $menu_access = $this->menu_access_model->get_menu_Accesses_by_roles_level($id_roles[$i]->id, 0);
                $this->buildTreeView($id_roles[$i]->id, $menu_access, 0);

                $data_menu_access = array(
                    'id_roles' => $id_roles[$i]->id,
                    'role' => $role->nama,
                    'menu_access' => $menu_access
                );

                array_push($menu_access_list, $data_menu_access);
            }

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $menu_access_list,
            ], REST_Controller::HTTP_OK);
        } else {
            $role = $this->role_model->get_role_by_id($id_role);
            $menu_access = $this->menu_access_model->get_menu_Accesses_by_roles_level($id_role, 0);
            $this->buildTreeView($id_role, $menu_access, 0);

            $data_menu_access = array(
                'id_roles' => $id_role,
                'role' => $role->nama,
                'menu_access' => $menu_access
            );
            array_push($menu_access_list, $data_menu_access);

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $menu_access_list,
            ], REST_Controller::HTTP_OK);
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
                } else {
                    $level--;
                }
            }
        }
    }
}
