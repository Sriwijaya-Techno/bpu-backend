<?php

require APPPATH . 'libraries/REST_Controller.php';

class Home extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/home_model", "api/kategori_model", "api/layanan_model", "api/item_kategori_model"));
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
                            $header = array(
                                "logo" => $upload_data['file_name'],
                                "title_logo" => $title_logo,
                                "sub_title_logo" => $sub_title_logo,
                                "lokasi" => $lokasi,
                                "kontak" => $kontak,
                            );

                            if ($this->home_model->insert_header_home($header)) {
                                return $this->response([
                                    'status' => "Success",
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
                        $header = array(
                            "title_logo" => $title_logo,
                            "sub_title_logo" => $sub_title_logo,
                            "lokasi" => $lokasi,
                            "kontak" => $kontak,
                        );

                        if ($this->home_model->insert_header_home($header)) {
                            return $this->response([
                                'status' => "Success",
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
        $visi = $this->security->xss_clean($this->post("visi"));
        $misi = $this->security->xss_clean($this->post("misi"));
        $tujuan = $this->security->xss_clean($this->post("tujuan"));
        $quotes = $this->security->xss_clean($this->post("quotes"));
        $this->form_validation->set_rules("isi", "Isi", "required");
        $this->form_validation->set_rules("visi", "Visi", "required");
        $this->form_validation->set_rules("misi", "Misi", "required");
        $this->form_validation->set_rules("tujuan", "Tujuan", "required");
        $this->form_validation->set_rules("quotes", "Quotes", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($isi) && !empty($visi) && !empty($misi) && !empty($tujuan) && !empty($quotes)) {
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
                                "visi" => $visi,
                                "misi" => $misi,
                                "tujuan" => $tujuan,
                                "quotes" => $quotes,
                                "gambar" => $upload_data['file_name'],
                            );

                            if ($this->home_model->update_tentang_home($get_home->id, $tentang)) {
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
                            $tentang = array(
                                "isi" => $isi,
                                "visi" => $visi,
                                "misi" => $misi,
                                "tujuan" => $tujuan,
                                "quotes" => $quotes,
                                "gambar" => $upload_data['file_name'],
                            );

                            if ($this->home_model->insert_tentang_home($tentang)) {
                                return $this->response([
                                    'status' => "Success",
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
                            "visi" => $visi,
                            "misi" => $misi,
                            "tujuan" => $tujuan,
                            "quotes" => $quotes,
                        );

                        if ($this->home_model->update_tentang_home($get_home->id, $tentang)) {
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
                        $tentang = array(
                            "isi" => $isi,
                            "visi" => $visi,
                            "misi" => $misi,
                            "tujuan" => $tujuan,
                            "quotes" => $quotes,
                        );

                        if ($this->home_model->insert_tentang_home($tentang)) {
                            return $this->response([
                                'status' => "Success",
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
                        'status' => "Success",
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

    public function contact_post()
    {
        $id_layanan = $this->security->xss_clean($this->post("id_layanan"));
        $nama = $this->security->xss_clean($this->post("nama"));
        $no_hp = $this->security->xss_clean($this->post("no_hp"));
        $email = $this->security->xss_clean($this->post("email"));
        $pertanyaan = $this->security->xss_clean($this->post("pertanyaan"));
        $this->form_validation->set_rules("id_layanan", "Id_layanan", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("no_hp", "No_hp", "required");
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("pertanyaan", "Pertanyaan", "required");

        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_layanan) && !empty($nama) && !empty($no_hp) && !empty($email) && !empty($pertanyaan)) {
                $contact = array(
                    "id_layanan" => $id_layanan,
                    "nama" => $nama,
                    "no_hp" => $no_hp,
                    "email" => $email,
                    "pertanyaan" => $pertanyaan
                );

                if ($this->home_model->insert_contact($contact)) {
                    return $this->response([
                        'status' => "Success",
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

    public function mitra_post()
    {
        $id_mitra = $this->security->xss_clean($this->post("id_mitra"));
        $nama = $this->security->xss_clean($this->post("nama"));
        $link = $this->security->xss_clean($this->post("link"));
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("link", "Link", "required");

        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($nama) && !empty($link)) {
                if (!empty($_FILES['gambar']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '\\gambar_mitra\\';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $_FILES['gambar']['name'] = $files['gambar']['name'];
                    $_FILES['gambar']['type'] = $files['gambar']['type'];
                    $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'];
                    $_FILES['gambar']['error'] = $files['gambar']['error'];
                    $_FILES['gambar']['size'] = $files['gambar']['size'];

                    $config['upload_path']          = $filename;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('gambar')) {
                        $error = array('error' => $this->upload->display_errors());
                        return $this->response([
                            'status' => "Error",
                            'message' => $error,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $upload_data = $this->upload->data();
                        $mitra = array(
                            "nama" => $nama,
                            "link" => $link,
                            "gambar" => $upload_data['file_name'],
                        );

                        if (!empty($id_mitra)) {
                            if ($this->home_model->update_mitra($id_mitra, $mitra)) {
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
                            if ($this->home_model->insert_mitra($mitra)) {
                                return $this->response([
                                    'status' => "Success",
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
                    $mitra = array(
                        "nama" => $nama,
                        "link" => $link,
                    );

                    if (!empty($id_mitra)) {
                        if ($this->home_model->update_mitra($id_mitra, $mitra)) {
                            return $this->response([
                                'status' => "Success",
                                'message' => 'Data Berhasil Diupdate',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return  $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }
                    } else {
                        if ($this->home_model->insert_mitra($mitra)) {
                            return $this->response([
                                'status' => "Success",
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
                            if ($this->home_model->insert_team($team)) {
                                return $this->response([
                                    'status' => "Success",
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
                                'status' => "Success",
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
                                'status' => "Success",
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

    public function contact_put()
    {
        $id_contact = $this->security->xss_clean($this->put("id_contact"));
        $id_layanan = $this->security->xss_clean($this->put("id_layanan"));
        $nama = $this->security->xss_clean($this->put("nama"));
        $no_hp = $this->security->xss_clean($this->put("no_hp"));
        $email = $this->security->xss_clean($this->put("email"));
        $pertanyaan = $this->security->xss_clean($this->put("pertanyaan"));

        if (!empty($id_contact) && !empty($id_layanan) && !empty($nama) && !empty($no_hp) && !empty($email) && !empty($pertanyaan)) {
            $contact = array(
                "id_layanan" => $id_layanan,
                "nama" => $nama,
                "no_hp" => $no_hp,
                "email" => $email,
                "pertanyaan" => $pertanyaan
            );

            if ($this->home_model->update_contact($id_contact, $contact)) {
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

    public function menu_get()
    {
        $layanans = $this->home_model->get_layanan();

        for ($i = 0; $i < count($layanans); $i++) {
            $kategoris = $this->home_model->get_kategori($layanans[$i]->id);
            $layanans[$i]->kategori = $kategoris;

            for ($j = 0; $j < count($kategoris); $j++) {
                $item_kategoris = $this->home_model->get_item_kategori($kategoris[$j]->id);
                $kategoris[$j]->item_kategori = $item_kategoris;

                for ($k = 0; $k < count($item_kategoris); $k++) {
                    $img_item_kategoris = $this->home_model->get_img_item_kategori($item_kategoris[$k]->id);
                    $img = '';
                    for ($l = 0; $l < count($img_item_kategoris); $l++) {
                        $img = base_url() . 'assets/uploads/item_kategori/' . $img_item_kategoris[$l]->gambar;
                    }

                    $item_kategoris[$k]->img = $img;
                }
            }
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $layanans,
        ], REST_Controller::HTTP_OK);
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

    public function contact_get()
    {
        $contact_home = $this->home_model->get_contact();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $contact_home,
        ], REST_Controller::HTTP_OK);
    }

    public function mitra_get()
    {
        $mitra_home = $this->home_model->get_mitra();

        for ($i = 0; $i < count($mitra_home); $i++) {
            $mitra_home[$i]->gambar = base_url() . 'assets/uploads/gambar_mitra/' . $mitra_home[$i]->gambar;
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $mitra_home,
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

    public function layanan_get()
    {
        $layanan_home = $this->layanan_model->get_layanans();

        for ($i = 0; $i < count($layanan_home); $i++) {
            $kategoris = $this->kategori_model->get_kategoris($layanan_home[$i]->slug);
            if (count($kategoris) > 0) {
                $data = [
                    'slug_kategori' => $kategoris[0]->slug,
                    'id_kategori' => '',
                    'slug_layanan' => $layanan_home[$i]->slug,
                    'id_layanan' => '',
                    'id_item_kategori' => '',
                ];

                $items_kategori = $this->item_kategori_model->get_items_kategori($data);
                $layanan_home[$i]->image = '';
                for ($j = 0; $j < count($items_kategori); $j++) {
                    $img_item = $this->item_kategori_model->get_imgs_item_kategori($items_kategori[$j]->id);

                    if (count($img_item) > 0 && ($layanan_home[$i]->image == '')) {
                        $layanan_home[$i]->image = base_url() . 'assets/uploads/item_kategori/' . $img_item[0]->gambar;
                        break;
                    }
                }

                if ($layanan_home[$i]->image == '') {
                    $layanan_home[$i]->image = base_url() . 'assets/uploads/no_image.png';
                }
            } else {
                $layanan_home[$i]->image = base_url() . 'assets/uploads/no_image.png';
            }

            $layanan_home[$i]->deskripsi = "Layanan " . $layanan_home[$i]->nama;
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $layanan_home,
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

    public function mitra_delete()
    {
        $id = $this->delete("id");
        $mitra = array(
            'status' => 'dihapus'
        );
        if ($this->home_model->update_mitra($id, $mitra)) {
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

    public function contact_delete()
    {
        $id = $this->delete("id");
        $contact = array(
            'status' => 'dihapus'
        );
        if ($this->home_model->update_contact($id, $contact)) {
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
