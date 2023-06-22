<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct()
    {
		parent::__construct();
        $this->load->model('Model_login');
	}

    function index()
    {
        $data['title'] = 'Login';
        $this->load->view('login', $data);
    }

    function login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $data = $this->Model_login->login($username, $password);

        if($data) {
            $loginData = array(
                'id_user' => $data->id_user,
                'username' => $data->username,
                'level' => $data->level,
            );

            $this->session->set_userdata($loginData);

            redirect(base_url('home'));
        } else {
            $this->session->set_flashdata('error', '<div class="alert alert-danger">Username atau Password salah!</div>');
            redirect(base_url('login'));
        }
    }

    function logout()
    {
        $this->session->sess_destroy();

        redirect(base_url('login'));
    }
}