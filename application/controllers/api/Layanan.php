<?php

require APPPATH . 'libraries/REST_Controller.php';

class Layanan extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/layanan_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $nama = $this->security->xss_clean($this->post("nama"));
        $this->form_validation->set_rules("nama", "Nama", "required");
        if ($this->form_validation->run() === FALSE) {
            return $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Ditambah',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($nama)) {
                if (!empty($_FILES['icon_layanan']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads/icon_layanan');

                    $_FILES['icon_layanan']['name'] = $files['icon_layanan']['name'];
                    $_FILES['icon_layanan']['type'] = $files['icon_layanan']['type'];
                    $_FILES['icon_layanan']['tmp_name'] = $files['icon_layanan']['tmp_name'];
                    $_FILES['icon_layanan']['error'] = $files['icon_layanan']['error'];
                    $_FILES['icon_layanan']['size'] = $files['icon_layanan']['size'];

                    $config['upload_path']          = $dir;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('icon_layanan')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data = array(
                            "status"    => "Gagal",
                            "pesan"     => $error,
                        );
                    } else {
                        $upload_data = $this->upload->data();
                        $layanan = array(
                            "nama" => $nama,
                            "icon" => $upload_data['file_name'],
                        );

                        if ($this->layanan_model->insert_layanan($layanan)) {
                            return $this->response([
                                'status' => "Sukses",
                                'message' => 'Data Berhasil Ditambah',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            return $this->response([
                                'status' => "Error",
                                'message' => 'Data Gagal Ditambah',
                            ], REST_Controller::HTTP_BAD_REQUEST);
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
                    'message' => 'Data Gagal Ditambah',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_get()
    {
        $users = $this->layanan_model->get_layanans();

        $this->response([
            'status' => "Success",
            'message' => 'Data Berhasil Dimuat',
            'data' => $users,
        ], 200);
    }
}
