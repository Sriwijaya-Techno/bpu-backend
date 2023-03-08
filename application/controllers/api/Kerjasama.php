<?php

require APPPATH . 'libraries/REST_Controller.php';

class Kerjasama extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/kerjasama_model", "api/rab_model", "api/pasal_model", "api/base_setting_model", "api/base_setting_status_model", "api/company_profile_status_model", "api/user_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_get()
    {
        $user_id = $this->get("user_id");

        if (!empty($user_id)) {
            $kerjasama = $this->kerjasama_model->get_kerjasamas_by_id($user_id);

            for ($i = 0; $i < count($kerjasama); $i++) {
                $data_pembayaran = $this->kerjasama_model->get_total_bayar_kerjasama($kerjasama[$i]->id_kerjasama);
                $kerjasama[$i]->sisa_bayar = $kerjasama[$i]->nilai_kontrak - $data_pembayaran->total_bayar;

                if (empty($kerjasama[$i]->judul_kegiatan)) {
                    $kerjasama[$i]->judul_kegiatan = "-";
                }

                $date1 = strtotime(date('Y-m-d'));
                $date2 = strtotime($kerjasama[$i]->tanggal_akhir);
                $days = ($date2 - $date1) / 86400;

                $kerjasama[$i]->sisa_waktu = $days;

                if ($kerjasama[$i]->status != 'disetujui') {
                    $kerjasama[$i]->tanggal_mulai = '-';
                    $kerjasama[$i]->tanggal_akhir = '-';
                    $kerjasama[$i]->nilai_kontrak = '-';
                    $kerjasama[$i]->sisa_bayar = '-';
                    $kerjasama[$i]->sisa_waktu = '-';
                }
            }

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
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $kerjasama = $this->kerjasama_model->get_detail_kerjasama($id_kerjasama);
            if (count($kerjasama) > 0) {
                if (!empty($kerjasama[0]->surat_penawaran)) {
                    $kerjasama[0]->surat_penawaran = base_url() . 'assets/uploads/surat/' . $kerjasama[0]->surat_penawaran;
                }
            }
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
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $kerjasama = $this->kerjasama_model->get_rab_kerjasama($id_kerjasama);

            for ($i = 0; $i < count($kerjasama); $i++) {
                $rab_histori = $this->kerjasama_model->get_rab_history_kerjasama_by_rab($id_kerjasama, $kerjasama[$i]->id);
                for ($j = 0; $j < count($rab_histori); $j++) {
                    $rab_histori[$j]->tipe_data = "histori rab";
                }

                $kerjasama[$i]->tipe_data = "rab";
                $kerjasama[$i]->history = $rab_histori;
            }

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

    public function rab_history_get()
    {
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $kerjasama = $this->kerjasama_model->get_rab_history_kerjasama($id_kerjasama);

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

    public function rab_surat_get()
    {
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $rab_surat_kerjasama = $this->kerjasama_model->get_rab_surat_kerjasama($id_kerjasama);

            for ($i = 0; $i < count($rab_surat_kerjasama); $i++) {
                $rab_surat_kerjasama[$i]->surat_url = base_url() . 'assets/uploads/surat/' . $rab_surat_kerjasama[$i]->nama;
            }

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $rab_surat_kerjasama,
            ], 200);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function rab_surat_penawaran_history_get()
    {
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $rab_surat_kerjasama = $this->kerjasama_model->get_rab_surat_penawaran_kerjasama($id_kerjasama);

            for ($i = 0; $i < count($rab_surat_kerjasama); $i++) {
                $rab_surat_kerjasama[$i]->surat_url = base_url() . 'assets/uploads/surat/' . $rab_surat_kerjasama[$i]->nama;
            }

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $rab_surat_kerjasama,
            ], 200);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function draft_get()
    {
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $dir_draft = realpath(APPPATH . '../assets/uploads/draft');
            $dir_logo =  realpath(APPPATH . '../assets/uploads/logo');
            $dir_bs_logo =  realpath(APPPATH . '../assets/uploads/base_setting');

            $base_setting = $this->base_setting_model->get_base_settings($id_kerjasama);
            for ($i = 0; $i < count($base_setting); $i++) {
                $base_setting[$i]->bs_logo_url = base_url() . 'assets/uploads/base_setting/' . $base_setting[$i]->bs_logo;
                $base_setting[$i]->bs_logo = $dir_bs_logo . '\\' . $base_setting[$i]->bs_logo;
            }

            if (count($base_setting) == 0) {
                $base_setting = $this->base_setting_model->get_old_base_settings();
                for ($i = 0; $i < count($base_setting); $i++) {
                    $base_setting[$i]->bs_jabatan = 'Rektor';
                    $base_setting[$i]->bs_logo_url = base_url() . 'assets/uploads/base_setting/' . $base_setting[$i]->bs_logo;
                    $base_setting[$i]->bs_logo = $dir_bs_logo . '\\' . $base_setting[$i]->bs_logo;
                }
            }

            $company_profile = $this->kerjasama_model->get_company_profile_by_id_kerjasama($id_kerjasama);
            for ($i = 0; $i < count($company_profile); $i++) {
                $company_profile[$i]->logo_url = base_url() . 'assets/uploads/logo/' . $company_profile[$i]->logo;
                $company_profile[$i]->logo = $dir_logo . '\\' . $company_profile[$i]->logo;
            }

            $draft = $this->kerjasama_model->get_draft_kerjasama($id_kerjasama);
            for ($i = 0; $i < count($draft); $i++) {
                $draft[$i]->draft_file_url = base_url() . 'assets/uploads/draft/' . $draft[$i]->draft_file;
                $draft[$i]->draft_file = $dir_draft . '\\' . $draft[$i]->draft_file;
            }
            $pasal = [];
            if (count($draft) > 0) {
                $draft_id = $draft[0]->id;
                $pasal = $this->kerjasama_model->get_pasal_draft($draft_id);
            }

            $data = array(
                "base_setting" => $base_setting,
                "draft" => $draft,
                "pasal" => $pasal,
                "company_profile" => $company_profile,
            );

            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $data,
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
        $dir_pembayaran = base_url() . 'assets/uploads/bukti_pembayaran/';
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $pembayaran = $this->kerjasama_model->get_pembayaran_kerjasama($id_kerjasama);
            for ($i = 0; $i < count($pembayaran); $i++) {
                if ($pembayaran[$i]->bukti_pembayaran != '') {
                    $pembayaran[$i]->bukti_pembayaran = $pembayaran[$i]->bukti_pembayaran;
                    $pembayaran[$i]->bukti_pembayaran_url = $dir_pembayaran . $pembayaran[$i]->bukti_pembayaran;
                } else {
                    $pembayaran[$i]->bukti_pembayaran_url = '';
                }
            }
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
        for ($i = 0; $i < count($kerjasama); $i++) {
            $data_pembayaran = $this->kerjasama_model->get_total_bayar_kerjasama($kerjasama[$i]->id_kerjasama);
            $status_detail = $this->kerjasama_model->get_status_detail_kerjasama($kerjasama[$i]->id_kerjasama);

            if (empty($kerjasama[$i]->judul_kegiatan)) {
                $kerjasama[$i]->judul_kegiatan = "-";
            }

            if (empty($kerjasama[$i]->nilai_kontrak)) {
                $kerjasama[$i]->nilai_kontrak = "-";
            }

            if (empty($kerjasama[$i]->tanggal_mulai)) {
                $kerjasama[$i]->tanggal_mulai = "-";
            }

            if (empty($kerjasama[$i]->tanggal_akhir)) {
                $kerjasama[$i]->tanggal_akhir = "-";
            }

            if ($kerjasama[$i]->tanggal_mulai == "-" || $kerjasama[$i]->tanggal_akhir == "-") {
                $kerjasama[$i]->sisa_waktu = "-";
            } else {
                $date1 = strtotime(date('Y-m-d'));
                $date2 = strtotime($kerjasama[$i]->tanggal_akhir);
                $days = ($date2 - $date1) / 86400;

                $kerjasama[$i]->sisa_waktu = $days;
            }

            if ($status_detail[0]->status == 'disetujui') {
                $kerjasama[$i]->sisa_bayar = $kerjasama[$i]->nilai_kontrak - $data_pembayaran->total_bayar;
            } else {
                $kerjasama[$i]->sisa_bayar = '-';
            }
        }

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $kerjasama,
        ], 200);
    }

    public function index_post()
    {
        $id_item_kategori = $this->post("id_item_kategori");
        $user_id = $this->post("user_id");
        $this->form_validation->set_rules("id_item_kategori", "Id_item_kategori", "required");
        $this->form_validation->set_rules("user_id", "User_id", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_item_kategori) && !empty($user_id)) {
                $kerjasama = array(
                    "id_item_kategori" => $id_item_kategori,
                    "user_id" => $user_id,
                );

                if ($this->kerjasama_model->insert_kerjasama($kerjasama)) {
                    $id_kerjasama = $this->db->insert_id();
                    $detail = array(
                        "id_kerjasama" => $id_kerjasama,
                    );

                    if ($this->kerjasama_model->insert_detail_kerjasama($detail)) {
                        $this->response([
                            'status' => "Success",
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
        $id_kerjasama = $this->post("id_kerjasama");
        $nama = $this->post("nama");
        $satuan = $this->post("satuan");
        $volume = $this->post("volume");
        $harga = $this->post("harga");
        $total = $this->post("total");
        $keterangan = $this->post("keterangan");
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
                    "id_kerjasama" => $id_kerjasama,
                    "nama" => $nama,
                    "satuan" => $satuan,
                    "volume" => $volume,
                    "harga" => $harga,
                    "total" => $total,
                    "keterangan" => $keterangan
                );

                if ($this->rab_model->insert_rab($rab)) {
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
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function rab_collection_post()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body);
        $id_user = $data->id_user;
        $id_kerjasama = $data->id_kerjasama;
        $data_rabs = $data->rab;

        for ($i = 0; $i < count($data_rabs); $i++) {
            if ($data_rabs[$i]->id_rab != 0) {
                $rab = array(
                    "id_kerjasama" => $id_kerjasama,
                    "nama" => $data_rabs[$i]->nama,
                    "satuan" => $data_rabs[$i]->satuan,
                    "volume" => $data_rabs[$i]->volume,
                    "harga" => $data_rabs[$i]->harga,
                    "total" => $data_rabs[$i]->total,
                    "keterangan" => $data_rabs[$i]->keterangan,
                );

                $data_rab = $this->kerjasama_model->get_rab_kerjasama_by_id_rab($data_rabs[$i]->id_rab);
                if ($data_rab->volume != $data_rabs[$i]->volume || $data_rab->harga != $data_rabs[$i]->harga) {
                    $user = $this->user_model->get_user_by_id($id_user);
                    if ($user[0]->tipe_akun == 'Institusi/Pemerintahan' || $user[0]->id_role == '4') {
                        $rab['status'] = "nego user";
                    } else {
                        $rab['status'] = "nego admin";
                    }

                    $rab_history = array(
                        "id_user" => $id_user,
                        "id_kerjasama" => $id_kerjasama,
                        "id_rab" => $data_rabs[$i]->id_rab,
                        "volume" => $data_rab->volume,
                        "harga" => $data_rab->harga,
                        "total" => $data_rab->total,
                        "status" => "tidak disetujui",
                    );

                    if (!$this->kerjasama_model->insert_rab_history($rab_history)) {
                        return $this->response([
                            'status' => "Gagal",
                            'message' => 'Gagal Mengupdate History',
                        ], REST_Controller::HTTP_OK);
                    }

                    $rab_history = array(
                        "id_user" => $id_user,
                        "id_kerjasama" => $id_kerjasama,
                        "id_rab" => $data_rabs[$i]->id_rab,
                        "volume" => $data_rabs[$i]->volume,
                        "harga" => $data_rabs[$i]->harga,
                        "total" => $data_rabs[$i]->total,
                        "status" => "nego",
                    );

                    if (!$this->kerjasama_model->insert_rab_history($rab_history)) {
                        return $this->response([
                            'status' => "Gagal",
                            'message' => 'Gagal Mengupdate History',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    // if ($data_rab->status == 'usul') {
                    //     $user = $this->user_model->get_user_by_id($id_user);
                    //     $this->kerjasama_model->get_rab_history_kerjasama_by_rab_usul($id_kerjasama, $data_rabs[$i]->id_rab)

                    //     // if (condition) {
                    //     //     # code...
                    //     // }
                    //     $rab['status'] = "disetujui";
                    // } else {
                    //     $rab['status'] = "disetujui";
                    // }

                    if ($data_rab->status != "disetujui") {
                        $rab_history = array(
                            "id_user" => $id_user,
                            "id_kerjasama" => $id_kerjasama,
                            "id_rab" => $data_rabs[$i]->id_rab,
                            "volume" => $data_rabs[$i]->volume,
                            "harga" => $data_rabs[$i]->harga,
                            "total" => $data_rabs[$i]->total,
                            "status" => "disetujui",
                        );

                        if (!$this->kerjasama_model->insert_rab_history($rab_history)) {
                            return $this->response([
                                'status' => "Gagal",
                                'message' => 'Gagal Mengupdate History',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }

                if (!$this->rab_model->update_rab($data_rabs[$i]->id_rab, $rab)) {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengolah Data',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        $rab_kerjasama = $this->kerjasama_model->get_rab_kerjasama($id_kerjasama);
        for ($i = 0; $i < count($rab_kerjasama); $i++) {
            $id_data_exist = false;
            for ($j = 0; $j < count($data_rabs); $j++) {
                if ($rab_kerjasama[$i]->id == $data_rabs[$j]->id_rab) {
                    $id_data_exist = true;
                }
            }

            if (!$id_data_exist) {
                if (!$this->rab_model->delete_rab($rab_kerjasama[$i]->id_rab)) {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengolah Data',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        for ($i = 0; $i < count($data_rabs); $i++) {
            if ($data_rabs[$i]->id_rab == 0) {
                $rab = array(
                    "id_kerjasama" => $id_kerjasama,
                    "nama" => $data_rabs[$i]->nama,
                    "satuan" => $data_rabs[$i]->satuan,
                    "volume" => $data_rabs[$i]->volume,
                    "harga" => $data_rabs[$i]->harga,
                    "total" => $data_rabs[$i]->total,
                    "keterangan" => $data_rabs[$i]->keterangan,
                );

                if (!$this->rab_model->insert_rab($rab)) {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengolah Data',
                    ], REST_Controller::HTTP_OK);
                }

                $id_rab = $this->db->insert_id();
                $rab_history = array(
                    "id_user" => $id_user,
                    "id_kerjasama" => $id_kerjasama,
                    "id_rab" => $id_rab,
                    "volume" =>  $data_rabs[$i]->volume,
                    "harga" =>  $data_rabs[$i]->harga,
                    "total" =>  $data_rabs[$i]->total,
                    "status" =>  "usul",
                );

                if (!$this->kerjasama_model->insert_rab_history($rab_history)) {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengupdate History',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        $status_detail = $this->kerjasama_model->get_status_detail_kerjasama($id_kerjasama);
        $status_rab = $this->kerjasama_model->get_status_rab_kerjasama($id_kerjasama);

        if ($status_detail[0]->status == 'disetujui') {
            $status_rab_kerjasama = true;
            for ($i = 0; $i < count($status_rab); $i++) {
                if ($status_rab[$i]->status != 'disetujui') {
                    $status_rab_kerjasama = false;
                }
            }

            if (!$status_rab_kerjasama) {
                $kerjasama = array(
                    "status" => "usul",
                );
            } else {
                $kerjasama = array(
                    "status" => "draft",
                );
            }
        } else {
            $kerjasama = array(
                "status" => "usul",
            );
        }

        if (!$this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
            return $this->response([
                'status' => "Gagal",
                'message' => 'Data Gagal Diupdate',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        return $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Diupdate',
        ], REST_Controller::HTTP_OK);
    }

    public function rab_surat_post()
    {
        $id_kerjasama = $this->post("id_kerjasama");
        $no_surat = $this->post("no_surat");
        $tanggal_surat = $this->post("tanggal_surat");
        $jenis_surat = $this->post("jenis_surat");
        $this->form_validation->set_rules("id_kerjasama", "Id_kerjasama", "required");
        $this->form_validation->set_rules("no_surat", "No_surat", "required");
        $this->form_validation->set_rules("tanggal_surat", "Tanggal_surat", "required");
        $this->form_validation->set_rules("jenis_surat", "Jenis_surat", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_kerjasama) && !empty($no_surat) && !empty($tanggal_surat) && !empty($jenis_surat)) {
                if ($this->kerjasama_model->cek_rab_surat_kerjasama($id_kerjasama)) {
                    if ($this->kerjasama_model->cek_pengajuan_rab_surat_kerjasama($id_kerjasama)) {
                        return $this->response([
                            'status' => "Gagal",
                            'message' => 'Surat yang diajukan harus dibalas terlebih dahulu',
                        ], REST_Controller::HTTP_OK);
                    }

                    if ($this->kerjasama_model->cek_penerimaan_rab_surat_kerjasama($id_kerjasama)) {
                        return $this->response([
                            'status' => "Gagal",
                            'message' => 'Tidak bisa mengajukan surat karena surat kerjasama sudah diterima',
                        ], REST_Controller::HTTP_OK);
                    }
                }

                if (!empty($_FILES['surat_file']['name'])) {
                    $surat_file = '';
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '/surat/';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $_FILES['surat_file']['name'] = $files['surat_file']['name'];
                    $_FILES['surat_file']['type'] = $files['surat_file']['type'];
                    $_FILES['surat_file']['tmp_name'] = $files['surat_file']['tmp_name'];
                    $_FILES['surat_file']['error'] = $files['surat_file']['error'];
                    $_FILES['surat_file']['size'] = $files['surat_file']['size'];

                    $config['upload_path']          = $filename;
                    $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('surat_file')) {
                        $error = array('error' => $this->upload->display_errors());

                        return $this->response([
                            "status"    => "Gagal",
                            "message"     => $error,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $upload_data = $this->upload->data();
                        $surat_file = $upload_data['file_name'];
                    }

                    $surat_rab = array(
                        "id_kerjasama" => $id_kerjasama,
                        "no_surat" => $no_surat,
                        "tanggal_surat" => $tanggal_surat,
                        "jenis_surat" => $jenis_surat,
                    );

                    if ($surat_file != '') {
                        $surat_rab['nama'] = $surat_file;
                    }

                    if ($this->rab_model->insert_surat_rab($surat_rab)) {
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
                        'status' => "Gagal",
                        'message' => 'Surat Harus Diisi Terlebih Dahulu',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function update_draft_post()
    {
        $id_kerjasama = $this->post("id_kerjasama");
        $id_draft = $this->post("id_draft");
        $id_cp = $this->post("id_cp");
        $jabatan = $this->post("jabatan");
        $nama_pj_univ = $this->post("nama_pj_univ");
        $draft_nomorp1 = $this->post("draft_nomorp1");
        $draft_nomorp2 = $this->post("draft_nomorp2");
        $draft_tanggal_mulai = $this->post("draft_tanggal_mulai");
        $draft_tanggal_akhir = $this->post("draft_tanggal_akhir");
        $draft_info = $this->post("draft_info");
        $draft_lokasi = $this->post("draft_lokasi");
        $draft_keterangan = $this->post("draft_keterangan");
        $ketua_tim = $this->post("ketua_tim");
        $draft_status = $this->post("draft_status");
        $pasal_1 = $this->post('pasal_1');
        $pasal_2 = $this->post('pasal_2');
        $pasal_3 = $this->post('pasal_3');
        $pasal_4 = $this->post('pasal_4');
        $pasal_5 = $this->post('pasal_5');
        $pasal_6 = $this->post('pasal_6');
        $pasal_7 = $this->post('pasal_7');
        $pasal_8 = $this->post('pasal_8');

        if ($this->kerjasama_model->cek_draft_kerjasama_by_id_kerjasama($id_kerjasama) && empty($id_draft)) {
            return $this->response([
                'status' => "Gagal",
                'message' => 'Draf Kerjasama Sudah Dibuat',
            ], REST_Controller::HTTP_OK);
        }

        if (
            !empty($draft_nomorp1)
        ) {
            $draft_file = '';
            if (!empty($_FILES['draft_file']['name'])) {
                $files = $_FILES;
                $dir = realpath(APPPATH . '../assets/uploads');
                $filename = $dir . '/draft/';

                if (!file_exists($filename)) {
                    mkdir($filename, 0775, true);
                }

                $_FILES['draft_file']['name'] = $files['draft_file']['name'];
                $_FILES['draft_file']['type'] = $files['draft_file']['type'];
                $_FILES['draft_file']['tmp_name'] = $files['draft_file']['tmp_name'];
                $_FILES['draft_file']['error'] = $files['draft_file']['error'];
                $_FILES['draft_file']['size'] = $files['draft_file']['size'];

                $config['upload_path']          = $filename;
                $config['allowed_types']        = 'pdf';
                $config['max_size']             = 1024 * 10;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('draft_file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data = array(
                        "status"    => "Gagal",
                        "pesan"     => $error,
                    );
                } else {
                    $upload_data = $this->upload->data();
                    $draft_file = $upload_data['file_name'];

                    if (!empty($id_draft)) {
                        $draft = array(
                            "id_cp" => $id_cp,
                            "draft_nomorp1" => $draft_nomorp1,
                            "draft_nomorp2" => $draft_nomorp2,
                            "draft_tanggal_mulai" => $draft_tanggal_mulai,
                            "draft_tanggal_akhir" => $draft_tanggal_akhir,
                            "draft_info" => $draft_info,
                            "draft_lokasi" => $draft_lokasi,
                            "draft_keterangan" => $draft_keterangan,
                            "ketua_tim" => $ketua_tim,
                            "draft_file" => $draft_file,
                            "draft_status" => $draft_status,
                        );

                        if ($this->kerjasama_model->update_draft_kerjasama($id_draft, $draft)) {
                            $bs_kerjasama = array(
                                "jabatan" => $jabatan,
                                "nama_pj_univ" => $nama_pj_univ,
                            );

                            if (!$this->kerjasama_model->update_base_setting_kerjasama($id_kerjasama, $bs_kerjasama)) {
                                return $this->response([
                                    'status' => "Gagal",
                                    'message' => 'Data Gagal Diupdate',
                                ], REST_Controller::HTTP_OK);
                            } else {
                                return $this->response([
                                    'status' => "Success",
                                    'message' => 'Data Berhasil Diupdate',
                                ], REST_Controller::HTTP_OK);
                            }
                        } else {
                            return $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }
                    } else {
                        $draft = array(
                            "id_kerjasama" => $id_kerjasama,
                            "id_cp" => $id_cp,
                            "draft_nomorp1" => $draft_nomorp1,
                            "draft_nomorp2" => $draft_nomorp2,
                            "draft_tanggal_mulai" => $draft_tanggal_mulai,
                            "draft_tanggal_akhir" => $draft_tanggal_akhir,
                            "draft_info" => $draft_info,
                            "draft_lokasi" => $draft_lokasi,
                            "draft_keterangan" => $draft_keterangan,
                            "ketua_tim" => $ketua_tim,
                            "draft_file" => $draft_file,
                            "draft_status" => $draft_status,
                        );

                        if ($this->kerjasama_model->insert_draft_kerjasama($draft)) {
                            $bs_kerjasama = array(
                                "id_kerjasama" => $id_kerjasama,
                                "id_base_setting" => 1,
                                "jabatan" => $jabatan,
                                "nama_pj_univ" => $nama_pj_univ,
                            );

                            if ($this->kerjasama_model->insert_base_setting_kerjasama($bs_kerjasama)) {
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
                                'status' => "Gagal",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                }
            } else {
                $dir_logo =  realpath(APPPATH . '../assets/uploads/logo');
                $dir_bs_logo =  realpath(APPPATH . '../assets/uploads/base_setting');
                if (!empty($id_draft)) {
                    $draft = array(
                        "id_cp" => $id_cp,
                        "draft_nomorp1" => $draft_nomorp1,
                        "draft_nomorp2" => $draft_nomorp2,
                        "draft_tanggal_mulai" => $draft_tanggal_mulai,
                        "draft_tanggal_akhir" => $draft_tanggal_akhir,
                        "draft_info" => $draft_info,
                        "draft_lokasi" => $draft_lokasi,
                        "draft_keterangan" => $draft_keterangan,
                        "ketua_tim" => $ketua_tim,
                        "draft_file" => $draft_file,
                        "draft_status" => $draft_status,
                    );

                    if ($this->kerjasama_model->update_draft_kerjasama($id_draft, $draft)) {
                        $arrpsl = [
                            '0' => $pasal_1,
                            '1' => $pasal_2,
                            '2' => $pasal_3,
                            '3' => $pasal_4,
                            '4' => $pasal_5,
                            '5' => $pasal_6,
                            '6' => $pasal_7,
                            '7' => $pasal_8,
                        ];

                        for ($i = 0; $i < 8; $i++) {
                            $pasal_kode = $i + 1;
                            $dat = [
                                'pasal_isi'   =>    $arrpsl[$i],
                            ];
                            $this->pasal_model->update_pasal($id_draft, $pasal_kode, $dat);
                        }

                        $bs_kerjasama = array(
                            "jabatan" => $jabatan,
                            "nama_pj_univ" => $nama_pj_univ,
                        );

                        if (!$this->kerjasama_model->update_base_setting_kerjasama($id_kerjasama, $bs_kerjasama)) {
                            return $this->response([
                                'status' => "Gagal",
                                'message' => 'Data Gagal Diupdate',
                            ], REST_Controller::HTTP_OK);
                        }

                        $title = "draft_kerjsama";
                        $base_setting = $this->base_setting_model->get_base_settings($id_kerjasama);
                        $cps_grab = $this->company_profile_status_model->get_company_profile_statuses();
                        $pasal = $this->pasal_model->get_pasals_by_id($id_draft);
                        $draft_company = $this->kerjasama_model->get_draft_cp_kerjasama($id_draft);

                        $data = array(
                            "title" => $title,
                            "cps_grab" => $cps_grab,
                            "pasal" => $pasal,
                            "cp_logo" => $dir_logo,
                            "bs_logo" => $dir_bs_logo,
                            "base_setting" => $base_setting,
                            "draft_company" => $draft_company,
                        );

                        $mpdf = new \Mpdf\Mpdf([
                            'mode' => 'utf-8',
                            'format' => 'A4',
                            'margin_left' => 24,
                            'margin_right' => 24,
                            'margin_header' => 0,
                            'margin_footer' => 0,
                            'margin-bottom'    => 20,
                            'margin-top'    => 20,
                            'orientation' => 'P',
                            'default_font_size' => 11,
                            'default_font' => 'Arial'
                        ]);

                        $filename = 'Draft_kerjasama_' . $data['draft_company'][0]->nama_perusahaan . '_' . $data['draft_company'][0]->draft_lokasi . '.pdf';
                        $path = 'assets/uploads/draft/' . $filename;
                        $data = $this->load->view('draft_pdf', $data, TRUE);
                        $mpdf->setFooter('aaa {PAGENO}');
                        $mpdf->WriteHTML($data);
                        $mpdf->Output($path, \Mpdf\Output\Destination::FILE);

                        $data_file = array(
                            "draft_file" => $filename
                        );

                        if ($this->kerjasama_model->update_file_draft_kerjasama($draft_company[0]->id, $data_file)) {
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
                            'status' => "Gagal",
                            'message' => 'Data Gagal Diupdate',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    if (empty($pasal_1)) {
                        $pasal_1 = '<h3>
                                <div style="text-align: center;">
                                    <span style="font-family: Arial; color: inherit;">
                                        PASAL 1
                                    </span>
                                </div>
                                <span style="font-family: Arial; color: inherit;">
                                    <div style="text-align: center;">
                                        <span style="color: inherit;">
                                            MAKSUD DAN TUJUAN
                                        </span>
                                    </div>
                                    <br>
                                </span>
                            </h3>
                            <h3>
                                <ol style="font-size: 13px;">
                                    <li style="text-align: left; margin-bottom: 0.0001pt; line-height: normal;">
                                        <span lang="IN" style="text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial;"><span style="font-weight: normal;">
                                        Nota Kesepahaman Bersama ini disusun dengan maksud untuk memberikan dasar hukum bagi </span>PARA PIHAK<span style="font-weight: normal;"> dalam melaksanakan kerjasama guna meningkatkan kemampuan segenap potensi dan sumber daya yang dimiliki </span>PARA PIHAK
                                    </span>
                                </li>
                                <li style="text-align: left; margin-bottom: 0.0001pt; line-height: normal;">
                                    <span lang="IN" style="text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial; font-weight: normal;">
                                    Nota Kesepahaman Bersama ini bertujuan untuk meningkatkan kualitas pelaksanaan tugas dan fungsi </span><span lang="IN" style="text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial;">PARA PIHAK</span><span lang="IN" style="text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial; font-weight: normal;"> sesuai kewenangan yang dimiliki
                                    </span>
                                </li>
                            </ol>
                        </h3>';
                    }

                    if (empty($pasal_2)) {
                        $pasal_2 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 2
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        RUANG
                                        LINGKUP KERJASAMA
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>';
                    }

                    if (empty($pasal_3)) {
                        $pasal_3 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 3
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        TUGAS PARA PIHAK
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>
                    
                        <div style="text-align: left;">
                            <span lang="IN" style="font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;"> 
                                <b>PARA PIHAK</b> dalam batas-batas kewenangan yang ada dan sumber daya yang tersedia akan saling menyediakan fasilitas yang diperlukan untuk pelaksanaan kerjasama sesuai dengan ruang lingkup kerjasama yang tersebut pada Pasal 2.
                            </span>
                            <br>
                        </div>';
                    }

                    if (empty($pasal_4)) {
                        $pasal_4 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 4
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>
                    
                        <div style="text-align: left;">
                            <span lang="IN" style="font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;"> 
                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.
                            </span>
                            <br>
                        </div>';
                    }

                    if (empty($pasal_5)) {
                        $pasal_5 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 5
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>
                    
                        <div style="text-align: left;">
                            <span lang="IN" style="font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;"> 
                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.
                            </span>
                            <br>
                        </div>';
                    }

                    if (empty($pasal_6)) {
                        $pasal_6 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 6
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>
                    
                        <div style="text-align: left;">
                            <span lang="IN" style="font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;"> 
                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.
                            </span>
                            <br>
                        </div>';
                    }

                    if (empty($pasal_7)) {
                        $pasal_7 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 7
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>
                    
                        <div style="text-align: left;">
                            <span lang="IN" style="font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;"> 
                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.
                            </span>
                            <br>
                        </div>';
                    }

                    if (empty($pasal_8)) {
                        $pasal_8 = '<h3>
                            <div style="text-align: center;">
                                <span style="font-family: Arial; color: inherit;">
                                    PASAL 8
                                </span>
                            </div>
                            <span style="font-family: Arial; color: inherit;">
                                <div style="text-align: center;">
                                    <span style="color: inherit;">
                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA
                                    </span>
                                </div>
                                <br>
                            </span>
                        </h3>
                    
                        <div style="text-align: left;">
                            <span lang="IN" style="font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;"> 
                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.
                            </span>
                            <br>
                        </div>';
                    }

                    $draft = array(
                        "id_kerjasama" => $id_kerjasama,
                        "id_cp" => $id_cp,
                        "draft_nomorp1" => $draft_nomorp1,
                        "draft_nomorp2" => $draft_nomorp2,
                        "draft_tanggal_mulai" => $draft_tanggal_mulai,
                        "draft_tanggal_akhir" => $draft_tanggal_akhir,
                        "draft_info" => $draft_info,
                        "draft_lokasi" => $draft_lokasi,
                        "draft_keterangan" => $draft_keterangan,
                        "ketua_tim" => $ketua_tim,
                        "draft_file" => $draft_file,
                        "draft_status" => $draft_status,
                    );

                    $this->kerjasama_model->insert_draft_kerjasama($draft);
                    $id_draft = $this->db->insert_id();

                    $bs_kerjasama = array(
                        "id_kerjasama" => $id_kerjasama,
                        "id_base_setting" => 1,
                        "jabatan" => $jabatan,
                        "nama_pj_univ" => $nama_pj_univ,
                    );

                    if (!$this->kerjasama_model->insert_base_setting_kerjasama($bs_kerjasama)) {
                        return $this->response([
                            'status' => "Gagal",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_OK);
                    }

                    $arrpsl = [
                        '0' => $pasal_1,
                        '1' => $pasal_2,
                        '2' => $pasal_3,
                        '3' => $pasal_4,
                        '4' => $pasal_5,
                        '5' => $pasal_6,
                        '6' => $pasal_7,
                        '7' => $pasal_8,
                    ];

                    for ($i = 0; $i < 8; $i++) {
                        $dat = [
                            'draft_id'    =>    $id_draft,
                            'pasal_kode'  =>    $i + 1,
                            'pasal_isi'   =>    $arrpsl[$i],
                        ];
                        $this->pasal_model->insert_pasal($dat);
                    }

                    $title = "draft_kerjsama";
                    $base_setting = $this->base_setting_model->get_base_settings($id_kerjasama);
                    $cps_grab = $this->company_profile_status_model->get_company_profile_statuses();
                    $pasal = $this->pasal_model->get_pasals_by_id($id_draft);
                    $draft_company = $this->kerjasama_model->get_draft_cp_kerjasama($id_draft);

                    $data = array(
                        "title" => $title,
                        "cps_grab" => $cps_grab,
                        "pasal" => $pasal,
                        "cp_logo" => $dir_logo,
                        "bs_logo" => $dir_bs_logo,
                        "base_setting" => $base_setting,
                        "draft_company" => $draft_company,
                    );

                    $mpdf = new \Mpdf\Mpdf([
                        'mode' => 'utf-8',
                        'format' => 'A4',
                        'margin_left' => 24,
                        'margin_right' => 24,
                        'margin_header' => 0,
                        'margin_footer' => 0,
                        'margin-bottom'    => 20,
                        'margin-top'    => 20,
                        'orientation' => 'P',
                        'default_font_size' => 11,
                        'default_font' => 'Arial'
                    ]);

                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '/draft/';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $filename = 'Draft_kerjasama_' . $data['draft_company'][0]->nama_perusahaan . '_' . $data['draft_company'][0]->draft_lokasi . '.pdf';
                    $path = 'assets/uploads/draft/' . $filename;
                    $data = $this->load->view('draft_pdf', $data, TRUE);
                    $mpdf->setFooter('aaa {PAGENO}');
                    $mpdf->WriteHTML($data);
                    $mpdf->Output($path, \Mpdf\Output\Destination::FILE);

                    $data_file = array(
                        "draft_file" => $filename
                    );

                    if ($this->kerjasama_model->update_file_draft_kerjasama($id_kerjasama, $data_file)) {
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
            return $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function bayar_post()
    {
        $id_pembayaran = $this->post("id_pembayaran");
        $nominal = $this->post("nominal");
        $tujuan_rekening = $this->post("tujuan_rekening");
        $tanggal = $this->post("tanggal");
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
                    $dir = realpath(APPPATH . '../assets/uploads');
                    $filename = $dir . '/bukti_pembayaran/';

                    if (!file_exists($filename)) {
                        mkdir($filename, 0775, true);
                    }

                    $_FILES['bukti_pembayaran']['name'] = $files['bukti_pembayaran']['name'];
                    $_FILES['bukti_pembayaran']['type'] = $files['bukti_pembayaran']['type'];
                    $_FILES['bukti_pembayaran']['tmp_name'] = $files['bukti_pembayaran']['tmp_name'];
                    $_FILES['bukti_pembayaran']['error'] = $files['bukti_pembayaran']['error'];
                    $_FILES['bukti_pembayaran']['size'] = $files['bukti_pembayaran']['size'];

                    $config['upload_path']          = $filename;
                    $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('bukti_pembayaran')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data = array(
                            "status"    => "Gagal",
                            "pesan"     => $error,
                        );

                        return $this->response([
                            'status' => "Gagal",
                            'message' => $error,
                        ], REST_Controller::HTTP_OK);
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
                            return $this->response([
                                'status' => "Success",
                                'message' => 'Pembayaran Berhasil',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return $this->response([
                                'status' => "Gagal",
                                'message' => 'Pembayaran Gagal',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                } else {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Bukti Pembayaran Harus Disertakan',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                return $this->response([
                    'status' => "Error",
                    'message' => 'Data Tidak Boleh Kosong',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function detail_post()
    {
        $id_detail = $this->post("id_detail");
        $judul_kegiatan = $this->post("judul_kegiatan");
        $project_hunter = $this->post("project_hunter");
        $ruang_lingkup = $this->post("ruang_lingkup");
        $deskripsi = $this->post("deskripsi");
        $lama_pekerjaan = $this->post("lama_pekerjaan");
        $satuan = $this->post("satuan");
        $tanggal_kontrak = $this->post("tanggal_kontrak");
        $tanggal_mulai = $this->post("tanggal_mulai");
        $metode_pembayaran = $this->post("metode_pembayaran");
        $jumlah_termin = $this->post("jumlah_termin");
        $nilai_kontrak = $this->post("nilai_kontrak");
        $no_surat = $this->post("no_surat");

        if (!empty($id_detail) && !empty($judul_kegiatan) && !empty($project_hunter) && !empty($ruang_lingkup) && !empty($deskripsi) && !empty($lama_pekerjaan) && !empty($satuan) && !empty($tanggal_kontrak) && !empty($tanggal_mulai) && !empty($metode_pembayaran) && !empty($nilai_kontrak)) {
            $surat_file = '';
            if (!empty($_FILES['surat_file']['name'])) {
                $files = $_FILES;
                $dir = realpath(APPPATH . '../assets/uploads');
                $filename = $dir . '/surat/';

                if (!file_exists($filename)) {
                    mkdir($filename, 0775, true);
                }

                $_FILES['surat_file']['name'] = $files['surat_file']['name'];
                $_FILES['surat_file']['type'] = $files['surat_file']['type'];
                $_FILES['surat_file']['tmp_name'] = $files['surat_file']['tmp_name'];
                $_FILES['surat_file']['error'] = $files['surat_file']['error'];
                $_FILES['surat_file']['size'] = $files['surat_file']['size'];

                $config['upload_path']          = $filename;
                $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                $config['max_size']             = 1024 * 10;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('surat_file')) {
                    $error = array('error' => $this->upload->display_errors());

                    return $this->response([
                        "status"    => "Gagal",
                        "message"     => $error,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $upload_data = $this->upload->data();
                    $surat_file = $upload_data['file_name'];
                }
            }

            if ($metode_pembayaran == 'sekaligus') {
                $jumlah_termin = 0;
            } else {
                if (empty($jumlah_termin)) {
                    $jumlah_termin = 1;
                }
            }

            if ($satuan == 'bulan') {
                $tanggal_akhir = date('Y-m-d', strtotime($tanggal_mulai . ' + ' . $lama_pekerjaan . ' month'));
            } else {
                $tanggal_akhir = date('Y-m-d', strtotime($tanggal_mulai . ' + ' . $lama_pekerjaan . ' days'));
            }

            $kerjasama = array(
                "judul_kegiatan" => $judul_kegiatan,
                "project_hunter" => $project_hunter,
                "ruang_lingkup" => $ruang_lingkup,
                "deskripsi" => $deskripsi,
                "lama_pekerjaan" => $lama_pekerjaan,
                "satuan" => $satuan,
                "tanggal_kontrak" => $tanggal_kontrak,
                "tanggal_mulai" => $tanggal_mulai,
                "tanggal_akhir" => $tanggal_akhir,
                "metode_pembayaran" => $metode_pembayaran,
                "jumlah_termin" => $jumlah_termin,
                "nilai_kontrak" => $nilai_kontrak,
                "no_surat" => $no_surat,
                "status" => "usul",
            );

            if (!empty($surat_file)) {
                $kerjasama["surat_penawaran"] = $surat_file;
            }

            if ($this->kerjasama_model->update_detail_kerjasama($id_detail, $kerjasama)) {
                $this->response([
                    'status' => "Success",
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
        $id_kerjasama = $this->put("id_kerjasama");
        $status = $this->put("status");

        if (!empty($status)) {
            $kerjasama = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_status_detail_kerjasama($id_kerjasama, $kerjasama)) {
                $status_detail = $this->kerjasama_model->get_status_detail_kerjasama($id_kerjasama);
                $status_rab = $this->kerjasama_model->get_status_rab_kerjasama($id_kerjasama);

                if ($status_detail[0]->status == 'disetujui' && count($status_rab) > 0) {
                    if ($status_rab[0]->status == 'disetujui') {
                        $kerjasama = array(
                            "status" => "draft",
                        );
                    } else {
                        $kerjasama = array(
                            "status" => "usul",
                        );
                    }
                } else {
                    $kerjasama = array(
                        "status" => "usul",
                    );
                }

                if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                    return $this->response([
                        'status' => "Success",
                        'message' => 'Data Berhasil Diupdate',
                    ], REST_Controller::HTTP_OK);
                } else {
                    return $this->response([
                        'status' => "Gagal",
                        'message' => 'Data Gagal Diupdate',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                return $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_rab_put()
    {
        $id_kerjasama = $this->put("id_kerjasama");
        $status = $this->put("status");

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
                        'status' => "Success",
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

    public function update_status_rab_surat_put()
    {
        $id_surat = $this->put("id_surat");
        $status = $this->put("status");

        if (!empty($status)) {
            $kerjasama = array(
                "status_surat" => $status,
            );

            if ($this->kerjasama_model->update_status_rab_surat_kerjasama($id_surat, $kerjasama)) {
                return $this->response([
                    'status' => "Success",
                    'message' => 'Data Berhasil Diupdate',
                ], REST_Controller::HTTP_OK);
            } else {
                return $this->response([
                    'status' => "Gagal",
                    'message' => 'Data Gagal Diupdate',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_draft_put()
    {
        $id_kerjasama = $this->put("id_kerjasama");
        $status = $this->put("status");

        if (!empty($status)) {
            $draft = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_status_draft_kerjasama($id_kerjasama, $draft)) {
                $status_draft = $this->kerjasama_model->get_status_draft_kerjasama($id_kerjasama);

                if ($status_draft[0]->status == 'disetujui') {
                    $kerjasama = array(
                        "status" => "disetujui",
                    );
                } else {
                    $kerjasama = array(
                        "status" => "draft",
                    );
                }

                if ($this->kerjasama_model->update_status_kerjasama($id_kerjasama, $kerjasama)) {
                    $detail = $this->kerjasama_model->get_detail_kerjasama($id_kerjasama);
                    if ($kerjasama['status'] == 'disetujui') {
                        if ($this->kerjasama_model->cek_pembayaran_kerjasama($id_kerjasama)) {
                            $this->response([
                                'status' => "Gagal",
                                'message' => 'Kerjasama sudah disetujui dan dibayar',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            $this->kerjasama_model->hapus_pembayaran($id_kerjasama);

                            if ($detail[0]->metode_pembayaran == 'sekaligus') {
                                $pembayaran = array(
                                    "id_kerjasama" => $id_kerjasama,
                                );

                                if ($this->kerjasama_model->insert_pembayaran_kerjasama($pembayaran)) {
                                    $this->response([
                                        'status' => "Success",
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
                                        'status' => "Success",
                                        'message' => 'Data Berhasil Diupdate',
                                    ], REST_Controller::HTTP_OK);
                                } else {
                                    $this->response([
                                        'status' => "Gagal",
                                        'message' => 'Data Gagal Diupdate',
                                    ], REST_Controller::HTTP_OK);
                                }
                            }
                        }
                    } else {
                        if ($this->kerjasama_model->hapus_pembayaran($id_kerjasama)) {
                            $this->response([
                                'status' => "Success",
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
        $id_pembayaran = $this->put("id_pembayaran");
        $status = $this->put("status");

        if (!empty($status)) {
            $pembayaran = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_pembayaran_kerjasama($id_pembayaran, $pembayaran)) {
                $this->response([
                    'status' => "Success",
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
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
