<?php

class Register_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    
    function setUsers($username, $password, $email)
    {
        //encrypting crypt, auto salt met cost
        $option = ['cost' => 12];
        $password = password_hash($password, PASSWORD_DEFAULT, $option);
        
        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email
                );
        
        //insert user
        $this->db->insert('users', $data);
        $query = $this->db->affected_rows();
        
        if ($query == 1)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}