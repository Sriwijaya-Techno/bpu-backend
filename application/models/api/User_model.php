<?php

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_users()
    {

        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("status_data", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_user_by_email($email)
    {

        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email", $email);
        $this->db->where("status_data", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_user_by_id($id)
    {

        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("id", $id);
        $this->db->where("status_data", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_user_by_username($username)
    {

        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("username", $username);
        $this->db->where("status_data", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_user_by_email_password($email, $password)
    {
        $this->db->where("email", $email);
        $this->db->where("password", $password);
        $this->db->where("status_data", "ditampilkan");
        $data = $this->db->get("user");
        return $data->row();
    }

    public function login($email, $password)
    {

        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email", $email);
        $this->db->where("password", $password);
        $this->db->where("status_data", "ditampilkan");
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_user($data = array())
    {
        return $this->db->insert("user", $data);
    }

    public function delete_user($user_id)
    {
        $this->db->where("id", $user_id);
        return $this->db->delete("user");
    }

    public function update_user_information($id, $informations)
    {
        $this->db->where("id", $id);
        return $this->db->update("user", $informations);
    }
}
