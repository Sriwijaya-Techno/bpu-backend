<?php

require APPPATH . 'libraries/REST_Controller.php';

class Home extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/home_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function header_post()
    {
        $title_logo = $this->security->xss_clean($this->post("title_logo"));
        $sub_title_logo = $this->security->xss_clean($this->post("sub_title_logo"));
        $lokasi = $this->security->xss_clean($this->post("lokasi"));
        $kontak = $this->security->xss_clean($this->post("kontak"));
        $this->form_validation->set_rules("title_logo", "Title_logo", "required");
        $this->form_validation->set_rules("sub_title_logo", "Sub_title_logo", "required");
        $this->form_validation->set_rules("lokasi", "Lokasi", "required");
        $this->form_validation->set_rules("kontak", "Kontak", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($title_logo) && !empty($sub_title_logo) && !empty($lokasi) && !empty($kontak)) {
                if (!empty($_FILES['logo_header_home']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '\\logo_header_home\\';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $_FILES['logo_header_home']['name'] = $files['logo_header_home']['name'];
                    $_FILES['logo_header_home']['type'] = $files['logo_header_home']['type'];
                    $_FILES['logo_header_home']['tmp_name'] = $files['logo_header_home']['tmp_name'];
                    $_FILES['logo_header_home']['error'] = $files['logo_header_home']['error'];
                    $_FILES['logo_header_home']['size'] = $files['logo_header_home']['size'];

                    $config['upload_path']          = $filename;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('logo_header_home')) {
                        $error = array('error' => $this->upload->display_errors());
                        return $this->response([
                            'status' => "Error",
                            'message' => $error,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $upload_data = $this->upload->data();

                        if ($this->home_model->cek_header_home()) {
                            $get_home = $this->home_model->get_header_home();
                            $header = array(
                                "logo" => $upload_data['file_name'],
                                "title_logo" => $title_logo,
                                "sub_title_logo" => $sub_title_logo,
                                "lokasi" => $lokasi,
                                "kontak" => $kontak,
                            );

                            if ($this->home_model->update_header_home($get_home->id, $header)) {
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
                            $header = array(
                                "logo" => $upload_data['file_name'],
                                "title_logo" => $title_logo,
                                "sub_title_logo" => $sub_title_logo,
                                "lokasi" => $lokasi,
                                "kontak" => $kontak,
                            );

                            if ($this->home_model->insert_header_home($header)) {
                                return $this->response([
                                    'status' => "Sukses",
                                    'message' => 'Data Berhasil Ditambah',
                                ], REST_Controller::HTTP_OK);
                            } else {
                                return $this->response([
                                    'status' => "Gagal",
                                    'message' => 'Data Gagal Ditambah',
                                ], REST_Controller::HTTP_OK);
                            }
                        }
                    }
                } else {
                    if ($this->home_model->cek_header_home()) {
                        $get_home = $this->home_model->get_header_home();
                        $header = array(
                            "title_logo" => $title_logo,
                            "sub_title_logo" => $sub_title_logo,
                            "lokasi" => $lokasi,
                            "kontak" => $kontak,
                        );

                        if ($this->home_model->update_header_home($get_home->id, $header)) {
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
                        $header = array(
                            "title_logo" => $title_logo,
                            "sub_title_logo" => $sub_title_logo,
                            "lokasi" => $lokasi,
                            "kontak" => $kontak,
                        );

                        if ($this->home_model->insert_header_home($header)) {
                            return $this->response([
                                'status' => "Sukses",
                                'message' => 'Data Berhasil Ditambah',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return  $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function tentang_post()
    {
        $isi = $this->security->xss_clean($this->post("isi"));
        $this->form_validation->set_rules("isi", "Isi", "required");

        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($isi)) {
                if (!empty($_FILES['gambar_tentang']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '\\gambar_tentang\\';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $_FILES['gambar_tentang']['name'] = $files['gambar_tentang']['name'];
                    $_FILES['gambar_tentang']['type'] = $files['gambar_tentang']['type'];
                    $_FILES['gambar_tentang']['tmp_name'] = $files['gambar_tentang']['tmp_name'];
                    $_FILES['gambar_tentang']['error'] = $files['gambar_tentang']['error'];
                    $_FILES['gambar_tentang']['size'] = $files['gambar_tentang']['size'];

                    $config['upload_path']          = $filename;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('gambar_tentang')) {
                        $error = array('error' => $this->upload->display_errors());
                        return $this->response([
                            'status' => "Error",
                            'message' => $error,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $upload_data = $this->upload->data();

                        if ($this->home_model->cek_tentang_home()) {
                            $get_home = $this->home_model->get_tentang_home();
                            $tentang = array(
                                "isi" => $isi,
                                "gambar" => $upload_data['file_name'],
                            );

                            if ($this->home_model->update_tentang_home($get_home->id, $tentang)) {
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
                            $tentang = array(
                                "isi" => $isi,
                                "gambar" => $upload_data['file_name'],
                            );

                            if ($this->home_model->insert_tentang_home($tentang)) {
                                return $this->response([
                                    'status' => "Sukses",
                                    'message' => 'Data Berhasil Ditambah',
                                ], REST_Controller::HTTP_OK);
                            } else {
                                return $this->response([
                                    'status' => "Gagal",
                                    'message' => 'Data Gagal Ditambah',
                                ], REST_Controller::HTTP_OK);
                            }
                        }
                    }
                } else {
                    if ($this->home_model->cek_tentang_home()) {
                        $get_home = $this->home_model->get_tentang_home();
                        $tentang = array(
                            "isi" => $isi,
                        );

                        if ($this->home_model->update_tentang_home($get_home->id, $tentang)) {
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
                        $tentang = array(
                            "isi" => $isi,
                        );

                        if ($this->home_model->insert_tentang_home($tentang)) {
                            return $this->response([
                                'status' => "Sukses",
                                'message' => 'Data Berhasil Ditambah',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return  $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Semua Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function testimoni_post()
    {
        $isi = $this->security->xss_clean($this->post("isi"));
        $nama = $this->security->xss_clean($this->post("nama"));
        $jabatan = $this->security->xss_clean($this->post("jabatan"));
        $this->form_validation->set_rules("isi", "Isi", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("jabatan", "Jabatan", "required");

        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($isi) && !empty($nama) && !empty($jabatan)) {
                $testimoni = array(
                    "isi" => $isi,
                    "nama" => $nama,
                    "jabatan" => $jabatan,
                );

                if ($this->home_model->insert_testimoni($testimoni)) {
                    return $this->response([
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
                    'message' => 'Semua Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function team_post()
    {
        $id_team = $this->security->xss_clean($this->post("id_team"));
        $nama = $this->security->xss_clean($this->post("nama"));
        $jabatan = $this->security->xss_clean($this->post("jabatan"));
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("jabatan", "Jabatan", "required");

        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($nama) && !empty($jabatan)) {
                if (!empty($_FILES['foto_team']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '\\foto_team\\';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $_FILES['foto_team']['name'] = $files['foto_team']['name'];
                    $_FILES['foto_team']['type'] = $files['foto_team']['type'];
                    $_FILES['foto_team']['tmp_name'] = $files['foto_team']['tmp_name'];
                    $_FILES['foto_team']['error'] = $files['foto_team']['error'];
                    $_FILES['foto_team']['size'] = $files['foto_team']['size'];

                    $config['upload_path']          = $filename;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('foto_team')) {
                        $error = array('error' => $this->upload->display_errors());
                        return $this->response([
                            'status' => "Error",
                            'message' => $error,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $upload_data = $this->upload->data();
                        $team = array(
                            "nama" => $nama,
                            "jabatan" => $jabatan,
                            "foto" => $upload_data['file_name'],
                        );

                        if (!empty($id_team)) {
                            if ($this->home_model->update_team($id_team, $team)) {
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
                            if ($this->home_model->insert_team($team)) {
                                return $this->response([
                                    'status' => "Sukses",
                                    'message' => 'Data Berhasil Ditambah',
                                ], REST_Controller::HTTP_OK);
                            } else {
                                return $this->response([
                                    'status' => "Gagal",
                                    'message' => 'Data Gagal Ditambah',
                                ], REST_Controller::HTTP_OK);
                            }
                        }
                    }
                } else {
                    $team = array(
                        "nama" => $nama,
                        "jabatan" => $jabatan,
                    );

                    if (!empty($id_team)) {
                        if ($this->home_model->update_team($id_team, $team)) {
                            return $this->response([
                                'status' => "Sukses",
                                'message' => 'Data Berhasil Diupdate',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return  $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }
                    } else {
                        if ($this->home_model->insert_team($team)) {
                            return $this->response([
                                'status' => "Sukses",
                                'message' => 'Data Berhasil Ditambah',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return  $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Semua Data Harus Diisi',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function testimoni_put()
    {
        $id_testimoni = $this->security->xss_clean($this->put("id_testimoni"));
        $isi = $this->security->xss_clean($this->put("isi"));
        $nama = $this->security->xss_clean($this->put("nama"));
        $jabatan = $this->security->xss_clean($this->put("jabatan"));

        if (!empty($isi) && !empty($nama) && !empty($jabatan)) {
            $testimoni = array(
                "isi" => $isi,
                "nama" => $nama,
                "jabatan" => $jabatan,
            );

            if ($this->home_model->update_testimoni($id_testimoni, $testimoni)) {
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

    public function header_get()
    {
        $header_home = $this->home_model->get_header_home();

        if ($header_home != null) {
            $header_home->logo = base_url() . 'assets/uploads/logo_header_home/' . $header_home->logo;
            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $header_home,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => [],
            ], REST_Controller::HTTP_OK);
        }
    }

    public function tentang_get()
    {
        $tentang_home = $this->home_model->get_tentang_home();
        if ($tentang_home != null) {
            $tentang_home->gambar = base_url() . 'assets/uploads/gambar_tentang/' . $tentang_home->gambar;
            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $tentang_home,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => [],
            ], REST_Controller::HTTP_OK);
        }
    }

    public function testimoni_get()
    {
        $testimoni_home = $this->home_model->get_testimoni();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $testimoni_home,
        ], REST_Controller::HTTP_OK);
    }

    public function team_get()
    {
        $team_home = $this->home_model->get_team();

        for ($i = 0; $i < count($team_home); $i++) {
            $team_home[$i]->foto = base_url() . 'assets/uploads/foto_team/' . $team_home[$i]->foto;
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $team_home,
        ], REST_Controller::HTTP_OK);
    }

    public function header_delete()
    {
        $id = $this->delete("id");
        if ($this->home_model->delete_header_home($id)) {
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

    public function tentang_delete()
    {
        $id = $this->delete("id");
        if ($this->home_model->delete_tentang_home($id)) {
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

    public function testimoni_delete()
    {
        $id = $this->delete("id");
        if ($this->home_model->delete_testimoni($id)) {
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

    public function team_delete()
    {
        $id = $this->delete("id");
        if ($this->home_model->delete_team($id)) {
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
}
