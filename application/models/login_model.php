<?php

/*
 * Author: Marijn
 * Created on: 22-12-2013
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function validate($username, $password) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $username);
        $query = $this->db->get();
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            $row = $query->row();
            if (password_verify($password, $row->password)) {
                // If there is a user, then create session data
                $data = array(
                    'user_id' => $row->id,
                    'username' => $row->username,
                    'email' => $row->email,
                    'level' => $row->level,
                    'validated' => true
                );
                $this->session->set_userdata($data);
                return true;
            }
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
    
    public function getUserdata($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $row;
        } else {
            return false;
        }
    }

}

?>