<?php if(!defined('BASEPATH')) exit('Hacking Attempt: Out now...!');

class Model_login extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        return $this->db->get('user')->row();
    }
}
