<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */

class Password_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function reset($username, $email) {
        // Prep the query
        $this->db->where('username', $username);
        $this->db->where('email', $email);
        
        $password = random_string('alnum', 20);
        //encrypting crypt, auto salt met cost
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