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
        $fasilitas = $this->security->xss_clean($this->post("fasilitas"));
        $ketentuan = $this->security->xss_clean($this->post("ketentuan"));
        $this->form_validation->set_rules("id_kategori", "Id_kategori", "required");
        $this->form_validation->set_rules("judul", "Judul", "required");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_kategori) && !empty($judul) && !empty($deskripsi)) {
                if ($this->item_kategori_model->cek_slug_item_kategori(slug($judul))) {
                    $item_kategori = array(
                        "id_kategori" => $id_kategori,
                        "judul" => $judul,
                        "deskripsi" => $deskripsi,
                        "slug" => slug($judul) . "-" . rand(0, 99),
                    );
                } else {
                    $item_kategori = array(
                        "id_kategori" => $id_kategori,
                        "judul" => $judul,
                        "deskripsi" => $deskripsi,
                        "slug" => slug($judul),
                    );
                }

                if (!empty($fasilitas)) {
                    $item_kategori['fasilitas'] = $fasilitas;
                }

                if (!empty($ketentuan)) {
                    $item_kategori['ketentuan'] = $ketentuan;
                }

                if ($this->item_kategori_model->insert_item_kategori($item_kategori)) {
                    $id_item_kategori = $this->db->insert_id();
                    $filenames = [];
                    $files = $_FILES;

                    $cpt = count($_FILES['gambar']['name']);
                    if (!empty($_FILES['gambar']['name'][0])) {
                        $dir = realpath(APPPATH . '../assets/uploads');
                        $filename = $dir . '\\item_kategori\\';

                        if (!file_exists($filename)) {
                            mkdir($filename, 0775, true);
                        }

                        for ($i = 0; $i < $cpt; $i++) {
                            $_FILES['gambar']['name'] = $files['gambar']['name'][$i];
                            $_FILES['gambar']['type'] = $files['gambar']['type'][$i];
                            $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$i];
                            $_FILES['gambar']['error'] = $files['gambar']['error'][$i];
                            $_FILES['gambar']['size'] = $files['gambar']['size'][$i];

                            $config['upload_path']          = $filename;
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
                    } else {
                        return $this->response([
                            'status' => "Gagal",
                            'message' => 'Data Gambar TIdak Boleh Kosong',
                        ], REST_Controller::HTTP_OK);
                    }

                    for ($i = 0; $i < count($filenames); $i++) {
                        $data_img_item_kategori = array(
                            "id_item_kategori" => $id_item_kategori,
                            "gambar" => $filenames[$i],
                        );

                        if (!$this->item_kategori_model->insert_img_item_kategori($data_img_item_kategori)) {
                            return $this->response([
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
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Ditambah',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                return $this->response([
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
        $fasilitas = $this->security->xss_clean($this->post("fasilitas"));
        $ketentuan = $this->security->xss_clean($this->post("ketentuan"));
        $this->form_validation->set_rules("id_item_kategori", "Id_item_kategori", "required");
        $this->form_validation->set_rules("judul", "Judul", "required");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Gagal",
                'message' => 'Data Gagal Diverifikasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_item_kategori) && !empty($judul) && !empty($deskripsi)) {
                if ($this->item_kategori_model->cek_slug_item_kategori(slug($judul))) {
                    $item_kategori = array(
                        "judul" => $judul,
                        "deskripsi" => $deskripsi,
                        "slug" => slug($judul) . "-" . rand(0, 99),
                    );
                } else {
                    $item_kategori = array(
                        "judul" => $judul,
                        "deskripsi" => $deskripsi,
                        "slug" => slug($judul),
                    );
                }

                if (!empty($fasilitas)) {
                    $item_kategori['fasilitas'] = $fasilitas;
                }

                if (!empty($ketentuan)) {
                    $item_kategori['ketentuan'] = $ketentuan;
                }

                if ($this->item_kategori_model->update_item_kategori($id_item_kategori, $item_kategori)) {
                    $img_item = $this->item_kategori_model->get_imgs_item_kategori($id_item_kategori);

                    for ($i = 0; $i < count($img_item); $i++) {
                        $this->item_kategori_model->delete_imgs_item_kategori($img_item[$i]->id_item_kategori);
                    }

                    $files = $_FILES;
                    $cpt = count($_FILES['gambar']['name']);
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '\\item_kategori\\';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }
                    $filenames = [];

                    if (!empty($_FILES['gambar']['name'][0])) {
                        for ($i = 0; $i < $cpt; $i++) {
                            $_FILES['gambar']['name'] = $files['gambar']['name'][$i];
                            $_FILES['gambar']['type'] = $files['gambar']['type'][$i];
                            $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$i];
                            $_FILES['gambar']['error'] = $files['gambar']['error'][$i];
                            $_FILES['gambar']['size'] = $files['gambar']['size'][$i];

                            $config['upload_path']          = $filename;
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
                                return $this->response([
                                    'status' => "Gagal",
                                    'message' => 'Data Gagal Diupdate',
                                ], REST_Controller::HTTP_OK);
                            }
                        }
                    }

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
                    'message' => 'Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_delete()
    {
        $id = $this->delete("id");

        if ($this->item_kategori_model->delete_imgs_item_kategori($id)) {
            if ($this->item_kategori_model->delete_item_kategori($id)) {
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
        } else {
            $this->response([
                'status' => "Gagal",
                'message' => 'Data Gagal Dihapus',
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_get()
    {
        $slug_kategori = $this->security->xss_clean($this->get("slug_kategori"));
        $id_kategori = $this->security->xss_clean($this->get("id_kategori"));
        $slug_layanan = $this->security->xss_clean($this->get("slug_layanan"));
        $id_layanan = $this->security->xss_clean($this->get("id_layanan"));
        $id_item_kategori = $this->security->xss_clean($this->get("id_item_kategori"));

        $data = [
            'slug_kategori' => $slug_kategori ?? '',
            'id_kategori' => $id_kategori ?? '',
            'slug_layanan' => $slug_layanan ?? '',
            'id_layanan' => $id_layanan ?? '',
            'id_item_kategori' => $id_item_kategori ?? '',
        ];
        $items_kategori = $this->item_kategori_model->get_items_kategori($data);
        $dir_item_kategori =  realpath(APPPATH . '../assets/uploads/item_kategori');

        for ($i = 0; $i < count($items_kategori); $i++) {
            $img_item = $this->item_kategori_model->get_imgs_item_kategori($items_kategori[$i]->id);

            for ($j = 0; $j < count($img_item); $j++) {
                $img_item[$j]->gambar_url = base_url() . 'assets/uploads/item_kategori/' . $img_item[$j]->gambar;
                $img_item[$j]->gambar = $dir_item_kategori . '\\' . $img_item[$j]->gambar;
            }

            $items_kategori[$i]->gambar = $img_item;
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $items_kategori,
        ], 200);
    }

    public function get_all_get()
    {
        $items_kategori = $this->item_kategori_model->get_all_items_kategori();

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
