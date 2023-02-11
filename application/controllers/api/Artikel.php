<?php

require APPPATH . 'libraries/REST_Controller.php';

class Artikel extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/artikel_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $user_id = $this->security->xss_clean($this->post("user_id"));
        $judul = $this->security->xss_clean($this->post("judul"));
        $isi = $this->security->xss_clean($this->post("isi"));
        $slug = $this->security->xss_clean($this->post("slug"));
        $id_kategori = $this->security->xss_clean($this->post("id_kategori"));
        $tanggal = $this->security->xss_clean($this->post("tanggal"));

        if (!empty($user_id) && !empty($judul) && !empty($isi) && !empty($slug) && !empty($id_kategori) && !empty($tanggal)) {
            if (!empty($_FILES['cover']['name'])) {
                $files = $_FILES;
                $dir = realpath(APPPATH . '../assets/uploads');
                $filename = $dir . '\\artikel\\';

                if (!file_exists($filename)) {
                    mkdir($filename, 0775, true);
                }

                $_FILES['cover']['name'] = $files['cover']['name'];
                $_FILES['cover']['type'] = $files['cover']['type'];
                $_FILES['cover']['tmp_name'] = $files['cover']['tmp_name'];
                $_FILES['cover']['error'] = $files['cover']['error'];
                $_FILES['cover']['size'] = $files['cover']['size'];

                $config['upload_path']          = $filename;
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['max_size']             = 1024 * 10;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('cover')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data = array(
                        "status"    => "Gagal",
                        "pesan"     => $error,
                    );
                } else {
                    $upload_data = $this->upload->data();

                    $artikel = array(
                        "user_id" => $user_id,
                        "judul" => $judul,
                        "isi" => $isi,
                        "slug" => $slug,
                        "id_kategori" => $id_kategori,
                        "tanggal" => $tanggal,
                        "cover" => $upload_data['file_name'],
                    );

                    if ($this->artikel_model->insert_artikel($artikel)) {
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
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Gambar Cover Harus Diisi',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Semua Data Harus Diisi',
            ], REST_Controller::HTTP_OK);
        }
    }

    public function update_post()
    {
        $artikel_id = $this->security->xss_clean($this->post("artikel_id"));
        $user_id = $this->security->xss_clean($this->post("user_id"));
        $judul = $this->security->xss_clean($this->post("judul"));
        $isi = $this->security->xss_clean($this->post("isi"));
        $slug = $this->security->xss_clean($this->post("slug"));
        $id_kategori = $this->security->xss_clean($this->post("id_kategori"));
        $tanggal = $this->security->xss_clean($this->post("tanggal"));

        if (!empty($user_id) && !empty($artikel_id) && !empty($judul) && !empty($isi) && !empty($slug) && !empty($id_kategori) && !empty($tanggal)) {
            if (!empty($_FILES['cover']['name'])) {
                $files = $_FILES;
                $dir = realpath(APPPATH . '../assets/uploads');
                $filename = $dir . '\\artikel\\';

                if (!file_exists($filename)) {
                    mkdir($filename, 0775, true);
                }

                $_FILES['cover']['name'] = $files['cover']['name'];
                $_FILES['cover']['type'] = $files['cover']['type'];
                $_FILES['cover']['tmp_name'] = $files['cover']['tmp_name'];
                $_FILES['cover']['error'] = $files['cover']['error'];
                $_FILES['cover']['size'] = $files['cover']['size'];

                $config['upload_path']          = $filename;
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['max_size']             = 1024 * 10;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('cover')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data = array(
                        "status"    => "Gagal",
                        "pesan"     => $error,
                    );
                } else {
                    $upload_data = $this->upload->data();

                    $artikel = array(
                        "user_id" => $user_id,
                        "judul" => $judul,
                        "isi" => $isi,
                        "slug" => $slug,
                        "id_kategori" => $id_kategori,
                        "tanggal" => $tanggal,
                        "cover" => $upload_data['file_name'],
                    );

                    if ($this->artikel_model->update_artikel($artikel_id, $artikel)) {
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
                }
            } else {
                $artikel = array(
                    "user_id" => $user_id,
                    "judul" => $judul,
                    "isi" => $isi,
                    "slug" => $slug,
                    "id_kategori" => $id_kategori,
                    "tanggal" => $tanggal,
                );

                if ($this->artikel_model->update_artikel($artikel_id, $artikel)) {
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
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Semua Data Harus Diisi',
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_delete()
    {
        $id = $this->delete("id");
        $artikel = array(
            "status" => "dihapus"
        );

        if ($this->artikel_model->update_artikel($id, $artikel)) {
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
        $user_id = $this->security->xss_clean($this->get("user_id"));
        $artikel_id = $this->security->xss_clean($this->get("artikel_id"));
        $start = $this->security->xss_clean($this->get("start"));
        $limit = $this->security->xss_clean($this->get("limit"));
        $desc = $this->security->xss_clean($this->get("desc"));
        $id_kategori = $this->security->xss_clean($this->get("id_kategori"));

        $dir_logo =  base_url() . 'assets/uploads/artikel/';

        $artikels = $this->artikel_model->get_artikel($user_id, $artikel_id, $start, $limit, $desc, $id_kategori);
        for ($i = 0; $i < count($artikels); $i++) {
            $artikels[$i]->cover = $dir_logo  . $artikels[$i]->cover;
        }
        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $artikels,
        ], REST_Controller::HTTP_OK);
    }
}
