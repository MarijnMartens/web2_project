<?php

class Register_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    
    function setUsers($username, $password, $email)
    {
        $data = array('username' => $username, 'password' => $password, 'email' => $email);
        $this->db->insert('users', $data);
        return $this->db->affected_rows();
    }
}