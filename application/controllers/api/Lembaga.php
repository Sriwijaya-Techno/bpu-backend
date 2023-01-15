<?php

require APPPATH . 'libraries/REST_Controller.php';

class Lembaga extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/lembaga_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $lembaga_nama = $this->security->xss_clean($this->post("lembaga_nama"));
        $lj_id = $this->security->xss_clean($this->post("lj_id"));
        $lembaga_pimpinan_nama = $this->security->xss_clean($this->post("lembaga_pimpinan_nama"));
        $ls_id = $this->security->xss_clean($this->post("ls_id"));
        $lembaga_lat = $this->security->xss_clean($this->post("lembaga_lat"));
        $lembaga_lng = $this->security->xss_clean($this->post("lembaga_lng"));
        $lembaga_address = $this->security->xss_clean($this->post("lembaga_address"));
        $tanggal_mulai = $this->security->xss_clean($this->post("tanggal_mulai"));
        $tanggal_berakhir = $this->security->xss_clean($this->post("tanggal_berakhir"));
        $lembaga_country_id = $this->security->xss_clean($this->post("lembaga_country_id"));
        $lembaga_country = $this->security->xss_clean($this->post("lembaga_country"));
        $lembaga_provinsi_id = $this->security->xss_clean($this->post("lembaga_provinsi_id"));
        $this->form_validation->set_rules("lembaga_nama", "Lembaga_nama", "required");
        $this->form_validation->set_rules("lj_id", "Lj_id", "required");
        $this->form_validation->set_rules("lembaga_pimpinan_nama", "Lembaga_pimpinan_nama", "required");
        $this->form_validation->set_rules("ls_id", "Ls_id", "required");
        $this->form_validation->set_rules("lembaga_lat", "Lembaga_lat", "required");
        $this->form_validation->set_rules("lembaga_lng", "Lembaga_lng", "required");
        $this->form_validation->set_rules("lembaga_address", "Lembaga_address", "required");
        $this->form_validation->set_rules("tanggal_mulai", "Tanggal_mulai", "required");
        $this->form_validation->set_rules("tanggal_berakhir", "Tanggal_berakhir", "required");
        $this->form_validation->set_rules("lembaga_country_id", "Lembaga_country_id", "required");
        $this->form_validation->set_rules("lembaga_country", "Lembaga_country", "required");
        $this->form_validation->set_rules("lembaga_provinsi_id", "Lembaga_provinsi_id", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_OK);
        } else {
            if (
                !empty($lembaga_nama) && !empty($lj_id) && !empty($lembaga_pimpinan_nama) && !empty($ls_id) &&
                !empty($lembaga_lat) && !empty($lembaga_lng) && !empty($lembaga_address) && !empty($tanggal_mulai) &&
                !empty($tanggal_berakhir) && !empty($lembaga_country_id) && !empty($lembaga_country) && !empty($lembaga_provinsi_id)
            ) {
                if (!empty($_FILES['lembaga_logo']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads/lembaga_logo');

                    $_FILES['lembaga_logo']['name'] = $files['lembaga_logo']['name'];
                    $_FILES['lembaga_logo']['type'] = $files['lembaga_logo']['type'];
                    $_FILES['lembaga_logo']['tmp_name'] = $files['lembaga_logo']['tmp_name'];
                    $_FILES['lembaga_logo']['error'] = $files['lembaga_logo']['error'];
                    $_FILES['lembaga_logo']['size'] = $files['lembaga_logo']['size'];

                    $config['upload_path']          = $dir;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('lembaga_logo')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data = array(
                            "status"    => "Gagal",
                            "pesan"     => $error,
                        );
                    } else {
                        $upload_data = $this->upload->data();
                        $lembaga_logo = $upload_data['file_name'];
                        $lembaga = array(
                            "lembaga_nama" => $lembaga_nama,
                            "lj_id" => $lj_id,
                            "lembaga_pimpinan_nama" => $lembaga_pimpinan_nama,
                            "ls_id" => $ls_id,
                            "lembaga_lat" => $lembaga_lat,
                            "lembaga_lng" => $lembaga_lng,
                            "lembaga_address" => $lembaga_address,
                            "tanggal_mulai" => $tanggal_mulai,
                            "tanggal_berakhir" => $tanggal_berakhir,
                            "lembaga_country_id" => $lembaga_country_id,
                            "lembaga_country" => $lembaga_country,
                            "lembaga_provinsi_id" => $lembaga_provinsi_id,
                            "lembaga_logo" => $lembaga_logo,
                        );

                        if ($this->lembaga_model->insert_lembaga($lembaga)) {
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
                    $this->response([
                        'status' => "Gagal",
                        'message' => 'Data File Lembaga Logo Harus Diisi',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => "Error",
                    'message' => 'Data Gagal Ditambah',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_get()
    {
        $lembagas = $this->lembaga_model->get_lembagas();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $lembagas,
        ], 200);
    }
}
