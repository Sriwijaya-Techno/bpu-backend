<?php

require APPPATH . 'libraries/REST_Controller.php';

class Kerjasama extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/kerjasama_model", "api/rab_model", "api/pasal_model", "api/base_setting_model", "api/lembaga_status_model", "api/lembaga_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_get()
    {
        $user_id = $this->get("user_id");

        if (!empty($user_id)) {
            $kerjasama = $this->kerjasama_model->get_kerjasamas_by_id($user_id);

            print_r($kerjasama);

            for ($i = 0; $i < count($kerjasama); $i++) {
                if ($kerjasama[$i]->status != 'disetujui') {
                    $kerjasama[$i]->tanggal_mulai = '-';
                    $kerjasama[$i]->tanggal_akhir = '-';
                    $kerjasama[$i]->nilai_kontrak = '-';
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

    public function draft_get()
    {
        $id_kerjasama = $this->get("id_kerjasama");

        if (!empty($id_kerjasama)) {
            $dir_draft = realpath(APPPATH . '../assets/uploads/draft');
            $dir_lembaga_logo =  realpath(APPPATH . '../assets/uploads/lembaga_logo');
            $dir_bs_logo =  realpath(APPPATH . '../assets/uploads/base_setting');

            $base_setting = $this->base_setting_model->get_base_settings();
            for ($i = 0; $i < count($base_setting); $i++) {
                $base_setting[$i]->bs_logo = $dir_bs_logo . '\\' . $base_setting[$i]->bs_logo;
            }

            $lembaga = $this->lembaga_model->get_lembagas();
            for ($i = 0; $i < count($lembaga); $i++) {
                $lembaga[$i]->lembaga_logo = $dir_lembaga_logo . '\\' . $lembaga[$i]->lembaga_logo;
            }

            $draft = $this->kerjasama_model->get_draft_kerjasama($id_kerjasama);
            for ($i = 0; $i < count($draft); $i++) {
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
                "lembaga" => $lembaga,
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
        $id_kerjasama = $this->get("id_kerjasama");

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
        $id_item_kategori = $this->post("id_item_kategori");
        $user_id = $this->post("user_id");
        $nomor = $this->post("nomor");
        $this->form_validation->set_rules("id_item_kategori", "Id_item_kategori", "required");
        $this->form_validation->set_rules("user_id", "User_id", "required");
        $this->form_validation->set_rules("nomor", "Nomor", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($id_item_kategori) && !empty($user_id) && !empty($nomor)) {
                $kerjasama = array(
                    "id_item_kategori" => $id_item_kategori,
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
        $id_kerjasama = $this->post("id_kerjasama");
        $nama = $this->post("nama");
        $satuan = $this->post("satuan");
        $volume = $this->post("volume");
        $harga = $this->post("harga");
        $total = $this->post("total");
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
                            'status' => "Gagal",
                            'message' => 'Data Gagal Ditambah',
                        ], REST_Controller::HTTP_OK);
                    }
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
        $id_kerjasama = $data->id_kerjasama;
        $data_rabs = $data->rab;

        for ($i = 0; $i < count($data_rabs); $i++) {
            if ($data_rabs[$i]->id_rab != 0) {
                $rab = array(
                    "nama" => $data_rabs[$i]->nama,
                    "satuan" => $data_rabs[$i]->satuan,
                    "volume" => $data_rabs[$i]->volume,
                    "harga" => $data_rabs[$i]->harga,
                    "total" => $data_rabs[$i]->total,
                );

                if ($this->rab_model->update_rab($data_rabs[$i]->id_rab, $rab)) {
                    $rab_kerjasama = array(
                        "status" => "usul",
                    );
                    if (!$this->kerjasama_model->update_rab_kerjasama($id_kerjasama, $data_rabs[$i]->id_rab, $rab_kerjasama)) {
                        $this->response([
                            'status' => "Gagal",
                            'message' => 'Gagal Mengolah Data',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
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
                if ($rab_kerjasama[$i]->id_rab == $data_rabs[$j]->id_rab) {
                    $id_data_exist = true;
                }
            }

            if (!$id_data_exist) {
                if (!$this->kerjasama_model->delete_rab_kerjasama($rab_kerjasama[$i]->id_kerjasama, $rab_kerjasama[$i]->id_rab)) {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengolah Data',
                    ], REST_Controller::HTTP_OK);
                }

                if (!$this->rab_model->delete_rab($rab_kerjasama[$i]->id_rab)) {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengolah Data',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        for ($i = 0; $i < count($data_rabs); $i++) {
            if ($data_rabs[$i]->id_rab == 0) {
                $rab = array(
                    "nama" => $data_rabs[$i]->nama,
                    "satuan" => $data_rabs[$i]->satuan,
                    "volume" => $data_rabs[$i]->volume,
                    "harga" => $data_rabs[$i]->harga,
                    "total" => $data_rabs[$i]->total,
                );

                if ($this->rab_model->insert_rab($rab)) {
                    $id_rab = $this->db->insert_id();
                    $rab_kerjasama = array(
                        "id_kerjasama" => $id_kerjasama,
                        "id_rab" => $id_rab,
                    );

                    if (!$this->kerjasama_model->insert_rab_kerjasama($rab_kerjasama)) {
                        $this->response([
                            'status' => "Gagal",
                            'message' => 'Gagal Mengolah Data',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Gagal Mengolah Data',
                    ], REST_Controller::HTTP_OK);
                }
            }
        }

        $this->response([
            'status' => "Sukses",
            'message' => 'Data Berhasil Diupdate',
        ], REST_Controller::HTTP_OK);
    }

    public function draft_post()
    {
        $id_kerjasama = $this->post("id_kerjasama");
        $id_lembaga = $this->post("id_lembaga");
        $draft_nomorp1 = $this->post("draft_nomorp1");
        $draft_nomorp2 = $this->post("draft_nomorp2");
        $draft_tanggal_mulai = $this->post("draft_tanggal_mulai");
        $draft_info = $this->post("draft_info");
        $draft_lokasi = $this->post("draft_lokasi");
        $draft_keterangan = $this->post("draft_keterangan");
        $draft_status = $this->post("draft_status");
        $pasal_1 = $this->post('pasal_1');
        $pasal_3 = $this->post('pasal_3');
        $pasal_4 = $this->post('pasal_4');
        $pasal_5 = $this->post('pasal_5');
        $pasal_6 = $this->post('pasal_6');
        $pasal_7 = $this->post('pasal_7');
        $pasal_8 = $this->post('pasal_8');

        if (
            !empty($draft_nomorp1) && !empty($id_lembaga) && !empty($draft_nomorp2) && !empty($draft_tanggal_mulai) &&
            !empty($draft_info) && !empty($draft_lokasi) && !empty($draft_keterangan) && !empty($draft_status) &&
            !empty($id_kerjasama)
        ) {
            $draft_file = '';
            if (!empty($_FILES['draft_file']['name'])) {
                $files = $_FILES;
                $dir = realpath(APPPATH . '../assets/uploads/draft');

                $_FILES['draft_file']['name'] = $files['draft_file']['name'];
                $_FILES['draft_file']['type'] = $files['draft_file']['type'];
                $_FILES['draft_file']['tmp_name'] = $files['draft_file']['tmp_name'];
                $_FILES['draft_file']['error'] = $files['draft_file']['error'];
                $_FILES['draft_file']['size'] = $files['draft_file']['size'];

                $config['upload_path']          = $dir;
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

                    $draft = array(
                        "id_kerjasama" => $id_kerjasama,
                        "id_lembaga" => $id_lembaga,
                        "draft_nomorp1" => $draft_nomorp1,
                        "draft_nomorp2" => $draft_nomorp2,
                        "draft_tanggal_mulai" => $draft_tanggal_mulai,
                        "draft_info" => $draft_info,
                        "draft_lokasi" => $draft_lokasi,
                        "draft_keterangan" => $draft_keterangan,
                        "draft_file" => $draft_file,
                        "draft_status" => $draft_status,
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
                        ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                if (
                    !empty($pasal_1) && !empty($pasal_3) && !empty($pasal_4) &&
                    !empty($pasal_5) && !empty($pasal_6) && !empty($pasal_7) && !empty($pasal_8)
                ) {
                    $checklist = json_decode($this->post("checklist"))->checklist;
                    $draft = array(
                        "id_kerjasama" => $id_kerjasama,
                        "id_lembaga" => $id_lembaga,
                        "draft_nomorp1" => $draft_nomorp1,
                        "draft_nomorp2" => $draft_nomorp2,
                        "draft_tanggal_mulai" => $draft_tanggal_mulai,
                        "draft_info" => $draft_info,
                        "draft_lokasi" => $draft_lokasi,
                        "draft_keterangan" => $draft_keterangan,
                        "draft_file" => $draft_file,
                        "draft_status" => $draft_status,
                    );

                    $this->kerjasama_model->insert_draft_kerjasama($draft);
                    $id_draft = $this->db->insert_id();

                    $ch = [];
                    foreach ($checklist as $checkbox) {
                        $ch[] = $checkbox;
                    }

                    $pasal_2 = implode('#@#', $ch);

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

                    for ($i = 0; $i < 7; $i++) {
                        $dat = [
                            'draft_id'    =>    $id_draft,
                            'pasal_kode'  =>    $i + 1,
                            'pasal_isi'   =>    $arrpsl[$i],
                        ];
                        $this->pasal_model->insert_pasal($dat);
                    }

                    $title = "draft_kerjsama";
                    $base_setting = $this->base_setting_model->get_base_settings();
                    $ls_grab = $this->lembaga_status_model->get_lembaga_statuses();
                    $pasal = $this->pasal_model->get_pasals_by_id($id_draft);
                    $draft_lembaga = $this->kerjasama_model->get_draft_lembaga_kerjasama($id_draft);

                    $data = array(
                        "title" => $title,
                        "ls_grab" => $ls_grab,
                        "pasal" => $pasal,
                        "base_setting" => $base_setting,
                        "draft_lembaga" => $draft_lembaga,
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

                    $filename = 'Draft_ kerjasama_' . $data['draft_lembaga'][0]->lembaga_nama . '_' . $data['draft_lembaga'][0]->draft_lokasi . '.pdf';
                    $path = 'assets/uploads/draft/' . $filename;
                    $data = $this->load->view('draft_pdf', $data, TRUE);
                    $mpdf->setFooter('aaa {PAGENO}');
                    $mpdf->WriteHTML($data);
                    $mpdf->Output($path, \Mpdf\Output\Destination::FILE);

                    $data_file = array(
                        "draft_file" => $filename
                    );

                    if ($this->kerjasama_model->update_file_draft_kerjasama($id_kerjasama, $data_file)) {
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
                        'status' => "Gagal",
                        'message' => 'Data Gagal Ditambah',
                    ], REST_Controller::HTTP_OK);
                }
            }
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_draft_post()
    {
        $id_draft = $this->post("id_draf");
        $id_lembaga = $this->post("id_lembaga");
        $draft_nomorp1 = $this->post("draft_nomorp1");
        $draft_nomorp2 = $this->post("draft_nomorp2");
        $draft_tanggal_mulai = $this->post("draft_tanggal_mulai");
        $draft_info = $this->post("draft_info");
        $draft_lokasi = $this->post("draft_lokasi");
        $draft_keterangan = $this->post("draft_keterangan");
        $draft_status = $this->post("draft_status");
        $pasal_1 = $this->post('pasal_1');
        $pasal_3 = $this->post('pasal_3');
        $pasal_4 = $this->post('pasal_4');
        $pasal_5 = $this->post('pasal_5');
        $pasal_6 = $this->post('pasal_6');
        $pasal_7 = $this->post('pasal_7');
        $pasal_8 = $this->post('pasal_8');

        if (
            !empty($draft_nomorp1) && !empty($id_lembaga) && !empty($draft_nomorp2) && !empty($draft_tanggal_mulai) &&
            !empty($draft_info) && !empty($draft_lokasi) && !empty($draft_keterangan) && !empty($draft_status) &&
            !empty($id_draft)
        ) {
            $draft_file = '';
            if (!empty($_FILES['draft_file']['name'])) {
                $files = $_FILES;
                $dir = realpath(APPPATH . '../assets/uploads/draft');

                $_FILES['draft_file']['name'] = $files['draft_file']['name'];
                $_FILES['draft_file']['type'] = $files['draft_file']['type'];
                $_FILES['draft_file']['tmp_name'] = $files['draft_file']['tmp_name'];
                $_FILES['draft_file']['error'] = $files['draft_file']['error'];
                $_FILES['draft_file']['size'] = $files['draft_file']['size'];

                $config['upload_path']          = $dir;
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

                    $draft = array(
                        "id_lembaga" => $id_lembaga,
                        "draft_nomorp1" => $draft_nomorp1,
                        "draft_nomorp2" => $draft_nomorp2,
                        "draft_tanggal_mulai" => $draft_tanggal_mulai,
                        "draft_info" => $draft_info,
                        "draft_lokasi" => $draft_lokasi,
                        "draft_keterangan" => $draft_keterangan,
                        "draft_file" => $draft_file,
                        "draft_status" => $draft_status,
                    );

                    if ($this->kerjasama_model->update_draft_kerjasama($id_draft, $draft)) {
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
                if (
                    !empty($pasal_1) && !empty($pasal_3) && !empty($pasal_4) &&
                    !empty($pasal_5) && !empty($pasal_6) && !empty($pasal_7) && !empty($pasal_8)
                ) {
                    $checklist = json_decode($this->post("checklist"))->checklist;
                    $draft = array(
                        "id_lembaga" => $id_lembaga,
                        "draft_nomorp1" => $draft_nomorp1,
                        "draft_nomorp2" => $draft_nomorp2,
                        "draft_tanggal_mulai" => $draft_tanggal_mulai,
                        "draft_info" => $draft_info,
                        "draft_lokasi" => $draft_lokasi,
                        "draft_keterangan" => $draft_keterangan,
                        "draft_file" => $draft_file,
                        "draft_status" => $draft_status,
                    );

                    if ($this->kerjasama_model->update_draft_kerjasama($id_draft, $draft)) {
                        $ch = [];
                        foreach ($checklist as $checkbox) {
                            $ch[] = $checkbox;
                        }

                        $pasal_2 = implode('#@#', $ch);

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

                        for ($i = 0; $i < 7; $i++) {
                            $pasal_kode = $i + 1;
                            $dat = [
                                'pasal_isi'   =>    $arrpsl[$i],
                            ];
                            $this->pasal_model->update_pasal($id_draft, $pasal_kode, $dat);
                        }

                        $title = "draft_kerjsama";
                        $base_setting = $this->base_setting_model->get_base_settings();
                        $ls_grab = $this->lembaga_status_model->get_lembaga_statuses();
                        $pasal = $this->pasal_model->get_pasals_by_id($id_draft);
                        $draft_lembaga = $this->kerjasama_model->get_draft_lembaga_kerjasama($id_draft);

                        $data = array(
                            "title" => $title,
                            "ls_grab" => $ls_grab,
                            "pasal" => $pasal,
                            "base_setting" => $base_setting,
                            "draft_lembaga" => $draft_lembaga,
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

                        $filename = 'Draft_ kerjasama_' . $data['draft_lembaga'][0]->lembaga_nama . '_' . $data['draft_lembaga'][0]->draft_lokasi . '.pdf';
                        $path = 'assets/uploads/draft/' . $filename;
                        $data = $this->load->view('draft_pdf', $data, TRUE);
                        $mpdf->setFooter('aaa {PAGENO}');
                        $mpdf->WriteHTML($data);
                        $mpdf->Output($path, \Mpdf\Output\Destination::FILE);

                        $data_file = array(
                            "draft_file" => $filename
                        );

                        if ($this->kerjasama_model->update_file_draft_kerjasama($draft_lembaga[0]->id, $data_file)) {
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
            }
        } else {
            $this->response([
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
        $id_detail = $this->put("id_detail");
        $judul_kegiatan = $this->put("judul_kegiatan");
        $ruang_lingkup = $this->put("ruang_lingkup");
        $deskripsi = $this->put("deskripsi");
        $lama_pekerjaan = $this->put("lama_pekerjaan");
        $tanggal_mulai = $this->put("tanggal_mulai");
        $metode_pembayaran = $this->put("metode_pembayaran");
        $jumlah_termin = $this->put("jumlah_termin");
        $nilai_kontrak = $this->put("nilai_kontrak");

        if (!empty($id_detail) && !empty($judul_kegiatan) && !empty($ruang_lingkup) && !empty($deskripsi) && !empty($lama_pekerjaan) && !empty($tanggal_mulai) && !empty($metode_pembayaran) && !empty($nilai_kontrak)) {
            if ($metode_pembayaran == 'sekaligus') {
                $jumlah_termin = 0;
            } else {
                if (empty($jumlah_termin)) {
                    $jumlah_termin = 1;
                }
            }

            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_mulai . ' + ' . $lama_pekerjaan . ' days'));
            $kerjasama = array(
                "judul_kegiatan" => $judul_kegiatan,
                "ruang_lingkup" => $ruang_lingkup,
                "deskripsi" => $deskripsi,
                "lama_pekerjaan" => $lama_pekerjaan,
                "tanggal_mulai" => $tanggal_mulai,
                "tanggal_akhir" => $tanggal_akhir,
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
        $id_kerjasama = $this->put("id_kerjasama");
        $status = $this->put("status");

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
        $id_pembayaran = $this->put("id_pembayaran");
        $status = $this->put("status");

        if (!empty($status)) {
            $pembayaran = array(
                "status" => $status,
            );

            if ($this->kerjasama_model->update_pembayaran_kerjasama($id_pembayaran, $pembayaran)) {
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
                'status' => "Error",
                'message' => 'Data Tidak Boleh Kosong',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
