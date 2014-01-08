<?php

/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * Last modified on: 08/01/2014
 * Edit: 08/01/2014: username and email no longer both required
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Password_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function reset($username, $email) {
        //Prep query
        if(isset($username) && !(isset($email))){
            $this->db->where('username', $username);
        } else if (isset($email) && !(isset($username))){
            $this->db->where('email', $email);
        } else {
            $this->db->where('username', $username);
            $this->db->or_where('email', $email);
        }
        //not to long to keep it simple for the user
        $password = random_string('alnum', 10);
        //encrypting crypt, auto salt with cost
        $option = ['cost' => 12];
        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT, $option);
        $data = array('password' => $passwordEncrypted);
        
        $this->db->update('user', $data);
        // Let's check if there are any results
        if ($this->db->affected_rows() == 1) {
         return $password;
        } else {
            // If the previous process did not validate
            // then return false.
            return FALSE;
        }
    }
    
}

?>