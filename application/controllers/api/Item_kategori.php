<?php

require APPPATH . 'libraries/REST_Controller.php';

class Item_kategori extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/item_kategori_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $id_kategori = $this->security->xss_clean($this->post("id_kategori"));
        $judul = $this->security->xss_clean($this->post("judul"));
        $deskripsi = $this->security->xss_clean($this->post("deskripsi"));
        $this->form_validation->set_rules("id_kategori", "Id_kategori", "required");
        $this->form_validation->set_rules("judul", "Judul", "required");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_kategori) && !empty($judul) && !empty($deskripsi)) {
                $item_kategori = array(
                    "id_kategori" => $id_kategori,
                    "judul" => $judul,
                    "deskripsi" => $deskripsi,
                );

                if ($this->item_kategori_model->insert_item_kategori($item_kategori)) {
                    $id_item_kategori = $this->db->insert_id();
                    $files = $_FILES;
                    $cpt = count($_FILES['gambar']['name']);
                    $dir = realpath(APPPATH . '../assets/uploads/item_kategori');
                    $filenames = [];
                    for ($i = 0; $i < $cpt; $i++) {
                        $_FILES['gambar']['name'] = $files['gambar']['name'][$i];
                        $_FILES['gambar']['type'] = $files['gambar']['type'][$i];
                        $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$i];
                        $_FILES['gambar']['error'] = $files['gambar']['error'][$i];
                        $_FILES['gambar']['size'] = $files['gambar']['size'][$i];

                        $config['upload_path']          = $dir;
                        $config['allowed_types']        = 'gif|jpg|jpeg|png';
                        $config['max_size']             = 1024 * 10;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('gambar')) {
                            $error = array('error' => $this->upload->display_errors());
                            $data = array(
                                "status"    => "Gagal",
                                "pesan"     => $error,
                            );
                        } else {
                            $upload_data = $this->upload->data();
                            array_push($filenames, $upload_data['file_name']);
                        }
                    }

                    for ($i = 0; $i < count($filenames); $i++) {
                        $data_img_item_kategori = array(
                            "id_item_kategori" => $id_item_kategori,
                            "gambar" => $filenames[$i],
                        );

                        if (!$this->item_kategori_model->insert_img_item_kategori($data_img_item_kategori)) {
                            $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_OK);
                        }
                    }

                    $this->response([
                        'status' => "Sukses",
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

    public function update_post()
    {
        $id_item_kategori = $this->security->xss_clean($this->post("id_item_kategori"));
        $judul = $this->security->xss_clean($this->post("judul"));
        $deskripsi = $this->security->xss_clean($this->post("deskripsi"));
        $this->form_validation->set_rules("id_item_kategori", "Id_item_kategori", "required");
        $this->form_validation->set_rules("judul", "Judul", "required");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Gagal",
                'message' => 'Data Gagal Diverifikasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_item_kategori) && !empty($judul) && !empty($deskripsi)) {
                $item_kategori = array(
                    "judul" => $judul,
                    "deskripsi" => $deskripsi,
                );

                if ($this->item_kategori_model->update_item_kategori($id_item_kategori, $item_kategori)) {
                    $img_item = $this->item_kategori_model->get_imgs_item_kategori($id_item_kategori);

                    for ($i = 0; $i < count($img_item); $i++) {
                        $this->item_kategori_model->delete_imgs_item_kategori($img_item[$i]->id_item_kategori);
                    }

                    $files = $_FILES;
                    $cpt = count($_FILES['gambar']['name']);
                    $dir = realpath(APPPATH . '../assets/uploads/item_kategori');
                    $filenames = [];
                    for ($i = 0; $i < $cpt; $i++) {
                        $_FILES['gambar']['name'] = $files['gambar']['name'][$i];
                        $_FILES['gambar']['type'] = $files['gambar']['type'][$i];
                        $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$i];
                        $_FILES['gambar']['error'] = $files['gambar']['error'][$i];
                        $_FILES['gambar']['size'] = $files['gambar']['size'][$i];

                        $config['upload_path']          = $dir;
                        $config['allowed_types']        = 'gif|jpg|jpeg|png';
                        $config['max_size']             = 1024 * 10;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('gambar')) {
                            $error = array('error' => $this->upload->display_errors());
                            $data = array(
                                "status"    => "Gagal",
                                "pesan"     => $error,
                            );
                        } else {
                            $upload_data = $this->upload->data();
                            array_push($filenames, $upload_data['file_name']);
                        }
                    }

                    for ($i = 0; $i < count($filenames); $i++) {
                        $data_img_item_kategori = array(
                            "id_item_kategori" => $id_item_kategori,
                            "gambar" => $filenames[$i],
                        );

                        if (!$this->item_kategori_model->insert_img_item_kategori($data_img_item_kategori)) {
                            $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }
                    }

                    $this->response([
                        'status' => "Sukses",
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
                    'message' => 'Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_get()
    {
        $id_kategori = $this->security->xss_clean($this->get("id_kategori"));
        $items_kategori = $this->item_kategori_model->get_items_kategori($id_kategori);

        for ($i = 0; $i < count($items_kategori); $i++) {
            $img_item = $this->item_kategori_model->get_imgs_item_kategori($items_kategori[$i]->id);

            $items_kategori[$i]->gambar = $img_item;
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $items_kategori,
        ], 200);
    }
}
