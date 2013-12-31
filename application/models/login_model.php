<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */

class Login_model extends CI_Model {

    public function validate($username, $password) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $username);
        $query = $this->db->get();
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            $row = $query->row();
            //if (password_verify($password, $row->password)) {
                // If there is a user, then create session data
                $data = array(
                    'userid' => $row->id,
                    'username' => $row->username,
                    'email' => $row->email,
                    'validated' => true
                );
                $this->session->set_userdata($data);
                return true;
           // }
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
}

?>