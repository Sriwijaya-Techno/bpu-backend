<?php

require APPPATH . 'libraries/REST_Controller.php';

class Company extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/company_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
    }

    public function index_post()
    {
        $user_id = $this->security->xss_clean($this->post("user_id"));
        $nama_perusahaan = $this->security->xss_clean($this->post("nama_perusahaan"));
        $alamat_email = $this->security->xss_clean($this->post("alamat_email"));
        $telepon = $this->security->xss_clean($this->post("telepon"));
        $alamat_perusahaan = $this->security->xss_clean($this->post("alamat_perusahaan"));
        $visi_misi = $this->security->xss_clean($this->post("visi_misi"));

        $this->form_validation->set_rules("user_id", "User_id", "required");
        $this->form_validation->set_rules("nama_perusahaan", "Nama_perusahaan", "required");
        $this->form_validation->set_rules("alamat_email", "Alamat_email", "required|valid_email");
        $this->form_validation->set_rules("telepon", "Telepon", "required");
        $this->form_validation->set_rules("alamat_perusahaan", "Alamat_perusahaan", "required");
        $this->form_validation->set_rules("visi_misi", "Visi_misi", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => "Error",
                'message' => 'Data Gagal Divalidasi',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($user_id) && !empty($nama_perusahaan) && !empty($alamat_email) && !empty($telepon) && !empty($alamat_perusahaan) && !empty($visi_misi)) {
                if (!empty($_FILES['logo']['name'])) {
                    $files = $_FILES;
                    $dir = realpath(APPPATH . '../assets/uploads/logo');

                    $_FILES['logo']['name'] = $files['logo']['name'];
                    $_FILES['logo']['type'] = $files['logo']['type'];
                    $_FILES['logo']['tmp_name'] = $files['logo']['tmp_name'];
                    $_FILES['logo']['error'] = $files['logo']['error'];
                    $_FILES['logo']['size'] = $files['logo']['size'];

                    $config['upload_path']          = $dir;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['max_size']             = 1024 * 10;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('logo')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data = array(
                            "status"    => "Gagal",
                            "pesan"     => $error,
                        );
                    } else {
                        $upload_data = $this->upload->data();

                        $company = array(
                            "user_id" => $user_id,
                            "nama_perusahaan" => $nama_perusahaan,
                            "alamat_email" => $alamat_email,
                            "telepon" => $telepon,
                            "alamat_perusahaan" => $alamat_perusahaan,
                            "logo" => $upload_data['file_name'],
                            "visi_misi" => $visi_misi,
                        );

                        if ($this->company_model->insert_company_profile($company)) {
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
                    }
                } else {
                    $company = array(
                        "user_id" => $user_id,
                        "nama_perusahaan" => $nama_perusahaan,
                        "alamat_email" => $alamat_email,
                        "telepon" => $telepon,
                        "alamat_perusahaan" => $alamat_perusahaan,
                        "visi_misi" => $visi_misi,
                    );

                    if ($this->company_model->insert_company_profile($company)) {
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
        $user_id = $this->security->xss_clean($this->get("user_id"));

        if (!empty($user_id)) {
            $company_profiles = $this->company_model->get_company_profile_by_user_id($user_id);
            $this->response([
                'status' => "Success",
                'message' => 'Data Berhasil Dimuat',
                'data' => $company_profiles,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => "Error",
                'message' => 'Input Tidak Boleh Kosong',
            ], REST_Controller::HTTP_OK);
        }
    }
}
