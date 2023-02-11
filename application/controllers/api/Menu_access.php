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
        $id_role = $this->security->xss_clean($this->post("id_role"));
        $menu = $this->security->xss_clean($this->post("menu"));
        $icon = $this->security->xss_clean($this->post("icon"));
        $url = $this->security->xss_clean($this->post("url"));
        $id_parent = $this->security->xss_clean($this->post("id_parent"));
        $level = $this->security->xss_clean($this->post("level"));
        $this->form_validation->set_rules("menu", "Menu", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_role) && !empty($menu) && !empty($icon) && !empty($url)) {
                $menu_access = array(
                    "id_role" => $id_role,
                    "menu" => $menu,
                    "icon" => $icon,
                    "url" => $url,
                    "id_parent" => $id_parent,
                    "level" => $level,
                );

                if ($this->menu_access_model->insert_menu_Access($menu_access)) {
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
    }

    public function index_put()
    {
        $id = $this->security->xss_clean($this->put("id_menu"));
        $id_role = $this->security->xss_clean($this->put("id_role"));
        $menu = $this->security->xss_clean($this->put("menu"));
        $icon = $this->security->xss_clean($this->put("icon"));
        $url = $this->security->xss_clean($this->put("url"));
        $id_parent = $this->security->xss_clean($this->put("id_parent"));
        $level = $this->security->xss_clean($this->put("level"));
        if (!empty($id) && !empty($id_role) && !empty($menu) && !empty($icon) && !empty($url)) {
            $menu_access = array(
                "id_role" => $id_role,
                "menu" => $menu,
                "icon" => $icon,
                "url" => $url,
                "id_parent" => $id_parent,
                "level" => $level,
            );

            if ($this->menu_access_model->update_menu_Access($id, $menu_access)) {
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
        $menu_access = $this->menu_access_model->get_menu_Accesses_by_roles_level($id_role, 0);
        $this->buildTreeView($menu_access, 0);

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $menu_access,
        ], REST_Controller::HTTP_OK);
    }

    public function buildTreeView($data_menus, $parent, $level = 0, $prelevel = -1)
    {
        for ($i = 0; $i < count($data_menus); $i++) {
            if ($parent == $data_menus[$i]->id_parent) {
                $id =  $data_menus[$i]->id;

                if ($level > $prelevel) {
                    $prelevel = $level;
                }
                $level++;

                $new_data = $this->menu_access_model->get_menu_Accesses_by_roles_level_parent(1, $level, $id);
                if (count($new_data) > 0) {
                    $data_menus[$i]->child = $new_data;
                    $this->buildTreeView($data_menus[$i]->child, $id, $level, $prelevel);
                    $level--;
                }
            }
        }
    }
}
