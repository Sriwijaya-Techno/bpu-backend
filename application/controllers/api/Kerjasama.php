<?php

require APPPATH . 'libraries/REST_Controller.php';

class Kerjasama extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/kerjasama_model", "api/rab_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_get()
    {
        $user_id = $this->security->xss_clean($this->get("user_id"));

        if (!empty($user_id)) {
            $kerjasama = $this->kerjasama_model->get_kerjasamas_by_id($user_id);

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $kerjasama,
            ], 200);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function detail_get()
    {
        $id_kerjasama = $this->security->xss_clean($this->get("id_kerjasama"));

        if (!empty($id_kerjasama)) {
            $kerjasama = $this->kerjasama_model->get_detail_kerjasama($id_kerjasama);

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $kerjasama,
            ], 200);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function rab_get()
    {
        $id_kerjasama = $this->security->xss_clean($this->get("id_kerjasama"));

        if (!empty($id_kerjasama)) {
            $kerjasama = $this->kerjasama_model->get_rab_kerjasama($id_kerjasama);

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $kerjasama,
            ], 200);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function pembayaran_get()
    {
        $id_kerjasama = $this->security->xss_clean($this->get("id_kerjasama"));

        if (!empty($id_kerjasama)) {
            $pembayaran = $this->kerjasama_model->get_pembayaran_kerjasama($id_kerjasama);
            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $pembayaran,
            ], 200);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function admin_get()
    {
        $kerjasama = $this->kerjasama_model->get_kerjasamas();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $kerjasama,
        ], 200);
    }

    public function index_post()
    {
        $id_kategori = $this->security->xss_clean($this->post("id_kategori"));
        $user_id = $this->security->xss_clean($this->post("user_id"));
        $nomor = $this->security->xss_clean($this->post("nomor"));
        $this->form_validation->set_rules("id_kategori", "Id_kategori", "required");
        $this->form_validation->set_rules("user_id", "User_id", "required");
        $this->form_validation->set_rules("nomor", "Nomor", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_kategori) && !empty($user_id) && !empty($nomor)) {
                $kerjasama = array(
                    "id_kategori" => $id_kategori,
                    "user_id" => $user_id,
                    "nomor" => $nomor,
                );

                if ($this->kerjasama_model->insert_kerjasama($kerjasama)) {
                    $id_kerjasama = $this->db->insert_id();
                    $detail = array(
                        "id_kerjasama" => $id_kerjasama,
                    );

                    if ($this->kerjasama_model->insert_detail_kerjasama($detail)) {
                        $this->response([
                            'status' => "Sukses",
                            'message' => 'Data Berhasil Ditambah',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => "Error",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response([
                        'status' => "Error",
                        'message' => 'Data Gagal Ditambah',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function rab_post()
    {
        $id_kerjasama = $this->security->xss_clean($this->post("id_kerjasama"));
        $nama = $this->security->xss_clean($this->post("nama"));
        $satuan = $this->security->xss_clean($this->post("satuan"));
        $volume = $this->security->xss_clean($this->post("volume"));
        $harga = $this->security->xss_clean($this->post("harga"));
        $total = $this->security->xss_clean($this->post("total"));
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("satuan", "Satuan", "required");
        $this->form_validation->set_rules("volume", "Volume", "required");
        $this->form_validation->set_rules("harga", "Harga", "required");
        $this->form_validation->set_rules("total", "total", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($nama) && !empty($satuan) && !empty($volume) && !empty($harga) && !empty($total)) {
                $rab = array(
                    "nama" => $nama,
                    "satuan" => $satuan,
                    "volume" => $volume,
                    "harga" => $harga,
                    "total" => $total,
                );

                if ($this->rab_model->insert_rab($rab)) {
                    $id_rab = $this->db->insert_id();
                    $rab_kerjasama = array(
                        "id_kerjasama" => $id_kerjasama,
                        "id_rab" => $id_rab,
                    );
                    if ($this->kerjasama_model->insert_rab_kerjasama($rab_kerjasama)) {
                        $this->response([
                            'status' => "Sukses",
                            'message' => 'Data Berhasil Ditambah',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => "Error",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response([
                        'status' => "Error",
                        'message' => 'Data Gagal Ditambah',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function draft_post()
    {
        $id_kerjasama = $this->security->xss_clean($this->post("id_kerjasama"));
        $this->form_validation->set_rules("id_kerjasama", "Id_kerjasama", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_kerjasama)) {
                if (!empty($_FILES['draft']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads/draft');

                    $_FILES['draft']['name'] = $files['draft']['name'];
                    $_FILES['draft']['type'] = $files['draft']['type'];
                    $_FILES['draft']['tmp_name'] = $files['draft']['tmp_name'];
                    $_FILES['draft']['error'] = $files['draft']['error'];
                    $_FILES['draft']['size'] = $files['draft']['size'];

                    $config['upload_path']          = $dir;
                    $config['allowed_types']        = 'pdf';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('draft')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data = array(
                            "status"    => "Gagal",
                            "pesan"     => $error,
                        );
                    } else {
                        $upload_data = $this->upload->data();
                        $draft = array(
                            "id_kerjasama" => $id_kerjasama,
                            "nama_draft" => $upload_data['file_name'],
                        );

                        if ($this->kerjasama_model->insert_draft_kerjasama($draft)) {
                            $this->response([
                                'status' => "Sukses",
                                'message' => 'Data Berhasil Ditambah',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data File Draft Harus Diisi',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function bayar_post()
    {
        $id_pembayaran = $this->security->xss_clean($this->post("id_pembayaran"));
        $nominal = $this->security->xss_clean($this->post("nominal"));
        $tujuan_rekening = $this->security->xss_clean($this->post("tujuan_rekening"));
        $tanggal = $this->security->xss_clean($this->post("tanggal"));
        $this->form_validation->set_rules("id_pembayaran", "Id_pembayaran", "required");
        $this->form_validation->set_rules("nominal", "Nominal", "required");
        $this->form_validation->set_rules("tujuan_rekening", "Tujuan_rekening", "required");
        $this->form_validation->set_rules("tanggal", "Tanggal", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_pembayaran) && !empty($nominal) && !empty($tujuan_rekening) && !empty($tanggal)) {
                if (!empty($_FILES['bukti_pembayaran']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads/bukti_pembayaran');

                    $_FILES['bukti_pembayaran']['name'] = $files['bukti_pembayaran']['name'];
                    $_FILES['bukti_pembayaran']['type'] = $files['bukti_pembayaran']['type'];
                    $_FILES['bukti_pembayaran']['tmp_name'] = $files['bukti_pembayaran']['tmp_name'];
                    $_FILES['bukti_pembayaran']['error'] = $files['bukti_pembayaran']['error'];
                    $_FILES['bukti_pembayaran']['size'] = $files['bukti_pembayaran']['size'];

                    $config['upload_path']          = $dir;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('bukti_pembayaran')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data = array(
                            "status"    => "Gagal",
                            "pesan"     => $error,
                        );
                    } else {
                        $upload_data = $this->upload->data();
                        $pembayaran = array(
                            "nominal" => $nominal,
                            "tujuan_rekening" => $tujuan_rekening,
                            "tanggal" => $tanggal,
                            "bukti_pembayaran" => $upload_data['file_name'],
                            "status" => 'menunggu konfirmasi',
                        );

                        if ($this->kerjasama_model->update_pembayaran_kerjasama($id_pembayaran, $pembayaran)) {
                            $this->response([
                                'status' => "Sukses",
                                'message' => 'Pembayaran Berhasil',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            $this->response([
                                'status' => "Gagal",
                                'message' => 'Pembayaran Gagal',
                            ], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Bukti Pembayaran Harus Disertakan',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function detail_put()
    {
        $id_detail = $this->security->xss_clean($this->put("id_detail"));
        $judul_kegiatan = $this->security->xss_clean($this->put("judul_kegiatan"));
        $ruang_lingkup = $this->security->xss_clean($this->put("ruang_lingkup"));
        $deskripsi = $this->security->xss_clean($this->put("deskripsi"));
        $lama_pekerjaan = $this->security->xss_clean($this->put("lama_pekerjaan"));
        $metode_pembayaran = $this->security->xss_clean($this->put("metode_pembayaran"));
        $jumlah_termin = $this->security->xss_clean($this->put("jumlah_termin"));
        $nilai_kontrak = $this->security->xss_clean($this->put("nilai_kontrak"));

        if (!empty($id_detail) && !empty($judul_kegiatan) && !empty($ruang_lingkup) && !empty($deskripsi) && !empty($lama_pekerjaan) && !empty($metode_pembayaran) && !empty($nilai_kontrak)) {
            if ($metode_pembayaran == 'sekaligus') {
                $jumlah_termin = 0;
            } else {
                if (empty($jumlah_termin)) {
                    $jumlah_termin = 1;
                }
            }

            $kerjasama = array(
                "judul_kegiatan" => $judul_kegiatan,
                "ruang_lingkup" => $ruang_lingkup,
                "deskripsi" => $deskripsi,
                "lama_pekerjaan" => $lama_pekerjaan,
                "metode_pembayaran" => $metode_pembayaran,
                "jumlah_termin" => $jumlah_termin,
                "nilai_kontrak" => $nilai_kontrak,
                "status" => "usul",
            );

            if ($this->kerjasama_model->update_detail_kerjasama($id_detail, $kerjasama)) {
                $this->response([
                    'status' => "Sukses",
                    'message' => 'Data Berhasil Diupdate',
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_detail_put()
    {
        $id_kerjasama = $this->security->xss_clean($this->put("id_kerjasama"));
        $status = $this->security->xss_clean($this->put("status"));

        if (!empty($status)) {
            $kerjasama = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_status_detail_kerjasama($id_kerjasama, $kerjasama)) {
                $status_detail = $this->kerjasama_model->get_status_detail_kerjasama($id_kerjasama);
                $status_rab = $this->kerjasama_model->get_status_rab_kerjasama($id_kerjasama);

                if ($status_detail[0]->status == 'disetujui' && $status_rab[0]->status == 'disetujui') {
                    $kerjasama = array(
                        "status" => "draft",
                    );
                } else {
                    $kerjasama = array(
                        "status" => "usul",
                    );
                }

                if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                    $this->response([
                        'status' => "Sukses",
                        'message' => 'Data Berhasil Diupdate',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_rab_put()
    {
        $id_kerjasama = $this->security->xss_clean($this->put("id_kerjasama"));
        $status = $this->security->xss_clean($this->put("status"));

        if (!empty($status)) {
            $kerjasama = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_status_rab_kerjasama($id_kerjasama, $kerjasama)) {
                $status_detail = $this->kerjasama_model->get_status_detail_kerjasama($id_kerjasama);
                $status_rab = $this->kerjasama_model->get_status_rab_kerjasama($id_kerjasama);

                if ($status_detail[0]->status == 'disetujui' && $status_rab[0]->status == 'disetujui') {
                    $kerjasama = array(
                        "status" => "draft",
                    );
                } else {
                    $kerjasama = array(
                        "status" => "usul",
                    );
                }

                if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                    $this->response([
                        'status' => "Sukses",
                        'message' => 'Data Berhasil Diupdate',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_draft_put()
    {
        $id_kerjasama = $this->security->xss_clean($this->put("id_kerjasama"));
        $status = $this->security->xss_clean($this->put("status"));

        if (!empty($status)) {
            $pembayaran = $this->kerjasama_model->get_pembayaran_kerjasama($id_kerjasama);

            $is_status_lunas = true;
            for ($i = 0; $i < count($pembayaran); $i++) {
                if ($pembayaran[$i]->status == 'belum dibayar') {
                    $is_status_lunas = false;
                }
            }

            if ($is_status_lunas) {
                $kerjasama = array(
                    "status" => "disetujui",
                );

                if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                    $this->response([
                        'status' => "Sukses",
                        'message' => 'Pembayaran Berhasil',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Pembayaran Gagal',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Sukses",
                    'message' => 'Pembayaran Berhasil',
                ], REST_Controller::HTTP_OK);
            }

            if ($this->kerjasama_model->update_status_draft_kerjasama($id_kerjasama, $kerjasama)) {
                $status_draft = $this->kerjasama_model->get_status_draft_kerjasama($id_kerjasama);

                if ($status_draft[0]->status == 'disetujui') {
                    $kerjasama = array(
                        "status" => "pembayaran",
                    );
                } else {
                    $kerjasama = array(
                        "status" => "draft",
                    );
                }

                if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                    $detail = $this->kerjasama_model->get_detail_kerjasama($id_kerjasama);
                    if ($kerjasama['status'] == 'pembayaran') {
                        if ($detail[0]->metode_pembayaran == 'sekaligus') {
                            $pembayaran = array(
                                "id_kerjasama" => $id_kerjasama,
                            );

                            if ($this->kerjasama_model->insert_pembayaran_kerjasama($pembayaran)) {
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
                            $termin = 0;
                            for ($i = 0; $i < $detail[0]->jumlah_termin; $i++) {
                                $pembayaran = array(
                                    "id_kerjasama" => $id_kerjasama,
                                );

                                if ($this->kerjasama_model->insert_pembayaran_kerjasama($pembayaran)) {
                                    $termin++;
                                }
                            }

                            if ($termin == $detail[0]->jumlah_termin) {
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
                        }
                    } else {
                        if ($this->kerjasama_model->hapus_pembayaran($id_kerjasama)) {
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
                    }
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_pembayaran_put()
    {
        $id_kerjasama = $this->security->xss_clean($this->put("id_kerjasama"));
        $id_pembayaran = $this->security->xss_clean($this->put("id_pembayaran"));
        $status = $this->security->xss_clean($this->put("status"));

        if (!empty($status)) {
            $pembayaran = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_pembayaran_kerjasama($id_pembayaran, $pembayaran)) {
                $pembayaran = $this->kerjasama_model->get_pembayaran_kerjasama($id_kerjasama);

                $is_status_lunas = true;
                for ($i = 0; $i < count($pembayaran); $i++) {
                    if ($pembayaran[$i]->status == 'belum dibayar' || $pembayaran[$i]->status == 'ditolak' || $pembayaran[$i]->status == 'menunggu konfirmasi') {
                        $is_status_lunas = false;
                    }
                }

                if ($is_status_lunas) {
                    $kerjasama = array(
                        "status" => "disetujui",
                    );

                    if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                        $this->response([
                            'status' => "Sukses",
                            'message' => 'Data Berhasil Diverifikasi',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => "Gagal",
                            'message' => 'Data Gagal Diverifikasi',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => "Sukses",
                        'message' => 'Data Berhasil Diverifikasi',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diverifikasi',
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
